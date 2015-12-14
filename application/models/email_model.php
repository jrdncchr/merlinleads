<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_Model extends CI_Model {

    protected $from = "support@merlinleads.net";
//    protected $cc = "Yates Harrison <yatesharrison@yahoo.com>, Jordan Cachero <jrdncchr@gmail.com>";
    protected $cc = ", Jordan Cachero <jrdncchr@gmail.com>";

    public function sendConfirmationEmail($email, $key, $random_password = false) {
        $message = "<html><body>";
//        $message .= "<img src='" . base_url() . IMG . "logo.png' height='100' width='400' />";
        $message .= "<p>Thank you for registering in Merlin Leads.</p>";
        $message .= "<p>Please click the this <a href='" . base_url() . "pages/confirm_email/" . base64_encode($email) . "/" . $key . "'>link</a> to activate your account.</p>";
        if($random_password) {
            $message .= "<br />";
            $message .= "<p>After verifying your account, you may now log in using the generated password: <b>" . $random_password . "</b></p>";
            $message .= "<p>Make sure to change your password after you logged in successfully.</p>";
        }
        $message .= "</body></html>";

        $to = $email;
        $subject = 'Merlin Leads - Email Confirmation';

        $headers = "From: Merlin Leads<" . $this->from . ">"  . "\r\n";
        $headers .= "BCC: $this->cc" . "\r\n";
        $headers .= "Content-type: text/html";

        mail($to, $subject, $message, $headers);
    }
    
    public function forgetPasswordSendEmail($user, $password) {
        $message = "<html><body>";
//        $message .= "<img src='" . base_url() . IMG . "logo.png' height='100' width='400' />";
        $message .= "<p>Your new generated password is: $password</p>";
        $message .= "<p><a href='".base_url(). "pages/login'>Login Now</a></p>";
        $message .= "</body></html>";

        $from = "support@merlinleads.net";
        $to = $user->email;
        $subject = 'Merlin Leads - Forget Password';

        $headers = "From: <" . $this->from . ">"  . "\r\n";
        $headers .= "BCC: <" . $this->cc . ">" . "\r\n";
        $headers .= "Content-type: text/html";

        mail($to, $subject, $message, $headers);
    }

    public function contactUsSendEmail($from, $message) {
        $to = 'support@merlinleads.net';
        $subject = 'Merlin Leads - [New Message] Contact Us';
        $headers = "From: <" . $from . ">"  . "\r\n";
        $headers .= "BCC: <" . $this->$cc . ">" . "\r\n";
        $headers .= "Content-type: text/html";
        mail($to, $subject, $message, $headers);
    }
   

}