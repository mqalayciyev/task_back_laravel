<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function add_update_task (Request $request){
        $messages = [
            'title.required'  => 'The title of the task is not specified',
            'description.required'  => 'The description of the task is not specified',
            'board_id.required'  => 'The board id is not specified',
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'board_id' => 'required',
        ], $messages);

        if($validator->fails()){
            return response()->json(['status' => 'warning', 'message' => $validator->errors()]);
        }

        $id = $request->id;

        if($id > 0){
            Task::where('id', $id)->update([
                'title' => $request->title,
                'description' => $request->description
            ]);
        }
        else{
            Task::create([
                'board_id' => $request->board_id,
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'description' => $request->description
            ]);
        }
        return response()->json(['status' => 'success', 'message' => 'Success']);
    }
    public function update_task_order (Request $request){


        $id_array = request()->all();


        foreach ($id_array as $key => $id) {
            Task::where('id', $id)->update([
                'order' => $key,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Success']);
    }
}
