<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoretimesheetsRequest;
use App\Http\Requests\UpdatetimesheetsRequest;

use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Timesheet::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_name' => 'required',
            'task_date' => 'required|date',
            'hours' => 'required|numeric',
            'status' => 'required',
            'user_id' => 'required',
            'project_id' => 'required',
        ]);

        $timesheet = Timesheet::create($validated);

        return response()->json($timesheet, 201);
    }

    public function show(Timesheet $timesheet)
    {
        return $timesheet->load(['user', 'project']);
    }

    public function update(Request $request, Timesheet $timesheet)
    {
        $validated = $request->validate([
            'task_name' => 'required',
            'task_date' => 'required|date',
            'hours' => 'required|numeric',
            'status' => 'required',
            'user_id' => 'required',
            'project_id' => 'required',
        ]);

        $timesheet->update($validated);

        return response()->json($timesheet, 200);
    }

    public function destroy(Timesheet $timesheet)
    {
        $timesheet->delete();

        return response()->json(null, 204);
    }
}
