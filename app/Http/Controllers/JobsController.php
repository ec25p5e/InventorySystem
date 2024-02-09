<?php

namespace App\Http\Controllers;

use App\Models\CronJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    public function index() {
        $jobs = CronJob::all();
        return view('jobs.list', [
            'jobs' =>$jobs
        ]);
    }

    public function create() {
        return view('jobs.create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'command' => 'required|string',
            'schedule' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        CronJob::create($validatedData);

        return redirect()
            ->route(getRoute(Auth::id(), 'LIST_OF_JOBS'))
            ->with('success', 'Cron job created successfully.');
    }
}
