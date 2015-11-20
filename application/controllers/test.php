<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url());
        }
        if ($user->type != "admin") {
            show_404();
        }
    }

    public function index() {
        $this->title = "Merlin Leads &raquo; Test";
        $this->data['user'] = $this->session->userdata('user');
        $this->js[] = "custom/test.js";
        $this->_renderL('pages/test');
    }

    public function checkRemoteHost() {
        echo $_SERVER['REMOTE_HOST'];
    }

    /*
     * Password
     */

    public function change_password() {
        include OTHERS . "PasswordHash.php";
        $this->load->model('user_model');
        $username = $_POST['username'];
        $new_password = $_POST['password'];
        $salt = $this->_get_random_string(16);
        $hashed_password = create_hash($new_password . $salt);
        $update = array(
            'password' => $hashed_password,
            'salt' => $salt
        );
        echo $this->user_model->updateByUsername($update, $username);
    }

    public function validate_password($p) {
        include OTHERS . "PasswordHash.php";
        $this->load->model('user_model');
        $user = $this->session->userdata('user');
        $u = $this->user_model->get($user->id);
        $password = $p . $u->salt;
        return validate_password($password, $u->password);
    }

    function _get_random_string($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}
