<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_Model extends CI_Model {

    public function __construct() {
        $this->load->library('email_library');
    }

    public function sendConfirmationEmail($to, $key, $random_password = false) {
        $email['subject'] = 'Merlin Leads - Email Confirmation';
        $email['to'] = $to;

        $email['content'] = "Thank you for registering in Merlin Leads.\r\n\r\n";
        $email['content'] .= "Please click the link below to confirm your email address: \r\n\r\n";
        $email['content'] .= base_url() . "pages/confirm_email/" . $key . "\r\n\r\n";
        if($random_password) {
            $email['content'] .= "After verifying your account, you may now log in using the generated password: " . $random_password . "\r\n\r\n";
            $email['content'] .= "Make sure to change your password after you logged in successfully.\r\n\r\n";
        }

        $this->email_library->send_email($email);
    }
    
    public function forgetPasswordSendEmail($user, $password) {
        $email['subject'] = 'Merlin Leads - Forgot Password';
        $email['to'] = $user->email;

        $email['content'] = "You have forgotten your password and requested to reset your password. \r\n\r\n";
        $email['content'] .= "Your new password is: $password \r\n\r\n";

        $this->email_library->send_email($email);
    }

    public function sendNewUserNotification($user) {
        $email['to'] = 'support@merlinleads.com';
        $email['subject'] = 'Merlin Leads - [New User] A new user has registered!';

        $email['content'] = "User Details: \r\n\r\n"
            . "First Name: " . $user['firstname'] . "\r\n\r\n"
            . "Last Name: " . $user['lastname'] . "\r\n\r\n"
            . "Phone: " . $user['phone'] . "\r\n\r\n"
            . "Email: " . $user['email'] . "\r\n\r\n"
            . "Country: " . $user['country'] . "\r\n\r\n"
            . "State: " . $user['state'] . "\r\n\r\n"
            . "Stripe ID: " . $user['stripe_customer_id'] . "\r\n\r\n";

        $this->email_library->send_email($email);
    }

    public function sendNewCityZipcodeUserRequest($czu) {
        $email['to'] = 'support@merlinleads.com';
        $email['subject'] = 'Merlin Leads - [City Zip Code / User Request] A user has requested a city / zip code.';

        $email['content'] = "Request Details: \r\n\r\n"
            . "Requested By: " . $czu['email'] . "\r\n\r\n"
            . "Requested City / Zip Code: " . $czu['czu_city'] . " / " . $czu['czu_zipcode'] . "\r\n\r\n";

        $this->email_library->send_email($email);
    }

    public function contactUsSendEmail($from, $message) {
        $email['to'] = 'support@merlinleads.com';
        $email['from'] = $from;
        $email['subject'] = 'Merlin Leads - [New Message] Contact Us';
        $email['content'] = $message;

        $this->email_library->send_email($email);
    }
   

}