<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Main extends MY_Controller {
    /*
     * Make sure the user is logged in, else redirect to the home page. 
     */

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url() . "property");
        }
        $this->load->model('user_model');
    }

    /*
     * Pages
     */


    public function index() {
        $user = $this->session->userdata('user');
        $this->load->model('package_model');
        if (!$this->package_model->getUserPackage($user->id)) {
            $add = array(
                'user_id' => $user->id,
                'package_name' => 'Admin',
                'start_date' => date('Y-m-d H:i:s'),
                'end_date' => date('Y-m-d H:i:s', strtotime("+5 years"))
            );
            $this->package_model->addUserPackage($user->id, $add);
        }

        $this->title = "Merlin Leads &raquo; Main";
        $this->data['user'] = $user;
        $this->session->set_userdata('selectedModule', 'Craiglist');
        $this->js[] = "custom/main.js";
        $this->_renderL('pages/main');
    }

    public function myaccount() {
        $user = $this->session->userdata('user');

        //get user subscription from stripe
        $this->load->library('stripe_library');
        $subscriptions = $this->stripe_library->get_subscriptions($user->stripe_customer_id);
        if($subscriptions) {
            $this->data['subscriptions'] = $subscriptions;
        }

        //get user property/profile count
        $this->load->model('property_model');
        $this->data['property_count'] = $this->property_model->getPropertiesCountByUser($user->id);
        $this->load->model('profile_model');
        $this->data['profile_count'] = $this->profile_model->getProfilesCount($user->id);

        //get user property/profile totals of available
        $available = $this->stripe_library->get_available_property_and_profile($user->stripe_customer_id);
        $this->data['available'] = $available;

        //get user card information from stripe
        $card = $this->stripe_library->getDefaultCard($user->stripe_customer_id);
        if($card) {
            $this->session->set_userdata('stripe_card_id', $card->id);
        }
        $this->data['card'] = $card;

        //get countries states
        $this->load->model('input_model');
        $this->data['states'] = $this->input_model->getCountryStates($user->country, $user->state_abbr);

        $this->title = "Merlin Leads &raquo; My Account";
        $this->data['user'] = $user;
        $this->js[] = "custom/myaccount.js";
        $this->_renderL('pages/myaccount');
    }

    public function upgrade() {
        $user = $this->session->userdata('user');
        $this->load->model('package_model');

        //get plans list
        $this->load->library('stripe_library');
        $plans = $this->stripe_library->get_all_plans();

        //monthly
        $monthly_plan = [];
        foreach ($plans as $p) {
            if($p->interval == "month" && $p->statement_descriptor == "Main") {
                $plan = $this->package_model->get_package_details($p->id);

                if($plan) {
                    $f = json_decode($plan->features_json);
                    $p->number_of_profile = $f->number_of_profiles;
                    $p->number_of_property = $f->number_of_properties;
                    $p->stripe_form = $plan->stripe_form;
                    $p->status = $plan->status;
                    $p->show = $plan->show;

                    $monthly_plan[] = $p;
                }
            }
        }
        $this->data['month_plan'] = $monthly_plan;
        //yearly
        $yearly_plan = [];
        foreach ($plans as $p) {
            if($p->interval == "year" && $p->statement_descriptor == "Main") {
                $plan = $this->package_model->get_package_details($p->id);

                if($plan) {
                    $f = json_decode($plan->features_json);
                    $p->number_of_profile = $f->number_of_profiles;
                    $p->number_of_property = $f->number_of_properties;
                    $p->stripe_form = $plan->stripe_form;
                    $p->status = $plan->status;
                    $p->show = $plan->show;

                    $yearly_plan[] = $p;
                }
            }
        }
        $this->data['year_plan'] = $yearly_plan;
        //addons
        $subscription = $this->stripe_library->get_main_subscription($user->stripe_customer_id);
        $addons = [];
        if(isset($subscription->plan)) {
            foreach ($plans as $p) {
                if($p->statement_descriptor == "Addon") {
                    $plan = $this->package_model->get_package_details($p->id);

                    if($plan) {
                        $f = json_decode($plan->features_json);

                        $p->number_of_profile = $f->number_of_profiles;
                        $p->number_of_property = $f->number_of_properties;
                        $p->stripe_form = $plan->stripe_form;
                        $p->status = $plan->status;
                        $p->show = $plan->show;

                        /*
                         * ----- ADD ADDITIONAL PROFILE FEATURE
                         */
                        $main_plan = $this->package_model->get_package_details($subscription->plan->id);
                        $main_f = json_decode($main_plan->features_json);
                        if(isset($main_f->add_additional_profile)) {
                            $addons[] = $p;
                        } else {
                            if($p->name != "Additional Profile") {
                                $addons[] = $p;
                            }
                        }
                    }


                }
            }
        }
        $this->data['addons'] = $addons;

        //get defaults
        $this->data['user'] = $user;
        $this->title = "Merlin Leads &raquo; Upgrade";
        $this->js[] = "custom/store.js";
        $this->_renderL('pages/store');
    }

    public function chargeAddon() {
        $user = $this->session->userdata('user');
        include OTHERS . 'stripe/lib/Stripe.php';

        $secret_key = STRIPE_SECRET_KEY;

        Stripe::setApiKey($secret_key);
        $token = $_POST['stripeToken'];
        try {
            // Create a Customer
            $customer = Stripe_Customer::create(array(
                        "card" => $token,
                        "description" => $_POST['stripeEmail'])
            );
            Stripe_Charge::create(array(
                "amount" => $_POST['amount'],
                "currency" => "usd",
                "description" => $_POST['stripeEmail'],
                "customer" => $customer->id)
            );
            //update users addons
            $this->load->model('package_model');
            $this->package_model->addUserAddon($user->id, $_POST['packageName'], $_POST['packageType']);
            $this->data['message'] = "Success";
        } catch (Stripe_CardError $e) {
            $this->data['message'] = "Failed: $e";
        }
        $this->data['user'] = $user;
        $this->data['packageName'] = $_POST['packageName'];
        $this->data['packageType'] = $_POST['packageType'];
        $this->_renderL('pages/store_success');
    }

    /*
     * Method used by ALL
     */

    public function logout() {
        $this->session->sess_destroy();
        // session_start();
        session_destroy(); 
        redirect(base_url() . "pages/login");
    }

    /*
     * Methods used in the page 'myaccount'
     */

    public function updateMyAccount() {
        $user = $this->session->userdata('user');
        $stateSplit = explode(' - ', trim($_POST['state']));
        $update = array(
            'firstname' => $_POST['first_name'],
            'lastname' => $_POST['last_name'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'country' => $_POST['country'],
            'state' => $stateSplit[1],
            'state_abbr' => $stateSplit[0]
        );
        $this->user_model->update($update, $user->id);
    }

    public function verifyTwitterCredentials() {
        $advance_twitter = array(
            'consumer_key' => $_POST['consumer_key'],
            'consumer_secret' => $_POST['consumer_secret'],
            'access_token' => $_POST['access_token'],
            'access_token_secret' => $_POST['access_token_secret']
        );
        $this->load->library('custom_library');
        $result = $this->custom_library->verify_twitter_credentials($advance_twitter);
        if ($result['result'] == true) {
            $user = $this->session->userdata('user');
            $update = array(
                'advance_twitter' => json_encode($advance_twitter),
                'advance_twitter_verified' => true
            );
            $this->user_model->update($update, $user->id);
        } else {
            echo $result['message'];
        }
    }

    public function changePassword() {
        include OTHERS . "PasswordHash.php";
        $user = $this->session->userdata('user');
        $currentPassword = $_POST['currentPassword'];
        if (validate_password($currentPassword . $user->salt, $user->password)) {
            $new_password = $_POST['newPassword'];
            $salt = $this->_get_random_string(16);
            $hashed_password = create_hash($new_password . $salt);
            $update = array(
                'password' => $hashed_password,
                'salt' => $salt
            );
            $this->load->model('user_model');
            echo $this->user_model->update($update, $user->id);
        } else {
            echo "Current Password is incorrect.";
        }
    }

    function _get_random_string($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function getCountryStates() {
        $this->load->model('input_model');
        echo $this->input_model->getCountryStates($_POST['country']);
    }

    /* Store Methods */

//    public function saveByLine() {
//        $file = fopen("C:\Users\Jordan\Desktop\\temp.txt", "r");
//        if ($file) {
//            while (($line = fgets($file)) !== false) {
//                $data = array(
//                    'category'=> 'HS',
//                    'module' => 'Classified Ads',
//                    'type' => 'POST',
//                    'content' => $line,
//                );
//                $this->load->database();
//                $this->db->insert('call_to_actions', $data);
//            }
//            echo "Done";
//        } else {
//            echo "Server Error";
//        }
//    }
//    public function saveBySymbol() {
//        $file = file_get_contents("C:\Users\Danero\Desktop\\temp.txt");
//        if ($file) {
//            $this->load->database();
//            $fileSplit = explode("-----", $file);
//            for ($i = 0; $i < sizeof($fileSplit); $i++) {
//                $split = explode('|', $fileSplit[$i]);
//                $data = array(
//                    'module'=> 'youtube',
//                    'type' => 'cta',
//                    'content' => trim($split[0]),
//                    'shortcode' => $split[1]
//                );
//                $this->db->insert('properties_templates_sc', $data);
//            }
//        } else {
//            echo "Server Error";
//        }
//    }
//    public function saveCustom() {
//        $this->load->database();
//        for ($i = 1; $i < 41; $i++) {
//            $data = array(
//                'number' => $i,
//                'phone' => '[Agent Phone]',
//                'contact_name' => "[Agent First Name] [Agent Last Name]",
//                'posting_title' => "[Title $i]",
//                'video_term' => "[Video Term $i]",
//                'specific_location' => "[Specific Location $i]",
//                'postal_code' => "[Zipcode]",
//                'posting_body' => "[Body Title $i]
//[Openhouse $i]
//[Agent Info $i]
//[Property Address $i]
//[Video-Bullet-CTA $i]
//[Video-CL-Link $i]
//[Bed-Bath $i]
//[CL-School $i]
//[Broker-Info $i]
//[Broker-License $i]
//[Ad Tags $i]",
//                'sqft' => "[Building SqFt]",
//                'price' => "[Price]",
//                'bedrooms' => "[Bed]",
//                'bathrooms' => "[CL-Bath]",
//                'housing_type' => "[Housing Type]",
//                'laundry' => "[Laundry]",
//                'parking' => "[Parking]",
//                'wheelchair_accessible' => "[Wheelchair]",
//                'no_smoking' => "[No Smoking]",
//                'furnished' => "[Furnished]",
//                'maps_section' => "[Address]",
//                'cross_street' => "[Cross Street]",
//                'city' => "[City]",
//                'state_abbr' => "[State Abbr]",
//            );
//            $this->db->insert('properties_templates_craiglist_video', $data);
//        }
//    }
//
//        public function saveCustom2() {
//        $this->load->database();
//        for ($i = 1; $i < 41; $i++) {
//            $data = array(
//                'module' => 'ebay',
//                'type' => 'Zipcode',
//                'shortcode' => "[zipcode $i]",
//                'content' => "[Zipcode]"
//            );
//            $this->db->insert('properties_templates_sc', $data);
//        }
//    }
}
