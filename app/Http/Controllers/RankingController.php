<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
{
    /**
     * Display the rankings leaderboard.
     */
    public function index()
    {
        $rankings = Ranking::getTopRankings(20);

        // Get current user's ranking
        $userRanking = null;
        if (Auth::check()) {
            $userRanking = Auth::user()->ranking;
            if ($userRanking) {
                $userRanking->updateStats();
            }
        }

        return view('rankings.index', compact('rankings', 'userRanking'));
    }

    /**
     * Show the form for creating a new ranking (Admin only).
     */
    public function create()
    {
        $this->authorize('create', Ranking::class);

        $users = User::where('role', '!=', 'admin')->get();
        return view('rankings.create', compact('users'));
    }

    /**
     * Store a newly created ranking in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Ranking::class);

        $request->validate([
            'user_id' => 'required|exists:users,id|unique:rankings,user_id',
        ]);

        $ranking = Ranking::create([
            'user_id' => $request->user_id,
        ]);

        $ranking->updateStats();

        return redirect()->route('rankings.index')->with('success', 'Ranking created successfully.');
    }

    /**
     * Display the specified ranking.
     */
    public function show(Ranking $ranking)
    {
        $this->authorize('view', $ranking);
        $ranking->updateStats();

        return view('rankings.show', compact('ranking'));
    }

    /**
     * Show the form for editing the specified ranking.
     */
    public function edit(Ranking $ranking)
    {
        $this->authorize('update', $ranking);

        $users = User::where('role', '!=', 'admin')->get();
        return view('rankings.edit', compact('ranking', 'users'));
    }

    /**
     * Update the specified ranking in storage.
     */
    public function update(Request $request, Ranking $ranking)
    {
        $this->authorize('update', $ranking);

        $request->validate([
            'user_id' => 'required|exists:users,id|unique:rankings,user_id,' . $ranking->id,
        ]);

        $ranking->update($request->only(['user_id']));
        $ranking->updateStats();

        return redirect()->route('rankings.index')->with('success', 'Ranking updated successfully.');
    }

    /**
     * Remove the specified ranking from storage.
     */
    public function destroy(Ranking $ranking)
    {
        $this->authorize('delete', $ranking);
        $ranking->delete();

        return redirect()->route('rankings.index')->with('success', 'Ranking deleted successfully.');
    }

    /**
     * Update all rankings (Admin utility).
     */
    public function updateAll()
    {
        $this->authorize('create', Ranking::class);

        $users = User::where('role', '!=', 'admin')->get();

        foreach ($users as $user) {
            $ranking = $user->ranking ?? Ranking::create(['user_id' => $user->id]);
            $ranking->updateStats();
        }

        return redirect()->route('rankings.index')->with('success', 'All rankings updated successfully.');
    }
}
