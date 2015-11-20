<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url());
        }
        if ($user->type != "admin") {
            redirect(base_url());
        }
        $this->load->model('user_model');
    }

    public function getUserDetails() {
        $result = array();
        $this->load->model('user_model');
        $this->load->model('package_model');
        $user = $this->user_model->get($_POST['user_id']);
        $result['user'] = $user;
        $this->load->model('input_model');
        $result['state'] = $this->input_model->getCountryStates($user->country, $user->state_abbr);
        echo json_encode($result);
    }

    public function updateUserDetails() {
        $stateSplit = explode(' - ', trim($_POST['state']));
        $update = array(
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'country' => $_POST['country'],
            'state' => $stateSplit[1],
            'state_abbr' => $stateSplit[0],
            'type' => $_POST['type'],
            'status' => $_POST['status']
        );
        $this->load->model('package_model');
        $this->user_model->updateUser($update, $_POST['user_id']);
    }

    function loginUser() {
        $id = $_POST['id'];
        $user = $this->user_model->get($id);
        //session_start();
        $_SESSION['user'] = $user;
        $this->load->library('session');
        $this->session->set_userdata('user', $user);
        echo "OK";
    }

    public function changePassword() {
        include OTHERS . "PasswordHash.php";
        $new_password = $_POST['newPassword'];
        $this->load->library('custom_library');
        $salt = $this->custom_library->get_random_string(16);
        $hashed_password = create_hash($new_password . $salt);
        $update = array(
            'password' => $hashed_password,
            'salt' => $salt
        );
        $this->load->model('user_model');
        echo $this->user_model->update($update, $_POST['id']);
    }

    public function deleteUser() {
        $id = $_POST['id'];
        $this->user_model->delete($id);
    }

}