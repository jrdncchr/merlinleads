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
        $this->load->model('merlin_library_model');
    }

    public function index() {
        $this->load->model('api_model');
        $this->data['fb'] = $this->api_model->facebook_verify_access_key($this->user);
        $this->data['linkedIn'] = $this->api_model->linkedin_verify_access_key($this->user);
        $this->data['twitter'] = $this->api_model->twitter_verify_access_key($this->user);

        $this->load->model('profile_model');
        $this->data['profile'] = $this->profile_model->getProfilesByUser($this->user->id);

        $this->load->model('property_model');
        $this->data['property'] = $this->property_model->getPropertiesForMerlinLibrary($this->user->id);

        $this->data['available_times'] = $this->_getAvailableTimes();
        $this->data['scheduler'] = $this->scheduler_model->get_scheduler_details(
            array('user_id' => $this->user->id));
        $this->data['user_category'] = $this->scheduler_model->get_scheduler_category(
            array('category_user_id' => $this->user->id));
        $this->data['merlin_category'] = $this->merlin_library_model->get_category(array('active' => 1));
        $this->_renderL('pages/scheduler/index');
    }

    public function scheduler_action() {
        $action = $this->input->post('action');
        switch($action) {
            case 'save' :
                $scheduler = $this->input->post('scheduler');
                if(isset($scheduler['scheduler_id'])) {
                    $result = $this->scheduler_model->update_scheduler($scheduler['scheduler_id'], $scheduler);
                } else {
                    $scheduler['user_id'] = $this->user->id;
                    $result = $this->scheduler_model->add_scheduler($scheduler);
                }
                echo json_encode($result);
                break;

            case 'delete' :
                $scheduler_id = $this->input->post("scheduler_id");
                $result = $this->scheduler_model->delete_scheduler($scheduler_id);
                echo json_encode($result);
                break;

            default:
                echo json_encode(array(
                    'success' => false,
                    'message' => "Action not found."
                ));
        }
    }

    public function category() {
        $this->_renderL('pages/scheduler/category');
    }

    public function category_action() {
        $action = $this->input->post('action');
        switch($action) {
            case 'list' :
                $list = $this->scheduler_model->get_scheduler_category(
                    array('category_user_id' => $this->user->id));
                echo json_encode(array('data' => $list));
                break;

            case 'save' :
                $category = $this->input->post('category');
                if(isset($category['category_id'])) {
                    $result = $this->scheduler_model->update_scheduler_category($category['category_id'], $category);
                } else {
                    $category['category_user_id'] = $this->user->id;
                    $result = $this->scheduler_model->add_scheduler_category($category);
                }
                echo json_encode($result);
                break;

            case 'delete' :
                $category_id = $this->input->post("category_id");
                $result = $this->scheduler_model->delete_scheduler_category($category_id);
                echo json_encode($result);
                break;

            default:
                echo json_encode(array(
                    'success' => false,
                    'message' => "Action not found."
                ));
        }
    }

    public function post() {
        $this->load->model('api_model');
        $this->data['fb'] = $this->api_model->facebook_verify_access_key($this->user);
        $this->data['linkedIn'] = $this->api_model->linkedin_verify_access_key($this->user);
        $this->data['twitter'] = $this->api_model->twitter_verify_access_key($this->user);

        $this->data['available_times'] = $this->_getAvailableTimes();
        $category = $this->scheduler_model->get_scheduler_category(
            array('category_user_id' => $this->user->id));
        $this->data['category'] = $category;
        $this->_renderL('pages/scheduler/post');
    }

    public function post_action() {
        $action = $this->input->post('action');
        switch($action) {

            case 'list' :
                $list = $this->scheduler_model->get_scheduler_post(
                    array('post_user_id' => $this->user->id));
                echo json_encode(array('data' => $list));
                break;

            case 'save' :
                $post = $this->input->post('post');
                if(isset($post['post_id'])) {
                    $result = $this->scheduler_model->update_scheduler_post($post['post_id'], $post);
                } else {
                    $post['post_user_id'] = $this->user->id;
                    $result = $this->scheduler_model->add_scheduler_post($post);
                }
                echo json_encode($result);
                break;

            case 'delete' :
                $post_id = $this->input->post("post_id");
                $result = $this->scheduler_model->delete_scheduler_post($post_id);
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