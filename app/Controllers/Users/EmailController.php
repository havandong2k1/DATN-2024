<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;

class EmailController extends BaseController
{
    public function index()
    {
        return view('contact/email');
    }

    function sendMail()
    {
        $from = $this->request->getVar('mailfrom');
        $subject = $this->request->getVar('subject');
        $message = $this->request->getVar('message');

        $email = \Config\Services::email();
        $email->setTo('dduong1703@gmail.com');
        $email->setFrom($from);

        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) {
            return view('contact');
        } else {
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
    }
}
