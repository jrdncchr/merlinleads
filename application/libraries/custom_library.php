<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Custom_Library {

    function array_decode_url($array) {
        foreach($array as $key => $value) {
            $array[$key] = urldecode($value);
        }
        return $array;
    }

    /*
     *  Returns a random string
     */
    function get_random_string($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    /*
     *  Verifies Twitter Credentials using Codebird
     */
    function verify_twitter_credentials($twitter) {
        require_once OTHERS . "twitter/codebird.php";
        \Codebird\Codebird::setConsumerKey($twitter['consumer_key'], $twitter['consumer_secret']);

        $cb = \Codebird\Codebird::getInstance();

        $cb->setToken($twitter['access_token'], $twitter['access_token_secret']);

        $reply = $cb->oauth2_token();
        if (isset($reply->errors)) {
            return array(
                'result' => false,
                'message' => $reply->errors[0]->message
            );
        } else {
            return array(
                'result' => true,
                'message' => "Verifying credentials successful!"
            );
        }
    }


    /*
     *  Shorten a URL using google api url shortener
     */
    function shorten_url($longUrl) {
        $apiKey = 'AIzaSyAKEAfsu-SEmh_Db0ptAU__BhGfV50m6d8';

        $postData = array('longUrl' => $longUrl, 'key' => $apiKey);
        $jsonData = json_encode($postData);

        $curlObj = curl_init();

        curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($curlObj, CURLOPT_POST, 1);
        curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

        $response = curl_exec($curlObj);
        $json = json_decode($response);

        curl_close($curlObj);
        return $json->id;
    }
    
    

}
