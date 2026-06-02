<?php

namespace App\Controllers;

class TestEmail extends BaseController
{
    public function index()
    {
        $email = service('email');

        $email->setTo('emailtujuan@gmail.com');
        $email->setSubject('Test SMTP');
        $email->setMessage('Email berhasil dikirim dari CI4.');

        if ($email->send()) {
            echo 'Berhasil';
        } else {
            echo $email->printDebugger(['headers']);
        }
    }
}