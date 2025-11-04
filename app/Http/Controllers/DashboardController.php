<?php

namespace App\Http\Controllers;

use App\Models\Bugs;
use App\Models\User;
use App\Models\Projects;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
        public function index()
    {

        $bugCounts = [
            Bugs::where('priority', 'Critical')->count(),
            Bugs::where('priority', 'High')->count(),
            Bugs::where('priority', 'Medium')->count(),
            Bugs::where('priority', 'Low')->count(),
        ];

        return view('dashboard', [
            'totalProjects' => Projects::count(),
            'totalBugs' => Bugs::count(),
            'resolvedBugs' => Bugs::where('status', 'Resolved')->count(),
            'totalUsers' => User::count(),
            'recentBugs' => Bugs::with('projects')->latest()->take(4)->get(),
            'bugCounts' => $bugCounts
        ]);
    }
}
