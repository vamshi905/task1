<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class Service extends Controller
{
  public function register(Request $request)
  {


    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email',
      'password' => 'required',
    ]);
    if ($validator->fails()) {
      $response = [
        "success" => false,
        "message" => $request->error()
      ];
      return $response()->json($response, 400);
    }

    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);
    $success['token'] =  $user->createToken('MyApp')->plainTextToken;
    $success['name'] =  $user->name;

    $response = [
      "success" => true,
      "message" => "Register Successfully",
      "data" => $success
    ];
    return $response;
  }

  public function login(Request $request)
  {
    //using sanctum
    // if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
    //         $user = Auth::user(); 
    //         $success['token'] = $user->createToken('MyApp')->plainTextToken;
    //         $success['name'] = $user->name;
    //         $response=[
    //             "success"=>true,
    //             "message"=>"Login Successfully",
    //             "token"=>$success
    //           ];
    //           return $response;
    // }
    // else{
    //     $response=[
    //         "success"=>false,
    //         "message"=>"Invalid Login"
    //       ];
    //       return $response;
    // }
    $user = ['email' => $request->email, 'password' => $request->password];
    if (Auth::attempt($user)) {
      $tok = Auth::user();
      $success['token'] = $tok->createToken('MyApp')->accessToken;
      $response = [
        "success" => true,
        "message" => "Login Successfully",
        "token" => $success
      ];
      return $response;
    } else {
      return "invalid access";
    }
  }
  public function details(string $id)
  {
    
      $user=Questionnaire::where('id',$id)->get();
    if(count($user)>0){
    return response()->json([
      'status'=>true,
      'data'=>$user
    ]);
  }
  else{
    return response()->json([
      'status'=>'data not found'
    ]);
  }
  
  }
  public function logout(Request $request)
  {
    $bool=auth()->user()->token()->revoke();
   //Auth::logout();
   if($bool){
     return response()->json([
      'status'=>true,
      'message'=>"logout successful"
    ]);
  }
  else{
    return response()->json([
      'status'=>false,
      'message'=>"logout fail"
    ]);
  }
  }
}
