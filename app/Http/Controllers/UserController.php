<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Project;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'dob' => 'required|date',
        ]);

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return $user->load('projects');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            //'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'dob' => 'required|date',
        ]);

        $user->update($validated);

        return response()->json($user, 200);
    }

    public function connectUserToProject(Request $request, $user_id) {
        $validated = $request->validate([
            'project_id' => 'required',
        ]);
        $project = Project::find($request['project_id']);
        $user = User::find($user_id);

        $result = $user->projects()->attach($project);

        return response()->json($result, 200);
    }

    public function disconnectUserToProject(Request $request, $user_id) {
        $validated = $request->validate([
            'project_id' => 'required',
        ]);
        $project = Project::find($request['project_id']);
        $user = User::find($user_id);

        $result = $user->projects()->detach($project);

        return response()->json($result, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
