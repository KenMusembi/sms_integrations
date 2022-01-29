<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\SendSMS;

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
    public function index()
    {
        return view('home');
    }

    public function send_message(Request $request, SendSMS $sendsms){  
        $recipient = $request->recipient;  
        //dd($recipient);
        $client = new \GuzzleHttp\Client();           
        $textmessage = $client->post(
            'https://api.mojasms.dev/sendsms',
            [
                'headers' => [
                    'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDFlYzE4Y2ExMzFiZjFiMjk4YTRhODU1ZDBkMmZmYTY1NjliNjUzM2M0ZjUyNDlmNjI2NDZkNWI3ZDk1NTZjNzg5YTQ2YjAwYWViNTRlNGMiLCJpYXQiOjE2NDMzMDkwNzAuNjgyODkzLCJuYmYiOjE2NDMzMDkwNzAuNjgyODk3LCJleHAiOjE2NzQ4NDUwNzAuNjc3MTc5LCJzdWIiOiIyMCIsInNjb3BlcyI6W119.WOj0fiK5Kr-BHWd1UDs_sDB-0kaVH19A04Mh-c3OPaKs22j4pmAcRLYLMRJCFivracQE6cOa2XFEhcbqmyRL31cFZPf1r8sW6bwCTzf7WmWiX8Qs7qREkaQwed4qhQ404Jo1-w4PMaFWyLq17p5lgjORfGhpsJJBhXvUp5FKP2WuLolLW2-r480Lvb0N6UTsr1JyvJUqBDS8AcnkUGY6K1bgTrNbLZkzLyP9IZ2KVKiJxP7vsosC8kPlaZMyjAKRso5B8iur38qACOonpjyyraEjVZyidx4aKKOGFoe2MpeLcyO4JYjC3ycFSszXmEuH5QwEdlMT5-g603QBgM-ZHsP9tz3Zo3w6mc0f1zH_GoJpulFCdjne0cVjgrEi3dgs4ygl1UlKQ8px_mnkunnm7QHPxzl5YC6jQyX6keYn7S4Go_feFThFEiXoeWA7CHJT8Bx18ATr2VQo0BQa0OTo9QwmKlwSkg6OToNKRXY2nSrhejPMZhFyAexKCAW36gZaNXiHtQz--4Ciw1R71IK6u3R1vAjA48TfI_DR3R7dEw-3LvparIf26iXPxQptXDCgICO0i1Qfc6-hASxm4X8fad-o3cKQq6jqcyvlFaErHitJj48HRw1CWirTmj4tWTG9RQSWELKmFPmKs038T4g8rrT_KXsIiAoThKD8U7UzwhU',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'from' => 'MOJAGATE',
                    'phone' => $request->recipient,
                    'message' => $request->message,
                    'message_id' => rand(0,10),
                    'webhook_url' => 'https://mojagate.com/sms-webhook',
                ],
            ]
        );
        $textbody = $textmessage->getBody();
        $status = json_decode($textbody, true);
        //$message->status=$status['status'];
        //print_r(json_decode((string) $textbody));
        //$message->save();

        if($textbody['status'] == 'Success'){
            $date_sent = $textbody['data']['recipients'][0]['created_at'];
            
            //update details in db
            $sendsms->status = 'Success';
            $sendsms->message = $request->message;
            $sendsms->recipient = $request->recipient;
            $sendsms->date_sent = $date_sent;        
            $sendsms->save();  

            return redirect('home')->with("success", 'Message sent succesfully!');                
        } else {
            return redirect('home')->with("status", 'Message not sent succesfully!');         
        }                
    }
}
