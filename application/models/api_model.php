<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_Model extends CI_Model {

    /*
     * GET ALL SECRET CONSTANTS
     */
    public function load() {
        $this->load->database();
        $secrets = $this->db->get('ml_secrets');
        foreach($secrets->result() as $s) {
            define($s->name, $s->value);
        }
    }

    /*
     * FACEBOOK
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
                $result['user'] = $this->facebook_get_user($user->fb_access_token);
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

    public function facebook_get_user($access_key) {
        $fb = new Facebook\Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_SECRET_KEY,
            'default_graph_version' => 'v2.2',
        ]);

        try {
            $response = $fb->get('/me?fields=id,name', $access_key);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $response->getGraphUser();
        return $user;
    }

    /*
     * LINKED IN
     */

    public function linkedin_verify_access_key($user) {
        if($user->li_access_token) {
            $result['access_token'] = $user->li_access_token;
            $result['expired_access_token'] = false;
            // check if expired
            $li = json_decode($user->li_access_token);
            $result['expires_at'] = $li->expires_in;
            if (time() > strtotime($li->expires_in)) {
                $result['expired_access_token'] = true;
            } else {
                $get_user = $this->linkedin_get_user_info(json_decode($user->li_access_token));
                if($get_user['success']) {
                    $result['user'] = $get_user['result'];
                }
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

    public function linkedin_get_user_info($li) {
        $result['success'] = false;
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,formatted-name,picture-url)?format=json");
            curl_setopt($ch, CURLOPT_HEADER, 1);
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
            $result['result'] = json_decode($body);
            $result['success'] = true;
        } catch(Exception $e) {
            $result['error'] = $e->getMessage();
        }
        return $result;

    }

    /*
     * TWITTER
     */

    public function twitter_verify_access_key($user) {
        $result['has_access_key'] = false;
        if($user->twitter_access_token) {
            $result['has_access_key'] = true;
            $access_token = json_decode($user->twitter_access_token);
            $connection = new \Abraham\TwitterOAuth\TwitterOAuth(TWITTER_KEY, TWITTER_SECRET_KEY, $access_token->oauth_token, $access_token->oauth_token_secret);
            $content = $connection->get("users/show", ["user_id" => $access_token->user_id]);
            $result['user_info'] = $content;
        }
        $result['auth_url'] = $this->get_twitter_auth_url();
        return $result;
    }

    public function get_twitter_auth_url() {
        $oauth_token = $this->generate_twitter_oauth_token();
        return "https://api.twitter.com/oauth/authorize?oauth_token=$oauth_token";
    }

    public function generate_twitter_oauth_token() {
        function buildBaseString($baseURI, $params){
            $r = array();
            ksort($params);
            foreach($params as $key=>$value){
                $r[] = "$key=" . rawurlencode($value);
            }
            return "POST&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
        }

        function getCompositeKey($consumerSecret, $requestToken){
            return rawurlencode($consumerSecret) . '&' . rawurlencode($requestToken);
        }

        function buildAuthorizationHeader($oauth){
            $r = 'Authorization: OAuth ';
            $values = array();
            foreach($oauth as $key=>$value)
                $values[] = "$key=\"" . rawurlencode($value) . "\""; //encode key=value string

            $r .= implode(', ', $values);
            return $r;
        }

        function sendRequest($oauth, $baseURI){
            $header = array( buildAuthorizationHeader($oauth), 'Expect:');

            $options = array(CURLOPT_HTTPHEADER => $header,
                CURLOPT_HEADER => false,
                CURLOPT_URL => $baseURI,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false);

            $ch = curl_init();
            curl_setopt_array($ch, $options);
            $response = curl_exec($ch);
            curl_close($ch);

            return $response;
        }

        $baseURI = 'https://api.twitter.com/oauth/request_token';

        $nonce = time();
        $timestamp = time();
        $oauth = array('oauth_callback' => 'http://localhost/merlinleads/twitter/callback',
            'oauth_consumer_key' => TWITTER_KEY,
            'oauth_nonce' => $nonce,
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => $timestamp,
            'oauth_version' => '1.0');
        $consumerSecret = TWITTER_SECRET_KEY;
        $baseString = buildBaseString($baseURI, $oauth);
        $compositeKey = getCompositeKey($consumerSecret, null);
        $oauth_signature = base64_encode(hash_hmac('sha1', $baseString, $compositeKey, true));
        $oauth['oauth_signature'] = $oauth_signature;

        $response = sendRequest($oauth, $baseURI);

        $responseArray = array();
        $parts = explode('&', $response);
        foreach($parts as $p){
            $p = explode('=', $p);
            $responseArray[$p[0]] = $p[1];
        }

        $oauth_token = $responseArray['oauth_token'];

        $this->session->set_userdata('twitter_oauth_token', $oauth_token);
        return $oauth_token;
    }


    /*
     * SCHEDULER POST
     */
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

            case 'Twitter' :
                $message = $scheduler->headline .  "\n\n" . $scheduler->content . "\n\n" . $scheduler->keywords;
                if($scheduler->url) {
                    $this->load->library('Googl');
                    $short_url = $this->googl->shorten($scheduler->url);
                    $message .= "\n\n" . $short_url;
                }
                $result = $this->post_twitter($scheduler->twitter_access_token, $message);
            default:
        }
        return $result;
    }

    public function post_twitter($twitter_access_token, $status) {
        $result = array('success' => false);
        try {
            $access_token = json_decode($twitter_access_token);
            $connection = new \Abraham\TwitterOAuth\TwitterOAuth(
                TWITTER_KEY, TWITTER_SECRET_KEY, $access_token->oauth_token, $access_token->oauth_token_secret);
            $content = $connection->post("statuses/update", ["status" => $status]);
            if(isset($content->id_str)) {
                $result['success'] = true;
                $result['link'] = "https://twitter.com/" . $content->user->screen_name . "/status/" . $content->id;
            }
        }catch (Exception $e) {
            $result['message'] = $e->getMessage();
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
                $result['link'] = "https://www.facebook.com/" . $graphNode['id'];
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