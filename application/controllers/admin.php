<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MY_Controller
{

    /*
     * Check first if the user that goes to this controller is type admin.
     */
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
        $this->data['user'] = $this->session->userdata('user');

        $this->load->model('template_model');
        $this->load->model('package_model');
        $this->load->model('hs_cta_model');
        $this->load->model('slideshare_model');
    }

    /*
     * The default value to shown in the admin page is the Youtube Template template no. 1 
     */
    public function index()
    {
        $this->templates();
    }

    public function modules() {
        filter_var_array($_POST, FILTER_SANITIZE_STRING);
        if(isset($_POST['action'])) {
            $this->load->model("modules_model");
            switch($_POST["action"])
            {
                case "list":
                    $modules = $this->modules_model->get();
                    echo json_encode(array("data" => $modules));
                    break;
                case "toggle":
                    echo $this->modules_model->toggle($_POST['module_id'], $_POST['module_enabled']);
                    break;
                default:
                    $this->output->set_status_header("400");
                    echo json_encode(array("error" => "Action is unknown"));
                    break;
            }
        } else {
             $this->_renderA("pages/admin/modules", "Modules");
        }
    }

    public function templates() {
        $this->load->model('modules_model');
        $this->data['modules'] = $this->modules_model->get_modules("M1", true);
        $this->load->model('template_model');
        $this->data['template_count'] = $this->template_model->getPropertyMediaTemplatesCountForInput('youtube', 1);
        $this->data['template'] = $this->template_model->getPropertyMediaTemplate('youtube', 1);

        $this->title = "Merlin Leads &raquo; Administration";
        $this->js[] = "custom/admin/admin_templates.js";
        $this->js[] = "custom/admin/admin.js";
        $this->_renderA('pages/admin/admin_templates', "Templates");
    }

    public function short_codes()
    {
        $this->load->model('modules_model');
        $this->data['modules'] = $this->modules_model->get_modules("M1");
        $this->load->model('template_model');
        $this->data['template_sc_types'] = $this->template_model->getPropertyTemplateScTypesForInput('youtube');

        $this->title = "Merlin Leads &raquo; Administration";
        $this->js[] = "custom/admin/admin_shortcodes.js";
        $this->js[] = "custom/admin/admin.js";
        $this->_renderA("pages/admin/admin_shortcodes", "Short Codes");
    }

    public function hs_cta()
    {
        $this->data['default'] = $this->hs_cta_model->getHsCtaId("Classified Ads", "Headline Statement");

        $this->title = "Merlin Leads &raquo; Administration";
        $this->js[] = "custom/admin/admin_hs_cta.js";
        $this->js[] = "custom/admin/admin.js";
        $this->_renderA("pages/admin/admin_hs_cta", "Templates");
    }

    public function users()
    {
        $this->title = "Merlin Leads &raquo; Administration";
        $this->js[] = "custom/admin/admin_users.js";
        $this->js[] = "custom/admin/admin.js";
        $this->_renderA("pages/admin/admin_users", "Users");
    }

    public function slideshare()
    {
        $images = $this->slideshare_model->getBackgrounds();
        if (null != $images) {
            $this->data['images'] = $images;
        }
        $this->title = "Merlin Leads &raquo; Administration";
        $this->js[] = "custom/admin/admin_slideshare.js";
        $this->js[] = "custom/admin/admin.js";
        $this->_renderA("pages/admin/admin_slideshare", "Modules");
    }

    public function packages()
    {
        $packages = $this->package_model->getPackage();
        $packages_features = $this->package_model->get_packages_features();

        $this->data['packages_features'] = $packages_features;
        $this->data['packages'] = $packages;
        $this->title = "Merlin Leads &raquo; Administration";
        $this->js[] = "custom/admin/admin_store.js";
        $this->js[] = "custom/admin/admin.js";
        $this->_renderA("pages/admin/admin_store", "Packages");
    }

    public function scheduler_merlin_category() {
        $this->_renderA('pages/admin/scheduler_merlin_category', 'Scheduler');
    }

    public function scheduler_category_action() {
        $action = $this->input->post('action');
        $this->load->model('merlin_library_model');
        switch($action) {
            case 'list' :
                $list = $this->merlin_library_model->get_category(array('active' => 1));
                echo json_encode(array('data' => $list));
                break;

            case 'save' :
                $category = $this->input->post('category');
                if(isset($category['category_id'])) {
                    $result = $this->merlin_library_model->update_category($category['category_id'], $category);
                } else {
                    $result = $this->merlin_library_model->add_category($category);
                }
                echo json_encode($result);
                break;

            case 'delete' :
                $category_id = $this->input->post("category_id");
                $result = $this->merlin_library_model->delete_category($category_id);
                echo json_encode($result);
                break;

            default:
                echo json_encode(array(
                    'success' => false,
                    'message' => "Action not found."
                ));
        }
    }

    public function scheduler_merlin_post() {
        $this->load->model('merlin_library_model');
        $category = $this->merlin_library_model->get_category(array('active' => 1));
        $this->data['category'] = $category;
        $this->_renderA('pages/admin/scheduler_merlin_post', 'Scheduler');
    }

    public function scheduler_post_action() {
        $this->load->model('merlin_library_model');
        $action = $this->input->post('action');
        switch($action) {

            case 'list' :
                $list = $this->merlin_library_model->get_post();
                echo json_encode(array('data' => $list));
                break;

            case 'save' :
                $post = $this->input->post('post');
                if(isset($post['post_id'])) {
                    $result = $this->merlin_library_model->update_post($post['post_id'], $post);
                } else {
                    $result = $this->merlin_library_model->add_post($post);
                }
                echo json_encode($result);
                break;

            case 'delete' :
                $post_id = $this->input->post("post_id");
                $result = $this->merlin_library_model->delete_post($post_id);
                echo json_encode($result);
                break;

            default:
                echo json_encode(array(
                    'success' => false,
                    'message' => "Action not found."
                ));

        }
    }

    public function scheduler_blog_post() {
        $this->load->model('merlin_library_model');
        $category = $this->merlin_library_model->get_category(array('active' => 1));
        $this->data['category'] = $category;
        $this->_renderA('pages/admin/scheduler_merlin_blog_post', 'Scheduler');
    }

    public function scheduler_blog_post_action() {
        $this->load->model('merlin_library_model');
        $action = $this->input->post('action');
        switch($action) {

            case 'list' :
                $list = $this->merlin_library_model->get_blog_post();
                echo json_encode(array('data' => $list));
                break;

            case 'save' :
                $post = $this->input->post('post');
                if(isset($post['bp_id'])) {
                    $result = $this->merlin_library_model->update_blog_post($post['bp_id'], $post);
                } else {
                    $result = $this->merlin_library_model->add_blog_post($post);
                }
                echo json_encode($result);
                break;

            case 'delete' :
                $post_id = $this->input->post("bp_id");
                $result = $this->merlin_library_model->delete_blog_post($post_id);
                echo json_encode($result);
                break;

            default:
                echo json_encode(array(
                    'success' => false,
                    'message' => "Action not found."
                ));

        }
    }

    /*
     * Cities / Zipcodes
     */

    public function cities_zipcodes() {
        $this->_renderA('pages/admin/cities_zipcodes', 'CitiesZipcodes');
    }

    public function cities_zipcodes_users() {
        $this->load->model('city_zipcode_model');
        $this->data['cz'] = $this->city_zipcode_model->get_cz();
        $this->_renderA('pages/admin/cities_zipcodes_users', 'CitiesZipcodes');
    }

    public function cities_zipcodes_requests() {
        $this->_renderA('pages/admin/cities_zipcodes_requests', 'CitiesZipcodes');
    }

    public function cities_zipcodes_action() {
        $this->load->model('city_zipcode_model');

        $action = $this->input->post('action');
        switch($action) {
            case 'czu_list' :
                $list = $this->city_zipcode_model->get_czu();
                echo json_encode(array('data' => $list));
                break;

            case 'czu_save' :
                $czu = $this->input->post('czu');
                if(isset($czu['czu_id'])) {
                    if($this->input->post('old_cz') != $czu['czu_cz_id']) {
                        $result = $this->city_zipcode_model->validate_czu($czu);
                    } else {
                        $result = array('success' => true);
                    }
                } else {
                    $result = $this->city_zipcode_model->validate_czu($czu);
                }

                if($result['success']) {
                    if(isset($czu['czu_id'])) {
                        $result = $this->city_zipcode_model->update_czu($czu['czu_id'], $czu);
                    } else {
                        $this->load->model('user_model');
                        $user = $this->user_model->getByEmail($this->input->post('email'));
                        if($user) {
                            $czu['czu_user_id'] = $user->id;
                            $result = $this->city_zipcode_model->add_czu($czu);
                        } else {
                            $result = array('success' => false, 'message' => 'User email not found.');
                        }
                    }
                }

                echo json_encode($result);
                break;

            case 'czu_delete' :
                $czu_id = $this->input->post("czu_id");
                $result = $this->city_zipcode_model->delete_czu($czu_id);
                echo json_encode($result);
                break;

            case 'czr_list' :
                $list = $this->city_zipcode_model->get_czr_admin(array('czr_status !=' => 'approved'));
                echo json_encode(array('data' => $list));
                break;

            case 'czr_save' :
                $status = $this->input->post('status');
                $czr_id = $this->input->post('czr_id');
                if($status == 'approved') {
                    $czr = $this->city_zipcode_model->get_czr(array('czr_id' => $czr_id), false);
                    $new_cz = array(
                        'cz_city' => $czr->czr_city,
                        'cz_zipcode' => $czr->czr_zipcode
                    );
                    $this->city_zipcode_model->add_cz($new_cz);
                }
                $result = $this->city_zipcode_model->update_czr($czr_id, array('czr_status' => $status));
                echo json_encode($result);
                break;

            case 'list' :
                $list = $this->city_zipcode_model->get_cz();
                echo json_encode(array('data' => $list));
                break;

            case 'save' :
                $cz = $this->input->post('cz');
                if(isset($post['cz_id'])) {
                    $result = $this->city_zipcode_model->update_cz($cz['cz_id'], $cz);
                } else {
                    $result = $this->city_zipcode_model->add_cz($cz);
                }
                echo json_encode($result);
                break;

            case 'delete' :
                $cz_id = $this->input->post("cz_id");
                $result = $this->city_zipcode_model->delete_cz($cz_id);
                echo json_encode($result);
                break;

            default:
                echo json_encode(array(
                    'success' => false,
                    'message' => "Action not found."
                ));

        }
    }

    /*
     * Settings
     */

    public function settings($page = "general")
    {
        $this->load->model('settings_model');
        $action = $this->input->post('action');

        // Actions for AJAX Call
        if($action) {
            switch($action) {
                case 'save_general' :
                    $settings = $this->input->post('settings');
                    $result = $this->settings_model->save($settings);
                    break;
                default:
                    $this->output->set_status_header("400");
                    $result = array('success' => false, 'message' => 'Action not found');
                    break;
            }
            echo json_encode($result);

        // Page Rendering
        } else {
            if($page == "general") {
                $this->load->model('package_model');
                $this->data['packages'] = $this->package_model->getPackage();
                $general = $this->settings_model->get(array('category' => 'general'));
                $this->data['general'] = transformArrayToKeyValue($general);
                $this->_renderA("pages/admin/settings_general", "Settings");
            }
        }
    }


    /*
     * Features
     */

    public function features() {
        $this->data['features'] = $this->package_model->get_features();

        $this->title = "Merlin Leads &raquo; Features";
        $this->js[] = "custom/admin/features.js";
        $this->js[] = "custom/admin/admin.js";
        $this->_renderA("pages/admin/features", "Packages");
    }

    public function features_process() {
        filter_var_array($_POST, FILTER_SANITIZE_STRING);
        if(isset($_POST['action'])) {
            switch($_POST["action"])
            {
                case "refresh_features_list":
                    echo json_encode(array('result' => $this->package_model->refresh_features_list()));
                    break;
                case "get_feature_details":
                    echo json_encode($this->package_model->get_features($_POST['id']));
                    break;
                case "update_feature":
                    unset($_POST['action']);
                    echo json_encode(array('result' => $this->package_model->update_feature($_POST['id'], $_POST)));
                    break;
                case "add_feature":
                    unset($_POST['action']);
                    echo json_encode(array('result' => $this->package_model->add_feature($_POST)));
                    break;
                case "delete_feature":
                    echo json_encode(array('result' => $this->package_model->delete_feature($_POST['id'])));
                    break;
                default:
                    $this->output->set_status_header("400");
                    echo json_encode(array("error" => "Action is unknown"));
                    break;
            }
        } else {
            $this->output->set_status_header("400");
            echo json_encode(array("error" => "Action is missing"));
        }
    }

    /*
     * Packages Features
     */

    public function packages_features() {
        $this->data['packages_features'] = $this->package_model->get_packages_features();
        $this->data['features'] = $this->package_model->get_features();

        $this->title = "Merlin Leads &raquo; Packages Features";
        $this->js[] = "custom/admin/packages_features.js";
        $this->js[] = "custom/admin/admin.js";
        $this->_renderA("pages/admin/packages_features", "Packages");
    }

    public function packages_features_process() {
        filter_var_array($_POST, FILTER_SANITIZE_STRING);
        if(isset($_POST['action'])) {
//            session_start();
            switch($_POST["action"])
            {
                case "update":
                    unset($_POST['action']);
                    echo json_encode(array('result' => $this->package_model->update_packages_features($_POST)));
                    $_SESSION['message'] = "Updating package feature successful!";
                    break;
                case "add":
                    unset($_POST['action']);
                    echo json_encode(array('result' => $this->package_model->add_packages_features($_POST)));
                    $_SESSION['message'] = "Adding package feature successful!";
                    break;
                case "delete":
                    echo json_encode(array('result' => $this->package_model->delete_packages_features($_POST['id'])));
                    $_SESSION['message'] = "Deleting package feature successful!";
                    break;
                default:
                    $this->output->set_status_header("400");
                    echo json_encode(array("error" => "Action is unknown"));
                    break;
            }
        } else {
            $this->output->set_status_header("400");
            echo json_encode(array("error" => "Action is missing"));
        }
    }

    /*
     * The following method are used for getting and changing values in the 
     * database "properties_templates_*"
     */

    public function changeModuleFull()
    {
        $module = $_POST['module'];
        $type = $_POST['type'];
        $this->load->model('template_model');
        if ($type == "Properties") {
            switch ($module) {
                case "Youtube":
                    $template = $this->template_model->getPropertyMediaTemplate($module, 1);
                    $data = array(
                        'count' => $this->template_model->getPropertyMediaTemplatesCountForInput('youtube', 1),
                        'title' => $template->title,
                        'description' => $template->description,
                        'keyword' => $template->keyword
                    );
                    break;
                case "Slideshare":
                    $template = $this->template_model->getPropertyMediaTemplate($module, 1);
                    $data = array(
                        'count' => $this->template_model->getPropertyMediaTemplatesCountForInput('slideshare', 1),
                        'title' => $template->title,
                        'description' => $template->description,
                        'keyword' => $template->keyword
                    );
                    break;
                case "Craiglist":
                    $template = $this->template_model->getPropertyCraiglistTemplates(1);
                    $data = array(
                        'count' => $this->template_model->getPropertyCraiglistTemplatesCountForInput('Regular'),
                        'posting_title' => $template->posting_title,
                        'specific_location' => $template->specific_location,
                        'posting_body' => $template->posting_body
                    );
                    break;
                case "Backpage":
                    $template = $this->template_model->getPropertyBackpageTemplates(1);
                    $data = array(
                        'count' => $this->template_model->getPropertyBackpageTemplatesCountForInput('Regular'),
                        'specific_location' => $template->specific_location,
                        'title' => $template->title,
                        'description' => $template->description
                    );
                    break;
                case "Ebay":
                    $template = $this->template_model->getPropertyEbayTemplates(1);
                    $data = array(
                        'count' => $this->template_model->getPropertyEbayTemplatesCountForInput('Regular'),
                        'title' => $template->title,
                        'description' => $template->description
                    );
                    break;
                case "Twitter":
                    $template = $this->template_model->getSocialTemplate("Twitter", 1);
                    $data = array(
                        'count' => $this->template_model->generateSocialCountForInput('Twitter'),
                        'description' => $template->description
                    );
                    break;
                default:
            }
            echo json_encode($data);
        }
    }

    public function changeTemplateFull()
    {
        $module = $_POST['module'];
        $template_no = $_POST['template_no'];
        $category = $_POST['category'];
        $type = $_POST['type'];
        if ($category == "Properties") {
            switch ($module) {
                case "Youtube":
                    $template = $this->template_model->getPropertyMediaTemplate($module, $template_no);
                    $data = array(
                        'title' => $template->title,
                        'description' => $template->description,
                        'keyword' => $template->keyword
                    );
                    break;
                case "Slideshare":
                    $template = $this->template_model->getPropertyMediaTemplate($module, $template_no);
                    $data = array(
                        'title' => $template->title,
                        'description' => $template->description,
                        'keyword' => $template->keyword
                    );
                    break;
                case "Craiglist":
                    if ($type == "Regular") {
                        $template = $this->template_model->getPropertyCraiglistTemplates($template_no);
                    } else {
                        $template = $this->template_model->getPropertyCraiglistVideoTemplates($template_no);
                    }
                    $data = array(
                        'posting_title' => $template->posting_title,
                        'specific_location' => $template->specific_location,
                        'posting_body' => $template->posting_body
                    );
                    break;
                case "Backpage":
                    if ($type == "Regular") {
                        $template = $this->template_model->getPropertyBackpageTemplates($template_no);
                    } else {
                        $template = $this->template_model->getPropertyBackpageVideoTemplates($template_no);
                    }
                    $data = array(
                        'specific_location' => $template->specific_location,
                        'title' => $template->title,
                        'description' => $template->description,
                    );
                    break;
                case "Ebay":
                    if ($type == "Regular") {
                        $template = $this->template_model->getPropertyEbayTemplates($template_no);
                    } else {
                        $template = $this->template_model->getPropertyEbayVideoTemplates($template_no);
                    }
                    $data = array(
                        'title' => $template->title,
                        'description' => $template->description,
                    );
                    break;
                case "Twitter":
                    $template = $this->template_model->getSocialTemplate("Twitter", $template_no);
                    $data = array(
                        'description' => $template->description
                    );
                    break;
                default:
            }
        }
        echo json_encode($data);
    }

    public function changeModuleType()
    {
        $category = $_POST['category'];
        $module = $_POST['module'];
        $type = $_POST['type'];
        if ($category == "Properties") {
            switch ($module) {
                case "Craiglist":
                    if ($type == "Regular") {
                        $template = $this->template_model->getPropertyCraiglistTemplates(1);
                    } else {
                        $template = $this->template_model->getPropertyCraiglistVideoTemplates(1);
                    }
                    $data = array(
                        'count' => $this->template_model->getPropertyCraiglistTemplatesCountForInput($type),
                        'posting_title' => $template->posting_title,
                        'specific_location' => $template->specific_location,
                        'posting_body' => $template->posting_body
                    );
                    break;
                case "Backpage":
                    if ($type == "Regular") {
                        $template = $this->template_model->getPropertyBackpageTemplates(1);
                    } else {
                        $template = $this->template_model->getPropertyBackpageVideoTemplates(1);
                    }
                    $data = array(
                        'count' => $this->template_model->getPropertyBackpageTemplatesCountForInput($type),
                        'title' => $template->title,
                        'specific_location' => $template->specific_location,
                        'description' => $template->description
                    );
                    break;
                case "Ebay":
                    if ($type == "Regular") {
                        $template = $this->template_model->getPropertyEbayTemplates(1);
                    } else {
                        $template = $this->template_model->getPropertyEbayVideoTemplates(1);
                    }
                    $data = array(
                        'count' => $this->template_model->getPropertyEbayTemplatesCountForInput($type),
                        'title' => $template->title,
                        'description' => $template->description
                    );
                    break;
                default:
            }
        }
        echo json_encode($data);
    }

    public function saveTemplateFull()
    {
        $category = $_POST['category'];
        $module = $_POST['module'];
        $template_no = $_POST['template_no'];
        if ($category == "Properties") {
            switch ($module) {
                case "Youtube":
                    $data = array(
                        'title' => $_POST['title'],
                        'description' => $_POST['description'],
                        'keyword' => $_POST['keyword']
                    );
                    echo $this->template_model->updatePropertyMediaTemplate($module, $template_no, $data);
                    break;
                case "Slideshare":
                    $data = array(
                        'title' => $_POST['title'],
                        'description' => $_POST['description'],
                        'keyword' => $_POST['keyword']
                    );
                    echo $this->template_model->updatePropertyMediaTemplate($module, $template_no, $data);
                    break;
                case "Craiglist":
                    $data = array(
                        'posting_title' => $_POST['posting_title'],
                        'specific_location' => $_POST['specific_location'],
                        'posting_body' => $_POST['posting_body']
                    );
                    echo $this->template_model->updatePropertyCraiglistTemplate($_POST['type'], $template_no, $data);
                    break;
                case "Backpage":
                    $data = array(
                        'specific_location' => $_POST['specific_location'],
                        'title' => $_POST['title'],
                        'description' => $_POST['description']
                    );
                    echo $this->template_model->updatePropertyBackpageTemplate($_POST['type'], $template_no, $data);
                    break;
                case "Ebay":
                    $data = array(
                        'title' => $_POST['title'],
                        'description' => $_POST['description']
                    );
                    echo $this->template_model->updatePropertyEbayTemplate($_POST['type'], $template_no, $data);
                    break;
                case "Twitter":
                    $data = array(
                        'description' => $_POST['description']
                    );
                    echo $this->template_model->updateSocialTemplate("Twitter", $data, $template_no);
                    break;
                default:
            }
        }
    }

    public function addTemplateFull()
    {
        $category = $_POST['category'];
        $module = $_POST['module'];
        if ($category == "Properties") {
            switch ($module) {
                case "Youtube":
                    $data = array(
                        'number' => $_POST['template_no'],
                        'title' => $_POST['title'],
                        'description' => $_POST['description'],
                        'keyword' => $_POST['keyword']
                    );
                    $result = $this->template_model->addPropertyMediaTemplate($module, $data);
                    if ($result == "OK") {
//                        session_start();
                        $_SESSION['admin_message'] = "Adding Template[Youtube] Successful!";
                        echo "OK";
                    }
                    break;
                case "Slideshare":
                    $data = array(
                        'number' => $_POST['template_no'],
                        'title' => $_POST['title'],
                        'description' => $_POST['description'],
                        'keyword' => $_POST['keyword']
                    );
                    $result = $this->template_model->addPropertyMediaTemplate($module, $data);
                    if ($result == "OK") {
//                        session_start();
                        $_SESSION['admin_message'] = "Adding Template[Slideshare] Successful!";
                        echo "OK";
                    }
                    break;
                case "Craiglist":
                    $data = array(
                        'number' => $_POST['number'],
                        'posting_title' => $_POST['posting_title'],
                        'specific_location' => $_POST['specific_location'],
                        'posting_body' => $_POST['posting_body']
                    );
                    $result = $this->template_model->addPropertyCraiglistTemplate($_POST['type'], $data);
                    if ($result == "OK") {
//                        session_start();
                        $_SESSION['admin_message'] = "Adding Template[Craiglist] Successful!";
                        echo "OK";
                    }
                    break;
                case "Backpage":
                    $data = array(
                        'number' => $_POST['number'],
                        'specific_location' => $_POST['specific_location'],
                        'title' => $_POST['title'],
                        'description' => $_POST['description'],
                    );
                    $result = $this->template_model->addPropertyBackpageTemplate($data);
                    if ($result == "OK") {
//                        session_start();
                        $_SESSION['admin_message'] = "Adding Template[Backpage] Successful!";
                        echo "OK";
                    }
                    break;
                case "Ebay":
                    $data = array(
                        'number' => $_POST['number'],
                        'title' => $_POST['title'],
                        'description' => $_POST['description'],
                    );
                    $result = $this->template_model->addPropertyEbayTemplate($data);
                    if ($result == "OK") {
//                        session_start();
                        $_SESSION['admin_message'] = "Adding Template[Ebay] Successful!";
                        echo "OK";
                    }
                    break;
                case "Twitter":
                    $data = array(
                        'template_no' => $_POST['templateNo'],
                        'description' => $_POST['description']
                    );
                    $result = $this->template_model->addSocialTemplate("Twitter", $data);
                    if ($result == "OK") {
//                        session_start();
                        $_SESSION['admin_message'] = "Adding Template[Twitter] Successful!";
                        echo "OK";
                    }
                    break;
                default:
            }
        }
    }

    public function deleteTemplateFull()
    {
        $category = $_POST['category'];
        $module = $_POST['module'];
        $template_no = $_POST['template_no'];
        $type = $_POST['type'];
        if ($category == "Properties") {
            switch ($module) {
                case "Youtube":
                    $result = $this->template_model->deletePropertyMediaTemplate($module, $template_no);
                    if ($result == "OK") {
//                        session_start();
                        $_SESSION['admin_message'] = "Deleting Youtube Template[$template_no] Successful!";
                        echo "OK";
                    }
                    break;
                case "Slideshare":
                    $result = $this->template_model->deletePropertyMediaTemplate($module, $template_no);
                    if ($result == "OK") {
//                        session_start();
                        $_SESSION['admin_message'] = "Deleting Slideshare Template[$template_no] Successful!";
                        echo "OK";
                    }
                    break;
                case "Craiglist":
                    $result = $this->template_model->deletePropertyCraiglistTemplate($type, $template_no);
                    if ($result == "OK") {
//                        session_start();
                        $_SESSION['admin_message'] = "Deleting Craiglist Template[$template_no] Successful!";
                        echo "OK";
                    }
                    break;
                case "Backpage":
                    $result = $this->template_model->deletePropertyBackpageTemplate($template_no);
                    if ($result == "OK") {
//                        session_start();
                        $_SESSION['admin_message'] = "Deleting Backpage Template[$template_no] Successful!";
                        echo "OK";
                    }
                    break;
                case "Ebay":
                    $result = $this->template_model->deletePropertyEbayTemplate($template_no);
                    if ($result == "OK") {
//                        session_start();
                        $_SESSION['admin_message'] = "Deleting Ebay Template[$template_no] Successful!";
                        echo "OK";
                    }
                    break;
                case "Twitter":
                    $result = $this->template_model->deleteSocialTemplate("Twitter", $template_no);
                    if ($result == "OK") {
//                        session_start();
                        $_SESSION['admin_message'] = "Deleting Twitter Template[$template_no] Successful!";
                        echo "OK";
                    }
                    break;
                default:
            }
        }
    }

    public function validateTemplateFullNo()
    {
        $category = $_POST['category'];
        if ($category == "Properties") {
            $template_no = $_POST['template_no'];
            $module = $_POST['module'];
            echo $this->template_model->checkPropertyMediaTemplateIfTemplateNoExist($module, $template_no);
        }
    }

    public function getNextTemplateNo()
    {
        $category = $_POST['category'];
        $module = $_POST['module'];
        if ($category == "Properties") {
            if ($module == "Craiglist") {
                $tempalte_no = $this->template_model->getPropertyCraiglistTemplatesCount() + 1;
                echo $tempalte_no;
            } else if ($module == "Backpage") {
                $tempalte_no = $this->template_model->getPropertyBackpageTemplatesCount() + 1;
                echo $tempalte_no;
            } else if ($module == "Ebay") {
                $tempalte_no = $this->template_model->getPropertyEbayTemplatesCount() + 1;
                echo $tempalte_no;
            } else if ($module == "Twitter") {
                $tempalte_no = $this->template_model->getPropertySocialTemplatesCount("Twitter");
                echo $tempalte_no;
            }
        }
    }

    /*
     * Methods used in getting and changing [shortcode] values in the 
     * database "properties_templates_sc"
     */

    public function changeModuleSc()
    {
        $module = $_POST['module'];
        $category = $_POST['category'];
        $this->load->model('template_model');
        if ($category == "Properties") {
            $types = $this->template_model->getPropertyTemplateScTypesForInput($module);
            echo $types;
        }
    }

    public function getShortcodes()
    {
        $category = $_POST['category'];
        $type = $_POST['type'];
        $module = $_POST['module'];
        if ($category == "Properties") {
            echo $this->template_model->getPropertyTemplatesShortcodes($module, $type);
        }
    }

    public function getShortcodeVal()
    {
        $category = $_POST['category'];
        $type = $_POST['type'];
        $module = $_POST['module'];
        $scid = $_POST['scid'];
        if ($category == "Properties") {
            echo $this->template_model->getPropertyTemplatesShortcodeVal($module, $type, $scid);
        }
    }

    public function validateTemplateScShortcode()
    {
        if ($_POST['category'] == "Properties") {
            $shortcode = $_POST['shortcode'];
            $module = $_POST['module'];
            echo $this->template_model->checkPropertyTemplateIfShortcodeExist($module, $shortcode);
        }
    }

    public function addTemplateSc()
    {
        $category = $_POST['category'];
        $data = array(
            'module' => $_POST['module'],
            'type' => $_POST['type'],
            'shortcode' => $_POST['shortcode'],
            'content' => $_POST['content']
        );
        if ($category == "Properties") {
            echo $this->template_model->addPropertyTemplateSc($data);
        }
    }

    public function deleteTemplateSc()
    {
        $category = $_POST['category'];
        $scid = $_POST['scid'];
        if ($category == "Properties") {
            echo $this->template_model->deletePropertyTemplateSc($scid);
        }
    }

    public function updateTemplateSc()
    {
        $category = $_POST['category'];
        $data = array(
            'content' => $_POST['content']
        );
        $scid = $_POST['scid'];
        if ($category == "Properties") {
            echo $this->template_model->updatePropertyTemplateSc($data, $scid);
        }
    }

    /* Manage Store Methods */

    public function getPackageInfo()
    {
        $package = $this->package_model->getPackage($_POST['id'][0]);
        if ($package) {
            echo json_encode($package);
        }
    }

    public function getPackageList()
    {
        $packages = $this->package_model->getPackage();
        $options = "";
        foreach ($packages as $p) {
            $options .= "<option value='" . $p->id . "'>" . $p->name . "</option>";
        }
        echo $options;
    }

    public function updatePackage()
    {
        $package = array(
            'stripe_plan_id' => $_POST['stripe_plan_id'],
            'packages_features_id' => $_POST['packages_features_id'],
            'status' => $_POST['status'],
            'show' => $_POST['show']
        );
        if ($this->package_model->updatePackage($_POST['stripe_plan_id'], $package) == true) {
            echo "Success";
        }
    }

    // NOT USED JUST SAVED IT FOR INFO
    public function deletePackage()
    {
        echo $this->package_model->deletePackage($_POST['id'][0], $_POST['name']) == true ? "Success" : $this->package_model->deletePackage($_POST['id'][0], $_POST['name']);
    }

    public function addPackage()
    {
        $package = array(
            'name' => $_POST['name'],
            'number_of_property' => $_POST['number_of_property'],
            'number_of_profile' => $_POST['number_of_profile'],
            'monthly_price' => $_POST['monthly_price'],
            'six_month_price' => $_POST['six_month_price'],
            'annual_price' => $_POST['annual_price'],
            'status' => $_POST['status'],
            'type' => $_POST['type'],
            'show' => $_POST['show']
        );

        $publishable_key = STRIPE_PUBLISHABLE_KEY;

        if ($_POST['type'] === "Package") {
            $action = base_url() . "main/chargePackage";
        } else {
            $action = base_url() . "main/chargeAddon";
        }

        $form = "<form id='payment-form' style='display: none;' class='monthly-form payment-form' action='$action' method='POST'>
            <script
                src='https://checkout.stripe.com/checkout.js' class=stripe-button
                data-key='" . $publishable_key . "'
                data-amount='" . $package['monthly_price'] . "'
                data-name='" . $package['name'] . " [Monthly]'>
            </script>
            <input type='hidden' name='amount' value='" . $package['monthly_price'] . "' />
            <input type='hidden' name='packageName' value='" . $package['name'] . "' />
            <input type='hidden' name='packageType' value='Monthly' />
        </form>";
        $package['monthly_price_form'] = $form;
        $form = "<form id='payment-form' style='display: none;' class='annual-form payment-form' action='$action' method='POST'>
            <script
                src='https://checkout.stripe.com/checkout.js' class=stripe-button
                data-key='" . $publishable_key . "'
                data-amount='" . $package['annual_price'] . "'
                data-name='" . $package['name'] . " [Annual]'>
            </script>
            <input type='hidden' name='amount' value='" . $package['annual_price'] . "' />
            <input type='hidden' name='packageName' value='" . $package['name'] . "' />
            <input type='hidden' name='packageType' value='Annual' />
        </form>";
        $package['annual_price_form'] = $form;
        if ($_POST['six_month_price'] != "") {
            $form = "<form id='payment-form' style='display: none;' class='six-month-form payment-form' action='$action' method='POST'>
            <script
                src='https://checkout.stripe.com/checkout.js' class=stripe-button
                data-key='" . $publishable_key . "'
                data-amount='" . $package['six_month_price'] . "'
                data-name='" . $package['name'] . " [6 Months]'>
            </script>
            <input type='hidden' name='amount' value='" . $package['six_month_price'] . "' />
            <input type='hidden' name='packageName' value='" . $package['name'] . "' />
            <input type='hidden' name='packageType' value='6 Months' />
            </form>";
            $package['six_month_price_form'] = $form;
        }

        echo $this->package_model->addPackage($package) == true ? "Success" : $this->package_model->addPackage($package);
    }

    /* HS CTA Methods */

    public function getHsCta()
    {
        echo $this->hs_cta_model->getHsCtaId($_POST['module'], $_POST['type']);
    }

    public function updateHsCta()
    {
        if ($this->hs_cta_model->updateHsCta($_POST['id'], $_POST['content']) === "OK") {
            echo "Success";
        }
    }

    public function addHsCta()
    {
        $data = array(
            'module' => $_POST['module'],
            'type' => $_POST['type'],
            'content' => $_POST['content']
        );
        if ($this->hs_cta_model->addHsCta($data) === "OK") {
            echo "Success";
        }
    }

    public function deleteHsCta()
    {
        if ($this->hs_cta_model->deleteHsCta($_POST['id']) === "OK") {
            echo "Success";
        }
    }

    /* Slideshare */

    public function upload_slideshare_bg($title = "")
    {
        $status = "";
        $msg = "";
        $file_element_name = 'userfile';
        if ($title == "") {
            $status = "error";
            $msg = "Title is missing.";
        } else {
            $config['upload_path'] = getcwd() . "/resources/images/ppt/bg";
            $config['allowed_types'] = 'gif|jpg|png|doc|txt';
            $config['max_size'] = 1024 * 8;
//            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();
                $bg_id = $this->slideshare_model->addBackground(array('image' => $data['file_name'], 'title' => urldecode($title)));
                if ($bg_id) {
                    $status = "success";
                    $msg = "File successfully uploaded";
                } else {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "Something went wrong when saving the file, please try again.";
                }
            }
        }
        @unlink($_FILES[$file_element_name]);
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function delete_slideshare_bg()
    {
        $file = $_POST['file'];
        if ($this->slideshare_model->deleteBackground($file)) {
            echo "OK";
        }
    }

    /* Others */

    public function getUsersOverview()
    {
        /**
         * Script:    DataTables server-side script for PHP 5.2+ and MySQL 4.1+
         * Notes:     Based on a script by Allan Jardine that used the old PHP mysql_* functions.
         *            Rewritten to use the newer object oriented mysqli extension.
         * Copyright: 2010 - Allan Jardine (original script)
         *            2012 - Kari S�derholm, aka Haprog (updates)
         * License:   GPL v2 or BSD (3-point)
         */
        mb_internal_encoding('UTF-8');

        $aColumns = array('id', 'status', 'firstname', 'lastname', 'username', 'phone', 'email', 'country', 'state', 'type', 'date_joined');

        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";

        /* DB table to use */
        $sTable = "users";

        /* Database connection information */
        $gaSql['user'] = DB_USERNAME;
        $gaSql['password'] = DB_PASSWORD;
        $gaSql['db'] = DB_DATABASE;
        $gaSql['server'] = DB_HOST;
        $gaSql['port'] = 3306;

        $input = &$_GET;
        $gaSql['charset'] = 'utf8';

        /**
         * MySQL connection
         */
        $db = new mysqli($gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db'], $gaSql['port']);
        if (mysqli_connect_error()) {
            die('Error connecting to MySQL server (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }

        if (!$db->set_charset($gaSql['charset'])) {
            die('Error loading character set "' . $gaSql['charset'] . '": ' . $db->error);
        }


        /**
         * Paging
         */
        $sLimit = "";
        if (isset($input['iDisplayStart']) && $input['iDisplayLength'] != '-1') {
            $sLimit = " LIMIT " . intval($input['iDisplayStart']) . ", " . intval($input['iDisplayLength']);
        }


        /**
         * Ordering
         */
        $aOrderingRules = array();
        if (isset($input['iSortCol_0'])) {
            $iSortingCols = intval($input['iSortingCols']);
            for ($i = 0; $i < $iSortingCols; $i++) {
                if ($input['bSortable_' . intval($input['iSortCol_' . $i])] == 'true') {
                    $aOrderingRules[] = "`" . $aColumns[intval($input['iSortCol_' . $i])] . "` "
                        . ($input['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc');
                }
            }
        }

        if (!empty($aOrderingRules)) {
            $sOrder = " ORDER BY " . implode(", ", $aOrderingRules);
        } else {
            $sOrder = " ORDER BY type, status, date_joined";
        }


        /**
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $iColumnCount = count($aColumns);
//        
        if (isset($input['sSearch']) && $input['sSearch'] != "") {
            $aFilteringRules = array();
            for ($i = 0; $i < $iColumnCount; $i++) {
                if (isset($input['bSearchable_' . $i]) && $input['bSearchable_' . $i] == 'true') {
                    $aFilteringRules[] = "`" . $aColumns[$i] . "` LIKE '%" . $db->real_escape_string($input['sSearch']) . "%'";
                }
            }
            if (!empty($aFilteringRules)) {
                $aFilteringRules = array('(' . implode(" OR ", $aFilteringRules) . ')');
            }
        }

// Individual column filtering
        for ($i = 0; $i < $iColumnCount; $i++) {
            if (isset($input['bSearchable_' . $i]) && $input['bSearchable_' . $i] == 'true' && $input['sSearch_' . $i] != '') {
                $aFilteringRules[] = "`" . $aColumns[$i] . "` LIKE '%" . $db->real_escape_string($input['sSearch_' . $i]) . "%'";
            }
        }
        $sWhere = "";
        if (!empty($aFilteringRules)) {
            $sWhere = " WHERE " . implode(" AND ", $aFilteringRules);
        }


        /**
         * SQL queries
         * Get data to display
         */
        $aQueryColumns = array();
        foreach ($aColumns as $col) {
            if ($col != ' ') {
                $aQueryColumns[] = $col;
            }
        }

        $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS `" . implode("`, `", $aQueryColumns) . "`
    FROM `" . $sTable . "`" . $sWhere . $sOrder . $sLimit;

        $rResult = $db->query($sQuery) or die($db->error);

// Data set length after filtering
        $sQuery = "SELECT FOUND_ROWS()";
        $rResultFilterTotal = $db->query($sQuery) or die($db->error);
        list($iFilteredTotal) = $rResultFilterTotal->fetch_row();

// Total data set length
        $sQuery = "SELECT COUNT(`" . $sIndexColumn . "`) FROM `" . $sTable . "`";
        $rResultTotal = $db->query($sQuery) or die($db->error);
        list($iTotal) = $rResultTotal->fetch_row();


        /**
         * Output
         */
        $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array(),
        );

        while ($aRow = $rResult->fetch_assoc()) {
            $row = array();
            for ($i = 0; $i < $iColumnCount; $i++) {
                if ($aColumns[$i] == 'version') {
                    // Special output formatting for 'version' column
                    $row[] = ($aRow[$aColumns[$i]] == '0') ? '-' : $aRow[$aColumns[$i]];
                } elseif ($aColumns[$i] != ' ') {
                    // General output
                    $row[] = $aRow[$aColumns[$i]];
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

}
