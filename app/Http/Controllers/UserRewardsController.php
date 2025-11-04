<?php

namespace App\Http\Controllers;

use App\Models\Bugs;
use App\Models\User;
use App\Models\UserRewards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRewardsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if (Auth::user() && Auth::user()->role === 'admin') {
            $query = UserRewards::with('user');
        } else {
            $query = UserRewards::with('user')->where('user_id', Auth::id());
        }


        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('bugs_resolved', 'like', '%' . $request->q . '%')
                    ->orWhere('date', 'like', '%' . $request->q . '%')
                    ->orWhere('total_bonus', 'like', '%' . $request->q . '%')
                    ->orWhereHas('user', function ($user) use ($request) {
                        $user->where('name', 'like', '%' . $request->q . '%');
                    });
            });
        }

        $rewards = $query->latest()->paginate(5);
        $users = User::all();

        return view('userRewards.index', compact('rewards', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->user_id;

        $bugs = Bugs::where('reported_by', $userId)
            ->where('status', 'Resolved')
            ->get();

        $bonus = $bugs->sum(function ($bug) {
            return match ($bug->priority) {
                'Critical' => 50000,
                'High' => 30000,
                'Medium' => 15000,
                'Low' => 5000,
                default => 0,
            };
        });

        UserRewards::updateOrCreate(
            [
                'user_id' => $userId,
                'date'    => now()->toDateString(),
            ],
            [
                'bugs_resolved' => $bugs->count(),
                'total_bonus'   => $bonus,
            ]
        );

        return redirect()->route('userRewards.index')->with('success', 'Reward has been successfully calculated!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserRewards $userReward)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->user_id;

        $bugs = Bugs::where('reported_by', $userId)
            ->where('status', 'Resolved')
            ->get();

        $bonus = $bugs->sum(function ($bug) {
            return match ($bug->priority) {
                'Critical' => 50000,
                'High' => 30000,
                'Medium' => 15000,
                'Low' => 5000,
                default => 0,
            };
        });

        $userReward->update([
            'user_id'       => $userId,
            'bugs_resolved' => $bugs->count(),
            'total_bonus'   => $bonus,
            'date'          => now()->toDateString(),
        ]);

        return redirect()->route('userRewards.index')->with('success', 'Reward updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRewards $userReward)
    {
        $userReward->delete();
        return redirect()->route('userRewards.index')->with('success', 'Reward has been successfully deleted.');
    }
}
