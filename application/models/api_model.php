<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_Model extends CI_Model {

    /*
     * Verifies the user fb access token if it's set, and expired.
     * This function always return a login Url, which is for authenticating the tool again.
     */
    public function facebook_verify_access_key($user) {
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

    public function linkedin_verify_access_key($user) {
        if($user->li_access_token) {
            $result['expired_access_token'] = false;
            // check if expired
            $li = json_decode($user->li_access_token);
            $result['expires_at'] = $li->expires_in;
            if (time() > strtotime($li->expires_in)) {
                $result['expired_access_token'] = true;
            }
        }
        $params = array(
            'response_type' => 'code',
            'client_id' => LI_CLIENT_ID,
            'scope' => 'w_share',
            'state' => uniqid('', true),
            'redirect_uri' => LI_CALLBACK
        );

        $_SESSION['li_state'] = $params['state'];

        $result['auth_url'] = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
        return $result;
    }

    public function insertPosts($post) {
        $this->db->insert('scheduler_posts', $post);
    }

    public function post($scheduler) {
        $result = array();
        switch($scheduler->module) {
            /*
             * LinkedIn
             */
            case 'LinkedIn' :
                $data = array(
                    'content' => array(
                        'title' => $scheduler->headline,
                        'description' => $scheduler->content . "\n\n" . $scheduler->keywords
                    ),
                    'visibility' => array(
                        "code" => "anyone"
                    )
                );
                if($scheduler->url) {
                    $data['content']['submitted-url'] = $scheduler->url;
                }
                $li = json_decode($scheduler->li_access_token);

                $result = $this->post_linkedin($data, $li);
                break;
            /*
             * Facebook
             */
            case 'Facebook' :
                $message = $scheduler->headline .  "\n\n" . $scheduler->content . "\n\n" . $scheduler->keywords;
                $linkData = [
                    'message' => $message,
                    'privacy' => array('value' => "EVERYONE")
                ];
                if($scheduler->url) {
                    $linkData['link'] = $scheduler->url;
                }
                $result = $this->post_facebook($linkData, $scheduler->fb_access_token);
                break;

            default:
        }
        return $result;
    }

    public function post_facebook($data, $access_token) {
        $fb = new \Facebook\Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_SECRET_KEY
        ]);

        $result = array('success' => false);
        try {
            $response = $fb->post('/me/feed', $data, $access_token);
            $graphNode = $response->getGraphNode();
            if(isset($graphNode['id'])) {
                $result['success'] = true;
                $result['link'] = "www.facebook.com/" . $graphNode['id'];
            }
        } catch(Exception $e) {
            $result['message'] = $e->getMessage();
        }
        return $result;
    }


    public function post_linkedin($data, $li) {
        $result['success'] = false;
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.linkedin.com/v1/people/~/shares");
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $li->access_token,
                'Content-Type: application/json',
                'Connection: Closed',
                'x-li-format: json'
            ));

            $xmlstr = curl_exec($ch);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $body = substr($xmlstr, $header_size);
            curl_close($ch);
            $body = json_decode($body);
            if(isset($body->updateKey)) {
                $result['success'] = true;
                $result['link'] = $body->updateUrl;
            }
        } catch(Exception $e) {
            $result['error'] = $e->getMessage();
        }
        return $result;
    }

} 