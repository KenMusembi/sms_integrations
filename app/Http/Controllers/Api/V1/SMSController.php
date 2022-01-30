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
        $user = User::where('email', $request->email)->first();
        $validCredentials = Hash::check($request['password'], $user->getAuthPassword());
        if ($validCredentials){
            $token = $user->createToken('myapptoken')->plainTextToken;
        }
        
        //return a 201 repsonse and show token when a login occurs
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }    
    
    
    //function to send sms
    public function sendsms(Request $request, SendSMS $sendsms)
    {   
        //we get saved variables from the env file
        $base_url = config('custom_variables.base_url'); 

        $username = config('custom_variables.username'); 
        
        $password= config('custom_variables.password'); 
        
        $webhook= config('custom_variables.webhook'); 
        
        $sender= config('custom_variables.sender'); 
        
        $client = new \GuzzleHttp\Client();
        
        //we first login to get a bearer token to use for the api
        $response = $client->post(
            $base_url.'/login',
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'email' => $username ,
                    'password' => $password,
                ],
            ]
        );
        //we now get the token from the json response
        $body = $response->getBody();
        $bearer_token = json_decode($body,true);
        $token = $bearer_token['data']['token'];
        
         
        $headers = [
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
       ];

       $data =[
            'from' => $sender,
            'phone' => $request->recipient,
            'message' => $request->message,
            'message_id' => Str::random(8),
            'webhook_url' => $webhook,
        
        ];       
        
        //this result variable has the json repsonse from the api
        $result =  Http::withHeaders($headers)->post($base_url.'/sendsms',$data)->json();
        
        //if we get a success message from the api, we record the transaction details in the database
        if($result['status'] == 'Success'){
            $date_sent = $result['data']['recipients'][0]['created_at'];
            
            //update details in db
            $sendsms->status = 'Success';
            $sendsms->message = $request->message;
            $sendsms->recipient = $request->recipient;
            $sendsms->date_sent = $date_sent;        
            $sendsms->save();  
            
            /*
            return the 201 response saying message was sent succesfully
            the response can be further customized according tot he usage
            */
            return response('Message sent succesfully', 201);               
        }
    }   
}
