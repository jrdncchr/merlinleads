<?php

class linkedin extends MY_Controller {

    /* Make sure the user is logged in, else redirect to the home page.
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url() . "property");
        }
    }

    public function auth() {
        if($_GET['state'] == $_SESSION['li_state']) {
            if(isset($_GET['code'])) {

                $params = array(
                    'grant_type' => 'authorization_code',
                    'client_id' => LI_CLIENT_ID,
                    'client_secret' => LI_SECRET_KEY,
                    'code' => $_GET['code'],
                    'redirect_uri' => LI_CALLBACK
                );

                // Access Token request
                $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_TIMEOUT, '3');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $xmlstr = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if($http_code == 200) {
                    $token = json_decode($xmlstr);
                    $token->expires_in = date("M d, Y", time() + $token->expires_in);
                    $this->load->model('user_model');
                    $update = array(
                        'li_access_token' => (string) json_encode($token)
                    );

                    if($this->user_model->updateInfo($update, $this->user->id)) {
                        redirect(base_url() . "main/myaccount/linkedin");
                    }
                }
            }
        } else {
            exit("Something went wrong.");
        }
    }

    public function post() {
        $li = json_decode($this->user->li_access_token);
        $data = array(
            'content' => array(
                'title' => $this->input->post('headline'),
                'description' => $this->input->post('body') . "\n\n" . $this->input->post('keywords'),
                'submitted-url' => $this->input->post('link')
            ),
            'visibility' => array(
                "code" => "anyone"
            )
        );
        $this->load->model('api_model');
        $post = $this->api_model->post_linkedin($data , $li);
        echo json_encode($post);
    }

}