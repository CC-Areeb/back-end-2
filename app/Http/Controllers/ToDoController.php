<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToDoRequest;
use App\Models\ToDo;
use Exception;
use Illuminate\Support\Facades\Validator;

class ToDoController extends Controller
{
    // Show store the to-do data
    public function storeToDo(ToDoRequest $request)
    {
        try {
            if (auth()->user()->active_status == 'active') {
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
                    'task_creator' => $request->task_creator,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'start' => $request->start,
                    'finish' => $request->finish,
                ]);

                return response()->json([
                    'status' => 200,
                    'data' => $to_do
                ]);
            }
        } catch (Exception $error) {
            return response()->json([
                'status' => 400,
                'message' => $error->getMessage(),
            ]);
        }
    }
}
