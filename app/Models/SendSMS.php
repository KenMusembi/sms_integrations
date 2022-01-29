<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendSMS extends Model
{
    use HasFactory;

     //adding fields to save sms information
     protected $fillable = [       
        'recipient',
        'message',            
    ];
}
