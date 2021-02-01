<?php

namespace Modules\AlumniDatabase\Http\Controllers;

use Illuminate\Http\Request;

use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    public function basic_email($email) {
        $data = array('name'=>"University of Baguio");
        Mail::send(['html'=>'mail'], $data, function($message) use ($email){
           $message->to($email, 'Feedback Form')->subject
              ('Graduating Students Information and Feedback Form');
           $message->from('lheamor28@gmail.com','University of Baguio');
        });
        if (Mail::failures()) 
            return redirect()->route('graduateindex')->with('error', '');
        else
        return redirect()->route('graduateindex')->with('resend', '');
        
     }
    
}
