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
        $this->bower_components['css'][] = "fullcalendar/dist/fullcalendar.min.css";
        $this->bower_components['js'][] = "moment/min/moment.min.js";
        $this->bower_components['js'][] = "fullcalendar/dist/fullcalendar.min.js";
        $this->_renderL('pages/scheduler/fullcalendar');
    }

    public function form($id = 0) {
        $this->load->model('input_model');

        /* Get only the available modules that the user has access token set */
        $this->db->reconnect();
        $module = $this->input_model->getSchedulerSelectOptions('module');
        $available_modules = array();
        foreach($module as $m) {
            if($m->module_name == "Facebook") {
                if($this->user->fb_access_token != "") {
                    $available_modules[] = $m;
                }
            } else if($m->module_name == "LinkedIn") {
                if($this->user->li_access_token != "") {
                    $available_modules[] = $m;
                }
            } else if($m->module_name == "Twitter") {
                if($this->user->twitter_access_token != "") {
                    $available_modules[] = $m;
                }
            }
        }

        $this->data['interval'] = $this->input_model->getSchedulerSelectOptions('interval');
        $this->data['time'] = $this->input_model->getSchedulerSelectOptions('time');

        $this->load->model('property_model');
        $this->data['property'] = $this->property_model->getPropertiesForMerlinLibrary($this->user->id);


        if($id > 0) {
            /* Make sure that the parameter scheduler ID is owned by the logged in user. */
            $allow = false;
            $scheduler = $this->scheduler_model->get($this->user->id, $id);
            if($scheduler) {
                if($this->user->id == $scheduler->user_id) {
                    $allow = true;
                    $this->data['scheduler'] = $scheduler;
                    if($scheduler->type == "Merlin Library") {
                        $this->load->model('merlin_library_model');
                        $this->data['merlin_category'] = $this->merlin_library_model->category_get_where(array(
                            'library_id' => $scheduler->library_id,
                            'active' => 1
                        ));
                    }
                }
            }
            if(!$allow) {
                header("Location: " . base_url() . "scheduler");
            }
        }

        $this->data['module'] = $available_modules;
        $this->data['library'] = $this->scheduler_model->scheduler_library_get($this->user->id);

        $this->load->model('merlin_library_model');
        $this->data['merlin_library'] = $this->merlin_library_model->library_get();
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

            case 'posts_list' :
                $list = $this->scheduler_model->get_post($this->input->post('scheduler_id'));
                echo json_encode(array('data' => $list ));
                break;

            case 'merlin_category_option' :
                $this->load->model('merlin_library_model');
                $html = $this->merlin_library_model->category_get_for_option($this->input->post('library_id'));
                echo $html;
                break;

            default:
                echo json_encode(array(
                    'success' => false,
                    'message' => "Invalid Action."
                ));

        }
    }

    public function library($sub = false, $id = 0) {
        $action = $this->input->post('action');

        /* Library */
        if(!$sub) {
            if($action) {
                switch($action) {
                    case 'list' :
                        $list = $this->scheduler_model->scheduler_library_get($this->user->id);
                        echo json_encode(array('data' => $list));
                        break;

                    case 'save' :
                        $data = $this->input->post();
                        unset($data['action']);
                        $data['user_id'] = $this->user->id;
                        $result = $this->scheduler_model->scheduler_library_save($data);
                        echo json_encode($result);
                        break;

                    case 'delete' :
                        $library_id = $this->input->post("library_id");
                        $result = $this->scheduler_model->scheduler_library_delete($library_id);
                        echo json_encode($result);
                        break;

                    default:
                        echo json_encode(array(
                            'success' => false,
                            'message' => "Action not found."
                        ));
                }
            } else {
                $this->_renderL('pages/scheduler/library');
            }

        /* Form */
        } else if($sub == 'form') {
            if($id > 0) {
                $this->data['library'] = $this->scheduler_model->scheduler_library_get($this->user->id, $id);
            }
            $this->_renderL('pages/scheduler/library_form');

        /* Templates */
        } else if($sub == 'template') {
            if($action) {
                switch($action) {

                    case 'list' :
                        $library_id = $this->input->post('library_id');
                        $list = $this->scheduler_model->scheduler_user_templates_get($library_id);
                        echo json_encode(array('data' => $list));
                        break;

                    case 'save' :
                        $data = $this->input->post();
                        unset($data['action']);
                        $data['user_id'] = $this->user->id;
                        $result = $this->scheduler_model->scheduler_user_templates_save($data);
                        echo json_encode($result);
                        break;

                    case 'delete' :
                        $ids = $this->input->post('ids');
                        $result = $this->scheduler_model->scheduler_user_templates_delete($ids);
                        echo json_encode($result);
                        break;

                    default:
                        echo json_encode(array(
                            'success' => false,
                            'message' => "Action not found."
                        ));

                }

            }
        }


    }

    public function merlin_library_generate($property_id = 5, $merlin_lib_category_id = 1) {
//        $property_id = $this->input->post('property_id');
        $this->load->model('property_model');
        $property = $this->property_model->getProperty($property_id);

        $this->load->model('profile_model');
        $profile = $this->profile_model->getProfile($property->profile_id);

//        $merlin_lib_category_id = $this->input->post('merlin_lib_category_id');
        $this->load->model('merlin_library_model');
        $template = $this->merlin_library_model->category_get_next_template($merlin_lib_category_id, $this->user->id);

        $this->load->model('template_model');
        $result = array(
            'headline' => $this->template_model->generatePropertyCraiglistData($template->headline, $property, $profile, null),
            'body' => $this->template_model->generatePropertyCraiglistData($template->content, $property, $profile, null),
            'keywords' => $this->template_model->generatePropertyCraiglistData($template->keywords, $property, $profile, null)
        );
        var_dump($result);
    }
} 