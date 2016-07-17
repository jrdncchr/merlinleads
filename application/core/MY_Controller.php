<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    protected $main_f = [];
    protected $user;
    protected $subscription;

    // Page resources
    protected $js = array();
    protected $css = array();
    protected $bower_components = array(
        'js' => array(),
        'css' => array()
    );
    protected $fonts = array();
    // Page Info
    protected $title = "Merlin Leads";
    protected $description = "Merlin Leads";
    protected $keywords = "Merlin Leads";
    protected $author = "Danero";
    // Page data
    protected $data = array();

    function __construct($logged = false)
    {
        parent::__construct();
        $this->load->model('api_model');
        $this->api_model->load();

        $this->user = $this->session->userdata("user");
        if ($logged) {
            $this->checkAuth();
        }

        $this->load->helper('url');

        // Get Subscription and Features
        if (null != $this->user) {
            $this->load->library('stripe_library');
            $this->load->model('package_model');
            $this->load->model('seo_builder_admin');

            /*
             * Fetch the subscription in Stripe then store it in a session.
             * This will make loading faster, since the next fetching will be in the session.
             */
            if ($this->is_session_started() === FALSE) {
                session_start();
            }
            if (!isset($_SESSION['subscription'])) {
                $subscription = $this->stripe_library->get_main_subscription($this->user->stripe_customer_id);
                if (!$subscription) {
                    $subscription = [];
                }
                $_SESSION["subscription"] = $subscription;
                $this->subscription = $_SESSION["subscription"];
            } else {
                $this->subscription = $_SESSION["subscription"];
            }

            if (sizeof($this->subscription) > 0) {
                $main_plan = $this->package_model->get_package_details($this->subscription->plan->id);
                $this->main_f = json_decode($main_plan->features_json);
            }

            $this->data['subscription'] = $this->subscription;
            $this->data['seo_builder'] = $this->seo_builder_admin->checkAuth($this->user->id);
            $this->data['user'] = $this->user;
            $this->data['main_f'] = $this->main_f;
        }
    }

    /*
     * Rendering for unauthorized users.
     */
    public function _render($view)
    {
        $this->data['admin'] = false;

        $data = $this->data;
        $data['css'] = $this->css;
        $data['js'] = $this->js;
        $data['bower_components'] = $this->bower_components;

        $data['title'] = $this->title;
        $data['description'] = $this->description;
        $data['keywords'] = $this->keywords;
        $data['author'] = $this->author;

        $data['head'] = $this->load->view('templates/head', $data, true);
        if (isset($data['user'])) {
            $data['nav'] = $this->load->view('templates/logged/nav', $data, true);
        } else {
            $data['nav'] = $this->load->view('templates/nav', $data, true);
        }
        $data['scripts'] = $this->load->view('templates/scripts', $data, true);
        $data['footer'] = $this->load->view('templates/footer', $data, true);

        $data['content'] = $this->load->view($view, $data, true);

        $this->load->view('templates/skeleton', $data);
    }

    /*
     * Rendering for authorized users.
     */
    public function _renderL($view)
    {
        $this->data['admin'] = false;

        $data = $this->data;
        $data['css'] = $this->css;
        $data['js'] = $this->js;
        $data['bower_components'] = $this->bower_components;

        $data['title'] = $this->title;
        $data['description'] = $this->description;
        $data['keywords'] = $this->keywords;
        $data['author'] = $this->author;

        $data['head'] = $this->load->view('templates/head', $data, true);
        $data['nav'] = $this->load->view('templates/logged/nav', $data, true);
        $data['quicklink'] = $this->load->view('templates/logged/quicklink', $data, true);
        $data['global'] = $this->load->view('templates/global', $data, true);
        $data['scripts'] = $this->load->view('templates/scripts', $data, true);
        $data['footer'] = $this->load->view('templates/footer', $data, true);

        $data['content'] = $this->load->view($view, $data, true);

        $this->load->view('templates/logged/skeleton', $data);
    }

    /*
     * Rendering for the admin.
     */
    public function _renderA($content, $main = "")
    {
        $this->data['admin'] = true;

        $data = $this->data;
        $data['css'] = $this->css;
        $data['js'] = $this->js;
        $data['bower_components'] = $this->bower_components;

        $data['title'] = $this->title;
        $data['description'] = $this->description;
        $data['keywords'] = $this->keywords;
        $data['author'] = $this->author;

        $this->load->library("admin_navs");
        $data['nav'] = $this->admin_navs->get_navs($main);

        $data['head'] = $this->load->view('templates/head', $data, true);
        $data['topnav'] = $this->load->view('templates/admin/topnav', $data, true);
        $data['sidebar'] = $this->load->view('templates/admin/sidebar', $data, true);
        $data['global'] = $this->load->view('templates/global', $data, true);
        $data['scripts'] = $this->load->view('templates/scripts', $data, true);
        $data['footer'] = $this->load->view('templates/footer', $data, true);
        $data['content'] = $this->load->view($content, $data, true);

        $this->load->view('templates/admin/new_skeleton', $data);
    }

    public function checkAuth()
    {
        $user = $this->user;
        if (null == $user) {
            show_404("An unauthorized user attempted to enter " . current_url() . ".");
        }
        return true;
    }

    function is_session_started()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }
}

?>