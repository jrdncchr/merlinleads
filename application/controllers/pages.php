<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function index()
    {
        $this->title = "Merlin Leads &raquo; Home";
        $this->js[] = "custom/home.js";
        $user = $this->session->userdata('user');
        if (null != $user) {
            $this->data['user'] = $user;
        }
        redirect(base_url() . "property");
    }

    public function login()
    {
        $this->title = "Merlin Leads &raquo; Login";

        $user = $this->session->userdata('user');
        if (null != $user) {
            redirect(base_url() . "property");
        } else {
            $this->_render('pages/login');
        }
    }

    public function forget_password()
    {
        $this->title = "Merlin Leads &raquo; Forget Password";
        $user = $this->session->userdata('user');
        if (null != $user) {
            redirect(base_url() . "property");
        } else {
            $this->_render('pages/forget_password');
        }
    }

    public function contact_us()
    {
        $user = $this->session->userdata('user');
        if (null != $user) {
            $this->data['user'] = $user;
        }
        $this->title = "Merlin Leads &raquo; Contact Us";
        $this->js[] = "custom/contact_us.js";
        $this->_render('pages/contact_us');
    }

    /* public functions used not logged in */

    public function login_attempt()
    {
        $this->load->model('user_model');
        $result = $this->user_model->login($_POST['loginEmail'], $_POST['loginPassword']);
        if ($result != "OK") {
            $this->session->set_flashdata("message", "<div class='alert alert-danger'><i class='fa fa-exclamation'></i> $result</div>");
            header("Location: " . base_url());
        } else {
            header("Location: " . base_url() . "property");
        }
    }

    public function forget_password_attempt()
    {
        $email = $_POST['email'];
        $this->load->model('user_model');
        $user = $this->user_model->checkEmailFP($email);
        if ($user) {
            include OTHERS . "PasswordHash.php";
            $new_password = $this->_get_random_string(10);
            $salt = $this->_get_random_string(16);
            $hashed_password = create_hash($new_password . $salt);
            $update = array(
                'password' => $hashed_password,
                'salt' => $salt
            );
            if ($this->user_model->updateUserFP($update, $user->id)) {
                $this->load->model('email_model');
                $this->email_model->forgetPasswordSendEmail($user, $new_password);
                $this->session->set_flashdata("message", "<div class='alert alert-success'><i class='fa fa-check'></i> The new password is sent to your email!</div>");
                header("Location: " . base_url() . 'pages/forget_password');
            } else {
                $this->session->set_flashdata("message", "<div class='alert alert-danger'><i class='fa fa-exclamation'></i> Generating new password failed, please try again later.</div>");
                header("Location: " . base_url() . 'pages/forget_password');
            }
        } else {
            $this->session->set_flashdata("message", "<div class='alert alert-danger'><i class='fa fa-exclamation'></i> The email you entered was not found.</div>");
            header("Location: " . base_url() . 'pages/forget_password');
        }
    }

    public function send_email()
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/" . OTHERS . "securimage/securimage.php";
        $securimage = new Securimage();
        if ($securimage->check($_POST['captcha_code']) == false) {
            $_SESSION['message'] = "The security code entered was incorrect.";
            $this->contact_us();
        } else {
            $this->load->model('email_model');
            $this->email_model->contactUsSendEmail($_POST['email'], $_POST['message']);
        }
    }

    public function confirm_email($key)
    {
        $this->load->model('user_model');
        $confirm = $this->user_model->confirm_email($key);
        if ($confirm == "OK") {
            $user = $this->user_model->get_user_by_confirmation_key($key);

            $this->load->library('stripe_library');
            $this->stripe_library->add_subscription($user->stripe_customer_id, $user->stripe_reg_plan_id);

            $this->session->set_flashdata("message",
                "<div class='alert alert-success'>
                    <i class='fa fa-check'></i> Hi <b>" . $user->firstname . " " . $user->lastname . "</b>, your account has been confirmed!
                </div>");
        } else {
            $this->session->set_flashdata("message", "<div class='alert alert-danger'><i class='fa fa-exclamation'></i> Email confirmation failed</div>");
        }
        header("Location: " . base_url());
    }

    function _get_random_string($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}