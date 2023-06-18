<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Chat::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $check_chat = Chat::where('person_id', '=', $request->person_id)->where('companion_id', '=',  $request->companion_id)->first();
        if ($check_chat !== null) {
            return Controller::sendError(null, "Чат уже создан!");
        };

        $chat = new Chat($request->all());
        $chat->save();

        return Controller::sendResponse($chat, "Чат создан!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Chat::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function get_user_chats(string $user_id){
        $chats = Chat::where("person_id", "=", $user_id)->get();
        $chats = Controller::fill_in_user($chats);
        $chats = Controller::fill_last_messages($chats);
        return Controller::sendResponse($chats, "Чаты найдены!");
    }
}




