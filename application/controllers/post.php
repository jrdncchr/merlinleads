<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Post extends MY_Controller {

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

        $this->title = "Merlin Leads &raquo; Post Property";
        $this->data['user'] = $this->session->userdata('user');
        $this->data['selectedModule'] = $this->session->userdata("selectedModule");
    }

    public function blog($poId = 0) {
        if($poId) {
            $property_overview = $this->property_model->getOverview($poId);
            $this->session->set_userdata("selectedPropertyId", $property_overview->property_id);
            $this->data['categories'] = $this->m2_category_model->get_list("Property");
            $this->data['property_overview'] = $property_overview;
            $this->_renderL("pages/m2_post/blog");
        } else {
            $user = $this->session->userdata('user');
            $property_id = $this->session->userdata("selectedPropertyId");
            $profile_id = explode(',', $this->session->userdata('selectedProfile'))[0];
            switch($_POST['action']) {
                case "get":
                    $this->m2_post_model->get(array(
                        "property_id"    => $property_id,
                        "module"         => "BLOG",
                        "category_type"  => "Property")
                    );
                    break;
                case "add":
                    $_POST['info']['property_id'] = $property_id;
                    $_POST['info']['profile_id'] = $profile_id;
                    $_POST['info']['user_id'] = $user->id;
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
                    $generated = $this->m2_post_model->generate($_POST['subCategory'], $profile_id, $property_id);
                    echo json_encode($generated);
                    break;
                case "list":
                    echo json_encode(
                        $this->m2_post_model->get_unsaved_subcategory($_POST['categoryId'], $user->id, "BLOG", $property_id)
                    );
                    break;
            }
        }
    }

    public function facebook($poId = 0) {
        if($poId) {
            $property_overview = $this->property_model->getOverview($poId);
            $this->session->set_userdata("selectedPropertyId", $property_overview->property_id);
            $this->data['categories'] = $this->m2_category_model->get_list("Property");
            $this->data['property_overview'] = $property_overview;
            $this->_renderL("pages/m2_post/facebook");
        } else {
            $user = $this->session->userdata('user');
            $property_id = $this->session->userdata("selectedPropertyId");
            $profile_id = explode(',', $this->session->userdata('selectedProfile'))[0];
            switch($_POST['action']) {
                case "get":
                    $this->m2_post_model->get(array("property_id" => $property_id, "module" => "FACEBOOK", "category_type"  => "Property"));
                    break;
                case "add":
                    $_POST['info']['property_id'] = $property_id;
                    $_POST['info']['profile_id'] = $profile_id;
                    $_POST['info']['user_id'] = $user->id;
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
                    $generated = $this->m2_post_model->generate($_POST['subCategory'], $profile_id, $property_id);
                    echo json_encode($generated);
                    break;
                case "list":
                    echo json_encode(
                        $this->m2_post_model->get_unsaved_subcategory($_POST['categoryId'], $user->id, "FACEBOOK", $property_id)
                    );
                    break;
            }
        }
    }

    public function google_plus($poId = 0) {
        if($poId) {
            $property_overview = $this->property_model->getOverview($poId);
            $this->session->set_userdata("selectedPropertyId", $property_overview->property_id);
            $this->data['categories'] = $this->m2_category_model->get_list("Property");
            $this->data['property_overview'] = $property_overview;
            $this->_renderL("pages/m2_post/google_plus");
        } else {
            $user = $this->session->userdata('user');
            $property_id = $this->session->userdata("selectedPropertyId");
            $profile_id = explode(',', $this->session->userdata('selectedProfile'))[0];
            switch($_POST['action']) {
                case "get":
                    $this->m2_post_model->get(array("property_id" => $property_id, "module" => "GOOGLE_PLUS", "category_type"  => "Property"));
                    break;
                case "add":
                    $_POST['info']['property_id'] = $property_id;
                    $_POST['info']['profile_id'] = $profile_id;
                    $_POST['info']['user_id'] = $user->id;
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
                    $generated = $this->m2_post_model->generate($_POST['subCategory'], $profile_id, $property_id);
                    echo json_encode($generated);
                    break;
                case "list":
                    echo json_encode(
                        $this->m2_post_model->get_unsaved_subcategory($_POST['categoryId'], $user->id, "GOOGLE_PLUS", $property_id)
                    );
                    break;
            }
        }
    }

    public function linked_in($poId = 0) {
        if($poId) {
            $property_overview = $this->property_model->getOverview($poId);
            $this->session->set_userdata("selectedPropertyId", $property_overview->property_id);
            $this->data['categories'] = $this->m2_category_model->get_list("Property");
            $this->data['property_overview'] = $property_overview;
            $this->_renderL("pages/m2_post/linked_in");
        } else {
            $user = $this->session->userdata('user');
            $property_id = $this->session->userdata("selectedPropertyId");
            $profile_id = explode(',', $this->session->userdata('selectedProfile'))[0];
            switch($_POST['action']) {
                case "get":
                    $this->m2_post_model->get(array("property_id" => $property_id, "module" => "LINKED_IN", "category_type"  => "Property"));
                    break;
                case "add":
                    $_POST['info']['property_id'] = $property_id;
                    $_POST['info']['profile_id'] = $profile_id;
                    $_POST['info']['user_id'] = $user->id;
                    $_POST['info']['module'] = "LINKED_IN";
                    $this->m2_post_model->add($_POST['info']);
                    break;
                case "update":
                    $this->m2_post_model->update($_POST['post_id'], $_POST['info']);
                    break;
                case "delete":
                    $this->m2_post_model->delete($_POST['idList']);
                    break;
                case "generate":
                    $generated = $this->m2_post_model->generate($_POST['subCategory'], $profile_id, $property_id);
                    echo json_encode($generated);
                    break;
                case "list":
                    echo json_encode(
                        $this->m2_post_model->get_unsaved_subcategory($_POST['categoryId'], $user->id, "LINKED_IN", $property_id)
                    );
                    break;
            }
        }
    }

    public function idx($poId = 0) {
        if($poId) {
            $property_overview = $this->property_model->getOverview($poId);
            $this->session->set_userdata("selectedPropertyId", $property_overview->property_id);
            $this->data['categories'] = $this->m2_category_model->get_list("Property");
            $this->data['property_overview'] = $property_overview;
            $this->_renderL("pages/m2_post/idx");
        } else {
            $user = $this->session->userdata('user');
            $property_id = $this->session->userdata("selectedPropertyId");
            $profile_id = explode(',', $this->session->userdata('selectedProfile'))[0];
            switch($_POST['action']) {
                case "get":
                    $this->m2_post_model->get(array("property_id" => $property_id, "module" => "IDX", "category_type"  => "Property"));
                    break;
                case "add":
                    $_POST['info']['property_id'] = $property_id;
                    $_POST['info']['profile_id'] = $profile_id;
                    $_POST['info']['user_id'] = $user->id;
                    $_POST['info']['module'] = "IDX";
                    $this->m2_post_model->add($_POST['info']);
                    break;
                case "update":
                    $this->m2_post_model->update($_POST['post_id'], $_POST['info']);
                    break;
                case "delete":
                    $this->m2_post_model->delete($_POST['idList']);
                    break;
                case "generate":
                    $generated = $this->m2_post_model->generate($_POST['subCategory'], $profile_id, $property_id);
                    echo json_encode($generated);
                    break;
                case "list":
                    echo json_encode(
                        $this->m2_post_model->get_unsaved_subcategory($_POST['categoryId'], $user->id, "IDX", $property_id)
                    );
                    break;
            }
        }
    }

}