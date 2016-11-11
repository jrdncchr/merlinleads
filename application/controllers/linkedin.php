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
        $linkedIn = new Happyr\LinkedIn\LinkedIn(LI_CLIENT_ID, LI_SECRET_KEY);

        if ($linkedIn->isAuthenticated()) {
            $access_token = $linkedIn->getAccessToken();
            $user = $linkedIn->get('v1/people/~:(id)');

            $user_account = array(
                'user_id' => $this->user->id,
                'account_id' => $user['id'],
                'type' => 'linkedin',
                'access_token' => $access_token->getToken()
            );

            $this->load->model('user_account_model');
            if ($this->user_account_model->save($user_account)) {
                redirect(base_url() . "main/myaccount/linkedin");
            }
        }
        exit("Something went wrong.");
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