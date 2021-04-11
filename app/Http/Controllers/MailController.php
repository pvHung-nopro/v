<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendEmail;
use App\Mail\TestMail;
use Mail;
class MailController extends Controller
{
    public function test(Request $request)
    {
        $time = 1;
        for ($i = 0; $i < 10; $i++) {
            dispatch(new SendEmail($request->all()))->delay(now()->addSeconds($time));
        }
    }
}
