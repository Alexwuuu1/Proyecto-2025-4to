<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Models\Certificate;
use App\Models\Donation;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{


    /**
     * Dashboard administrativo principal
     */
    public function dashboard()
    {
        // Estadísticas generales
        $stats = [
            'total_users' => User::count(),
            'total_activities' => Activity::count(),
            'total_certificates' => Certificate::count(),
            'total_donations' => Donation::count(),
            'total_donations_amount' => Donation::sum('amount'),
            'active_activities' => Activity::where('status', 'active')->count(),
            'pending_activities' => Activity::where('status', 'pending')->count(),
        ];

        // Usuarios recientes
        $recentUsers = User::latest()->take(5)->get();

        // Actividades recientes
        $recentActivities = Activity::with('user')->latest()->take(5)->get();

        // Top voluntarios
        $topVolunteers = Ranking::with('user')
            ->orderBy('total_points', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentActivities', 'topVolunteers'));
    }

    /**
     * Gestión de usuarios
     */
    public function users()
    {
        $users = User::with(['activities', 'certificates', 'donations', 'ranking'])
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,voluntario,estudiante',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'points' => 0,
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo_path'] = $path;
        }

        User::create($data);

        return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,voluntario,estudiante',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'points' => 'required|integer|min:0',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'role', 'phone', 'bio', 'points']);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($user->profile_photo_path && \Storage::disk('public')->exists($user->profile_photo_path)) {
                \Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Store new profile photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo_path'] = $path;
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroyUser(User $user)
    {
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('admin.users')->with('error', 'No puedes eliminar el último administrador.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Gestión de actividades
     */
    public function activities()
    {
        $activities = Activity::with('user')->paginate(15);
        return view('admin.activities.index', compact('activities'));
    }

    public function approveActivity(Activity $activity)
    {
        $activity->update(['status' => 'active']);

        // Send notification to all users when activity is approved
        $users = User::where('role', '!=', 'admin')->get();
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\NewActivityNotification($activity));
        }

        return redirect()->back()->with('success', 'Actividad aprobada.');
    }

    public function rejectActivity(Activity $activity)
    {
        $activity->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Actividad rechazada.');
    }

    public function editActivity(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function updateActivity(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_participants' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,pending,completed,cancelled',
        ]);

        $activity->update($request->all());
        return redirect()->route('admin.activities')->with('success', 'Actividad actualizada.');
    }

    /**
     * Estadísticas y reportes
     */
    public function reports()
    {
        // Estadísticas mensuales de actividades
        $monthlyActivityStats = DB::table('activities')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month', 'year')
            ->orderBy('month')
            ->get();

        // Estadísticas mensuales de donaciones
        $monthlyDonationStats = DB::table('donations')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(amount) as total_amount, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->where('status', 'completed')
            ->groupBy('month', 'year')
            ->orderBy('month')
            ->get();

        // Estadísticas por rol
        $roleStats = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->get();

        // Top actividades
        $topActivities = Activity::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(10)
            ->get();

        // Estadísticas de donaciones
        $donationStats = [
            'total_donations' => Donation::count(),
            'total_donation_amount' => Donation::where('status', 'completed')->sum('amount'),
            'pending_donations' => Donation::where('status', 'pending')->count(),
            'approved_donations' => Donation::where('status', 'approved')->count(),
            'completed_donations' => Donation::where('status', 'completed')->count(),
        ];

        // Top donadores
        $topDonors = User::withSum(['donations' => function ($query) {
            $query->where('status', 'completed');
        }], 'amount')
            ->orderBy('donations_sum_amount', 'desc')
            ->take(10)
            ->get();

        // Estadísticas de certificados
        $certificateStats = [
            'total_certificates' => Certificate::count(),
            'total_hours' => Certificate::sum('hours_volunteered'),
        ];

        return view('admin.reports', compact(
            'monthlyActivityStats',
            'monthlyDonationStats',
            'roleStats',
            'topActivities',
            'donationStats',
            'topDonors',
            'certificateStats'
        ));
    }

    /**
     * Gestión de certificados
     */
    public function certificates()
    {
        $certificates = Certificate::with('user')->paginate(15);
        return view('admin.certificates.index', compact('certificates'));
    }

    public function createCertificate()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.certificates.create', compact('users'));
    }

    public function storeCertificate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'activity_title' => 'required|string|max:255',
            'hours_volunteered' => 'required|integer|min:1',
            'issued_date' => 'required|date',
        ]);

        $certificate = Certificate::create($request->all());

        // Send notification to the user
        $certificate->user->notify(new \App\Notifications\CertificateIssuedNotification($certificate));

        return redirect()->route('admin.certificates')->with('success', 'Certificado creado exitosamente.');
    }

    /**
     * Gestión de donaciones
     */
    public function donations()
    {
        $donations = Donation::with('user')->paginate(15);
        return view('admin.donations.index', compact('donations'));
    }

    public function approveDonation(Donation $donation)
    {
        $donation->update(['status' => 'approved']);

        // Send notification to the donor
        $donation->user->notify(new \App\Notifications\DonationApprovedNotification($donation));

        return redirect()->back()->with('success', 'Donación aprobada.');
    }

    public function rejectDonation(Donation $donation)
    {
        $donation->update(['status' => 'cancelled']);
        return redirect()->back()->with('success', 'Donación rechazada.');
    }

    /**
     * Configuración del sistema
     */
    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        // Aquí irían configuraciones del sistema
        // Por ahora, placeholder
        return redirect()->back()->with('success', 'Configuración actualizada.');
    }
}
