<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SendSMS;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SMSController extends Controller
{
    /*
    protect the send sms function by having user provide credentials
    to get unique token to be used in the send sms route
    */
    public function login(Request $request){
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $request->email)->first();
        $validCredentials = Hash::check($request['password'], $user->getAuthPassword());
        if ($validCredentials){
            $token = $user->createToken('myapptoken')->plainTextToken;
        }       
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    
    
    public function sendsms(Request $request, SendSMS $sendsms)
    {
        $request->validate([
            'recipient'=> 'required',
            'message'=> 'required'
        ]);

        $headers = [
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDFlYzE4Y2ExMzFiZjFiMjk4YTRhODU1ZDBkMmZmYTY1NjliNjUzM2M0ZjUyNDlmNjI2NDZkNWI3ZDk1NTZjNzg5YTQ2YjAwYWViNTRlNGMiLCJpYXQiOjE2NDMzMDkwNzAuNjgyODkzLCJuYmYiOjE2NDMzMDkwNzAuNjgyODk3LCJleHAiOjE2NzQ4NDUwNzAuNjc3MTc5LCJzdWIiOiIyMCIsInNjb3BlcyI6W119.WOj0fiK5Kr-BHWd1UDs_sDB-0kaVH19A04Mh-c3OPaKs22j4pmAcRLYLMRJCFivracQE6cOa2XFEhcbqmyRL31cFZPf1r8sW6bwCTzf7WmWiX8Qs7qREkaQwed4qhQ404Jo1-w4PMaFWyLq17p5lgjORfGhpsJJBhXvUp5FKP2WuLolLW2-r480Lvb0N6UTsr1JyvJUqBDS8AcnkUGY6K1bgTrNbLZkzLyP9IZ2KVKiJxP7vsosC8kPlaZMyjAKRso5B8iur38qACOonpjyyraEjVZyidx4aKKOGFoe2MpeLcyO4JYjC3ycFSszXmEuH5QwEdlMT5-g603QBgM-ZHsP9tz3Zo3w6mc0f1zH_GoJpulFCdjne0cVjgrEi3dgs4ygl1UlKQ8px_mnkunnm7QHPxzl5YC6jQyX6keYn7S4Go_feFThFEiXoeWA7CHJT8Bx18ATr2VQo0BQa0OTo9QwmKlwSkg6OToNKRXY2nSrhejPMZhFyAexKCAW36gZaNXiHtQz--4Ciw1R71IK6u3R1vAjA48TfI_DR3R7dEw-3LvparIf26iXPxQptXDCgICO0i1Qfc6-hASxm4X8fad-o3cKQq6jqcyvlFaErHitJj48HRw1CWirTmj4tWTG9RQSWELKmFPmKs038T4g8rrT_KXsIiAoThKD8U7UzwhU',
            'Accept' => 'application/json',
       ];

       $data =[
            'from' => 'MOJAGATE',
            'phone' => $request->recipient,
            'message' => $request->message,
            'message_id' => Str::random(8),
            'webhook_url' => 'https://mojagate.com/sms-webhook',
        
        ];       
        
        $result =  Http::withHeaders($headers)->post('https://api.mojasms.dev/sendsms',$data)->json();

        if($result['status'] == 'Success'){
            $date_sent = $result['data']['recipients'][0]['created_at'];
            
            //update details in db
            $sendsms->status = 'Success';
            $sendsms->message = $request->message;
            $sendsms->recipient = $request->recipient;
            $sendsms->date_sent = $date_sent;        
            $sendsms->save();  
            
            return response('Message sent succesfully', 201);         
        }
    }
}
