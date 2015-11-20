<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Generic_Post extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url());
        }

        $this->load->model("property_model");
        $this->load->model("m2_sub_category_model");
        $this->load->model("m2_category_model");
        $this->load->model("m2_post_model");

        $this->title = "Merlin Leads &raquo; Generic Post";
        $this->data['user'] = $this->session->userdata('user');
        $this->data['selectedModule'] = $this->session->userdata("selectedModule");
    }

    public function blog() {
        if(isset($_POST['action'])) {
            $user = $this->session->userdata('user');
            $profile_id = explode(',', $this->session->userdata('selectedProfile'))[0];
            switch($_POST['action']) {
                case "get":
                    $this->m2_post_model->get(array("user_id" => $user->id, "module" => "BLOG", "category_type" => "Generic"));
                    break;
                case "add":
                    $_POST['info']['user_id'] = $user->id;
                    $_POST['info']['profile_id'] = $profile_id;
                    $_POST['info']['module'] = "BLOG";
                    $this->m2_post_model->add($_POST['info']);
                    break;
                case "update":
                    $this->m2_post_model->update($_POST['post_id'], $_POST['info']);
                    break;
                case "delete":
                    $this->m2_post_model->delete($_POST['idList']);
                    break;
                case "generate":
                    $generated = $this->m2_post_model->generate($_POST['subCategory'], $profile_id);
                    echo json_encode($generated);
                    break;
                case "list":
                    echo json_encode(
                        $this->m2_post_model->get_unsaved_subcategory($_POST['categoryId'], $user->id, "BLOG")
                    );
                    break;
            }
        } else {
            $this->data['categories'] = $this->m2_category_model->get_list("Generic");
            $this->_renderL("pages/m2_post/generic_blog");
        }
    }

    public function facebook() {
        if(isset($_POST['action'])) {
            $user = $this->session->userdata('user');
            $profile_id = explode(',', $this->session->userdata('selectedProfile'))[0];
            switch($_POST['action']) {
                case "get":
                    $this->m2_post_model->get(array("user_id" => $user->id, "module" => "FACEBOOK", "category_type" => "Generic"));
                    break;
                case "add":
                    $_POST['info']['user_id'] = $user->id;
                    $_POST['info']['profile_id'] = $profile_id;
                    $_POST['info']['module'] = "FACEBOOK";
                    $this->m2_post_model->add($_POST['info']);
                    break;
                case "update":
                    $this->m2_post_model->update($_POST['post_id'], $_POST['info']);
                    break;
                case "delete":
                    $this->m2_post_model->delete($_POST['idList']);
                    break;
                case "generate":
                    $generated = $this->m2_post_model->generate($_POST['subCategory'], $profile_id);
                    echo json_encode($generated);
                    break;
                case "list":
                    echo json_encode(
                        $this->m2_post_model->get_unsaved_subcategory($_POST['categoryId'], $user->id, "FACEBOOK")
                    );
                    break;
            }
        } else {
            $this->data['categories'] = $this->m2_category_model->get_list("Generic");
            $this->_renderL("pages/m2_post/generic_facebook");
        }
    }

    public function google_plus() {
        if(isset($_POST['action'])) {
            $user = $this->session->userdata('user');
            $profile_id = explode(',', $this->session->userdata('selectedProfile'))[0];
            switch($_POST['action']) {
                case "get":
                    $this->m2_post_model->get(array("user_id" => $user->id, "module" => "GOOGLE_PLUS", "category_type" => "Generic"));
                    break;
                case "add":
                    $_POST['info']['user_id'] = $user->id;
                    $_POST['info']['profile_id'] = $profile_id;
                    $_POST['info']['module'] = "GOOGLE_PLUS";
                    $this->m2_post_model->add($_POST['info']);
                    break;
                case "update":
                    $this->m2_post_model->update($_POST['post_id'], $_POST['info']);
                    break;
                case "delete":
                    $this->m2_post_model->delete($_POST['idList']);
                    break;
                case "generate":
                    $generated = $this->m2_post_model->generate($_POST['subCategory'], $profile_id);
                    echo json_encode($generated);
                    break;
                case "list":
                    echo json_encode(
                        $this->m2_post_model->get_unsaved_subcategory($_POST['categoryId'], $user->id, "GOOGLE_PLUS")
                    );
                    break;
            }
        } else {
            $this->data['categories'] = $this->m2_category_model->get_list("Generic");
            $this->_renderL("pages/m2_post/generic_google_plus");
        }
    }

}