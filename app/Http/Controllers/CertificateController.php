<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Display a listing of certificates.
     */
    public function index()
    {
        $certificates = Auth::user()->certificates()->latest()->paginate(10);
        return view('certificates.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new certificate (Admin only).
     */
    public function create()
    {
        $this->authorize('create', Certificate::class);

        $users = User::where('role', '!=', 'admin')->get();
        return view('certificates.create', compact('users'));
    }

    /**
     * Store a newly created certificate in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Certificate::class);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_hours' => 'required|integer|min:1',
            'issue_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $certificate = Certificate::create([
            'user_id' => $request->user_id,
            'certificate_number' => Certificate::generateCertificateNumber(),
            'total_hours' => $request->total_hours,
            'issue_date' => $request->issue_date,
            'description' => $request->description,
            'status' => 'active',
        ]);

        return redirect()->route('certificates.index')->with('success', 'Certificate created successfully.');
    }

    /**
     * Display the specified certificate.
     */
    public function show(Certificate $certificate)
    {
        $this->authorize('view', $certificate);
        return view('certificates.show', compact('certificate'));
    }

    /**
     * Generate and download PDF certificate.
     */
    public function download(Certificate $certificate)
    {
        $this->authorize('view', $certificate);

        $pdf = Pdf::loadView('certificates.pdf', compact('certificate'));
        return $pdf->download('certificate-' . $certificate->certificate_number . '.pdf');
    }

    /**
     * Show the form for editing the specified certificate.
     */
    public function edit(Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        $users = User::where('role', '!=', 'admin')->get();
        return view('certificates.edit', compact('certificate', 'users'));
    }

    /**
     * Update the specified certificate in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_hours' => 'required|integer|min:1',
            'issue_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,revoked',
        ]);

        $certificate->update($request->only([
            'user_id',
            'total_hours',
            'issue_date',
            'description',
            'status',
        ]));

        return redirect()->route('certificates.index')->with('success', 'Certificate updated successfully.');
    }

    /**
     * Remove the specified certificate from storage.
     */
    public function destroy(Certificate $certificate)
    {
        $this->authorize('delete', $certificate);
        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully.');
    }

    /**
     * Validate certificate by number (public route).
     */
    public function validateCertificate(Request $request)
    {
        $request->validate([
            'certificate_number' => 'required|string',
        ]);

        $certificate = Certificate::where('certificate_number', $request->certificate_number)->first();

        if (!$certificate) {
            return view('certificates.validate', [
                'certificate' => null,
                'message' => 'Certificate not found.',
            ]);
        }

        return view('certificates.validate', compact('certificate'));
    }

    /**
     * Show validation form.
     */
    public function showValidateForm()
    {
        return view('certificates.validate-form');
    }
}
