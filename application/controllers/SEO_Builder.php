<?php

if(!defined('BASEPATH')) exit("No direct access allowed!");

class SEO_Builder extends MY_Controller {

    public function __construct() {
        parent::__construct(true);
        //Validate if user has an IDX feature activated.
        if(!isset($this->main_f->seo_builder) && $this->user->type != 'admin') {
            show_404("A user attempted to use IDX feature but his package does not allow the IDX feature.");
        }
        $this->load->library("custom_library");
        $this->load->model("seo_builder_model");
    }

    public function index() {
        $this->_renderL("pages/seo_builder/overview");
    }

    public function action() {
        $action = $_POST['action'];
        unset($_POST['action']);

        switch($action) {
            case "list":
                echo $this->seo_builder_model->get_list($this->user->id);
                break;

            case "save":
                $_POST['user_id'] = $this->user->id;
                $_POST['search_criteria'] = json_encode($_POST['search_criteria']);
                $post = $this->custom_library->array_decode_url($_POST); //decode uri first since bedrooms and bathrooms are using + signs
                $result =  $this->seo_builder_model->save($post);
                echo json_encode($result);
                break;

            case "delete":
                $result = $this->seo_builder_model->delete($_POST['id']);
                echo json_encode($result);
                break;

            case "generate":
                $result = $this->seo_builder_model->generate($_POST['id']);
                echo json_encode($result);
                break;

            case "category_inputs":
                $inputs = $this->seo_builder_model->get_category_inputs($_POST['category_id']);
                echo json_encode($inputs);
                break;

            default:
                echo json_encode(array("success" => false, "message" => "Action did not match any of the available actions."));
        }
    }

    public function manage($id = 0) {
        if($id > 0) {
            $seo = $this->seo_builder_model->get($id);
            if($seo) {
                if($seo->user_id == $this->user->id) {
                    $this->data["seo"] = $seo;
                } else {
                    $this->index();
                }
            } else {
                $this->index();
            }
        }
        $this->load->model('profile_model');
        $this->data['profiles'] = $this->profile_model->getProfilesByUser($this->user->id);

        $this->load->model('seo_builder_admin');
        $this->data['cities'] = $this->seo_builder_admin->city_get(array("user_id" => $this->user->id));
        $this->data['categories'] = $this->seo_builder_admin->as_category_get();
        $this->data['templates'] = $this->seo_builder_admin->get_template();
        $this->_renderL("pages/seo_builder/manage");
    }


} 