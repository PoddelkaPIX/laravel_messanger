<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Chat;
use App\Models\User;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\MessageSent;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::Collection(Controller::fill_in_status(User::all()));
        // return UserResource::Collection(DB::table('users')
        // ->join('statuses', 'statuses.id', '=', 'users.status_id')
        // ->select('users.*', 'statuses.status')
        // ->get());
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return UserResource::Collection(Controller::fill_in_status([User::findOrFail($id)]));
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

    public function searchByName(Request $request){
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        MessageSent::dispatch("Ты получил сообщение?");
        
        $name = $request->get('name');
        Log::channel('stderr')->info($request->get('name'));
        // $output->writeln($request->input('name'));
        $users = User::where('name', 'LIKE', '%'.$name.'%')->get();
       
        return UserResource::Collection(Controller::fill_in_status($users));
    }
}