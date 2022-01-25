<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    public function load (Request $request){
        $data = Board::with('tasks')->orderBy('id')->get();

        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function add_update_board (Request $request){

        $messages = [
            'title.required'  => 'The title of the board is not mentioned',
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], $messages);




        if($validator->fails()){
            return response()->json(['status' => 'warning', 'message' => $validator->errors()]);
        }

        $id = $request->id;
        if($id > 0){
            Board::where('id', $id)->update([
                'title' => $request->title
            ]);
        }
        else{
            Board::create([
                'title' => $request->title
            ]);
        }
        return response()->json(['status' => 'success', 'message' => 'Success']);
    }
}
