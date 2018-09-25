<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;

use Carbon;


class MailController extends Controller
{

    public function send(Request $request) {
        try {

            $subject = '[FHUI Guide] ' . $request->subject;
            $content = $request->content;
            $sender = $request->sender;

            Mail::send('mail', ['sender' => $sender, 'content' => $content], function($msg) use ($subject) {
                $msg->to('advokasihukumui@gmail.com');
                // $msg->to('tybantarnusa@gmail.com');
                $msg->bcc('tybantarnusa@gmail.com');
                $msg->subject($subject);
                $msg->from('lapor@fhuiguide.com', 'FHUI Guide Lapor Advo');
            });

            return [
                'status' => 'Success',
                'data' => [
                    'subject' => $subject,
                    'content' => $content,
                    'sender' => $sender,
                    'from' => 'FHUI Guide Lapor Advo <lapor@fhuiguide.com>',
                    'to' => 'advokasihukumui@gmail.com'
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'Error',
                'message' => $e->getMessage()
            ];
        }
    }

}
