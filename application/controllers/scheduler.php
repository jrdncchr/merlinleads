<?php

class scheduler extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url() . "property");
        }
        $this->load->model('scheduler_model');
    }

    public function index() {
        $this->_renderL('pages/scheduler/overview');
    }

    public function form($id = 0) {
        $this->load->model('input_model');;
        $this->data['module'] = $this->input_model->getSchedulerSelectOptions('module');
        $this->data['interval'] = $this->input_model->getSchedulerSelectOptions('interval');
        $this->data['time'] = $this->input_model->getSchedulerSelectOptions('time');

        if($id > 0) {
            /* Make sure that the parameter scheduler ID is owned by the logged in user.
             */
            $allow = false;
            $scheduler = $this->scheduler_model->get($this->user->id, $id);
            if($scheduler) {
                if($this->user->id == $scheduler->user_id) {
                    $this->data['scheduler'] = $scheduler;
                    $allow = true;
                }
            }
            if(!$allow) {
                header("Location: " . base_url() . "scheduler");
            }
        }

        $this->_renderL('pages/scheduler/form');
    }

    public function action() {
        $action = $this->input->post('action');

        switch($action) {

            case 'list' :
                $list = $this->scheduler_model->get($this->user->id);
                echo json_encode(array('data' => $list));
                break;

            case 'save' :
                $data = $this->input->post();
                $data['scheduler']['user_id'] = $this->user->id;
                $result = $this->scheduler_model->save($data);
                echo json_encode($result);
                break;

            case 'delete' :
                $result = $this->scheduler_model->delete(
                    $this->input->post('scheduler_id'), $this->input->post('content_id'));
                echo json_encode($result);
                break;

            default:
                echo json_encode(array(
                    'success' => false,
                    'message' => "Invalid Action."
                ));

        }
    }
} 