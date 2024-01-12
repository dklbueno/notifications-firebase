<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationSendController extends Controller
{
    public function updateDeviceToken(Request $request)
    {
        // Auth::user()->device_token =  $request->token;

        // Auth::user()->save();

        $user = User::find($request->user);
        $user->device_token =  $request->token;
        $user->save();

        return response()->json(['Token successfully stored.']);
    }

    public function sendNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $users = User::whereNotNull('device_token')->get();

        $userIds = $users->pluck('id')->toArray();

        $FcmToken = $users->pluck('device_token')->toArray();
            
        $serverKey = env('FIREBASE_SERVER_KEY');
    
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
    
        $headers = [
            'Authorization' => 'key=' . $serverKey,
            'Content-Type' => 'application/json',
        ];

        $result = Http::withHeaders($headers)->post($url, $data);

        Notification::create([
            'users' => $userIds,
            'from_app' => 'CRM',
            'message' => $request->body,
            'link' => 'https://google.com.br',
            'read' => false,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        dd($result->json());
    }
}