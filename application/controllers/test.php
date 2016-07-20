<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends MY_Controller {

    public function index() {
        $this->load->model('email_model');
        $this->email_model->sendConfirmationEmail('danero.jrc@gmail.com', 'test');
    }

}
