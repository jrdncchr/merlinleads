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
        $result = array('has_valid_access_token' => false);

        $fb = new \Facebook\Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_SECRET_KEY
        ]);

        $CI =& get_instance();
        $CI->load->model('user_account_model');
        $facebook_accounts = $CI->user_account_model->get(array('user_id' => $user->id, 'type' => 'facebook'));

        if (sizeof($facebook_accounts) > 0) {
            foreach ($facebook_accounts as $account) {
                if ($account->access_token) {
                    $oAuth2Client = $fb->getOAuth2Client();
                    $tokenMetadata = $oAuth2Client->debugToken($account->access_token);
                    $accessToken = new Facebook\Authentication\AccessToken(
                        $account->access_token,
                        strtotime($tokenMetadata->getExpiresAt()->format('M d, Y'))
                    );

                    if ($accessToken->isExpired()) {
                        $a['expired_access_token'] = true;
                    } else {
                        $a['expired_access_token'] = false;
                        $a['valid_access_token'] = true;
                        $a['expires_at'] = $tokenMetadata->getExpiresAt()->format('M d, Y');
                        $a['user'] = $this->facebook_get_user($account->access_token);
                        $a['id'] = $account->id;
                        $result['has_valid_access_token'] = true;
                    }
                    $result['accounts'][] = $a;
                }
            }
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
        $result['has_valid_access_token'] = false;

        $CI =& get_instance();
        $CI->load->model('user_account_model');
        $linkedin_accounts = $CI->user_account_model->get(array('user_id' => $user->id, 'type' => 'linkedin'));

        if (sizeof($linkedin_accounts) > 0) {
            foreach ($linkedin_accounts as $account) {
                $result['has_valid_access_token'] = true;
                $linkedIn = new Happyr\LinkedIn\LinkedIn(LI_CLIENT_ID, LI_SECRET_KEY);
                $linkedIn->setAccessToken($account->access_token);
                $a['user_info'] = $linkedIn->get('v1/people/~:(id,first-name,last-name,formatted-name,picture-url)');
                $a['id'] = $account->id;
                $result['accounts'][] = $a;
            }
        }

        $linkedIn = new Happyr\LinkedIn\LinkedIn(LI_CLIENT_ID, LI_SECRET_KEY);
        $result['auth_url'] = $linkedIn->getLoginUrl(array('redirect_uri' => LI_CALLBACK));
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
                'Authorization: Bearer ' . $li,
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
        $result['has_valid_access_token'] = false;

        $CI =& get_instance();
        $CI->load->model('user_account_model');
        $twitter_accounts = $CI->user_account_model->get(array('user_id' => $user->id, 'type' => 'twitter'));

        if (sizeof($twitter_accounts) > 0) {
            foreach ($twitter_accounts as $account) {
                try {
                    $result['has_valid_access_token'] = true;
                    $access_token = json_decode($account->access_token);
                    $connection = new \Abraham\TwitterOAuth\TwitterOAuth(TWITTER_KEY, TWITTER_SECRET_KEY, $access_token->oauth_token, $access_token->oauth_token_secret);
                    $content = $connection->get("users/show", ["user_id" => $access_token->user_id]);
                    $a['user_info'] = $content;
                    $a['id'] = $account->id;
                    $result['accounts'][] = $a;
                }catch(Exception $e) {}
            }
        }
        $result['auth_url'] = $this->get_twitter_auth_url();

        return $result;
    }

    public function get_twitter_auth_url() {
        $connection = new \Abraham\TwitterOAuth\TwitterOAuth(TWITTER_KEY, TWITTER_SECRET_KEY);
        $request_token = $connection->oauth("oauth/request_token", array("oauth_callback" => "http://localhost/merlinleads/twitter/callback"));

        $oauth_token = $request_token['oauth_token'];
        $token_secret = $request_token['oauth_token_secret'];
        setcookie("token_secret", " ", time()-3600);
        setcookie("token_secret", $token_secret, time()+60*10);
        setcookie("oauth_token", " ", time()-3600);
        setcookie("oauth_token", $oauth_token, time()+60*10);
        $this->session->set_userdata('twitter_oauth_token', $oauth_token);
        $url = $connection->url("oauth/authorize", array("oauth_token" => $oauth_token));
        return $url;
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

            var_dump($response);exit;
            return $response;
        }

        $baseURI = 'https://api.twitter.com/oauth/request_token';

        $nonce = time();
        $timestamp = time();
//        $oauth_callback = "http://merlinleads.net/demo/twitter/callback";
        $oauth_callback = "http://127.0.0.1/merlinleads/twitter/callback";
        $oauth = array('oauth_callback' => $oauth_callback,
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
        if(!$response) {
            return null;
        }
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
        $this->db->insert('scheduler_posted_post', $post);
    }

    public function ot_post($post, $user_accounts) {
        $result = array();
        foreach($user_accounts as $ua) {
            switch($ua->type) {
                /*
                 * LinkedIn
                 */
                case 'linkedin' :
                    $options = array('json'=>
                        array(
                            'content' => array(
                                'description' => $post->post_linkedin_snippet
                            ),
                            'visibility' => array(
                                'code' => 'anyone'
                            )
                        )
                    );
                    if($post->post_url) {
                        $options['json']['content']['submitted-url'] = $post->post_url;
                    }

                    $r = $this->post_linkedin($options, $ua->access_token);
                    $r['module'] = $ua->type;
                    $result[] = $r;
                    break;
                /*
                 * Facebook
                 */
                case 'facebook' :
                    $linkData = [
                        'message' => $post->post_facebook_snippet,
                        'privacy' => array('value' => "EVERYONE")
                    ];
                    if($post->post_url) {
                        $linkData['link'] = $post->post_url;
                    }
                    $r = $this->post_facebook($linkData, $ua->access_token);
                    $r['module'] = $ua->type;
                    $result[] = $r;
                    break;

                case 'twitter' :
                    $message = $post->post_twitter_snippet;
                    if($post->post_url) {
                        $this->load->library('Googl');
                        $short_url = $this->googl->shorten($post->post_url);
                        $message .= "\n\n" . $short_url;
                    }
                    $r = $this->post_twitter($ua->access_token, $message);
                    $r['module'] = $ua->type;
                    $result[] = $r;
                default:
            }
        }

        return $result;
    }

    public function post($scheduler, $post, $user_accounts) {
        $result = array();
        foreach($user_accounts as $ua) {
            switch($ua->type) {
                /*
                 * LinkedIn
                 */
                case 'linkedin' :
                    $options = array('json'=>
                        array(
                            'content' => array(
                                'description' => $post->post_linkedin_snippet
                            ),
                            'visibility' => array(
                                'code' => 'anyone'
                            )
                        )
                    );
                    if($post->post_url) {
                        $options['json']['content']['submitted-url'] = $post->post_url;
                    }

                    $r = $this->post_linkedin($options, $ua->access_token);
                    $r['module'] = $ua->type;
                    $result[] = $r;
                    break;
                /*
                 * Facebook
                 */
                case 'facebook' :
                    $linkData = [
                        'message' => $post->post_facebook_snippet,
                        'privacy' => array('value' => "EVERYONE")
                    ];
                    if($post->post_url) {
                        $linkData['link'] = $post->post_url;
                    }
                    $r = $this->post_facebook($linkData, $ua->access_token);
                    $r['module'] = $ua->type;
                    $result[] = $r;
                    break;

                case 'twitter' :
                    $message = $post->post_twitter_snippet;
                    if($post->post_url) {
                        $this->load->library('Googl');
                        $short_url = $this->googl->shorten($post->post_url);
                        $message .= "\n\n" . $short_url;
                    }
                    $r = $this->post_twitter($ua->access_token, $message);
                    $r['module'] = $ua->type;
                    $result[] = $r;
                default:
            }
        }

        return $result;
    }

    public function post_event_notification($event_notification, $post, $user)
    {
        $result = array();
        $modules = explode('|', $event_notification->modules);
        foreach($modules as $m) {
            switch($m) {
                case 'linkedin' :
                    $data = array(
                        'content' => array(
                            'description' => $post->content
                        ),
                        'visibility' => array(
                            "code" => "anyone"
                        )
                    );
                    if ($post->link) {
                        $data['content']['submitted-url'] = $post->link;
                    }
                    $li = json_decode($user->li_access_token);

                    $r = $this->post_linkedin($data, $li);
                    $r['module'] = $m;
                    $result[] = $r;
                    break;
                case 'facebook' :
                    $linkData = [
                        'message' => $post->content,
                        'privacy' => array('value' => "EVERYONE")
                    ];
                    if ($post->link) {
                        $linkData['link'] = $post->link;
                    }
                    $r = $this->post_facebook($linkData, $user->fb_access_token);
                    $r['module'] = $m;
                    $result[] = $r;
                    break;
                case 'twitter' :
                    $message = $post->content;
                    if($post->post_url) {
                        $this->load->library('Googl');
                        $short_url = $this->googl->shorten($post->link);
                        $message .= "\n\n" . $short_url;
                    }
                    $r = $this->post_twitter($user->twitter_access_token, $message);
                    $r['module'] = $m;
                    $result[] = $r;
                default:
            }
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


    public function post_linkedin($options, $access_token) {
        $result['success'] = false;
        try {
            $linkedIn = new Happyr\LinkedIn\LinkedIn(LI_CLIENT_ID, LI_SECRET_KEY);
            $linkedIn->setAccessToken($access_token);
            $body = $linkedIn->post('v1/people/~/shares', $options);
            if (isset($body['updateKey'])) {
                $result['success'] = true;
                $result['link'] = $body['updateUrl'];
            }
        } catch(Exception $e) {
            $result['error'] = $e->getMessage();
        }
        return $result;
    }


} 