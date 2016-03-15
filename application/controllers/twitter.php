<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class twitter extends MY_Controller {

    /* Make sure the user is logged in, else redirect to the home page.
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url());
        }
    }

    public function callback() {
        $oauth_token = $this->session->userdata('twitter_oauth_token');
        $oauth = new \Abraham\TwitterOAuth\TwitterOAuth(TWITTER_KEY, TWITTER_SECRET_KEY, $oauth_token,  $_GET['oauth_token']);

        $access_token = $oauth->oauth("oauth/access_token",
            array("oauth_verifier" => $_GET['oauth_verifier']));

        $this->load->model('user_model');
        $update = array(
            'twitter_access_token' => (string) json_encode($access_token)
        );

        if($this->user_model->updateInfo($update, $this->user->id)) {
            $_SESSION['twitter_access_token'] = (string) json_encode($access_token);
            $this->session->set_userdata('twitter_access_token', (string) json_encode($access_token));
            redirect(base_url() . "main/myaccount/twitter");
        }

    }

}