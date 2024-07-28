<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\AccessCodeMail;
use App\Models\AccessCode;

class TestEmailController extends Controller
{
    public function sendTestEmail()
    {
        $accessCode = new AccessCode();
        $accessCode->code = '12345678';
        $accessCode->email = 'heningtriswari01@gmail.com';

        Mail::to('heningtriswari01@gmail.com')->send(new AccessCodeMail($accessCode));

        return 'Test email sent!';
    }
}
