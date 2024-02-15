<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToDoRequest;
use App\Models\ToDo;
use App\Models\User;
use App\Notifications\TaskAssignNotification;
use Exception;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class ToDoController extends Controller
{

    public function viewTask($id)
    {
        $task = ToDo::findOrFail($id);
        dd($task);
    }

    // Make task and notify the receiver
    public function storeToDo(ToDoRequest $request)
    {
        try {
            if (auth()->check() && auth()->user()->active_status = 'active') {
                $validator = Validator::make($request->all(), $request->rules());
                if ($validator->fails()) {
                    return response()->json([
                        "status" => "400",
                        "message" => $validator->errors()->first(),
                    ]);
                }
                // Create a task
                $to_do = ToDo::create([
                    'task_name' => $request->task_name,
                    'task_description' => $request->task_description,
                    'user_id' => $request->user_id,
                    'task_creator' => auth()->user()->id,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'start' => $request->start,
                    'finish' => $request->finish,
                ]);

                // send email notification to receiver
                $receiver = User::find($to_do->user_id);
                $sender = auth()->user();
                Notification::send($receiver, new TaskAssignNotification($to_do, $sender));

                return response()->json([
                    'status' => 200,
                    'message' => 'Task created successfully!',
                    // 'data' => $to_do
                ]);
            }
        } catch (Exception $error) {
            return response()->json([
                'status' => 400,
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function updateTask(Request $request, $id)
    {
        try {
            if (auth()->user()->active_status == 'active') {
                $task = ToDo::find($id);

                if (!$task) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Task not found',
                    ]);
                }

                $updateResult = $task->update([
                    'task_name' => $request->input('task_name'),
                    'task_description' => $request->input('task_description'),
                    'start_date' => $request->input('start_date'),
                    'end_date' => $request->input('end_date'),
                    'start' => $request->input('start'),
                    'finish' => $request->input('finish'),
                ]);

                if ($updateResult) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Task updated successfully',
                    ]);
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Failed to update task',
                    ]);
                }
            }
        } catch (Exception $error) {
            return response()->json([
                'status' => 400,
                'message' => $error->getMessage(),
            ]);
        }
    }
}
