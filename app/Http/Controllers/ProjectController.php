<?php

namespace App\Http\Controllers;

//use App\Http\Requests\StoreProjectsRequest;
//use App\Http\Requests\UpdateProjectsRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Project::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'department' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'date|after:start_date',
        ]);

        $project = Project::create($validated);

        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        return $project->load('users');
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required',
            'department' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'date|after:start_date',
        ]);

        $project->update($validated);

        return response()->json($project, 200);
    }

    public function connectProjectToUser(Request $request, $project_id) {
        $validated = $request->validate([
            'user_id' => 'required',
        ]);
        $user = Project::find($request['user_id']);
        $project = User::find($project_id);

        $result = $project->users()->attach($user);

        return response()->json($result, 200);
    }

    public function disconnectProjectToUser(Request $request, $project_id) {
        $validated = $request->validate([
            'user_id' => 'required',
        ]);
        $user = Project::find($request['user_id']);
        $project = User::find($project_id);

        $result = $project->users()->detach($user);

        return response()->json($result, 200);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(null, 204);
    }
}
