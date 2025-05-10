<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $totalProjects = Project::count();

        $projectsByStatus = Project::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        $recentProjects = Project::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json(compact('totalProjects', 'projectsByStatus', 'recentProjects'));
    }

    public function projectsByMonth(Request $request): JsonResponse
    {
        $projects = Project::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month'), DB::raw('count(*) as total'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json(compact('projects'));
    }
}
