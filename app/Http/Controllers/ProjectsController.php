<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Projects::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('project_name', 'like', '%' . $request->q . '%')
                    ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }
        $projects = $query->paginate(5);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function store(Request $request)
    {
        Projects::create($request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]));

        return redirect()->route('projects.index')->with('success', 'Projects created successfully!');
    }

    public function update(Request $request, Projects $project)
    {
        $project->update($request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]));

        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }

    public function destroy(Projects $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Data has been successfully deleted.');
    }
}
