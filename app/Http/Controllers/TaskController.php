<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Enums\StatusEnum;
use App\Enums\PriorityEnum;
use App\Http\Requests\Task\StoreTaskRequest;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $this->checkAccess($project);

        $tasks = $project->tasks()->with('assignedUser')->get();

        return response()->json([
            'success' => true,
            'tasks' => $tasks
        ]);
    }

    public function store(StoreTaskRequest $request, Project $project)
    {
        $this->checkAccess($project);

        $data = $request->validated();

        if (!empty($data['assigned_to'])) {
            $isMember =
                $project->users()->where('user_id', $data['assigned_to'])->exists()
                || $project->user_id == $data['assigned_to'];

            if (!$isMember) {
                abort(403, 'Assigned user must be a member of the project');
            }
        }

        $task = Task::create([
            'project_id'  => $project->id,
            'created_by'  => auth()->id(),
            'assigned_to' => $data['assigned_to'] ?? null,
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'status'      => $data['status'] ?? StatusEnum::TODO,
            'priority'    => $data['priority'] ?? PriorityEnum::MEDIUM,
        ]);

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }

    public function update(StoreTaskRequest $request, Project $project, Task $task)
    {
        $this->checkAccess($project);

        if ($task->project_id !== $project->id) {
            abort(400, 'Task does not belong to this project');
        }

        $data = $request->validated();

        if (!empty($data['assigned_to'])) {
            $isMember =
                $project->users()->where('user_id', $data['assigned_to'])->exists()
                || $project->user_id == $data['assigned_to'];

            if (!$isMember) {
                abort(403, 'Assigned user must be a member of the project');
            }
        }

        $task->update($data);

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }

    public function destroy(Project $project, Task $task)
    {
        $this->checkAccess($project);

        if ($task->project_id !== $project->id) {
            abort(400, 'Task does not belong to this project');
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ]);
    }

    private function checkAccess(Project $project)
    {
        $isMember = $project->users()
            ->where('user_id', auth()->id())
            ->exists();

        if ($project->user_id !== auth()->id() && !$isMember) {
            abort(403, 'You are not a member of this project');
        }
    }
}
