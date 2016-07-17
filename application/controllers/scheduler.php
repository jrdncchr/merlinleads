<?php

class scheduler extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url());
        }
        $this->load->model('scheduler_model');
        $this->load->model('merlin_library_model');
    }

    public function index()
    {
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

    public function scheduler_action()
    {
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

    public function category()
    {
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

    public function post($action = "", $id = 0)
    {
        if($action == "form") {
            $this->load->model('api_model');
            $this->data['fb'] = $this->api_model->facebook_verify_access_key($this->user);
            $this->data['linkedIn'] = $this->api_model->linkedin_verify_access_key($this->user);
            $this->data['twitter'] = $this->api_model->twitter_verify_access_key($this->user);

            $this->data['available_times'] = $this->_getAvailableTimes();
            $category = $this->scheduler_model->get_scheduler_category(
                array('category_user_id' => $this->user->id));
            $this->data['category'] = $category;

            $this->load->model('merlin_library_model');
            $merlin_category = $this->merlin_library_model->get_category(array('active' => 1));
            $this->data['merlin_category'] = $merlin_category;

            $this->load->model('profile_model');
            $this->data['profile'] = $this->profile_model->getProfilesByUser($this->user->id);

            $this->load->model('city_zipcode_model');
            $this->data['city_zipcode'] = $this->city_zipcode_model->get_czu(array('czu_user_id' => $this->user->id, 'czu_status' => 'active'));

            if($id > 0) {
                $this->load->model('scheduler_model');
                $post = $this->scheduler_model->get_scheduler_post(array('post_id' => $id, 'post_user_id' => $this->user->id), false);
                $this->data['post'] = $post;

                $category_id = $post->bp_category_id;
                $categories = $this->merlin_library_model->get_blog_post(array('bp_category' => $category_id));
                $topics = "<option value=''>Select Topic</option>";
                foreach($categories as $c) {
                    $topics .= "<option value='" . $c->bp_id . "'>" . $c->bp_topic . "</option>";
                }
                $this->data['topics'] = $topics;
            }

            $this->_renderL('pages/scheduler/post_add');
        } else {
            $this->_renderL('pages/scheduler/post');
        }
    }

    public function post_action()
    {
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

            case 'generate' :
                $topic_id = $this->input->post('topic_id');
                $profile_id = $this->input->post('profile_id');
                $area = $this->input->post('area');

                $this->load->model('merlin_library_model');
                $blog_post = $this->merlin_library_model->get_blog_post(array('bp_id' => $topic_id), false);

                $this->load->model('profile_model');
                $profile = $this->profile_model->getProfile($profile_id);

                $this->load->model('template_model');
                $result = array(
                    'headline' => $this->template_model->generateData($blog_post->bp_headline, null, $profile),
                    'body' => $this->template_model->generateData($blog_post->bp_body, null, $profile),
                    'keywords' => $this->template_model->generateData($blog_post->bp_keywords, null, $profile),
                    'facebook_snippet' => $this->template_model->generateData($blog_post->bp_facebook_snippet, null, $profile),
                    'twitter_snippet' => $this->template_model->generateData($blog_post->bp_twitter_snippet, null, $profile),
                    'linkedin_snippet' => $this->template_model->generateData($blog_post->bp_linkedin_snippet, null, $profile),
                    'subject_line' => $this->template_model->generateData($blog_post->bp_subject_line, null, $profile),
                    'email_content' => $this->template_model->generateData($blog_post->bp_email_content, null, $profile)
                );
                echo json_encode($result);
                break;

            case 'category_change' :
                $category_id = $this->input->post('category_id');
                $categories = $this->merlin_library_model->get_blog_post(array('bp_category' => $category_id));
                $result = "<option value=''>Select Topic</option>";
                foreach($categories as $c) {
                    $result .= "<option value='" . $c->bp_id . "'>" . $c->bp_topic . "</option>";
                }
                echo $result;
                break;

            default:
                echo json_encode(array(
                    'success' => false,
                    'message' => "Action not found."
                ));

        }
    }

    public function _getAvailableTimes()
    {
        return array(
        '12 AM', '1 AM', '2 AM', '3 AM', '4 AM', '5 AM', '6 AM', '7 AM', '8 AM', '9 AM', '10 AM', '11 AM',
        '12 PM', '1 PM', '2 PM', '3 PM', '4 PM', '5 PM', '6 PM', '7 PM', '8 PM', '9 PM', '10 PM', '11 PM');
    }

} 