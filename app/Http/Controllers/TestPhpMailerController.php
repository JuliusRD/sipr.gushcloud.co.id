<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

class TestPhpMailerController extends Controller
{
    public function index()
    {
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPSecure = 'tls';
        $mail->Host = "smtp.gmail.com"; //hostname masing-masing provider email
        $mail->SMTPDebug = 2;
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = "notif.pr@gmail.com"; //user email
        $mail->Password = "Gcid@2021"; //password email
        $mail->SetFrom("notif.pr@gmail.com", "Nama pengirim yang muncul"); //set email pengirim
        $mail->Subject = "Pemberitahuan Email dari Website"; //subyek email
        $mail->AddAddress("azizmsn175@gmail.com", "Nama penerima yang muncul"); //tujuan email
        $mail->MsgHTML("Testing…");
        if ($mail->Send()) echo "Message has been sent";
        else echo "Failed to sending message";
        
        
        
        
        //  $text             = 'Hello Mail';
        // $mail = new PHPMailer;
        // $mail->SMTPDebug  = 1; // debugging: 1 = errors and messages, 2 = messages only
        // $mail->SMTPAuth   = true; // authentication enabled
        // $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        // $mail->Host       = "smtp.gmail.com";
        // $mail->Port       = 465; // or 587
        // $mail->IsHTML(true);
        // $mail->Username = "notif.pr@gmail.com";
        // $mail->Password = "Gcid@2021";
        // $mail->SetFrom("notif.pr@gmail.com", 'Sender Name');
        // $mail->Subject = "Test Subject";
        // $mail->Body    = $text;
        // $mail->AddAddress("azizmsn175@gmail.com", "Receiver Name");
        // if ($mail->Send()) {
        //     return 'Email Sended Successfully';
        // } else {
        //     return 'Failed to Send Email';
        // }
    }
}
