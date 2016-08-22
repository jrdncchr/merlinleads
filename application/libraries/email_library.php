<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Email_Library {

    private $api_key;
    private $from;

    function __construct() {
        $this->api_key = SEND_GRID_API_KEY;
        $this->from = "Merlin Leads <support@merlinleads.com>";
    }

    public function send_email($email) {
        if(isset($email['from'])) {
            $this->from = $email['from'];
        }

        $from = new SendGrid\Email(null, $this->from);
        $subject = $email['subject'];
        $to = new SendGrid\Email(null, $email['to']);
        $content = new SendGrid\Content("text/plain", $email['content']);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        $sg = new \SendGrid($this->api_key);
        $response = $sg->client->mail()->send()->post($mail);
        var_dump($response);exit;
        return $response->statusCode();
    }

}
