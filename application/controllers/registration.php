<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registration extends MY_Controller {

    public function __construct() {
        parent::__construct();
        include_once OTHERS . 'stripe/lib/Stripe.php';
        Stripe::setApiKey(STRIPE_SECRET_KEY);
        $this->load->library('session');
        $this->load->model('user_model');
    }

    public function index() {
        $this->title = "Merlin Leads &raquo; Registration";
        $this->js[] = "custom/registration.js";
        $this->_render('pages/registration');
    }

    public function create() {
        if ($_POST) {
            $customer = Stripe_Customer::create(array('email' => $_POST['email']));

            foreach ($_POST as $key => $value) {
                $_POST[$key] = urldecode($value);
            }

            include OTHERS . "PasswordHash.php";
            $new_password = $_POST['password'];
            $salt = $this->_get_random_string(16);
            $hashed_password = create_hash($new_password . $salt);
            $stateSplit = explode(' - ', $_POST['state']);
            $key = $this->generateRandomString();

            $user = array(
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'password' => $hashed_password,
                'salt' => $salt,
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'country' => $_POST['country'],
                'state' => $stateSplit[1],
                'state_abbr' => $stateSplit[0],
                'confirmation_key' => $key,
                'stripe_customer_id' => $customer->id,
            );
            $this->load->model('email_model');
            if ($this->user_model->add($user)) {
                echo "OK";
            }
        } else {
            $this->index();
        }
    }

    public function getCountryStates() {
        $this->load->model('input_model');
        echo $this->input_model->getCountryStates($_POST['country']);
    }

    public function thankyou() {
        $this->title = "Merlin Leads &raquo; Thank You!";
        $email = $this->session->userdata('registerEmail');
        if ($email == null) {
            redirect(base_url());
        } else {
            $this->session->unset_userdata('registerEmail');
            $this->data['email'] = $email;
            $this->_render('pages/registration_thankyou');
        }
    }

    public function checkUsername() {
        $this->user_model->checkUsername($_POST['username']);
    }

    public function checkEmail() {
        $this->user_model->checkEmail($_POST['email']);
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