<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin2 extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url());
        }
        if ($user->type != "admin") {
            show_404();
        }
        $this->title = "Merlin Leads &raquo; Administration";
        $this->js[] = "custom/admin/admin.js";
        $this->data['user'] = $this->session->userdata('user');
    }

    public function category() {
        $this->load->model('m2_category_model');
        $action = isset($_POST['action']) ? $_POST['action'] : false;
        if($action) {
            switch($action) {
                case "get":
                    $this->m2_category_model->get();
                    break;
                case "add":
                    $this->m2_category_model->add($_POST['info']);
                    break;
                case "update":
                    $this->m2_category_model->update($_POST['category_id'], $_POST['info']);
                    break;
                case "delete":
                    $this->m2_category_model->delete($_POST['idList']);
                    break;
                case "list":
                    $this->m2_category_model->get_list();
                    break;
                default:
                    echo json_encode(array("success" => false));
            }
        } else {
            $this->_renderA('pages/admin/m2_categories', "Templates");
        }
    }

    public function sub_category() {
        $this->load->model('m2_sub_category_model');
        $action = isset($_POST['action']) ? $_POST['action'] : false;
        if($action) {
            switch($action) {
                case "get":
                    $this->m2_sub_category_model->get();
                    break;
                case "add":
                    $this->m2_sub_category_model->add($_POST['info']);
                    break;
                case "update":
                    $this->m2_sub_category_model->update($_POST['sub_category_id'], $_POST['info']);
                    break;
                case "delete":
                    $this->m2_sub_category_model->delete($_POST['idList']);
                    break;
                default:
                    echo json_encode(array("success" => false));
            }
        } else {
            $this->load->model('m2_category_model');
            $this->data['categories'] = $this->m2_category_model->get_list();
            $this->_renderA('pages/admin/m2_sub_categories', "Templates");
        }
    }

    public function seo_builder_city() {
        $this->load->model('seo_builder_admin');
        $action = isset($_POST['action']) ? $_POST['action'] : false;
        if($action) {
            switch($action) {
                case "list":
                    return $this->seo_builder_admin->city_get_list();
                    break;
                case "get":
                    echo isset($_POST['id']) ? $this->seo_builder_admin->city_get($_POST['id']) : $this->seo_builder_admin->city_get();
                    break;
                case "add":
                    $_POST['info']['user_id'] = $_POST['info']['user_id'] == "" ? null : $_POST['info']['user_id'];
                    $this->seo_builder_admin->city_add($_POST['info']);
                    break;
                case "update":
                    $_POST['info']['user_id'] = $_POST['info']['user_id'] == "" ? null : $_POST['info']['user_id'];
                    $this->seo_builder_admin->city_update($_POST['id'], $_POST['info']);
                    break;
                case "delete":
                    $this->seo_builder_admin->city_delete($_POST['idList']);
                    break;
                case "validate_city":
                    echo $this->seo_builder_admin->city_validate($_POST['city']);
                    break;
                default:
                    echo json_encode(array("success" => false));
            }
        } else {
            $this->load->model('user_model');
            $this->data['users'] = $this->user_model->get();
            $this->_renderA('pages/admin/seo_builder_city', 'SEOBuilder');
        }
    }

    public function seo_builder_template() {
        $this->load->model('seo_builder_admin');
        $action = isset($_POST['action']) ? $_POST['action'] : false;
        if($action) {
            switch($action) {
                case "list":
                    echo $this->seo_builder_admin->template_get();
                    break;
                case "get":
                    echo isset($_POST['id']) ? $this->seo_builder_admin->template_get($_POST['id']) : $this->seo_builder_admin->template_get();
                    break;
                case "add":
                    $this->seo_builder_admin->template_add($_POST['info']);
                    break;
                case "update":
                    $this->seo_builder_admin->template_update($_POST['id'], $_POST['info']);
                    break;
                case "delete":
                    $this->seo_builder_admin->template_delete($_POST['idList']);
                    break;
                case "validate_city":
                    echo $this->seo_builder_admin->template_validate($_POST['template_name']);
                    break;
                default:
                    echo json_encode(array("success" => false));
            }
        } else {
            $this->_renderA('pages/admin/seo_builder_template', 'SEOBuilder');
        }
    }

    public function seo_builder_as_category() {
        $this->load->model('seo_builder_admin');
        $action = isset($_POST['action']) ? $_POST['action'] : false;
        if($action) {
            switch($action) {
                case "list":
                    echo json_encode(array("data" => $this->seo_builder_admin->as_category_get()));
                    break;
                case "get":
                    echo isset($_POST['id']) ? $this->seo_builder_admin->as_category_get($_POST['id']) : $this->seo_builder_admin->as_category_get();
                    break;
                case "add":
                    $this->seo_builder_admin->as_category_add($_POST['info']);
                    break;
                case "update":
                    $this->seo_builder_admin->as_category_update($_POST['id'], $_POST['info']);
                    break;
                case "delete":
                    $this->seo_builder_admin->as_category_delete($_POST['idList']);
                    break;
                case "validate_exists":
                    echo $this->seo_builder_admin->as_category_validate($_POST['to_validate']);
                    break;
                default:
                    echo json_encode(array("success" => false));
            }
        } else {
            $this->_renderA('pages/admin/seo_builder_as_category', 'SEOBuilder');
        }
    }

    public function seo_builder_as_input() {
        $this->load->model('seo_builder_admin');
        $action = isset($_POST['action']) ? $_POST['action'] : false;
        if($action) {
            switch($action) {
                case "list":
                    echo json_encode(array("data" => $this->seo_builder_admin->as_input_list(array('category_id' => $_POST['category_id']))));
                    break;
                case "get":
                    echo isset($_POST['id']) ? $this->seo_builder_admin->as_input_get($_POST['id']) : $this->seo_builder_admin->as_input_get();
                    break;
                case "add":
                    $this->seo_builder_admin->as_input_add($_POST['info']);
                    break;
                case "update":
                    $this->seo_builder_admin->as_input_update($_POST['id'], $_POST['info']);
                    break;
                case "delete":
                    $this->seo_builder_admin->as_input_delete($_POST['idList']);
                    break;
                case "validate_exists":
                    echo $this->seo_builder_admin->as_input_validate($_POST['category_id'], $_POST['to_validate']);
                    break;
                default:
                    echo json_encode(array("success" => false));
            }
        } else {
            $this->data['categories'] = $this->seo_builder_admin->as_category_get();
            $this->_renderA('pages/admin/seo_builder_as_input', 'SEOBuilder');
        }
    }

    public function seo_builder_as_option() {
        $this->load->model('seo_builder_admin');
        $action = isset($_POST['action']) ? $_POST['action'] : false;
        if($action) {
            switch($action) {
                case "list":
                    echo json_encode(array("data" => $this->seo_builder_admin->as_option_list(array('input_id' => $_POST['input_id']))));
                    break;
                case "get":
                    echo isset($_POST['id']) ? $this->seo_builder_admin->as_input_get(array('id' => $_POST['id'])) : $this->seo_builder_admin->as_input_get(array());
                    break;
                case "add":
                    $this->seo_builder_admin->as_option_add($_POST['info']);
                    break;
                case "update":
                    $this->seo_builder_admin->as_option_update($_POST['id'], $_POST['info']);
                    break;
                case "delete":
                    $this->seo_builder_admin->as_option_delete($_POST['idList']);
                    break;
                case "inputs":
                    echo json_encode($this->seo_builder_admin->as_input_list(array('category_id' => $_POST['category_id'], 'type' => 'SELECT')));
                    break;
                case "validate_exists":
                    echo $this->seo_builder_admin->as_option_validate($_POST['input_id'], $_POST['to_validate']);
                    break;
                default:
                    echo json_encode(array("success" => false));
            }
        } else {
            $this->data['categories'] = $this->seo_builder_admin->as_category_get();
            $this->_renderA('pages/admin/seo_builder_as_option', 'SEOBuilder');
        }
    }

    public function events($id = 0)
    {
        $this->load->model('events_model');
        $action = $this->input->post('action');
        if ($action) {
            switch ($action) {
                case 'property_events_list':
                    $result = $this->events_model->get();
                    echo json_encode(array("data" => $result));
                    break;
                case 'property_events_save':
                    $event = $this->input->post('event');
                    $result = $this->events_model->save($event);
                    echo json_encode($result);
                    break;
                case 'property_events_templates':
                    $this->load->model('events_templates_model');
                    $event_id = $this->input->post('event_id');
                    $result = $this->events_templates_model->get(array('event_id' => $event_id));
                    echo json_encode(array("data" => $result));
                    break;
                case 'property_events_templates_save':
                    $this->load->model('events_templates_model');
                    $template = $this->input->post('template');
                    $result = $this->events_templates_model->save($template);
                    echo json_encode($result);
                    break;
                case 'property_events_templates_delete':
                    $this->load->model('events_templates_model');
                    $template_id = $this->input->post('template_id');
                    $result = $this->events_templates_model->delete($template_id);
                    echo json_encode($result);
                    break;
                default:
                    echo json_encode(array("success" => false));
            }
        } else {
            if ($id > 0) {
                $this->data['event'] = $this->events_model->get(array('id' => $id), false);
                $this->_renderA('pages/admin/events/event', 'Events');
            } else {
                $this->_renderA('pages/admin/events/index', 'Events');
            }
        }
    }

}
