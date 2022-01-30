<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendSMS extends Model
{
    use HasFactory;

    //table referenced
    protected $table = 'send_s_m_s';

     //adding fields to save sms information
     protected $fillable = [       
        'status',
        'message',
        'recipient',
        'date_sent'              
    ];
}
