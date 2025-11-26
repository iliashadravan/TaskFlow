<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreRequest;
use App\Models\Project;

class ProjectController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $project = Project::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'project' => $project,
        ], 201);
    }

    public function index()
    {
        $projects = auth()->user()->ownProjects()->get();

        return response()->json([
            'success' => true,
            'project' => $projects,
        ]);
    }

    public function show(Project $project)
    {
        $this->authorizeProject($project);

        return response()->json([
            'success' => true,
            'project' => $project->load('owner', 'users'),
        ]);
    }

    public function update(StoreRequest $request, Project $project)
    {
        $this->authorizeProject($project);

        $data = $request->validated();

        $project->update($data);

        return response()->json([
            'success' => true,
            'project' => $project
        ]);
    }

    public function destroy(Project $project)
    {
        $this->authorizeProject($project);

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully',
        ]);
    }

    private function authorizeProject(Project $project): void
    {
        if ($project->user_id !== auth()->id()) {
            abort(403, 'You are not the owner of this project');
        }
    }
}
