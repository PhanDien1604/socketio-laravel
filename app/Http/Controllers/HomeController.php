<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessageJob;
use App\Models\Message;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $friends = User::where('id', '!=', $userId)->get()->toArray();
        return view('home', compact('friends'));
    }

    public function sendMessages(Request $request) {
        $sender_id = Auth::id();
        $receiver_id = $request->receiver_id;

        $message = new Message();
        $message->message = $request->message;

        if($message->save()) {
            try {
                $message->users()->attach($sender_id, ['receiver_id' => $receiver_id]);
                $sender = User::where('id', '=', $sender_id)->first();

                $data = [
                    'sender_id' => $sender_id,
                    'sender_name' => $sender->name,
                    'receider_id' => $receiver_id,
                    'content' => $message->message,
                    'created_at' => $message->created_at,
                    'message_id' => $message->id
                ];

                return response()->json([
                    'data' => $data,
                    'success' => true
                ]);
            } catch (\Throwable $th) {
                $message->delete();

                return back();
            }
        }
    }

    public function getMessages(Request $request) {
        $sender_id = Auth::id();
        $receiver_id = $request->receiver_id;

        $dataMessageSender = DB::table('user_messages')
        ->where('sender_id', $sender_id)
        ->where('receiver_id', $receiver_id)
        ->join('messages','messages.id', '=', 'message_id')
        ->orderBy('messages.created_at')
        ->get();

        $dataMessageReceiver = DB::table('user_messages')
        ->where('sender_id', $receiver_id)
        ->where('receiver_id', $sender_id)
        ->join('messages','messages.id', '=', 'message_id')
        ->orderBy('messages.created_at')
        ->get();

        // $data = [
        //     "dataMessageSender" => $dataMessageSender->toArray(),
        //     "dataMessageReceiver" => $dataMessageReceiver->toArray()
        // ];
        $dataCollection = collect(array_merge($dataMessageSender->toArray(), $dataMessageReceiver->toArray()));

        $data = $dataCollection->sortBy('created_at')->values()->toArray();

        return response()->json([
            'data' => $data
        ]);
    }
}
