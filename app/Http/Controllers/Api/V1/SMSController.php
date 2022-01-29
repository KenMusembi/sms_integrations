<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SendSMS;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SMSController extends Controller
{
    
    public function sendsms(Request$request){
        $username = 'interviewtest@mojagate.com';
        $password = '6648f8c$1P1084';
       // $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDFlYzE4Y2ExMzFiZjFiMjk4YTRhODU1ZDBkMmZmYTY1NjliNjUzM2M0ZjUyNDlmNjI2NDZkNWI3ZDk1NTZjNzg5YTQ2YjAwYWViNTRlNGMiLCJpYXQiOjE2NDMzMDkwNzAuNjgyODkzLCJuYmYiOjE2NDMzMDkwNzAuNjgyODk3LCJleHAiOjE2NzQ4NDUwNzAuNjc3MTc5LCJzdWIiOiIyMCIsInNjb3BlcyI6W119.WOj0fiK5Kr-BHWd1UDs_sDB-0kaVH19A04Mh-c3OPaKs22j4pmAcRLYLMRJCFivracQE6cOa2XFEhcbqmyRL31cFZPf1r8sW6bwCTzf7WmWiX8Qs7qREkaQwed4qhQ404Jo1-w4PMaFWyLq17p5lgjORfGhpsJJBhXvUp5FKP2WuLolLW2-r480Lvb0N6UTsr1JyvJUqBDS8AcnkUGY6K1bgTrNbLZkzLyP9IZ2KVKiJxP7vsosC8kPlaZMyjAKRso5B8iur38qACOonpjyyraEjVZyidx4aKKOGFoe2MpeLcyO4JYjC3ycFSszXmEuH5QwEdlMT5-g603QBgM-ZHsP9tz3Zo3w6mc0f1zH_GoJpulFCdjne0cVjgrEi3dgs4ygl1UlKQ8px_mnkunnm7QHPxzl5YC6jQyX6keYn7S4Go_feFThFEiXoeWA7CHJT8Bx18ATr2VQo0BQa0OTo9QwmKlwSkg6OToNKRXY2nSrhejPMZhFyAexKCAW36gZaNXiHtQz--4Ciw1R71IK6u3R1vAjA48TfI_DR3R7dEw-3LvparIf26iXPxQptXDCgICO0i1Qfc6-hASxm4X8fad-o3cKQq6jqcyvlFaErHitJj48HRw1CWirTmj4tWTG9RQSWELKmFPmKs038T4g8rrT_KXsIiAoThKD8U7UzwhU';
       // $token2 = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZmJmOTYyNjhmMDg3NmU5MDliYjczY2NhNzMwYTJiYjkxN2Y4MWRlN2YyMTdlN2NlOGJmYjMwOTg2MjY1YTAzNDZlYWQxNTkyODg2ZjljNjgiLCJpYXQiOjE2NDM0NDc3MzQuMzA4MTY3LCJuYmYiOjE2NDM0NDc3MzQuMzA4MTcxLCJleHAiOjE2NzQ5ODM3MzQuMzAyOTYsInN1YiI6IjIwIiwic2NvcGVzIjpbXX0.I-gmmjz3GUCZu_Lblt24pMMwJSv9MWEffCyPkMZ1Y9qE4jPpqbMUz8emftuKd3aG4LZFmsqsCY_BN6Qn8z0py_S8SjBhgOcqr5MAs_-mmDWODaW6B1za1FvbxfsHRiVcVPHniE3VfxAPzpuDGDkc6EOQ4sCU4Q4hmjvffWKmprUnQcg2hIt6TMIQjZ0jL51G9oRQ6lPYFGazaQCkICw2IhtDMRkEwuSEnkYyoXCG9S3WoEMetO1FxbsFA0wgaXdzvcwCsaQKki5ckBto3CRR23lkjHCXo2ZWbbDi_qvzAuw7l2715UUvOWWd4kgwOJk7Dqk7h6xU6AuCprUG3W9MPIy4lxV272O1N4xIHFoZeI11LmmgqCDeSuNaLhViEQiS0dZ8lWcRe4b59YmvtgRj_vFejXgeAsF1h8Pzs6QGDq66UwiRvRdJooOVjTlBcUV1qg-qrZrSGVHdWQ_oenZgWpQ3AZ8t06BrJQ2J71s7oi85B3gZpiP54hPjuLYvc92LChEu9Kl5l30Mjm0_VvkHSWmzpd7zdlQGhY0Yu-__e-rZwsi1t01f2X1KyeCDWvF3CGGwpAj2bz2AZJ5e5UHBGCYHCH0a1D2c6TZf05HUznMTHjifm06gxudKZKA3MHkMW0hVep4E7hO2A9k-xZCJ5DoA8HBQ3tA8bdjpaNxY_gI';
        $recipient = $request->recipient;
        $message = $request->message;
       
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            'https://api.mojasms.dev/sendsms',
            [
                'headers' => [
                    'Authorization' => 'Bearer
                        eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDFlYzE4Y2ExMzFiZjFiMjk4YTRhODU1ZDBkMmZmYTY1NjliNjUzM2M0ZjUyNDlmNjI2NDZkNWI3ZDk1NTZjNzg5YTQ2YjAwYWViNTRlNGMiLCJpYXQiOjE2NDMzMDkwNzAuNjgyODkzLCJuYmYiOjE2NDMzMDkwNzAuNjgyODk3LCJleHAiOjE2NzQ4NDUwNzAuNjc3MTc5LCJzdWIiOiIyMCIsInNjb3BlcyI6W119.WOj0fiK5Kr-BHWd1UDs_sDB-0kaVH19A04Mh-c3OPaKs22j4pmAcRLYLMRJCFivracQE6cOa2XFEhcbqmyRL31cFZPf1r8sW6bwCTzf7WmWiX8Qs7qREkaQwed4qhQ404Jo1-w4PMaFWyLq17p5lgjORfGhpsJJBhXvUp5FKP2WuLolLW2-r480Lvb0N6UTsr1JyvJUqBDS8AcnkUGY6K1bgTrNbLZkzLyP9IZ2KVKiJxP7vsosC8kPlaZMyjAKRso5B8iur38qACOonpjyyraEjVZyidx4aKKOGFoe2MpeLcyO4JYjC3ycFSszXmEuH5QwEdlMT5-g603QBgM-ZHsP9tz3Zo3w6mc0f1zH_GoJpulFCdjne0cVjgrEi3dgs4ygl1UlKQ8px_mnkunnm7QHPxzl5YC6jQyX6keYn7S4Go_feFThFEiXoeWA7CHJT8Bx18ATr2VQo0BQa0OTo9QwmKlwSkg6OToNKRXY2nSrhejPMZhFyAexKCAW36gZaNXiHtQz--4Ciw1R71IK6u3R1vAjA48TfI_DR3R7dEw-3LvparIf26iXPxQptXDCgICO0i1Qfc6-hASxm4X8fad-o3cKQq6jqcyvlFaErHitJj48HRw1CWirTmj4tWTG9RQSWELKmFPmKs038T4g8rrT_KXsIiAoThKD8U7UzwhU
                    ',
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'from' => 'MOJAGATE',
                    'phone' => '254748050434',
                    'message' => 'Test SMS 3',
                    'message_id' => Str::random(8),
                    'webhook_url' => 'https://mojagate.com/sms-webhook',
                ],
            ]
        );
        $body = $response->getBody();
        print_r(json_decode((string) $body));
        return $body;
        
    }
}
