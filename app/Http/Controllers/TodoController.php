<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TodoController extends Controller
{
    //
    public function addtask(Request $req){
        // return'hejj';
        $user=Auth::user();
        $validator=Validator::make($req->all(),
        [
            "title"=>"required",
            "discription"=>"required",
        ]
    );
    if($validator->fails()) {
        return response()->json(["validation_errors" => $validator->errors()]);
    }
        $task=array(
        "title"=>$req->title,
        "discription"=>$req->discription,
        "status"=>$req->status,
        "user_id"=>$user->id
    );
        $task=Task::create($task);
        if(!is_null($task)) {
            return response()->json(["status" =>200, "success" => true, "data" => $task]);
        }

        else {
            return response()->json(["status" => "failed","success" => false, "message" => "task not created."]);
        }
    }


        public function task(){
            $tasks=array();
            $user=Auth::user();
            $tasks=Task::where("user_id", $user->id)->get();
            if(count($tasks) > 0) {
                return response()->json(["status" =>200, "success" => true, "count" => count($tasks), "data" => $tasks]);
            }

            else {
                return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no todo found"]);
            }
        }


//         public function update(Request $req ,$task_id){
//            $data=Task::findOrFail($task_id);
//            $validator=Validator::make($req->all(),
//             [
//                 "title"=>"required",
//                 "discription"=>"required",
//             ]
//           );
//           if($validator->fails()) {
//             return response()->json(["validation_errors" => $validator->errors()]);
//          }
//         else{
//             $data->update($req->all());
//              return response()->json(["success" =>"success"]);
//          }
//         }
public function update(Request $req){
            $data=Task::find($req->id);
            $data->title=$req->title;
            $data->discription=$req->discription;
            $data->status=$req->status;
            $result=$data->save();
            if($result){
                return ["result"=>"Data has been Updated"];
            }else{
                return["result"=>"Data not Updated"];
            }
        }


        public function delete($task_id){
            $user=Auth::user();
            if($task_id == 'undefined' || $task_id == "") {
                return response()->json(["status" => "failed", "success" => false, "message" => "Alert! enter the task id"]);
            }
            $task=Task::find($task_id);
            if(!is_null($task)) {
                $delete_status=Task::where("id", $task_id)->delete();
                if($delete_status == 1) {

                    return response()->json(["status" =>200, "success" => true, "message" => "Success! todo deleted"]);
                }
    
                else {
                    return response()->json(["status" => "failed", "success" => false, "message" => "Alert! todo not deleted"]);
                }
            }
    
            else {
                return response()->json(["status" => "failed", "success" => false, "message" => "Alert! todo not found"]);
            }
        }
      
}
    

