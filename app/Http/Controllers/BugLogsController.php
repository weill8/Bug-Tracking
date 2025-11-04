<?php

namespace App\Http\Controllers;

use App\Models\Bugs;
use App\Models\Projects;
use App\Models\User;
use App\Models\BugLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BugLogsController extends Controller
{

    public function index(Request $request)
    {
        $query = BugLogs::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('new_status', 'like', '%' . $request->q . '%')
                    ->orWhereHas('bugs', function ($bug) use ($request) {
                        $bug->where('title', 'like', '%' . $request->q . '%');
                    })
                    ->orWhereHas('changed', function ($user) use ($request) {
                        $user->where('name', 'like', '%' . $request->q . '%');
                    });
            });
        }

        $bugLogs = $query->paginate(5);
        $bugs = Bugs::pluck('Title', 'id');
        $users = User::pluck('name', 'id');

        $statuses = [
            'In Progress' => 'In Progress',
            'Resolved' => 'Resolved',
        ];

        return view('bugLogs.index', compact('bugLogs', 'bugs', 'statuses', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bug_id' => 'required|integer|exists:bugs,id',
            'new_status' => 'required|string|in:In Progress,Resolved',
        ]);

        $data['changed_by'] = Auth::id();
        BugLogs::create($data);

        return redirect()->route('bugLogs.index')->with('success', 'Bug log created successfully!');
    }

    public function update(Request $request, BugLogs $bugLog)
    {
        $bugLog->update($request->validate([
            'bug_id' => 'required|integer|exists:bugs,id',
            'new_status' => 'required|string|in:In Progress,Resolved',
        ]));

        return redirect()->route('bugLogs.index')->with('success', 'Bug log updated successfully!');
    }

    public function destroy(BugLogs $bugLog)
    {
        $bugLog->delete();
        return redirect()->route('bugLogs.index')->with('success', 'Data has been successfully deleted.');
    }
}
