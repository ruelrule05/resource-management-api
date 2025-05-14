<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('project_id')) {
            $query->where('project_id', $request->input('project_id'));
        }

        if ($request->has('due_date_from')) {
            $query->where('due_date', '>=', $request->input('due_date_from'));
        }
        if ($request->has('due_date_to')) {
            $query->where('due_date', '<=', $request->input('due_date_to'));
        }

        // Define sortable field to avoid issues when manually entering via address bar
        if ($request->has('sort_by') && in_array($request->input('sort_by'), ['title', 'status', 'project_id', 'due_date', 'created_at'])) {
            $sortDirection = $request->input('sort_direction', 'asc');
            $query->orderBy($request->input('sort_by'), $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->input('per_page', 10);
        $tasks = $query->paginate($perPage)->appends($request->query());

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();

        return new TaskResource(Task::create($data));
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        $task->update($data);

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(null, 204);
    }
}
