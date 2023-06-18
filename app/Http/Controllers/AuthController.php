<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'copy_password' => 'required|same:password',
        ]);
       
        if($validator->fails()){
            return $this->sendError($validator->errors(), 'Ошибка валидации');       
        }
       
        $user = new User([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);
        $user->save();
        return $this->sendResponse($user, 'Пользователь удачно зарегистрирован');
    }
    
    public function login(Request $request)
    {     
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors(), 'Ошибка валидации');       
        }

        if (!Auth::attempt($request->all())) {
            return $this->sendError($request->all(), "Не верный логин или пароль");
            // return response()->json(["message"=>"Не верный логин или пароль"], 401);
        }
        $user = $request->user();

        $tokenResult = $user->createToken("Token");
       
        $token = $tokenResult->accessToken;

        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return $this->sendResponse([
            'user' => Auth::user(),
            'access_token' => $tokenResult->plainTextToken,
            'token_type' => "Bearer",
            'expires_at' => Carbon::parse($tokenResult->accessToken->expires_at)->toDateTimeString()
        ], "Удачный вход");
    }

    public function authentication(Request $request){
        return response()->json(["data"=>
            auth('api')->user(),
        ]);
    }
}
