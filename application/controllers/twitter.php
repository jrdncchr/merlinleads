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

        $user_account = array(
            'user_id' => $this->user->id,
            'account_id' => $access_token['user_id'],
            'type' => 'twitter',
            'access_token' => (string) json_encode($access_token)
        );

        $this->load->model('user_account_model');
        if ($this->user_account_model->save($user_account)) {
            redirect(base_url() . "main/myaccount/twitter");
        }

    }

}