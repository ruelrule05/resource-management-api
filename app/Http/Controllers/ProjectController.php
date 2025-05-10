<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\DeleteProjectRequest;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->has('search')) {
            $searchTerm = $request->get('search');

            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('status', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('sort_by') && in_array($request->input('sort_by'), ['name', 'start_date', 'created_at', 'id'])) {
            $sortDirection = $request->get('sort_direction', 'asc');
            $query->orderBy($request->input('sort_by'), $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->input('per_page', 10);
        $projects = $query->paginate($perPage)->appends($request->query());

        return ProjectResource::collection($projects);
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        return new ProjectResource(Project::create($data));
    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        $project->update($data);

        return new ProjectResource($project);
    }

    public function destroy(DeleteProjectRequest $request, Project $project)
    {
        $project->delete();

        return response()->json(['message' => 'Project deleted'], 204);
    }
}
