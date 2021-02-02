<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Exception;

class TodoController extends Controller
{
    public function addTask(Request $req)
    {
        $user = Auth::user();
        $validator = Validator::make(
            $req->all(),
            [
                "title" => "required",
                "description" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["validation_errors" => $validator->errors()]);
        }
        $data = $req->only(['title', 'description', 'status']);
        $data['user_id'] = $user->id;

        $task = Task::create($data);
        if (!is_null($task)) {
            return response()->json(["success" => true, "data" => $task], 200);
        } else {
            return response()->json(["success" => false, "message" => "task not created."], 400);
        }
    }


    public function task() // should be tasks
    {
        $user = Auth::user();
        $tasks = $user->tasks()->get();
        return response()->json(["success" => true, "count" => count($tasks), "data" => $tasks], 200);
    }


    public function update(Request $req)
    {
        $task = Task::find($req->id);
        $data = $req->only(['title', 'description', 'status']);

        $task->update($data);

        return response()->json(["success" => true, "data" => $task], 200);
    }


    public function delete($task_id)
    {
        $user = Auth::user();

        try {
            $task = Task::findOrFail($task_id);

            if ($task->user_id != $user->id) {
                return response()->json(["status" => "failed", "success" => false, "message" => "Forbidden"], 403);
            }

            $task->delete();
        } catch (Exception $e) {
            return response()->json(["status" => "failed", "success" => false, "message" => "Alert! todo not found"], 404);
        }

        return response()->json(["status" => 200, "success" => true, "message" => "Success! todo deleted"], 200);
    }
}
