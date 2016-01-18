<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Facebook_Model extends CI_Model {

    /*
     * Verifies the user fb access token if it's set, and expired.
     * This function always return a login Url, which is for authenticating the tool again.
     */
    public function verify_access_key($user) {
        $result = array();
        $fb = new \Facebook\Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_SECRET_KEY
        ]);


        if($user->fb_access_token) {
            $oAuth2Client = $fb->getOAuth2Client();
            $tokenMetadata = $oAuth2Client->debugToken($user->fb_access_token);
            $accessToken = new Facebook\Authentication\AccessToken(
                $user->fb_access_token,
                strtotime($tokenMetadata->getExpiresAt()->format('M d, Y'))
            );


            if($accessToken->isExpired()) {
                $result['valid_access_token'] = false;
                $result['expired_access_token'] = true;
            } else {
                $result['valid_access_token'] = true;
                $result['expires_at'] = $tokenMetadata->getExpiresAt()->format('M d, Y');
            }
        } else {
            $result['valid_fb_access_token'] = false;
        }


        $helper = $fb->getRedirectLoginHelper();

        // We only ask authentication for the Publish action, w/c allows us to post in the user's feed.
        $permissions = ['publish_actions'];
        $loginUrl = $helper->getLoginUrl(base_url() . "facebook/login_callback", $permissions);
        $result['login_url'] = $loginUrl;

        return $result;

    }

} 