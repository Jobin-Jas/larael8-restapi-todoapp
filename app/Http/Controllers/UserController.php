<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class UserController extends Controller
{
    //
    public function login(Request $req){
        if(Auth::attempt(['email' =>$req->email, 'password' => $req->password])){
            $user=Auth::user();
            $response=[];
            $response['token']=$user->createToken('todo')->accessToken;
            $response['name']=$user->name;
            return response()->json($response,200);


        }else{
            return response()->json(['error'=>'unauthenticated'],203);
        }
    }
    public function register(Request $req){
        $Validate=Validator::make($req->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|alpha_num|min:6',
            ]
            );
            if($Validate->fails()){
                return response()->json(['validation_error'=>$Validate->errors()]);
            }
            
            $input=$req->all();
            $input['password']=bcrypt($input['password']);
            $user=User::create($input);
            $response=[];
            $response['token']=$user->createToken('todo')->accessToken;
            $response['name']=$user->name;
            $response['email']=$user->email;
            return response()->json($response,200);

    }
    public function tasklist(){
        $response=[
            'status'=>'ok',
        ];
    }
}
