<?php

if(!defined('BASEPATH')) {
    exit("No direct access allowed");
}

class Facebook extends MY_Controller {

    /*
     * Make sure the user is logged in, else redirect to the home page.
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url() . "property");
        }
    }

    function login_callback() {
        $fb = new \Facebook\Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_SECRET_KEY
        ]);

        $helper = $fb->getRedirectLoginHelper();
        try {
            $access_token = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph return an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if(!isset($access_token)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        $oAuth2Client = $fb->getOAuth2Client();
        $tokenMetaData = $oAuth2Client->debugToken($access_token);
        $tokenMetaData->validateAppId(FB_APP_ID);
        $tokenMetaData->validateExpiration();

        if(!$access_token->isLongLived()) {
            try {
                $access_token = $oAuth2Client->getLongLivedAccessToken($access_token);
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>";
                exit;
            }
        }

        $facebook_access_token = (string) $access_token;
        $this->load->model('api_model');
        $facebook_user = $this->api_model->facebook_get_user($facebook_access_token);

        $user_account = array(
            'user_id' => $this->user->id,
            'account_id' => $facebook_user['id'],
            'type' => 'facebook',
            'access_token' => $facebook_access_token
        );

        $this->load->model('user_account_model');
        if ($this->user_account_model->save($user_account)) {
            $_SESSION['facebook_access_token'] = $facebook_access_token;
            $this->session->set_userdata('facebook_access_token', $facebook_access_token);
            redirect(base_url() . "main/myaccount/facebook");
        }
    }


    function post()
    {
        $message = $this->input->post('headline') .  "\n\n" . $this->input->post('body') . "\n\n" . $this->input->post('keywords');
        $linkData = [
            'link' => $this->input->post('link'),
            'message' => $message
        ];
        $this->load->model('api_model');
        $result = $this->api_model->post_facebook($linkData, $this->user->fb_access_token);
        echo json_encode($result);
    }

}