<?php

class scheduler extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url());
        }
        $this->load->model('scheduler_model');
    }

    public function index() {
        $this->data['available_times'] = $this->_getAvailableTimes();
        $this->data['scheduler'] = $this->scheduler_model->get_scheduler(
            array('user_id' => $this->user->id));
        $this->_renderL('pages/scheduler/index');
    }

    public function library() {
        $this->_renderL('pages/scheduler/library');
    }

    public function library_action() {
        $action = $this->input->post('action');
        switch($action) {
            case 'list' :
                $list = $this->scheduler_model->get_scheduler_library(
                    array('library_user_id' => $this->user->id));
                echo json_encode(array('data' => $list));
                break;

            case 'save' :
                $library = $this->input->post('library');
                if(isset($library['library_id'])) {
                    $result = $this->scheduler_model->update_scheduler_library($library['library_id'], $library);
                } else {
                    $library['library_user_id'] = $this->user->id;
                    $result = $this->scheduler_model->add_scheduler_library($library);
                }
                echo json_encode($result);
                break;

            case 'delete' :
                $library_id = $this->input->post("library_id");
                $result = $this->scheduler_model->delete_scheduler_library($library_id);
                echo json_encode($result);
                break;

            default:
                echo json_encode(array(
                    'success' => false,
                    'message' => "Action not found."
                ));
        }
    }

    public function content() {
        $library = $this->scheduler_model->get_scheduler_library(
            array('library_user_id' => $this->user->id));
        $this->data['library'] = $library;
        $this->_renderL('pages/scheduler/content');
    }

    public function content_action() {
        $action = $this->input->post('action');
        switch($action) {

            case 'list' :
                $list = $this->scheduler_model->get_scheduler_content(
                    array('content_user_id' => $this->user->id));
                echo json_encode(array('data' => $list));
                break;

            case 'save' :
                $content = $this->input->post('content');
                if(isset($content['content_id'])) {
                    $result = $this->scheduler_model->update_scheduler_content($content['content_id'], $content);
                } else {
                    $content['content_user_id'] = $this->user->id;
                    $result = $this->scheduler_model->add_scheduler_content($content);
                }
                echo json_encode($result);
                break;

            case 'delete' :
                $content_id = $this->input->post("content_id");
                $result = $this->scheduler_model->delete_scheduler_content($content_id);
                echo json_encode($result);
                break;

            default:
                echo json_encode(array(
                    'success' => false,
                    'message' => "Action not found."
                ));

        }
    }

    public function _getAvailableTimes() {
        return array(
        '12 AM', '1 AM', '2 AM', '3 AM', '4 AM', '5 AM', '6 AM', '7 AM', '8 AM', '9 AM', '10 AM', '11 AM',
        '12 PM', '1 PM', '2 PM', '3 PM', '4 PM', '5 PM', '6 PM', '7 PM', '8 PM', '9 PM', '10 PM', '11 PM');
    }

} 