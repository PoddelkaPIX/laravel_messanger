<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Chat;
use App\Models\User;
use App\Models\Status;
use App\Models\Message;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    public function sendResponse($result, $message){
        $response = [
              'success' => true,
              'data'    => $result,
              'message' => $message,
          ];
          return response()->json($response, 200);
    }

    public function sendError($result, $message){
      $response = [
            'success' => false,
            'error'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    function fill_in_status($users){
        foreach ($users as $user){
            $user["status"] = Status::findOrFail($user->status_id);
        }
        return $users;
    }
    
    function fill_last_messages($chats){
        foreach ($chats as $chat){
            $chat["last_message"] = Message::where("chat_id", "=", $chat->id)->orderBy('id', 'desc')->first();
        }
        return $chats;
    }
    
    function fill_in_user($chats){
        foreach ($chats as $chat){
            $chat["person"] = User::findOrFail($chat->person_id);
            $chat["companion"] = User::findOrFail($chat->companion_id);
        }
        return $chats;
    }
}

