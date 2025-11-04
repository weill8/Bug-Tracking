<?php

namespace App\Http\Controllers;

use App\Models\Bugs;
use App\Models\User;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BugsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Bugs::query();
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                    ->orWhere('description', 'like', '%' . $request->q . '%')
                    ->orWhereHas('projects', function ($project) use ($request) {
                        $project->where('project_name', 'like', '%' . $request->q . '%'); 
                    })
                    ->orWhere('priority', 'like', '%' . $request->q . '%')
                    ->orWhere('status', 'like', '%' . $request->q . '%')
                    ->orWhereHas('reported', function ($user) use ($request) {
                        $user->where('name', 'like', '%' . $request->q . '%');
                    });
            });
        }
        $bugs = $query->paginate(5);
        $projects = Projects::pluck('project_name', 'id');

        $priorities = [
            'Low' => 'Low',
            'Medium' => 'Medium',
            'High' => 'High',
            'Critical' => 'Critical',
        ];

        $statuses = [
            'In Progress' => 'In Progress',
            'Resolved' => 'Resolved',
        ];

        $users = User::pluck('name', 'id');

        return view('bugs.index', compact('bugs', 'projects', 'priorities', 'statuses', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|integer|exists:projects,id',
            'priority' => 'required|string|in:Low,Medium,High,Critical',
        ]);

        $data['reported_by'] = Auth::id();

        Bugs::create($data);

        return redirect()->route('bugs.index')->with('success', 'Bug created successfully!');
    }


    public function update(Request $request, Bugs $bug)
    {
        $bug->update($request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|integer|exists:projects,id',
            'priority' => 'required|string|in:Low,Medium,High,Critical',
        ]));


        return redirect()->route('bugs.index')->with('success', 'Bug updated successfully!');
    }


    public function destroy(Bugs $bug)
    {
        $bug->delete();
        return redirect()->route('bugs.index')->with('success', 'Data has been successfully deleted.!');
    }
}
