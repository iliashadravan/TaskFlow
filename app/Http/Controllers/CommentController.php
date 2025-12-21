<?php

namespace App\Http\Controllers;

use App\Http\Requests\comments\storeRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function index(Project $project, Task $task)
    {
        return response()->json(
            $task->comments()->with(['user', 'replies.user'])->latest()->get()
        );
    }


    public function store(storeRequest $request, Project $project, Task $task)
    {
        $comment = Comment::create([
            'task_id'   => $task->id,
            'user_id'   => Auth::id(),
            'parent_id' => $request->parent_id,
            'body'      => $request->body,
        ]);

        return response()->json($comment, 201);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully'
        ]);
    }
}
