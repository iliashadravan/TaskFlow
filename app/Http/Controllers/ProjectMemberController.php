<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\Project\AddUserRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{
    public function addUser(AddUserRequest $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403, 'You are not the owner of this project');
        }

        $data = $request->validated();

        if ($data['user_id'] == $project->user_id) {
            abort(403, 'Owner role cannot be changed.');
        }

        if ($project->users()->where('user_id', $data['user_id'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'This user is already a member of the project'
            ], 409);
        }

        $project->users()->attach($data['user_id'], [
            'role' => $data['role'] ?? RoleEnum::MEMBER
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User added successfully',
        ]);
    }

    public function removeUser(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403, 'Only project owner can remove users');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        if ($request->user_id == $project->user_id) {
            abort(403, 'Owner cannot remove himself from the project.');
        }

        $project->users()->detach($request->user_id);

        return response()->json([
            'success' => true,
            'message' => 'User removed successfully'
        ]);
    }

    public function members(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403, 'You are not the owner of this project');
        }

        return response()->json([
            'success' => true,
            'members' => [
                'owner' => $project->owner,
                'users' => $project->users()->get(),
            ]
        ]);
    }
}
