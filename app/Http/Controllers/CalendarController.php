<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Display the calendar view
     */
    public function index()
    {
        return view('calendar.index');
    }

    /**
     * Get activities for calendar (JSON response for AJAX)
     */
    public function getActivities(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $query = Activity::with(['user', 'users'])
            ->whereNotNull('start_date')
            ->whereNotNull('end_date');

        if ($start && $end) {
            $query->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start, $end])
                  ->orWhereBetween('end_date', [$start, $end])
                  ->orWhere(function ($q2) use ($start, $end) {
                      $q2->where('start_date', '<=', $start)
                         ->where('end_date', '>=', $end);
                  });
            });
        }

        $activities = $query->get();

        $events = $activities->map(function ($activity) {
            $color = match($activity->status) {
                'active' => '#10b981', // green
                'pending' => '#f59e0b', // yellow
                'completed' => '#6b7280', // gray
                'cancelled' => '#ef4444', // red
                default => '#3b82f6', // blue
            };

            return [
                'id' => $activity->id,
                'title' => $activity->name,
                'start' => $activity->start_date->toISOString(),
                'end' => $activity->end_date->toISOString(),
                'description' => $activity->description,
                'location' => $activity->location,
                'max_participants' => $activity->max_participants,
                'current_participants' => $activity->current_participants,
                'status' => $activity->status,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'organizer' => $activity->user->name,
                    'participants' => $activity->users->pluck('name')->toArray(),
                    'is_full' => $activity->isFull(),
                ]
            ];
        });

        return response()->json($events);
    }

    /**
     * Show activity details
     */
    public function show(Activity $activity)
    {
        $activity->load(['user', 'users']);

        return view('calendar.show', compact('activity'));
    }

    /**
     * Join an activity
     */
    public function join(Activity $activity)
    {
        $user = Auth::user();

        if ($activity->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Ya estás participando en esta actividad.');
        }

        if ($activity->isFull()) {
            return redirect()->back()->with('error', 'La actividad está llena.');
        }

        $activity->users()->attach($user->id);

        return redirect()->back()->with('success', 'Te has unido a la actividad exitosamente.');
    }

    /**
     * Leave an activity
     */
    public function leave(Activity $activity)
    {
        $user = Auth::user();

        if (!$activity->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'No estás participando en esta actividad.');
        }

        $activity->users()->detach($user->id);

        return redirect()->back()->with('success', 'Has abandonado la actividad.');
    }
}
