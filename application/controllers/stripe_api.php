<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stripe_Api extends MY_Controller {

    public function __construct() {
        parent::__construct();
        include_once OTHERS . 'stripe/lib/Stripe.php';
        Stripe::setApiKey(STRIPE_SECRET_KEY);
    }

    /*
     * Subscriptions
     */

    public function chargePackage() {
        $user = $this->session->userdata('user');
        $customer = Stripe_Customer::retrieve($user->stripe_customer_id);
        try {
            $plan = Stripe_Plan::retrieve($_POST['planId']);
            if($plan->statement_descriptor == "Main") {
                $this->load->library('stripe_library');
                $subscription_id = $this->stripe_library->get_main_subscription_id($user->stripe_customer_id);
                if($subscription_id) {
                    $subscription = $customer->subscriptions->retrieve($subscription_id);
                    $subscription->plan = $_POST['planId'];
                    $subscription->card = $_POST['stripeToken'];
                    $subscription->save();
                } else {
                    $customer->subscriptions->create(
                        array("plan" => $plan->id, "trial_end" => 'now', 'card' => $_POST['stripeToken']));
                }    
            } else { //Package is Addon
                $customer->subscriptions->create(array("plan" => $plan->id, 'card' => $_POST['stripeToken']));
            }        
            $this->data['message'] = "Success";
        } catch (Stripe_CardError $e) {
            $err  = $e->getJsonBody()['error'];
            $this->data['message'] = "Error Type: " . $err['code'] . "\n Message: " . $err['message'];
        } catch (Stripe_InvalidRequestError $e) { //customer has no active cards
            $err  = $e->getJsonBody()['error'];
            $this->data['message'] = "Message: " . $err['message'];
        }   

        $this->data['user'] = $user;
        $this->data['packageName'] = $_POST['planName'];
        $this->_renderL('pages/store_success');
    }

    public function cancel_subscription() {
        $user = $this->session->userdata('user');
        $subscription_id = $_POST['id'];
        $plan_name = $_POST['planName'];
        $customer = Stripe_Customer::retrieve($user->stripe_customer_id);
        $customer->subscriptions->retrieve($subscription_id)->cancel();

//        session_start();
        $_SESSION['message'] = "You have cancelled your subscription for $plan_name.";
        header("Location: " . base_url() . "main/myaccount");
        exit();
    }

    /*
     * Customers
     */

    public function create_customer() {
        // get user details from stripe
        $input = @file_get_contents("php://input");
        $event_json = json_decode($input);
        $user = $event_json->data->object;
        $card = isset($event_json->data->object->cards->data[0]) ? $event_json->data->object->cards->data[0]: null;

//         mail("jrdncchr@gmail.com", "Attempted to create a user.", $input);

        $this->load->model('user_model');
        // check if the email exists
        if(!$this->user_model->checkEmailFP($user->email)) { // return null if email already exists
            // create needed fields and save to users
            $this->load->library('custom_library');
            $random_password = $this->custom_library->get_random_string(10);
            $salt = $this->custom_library->get_random_string(16);

            include_once OTHERS . "PasswordHash.php";
            $hashed_password = create_hash($random_password . $salt);
            $key = $this->custom_library->get_random_string(16);

            $new_user = array(
                'email' => $user->email,
                'password' => $hashed_password,
                'salt' => $salt,
                'confirmation_key' => $key,
                'stripe_customer_id' => $user->id,
                );  
            if($card) {
                $new_user['firstname'] = $card->name;
                $new_user['country'] = $card->address_country;
            }

            $result = $this->user_model->add($new_user);
            if($result) {
                // add subscription

                // send confirmation email
                $this->load->model('email_model');
                $this->email_model->sendConfirmationEmail($user->email, $key, $random_password);
                http_response_code(200);
            }
        } else {
            //add subscription to the user
            mail("jrdncchr@gmail.com", "LGT.net - User Duplication", "There was attempt to create an existing user with an email of: " . $user->email);
            http_response_code(200);
        }
    }

    public function delete_customer() {
        $input = @file_get_contents("php://input");
        $event_json = json_decode($input);
        $user = $event_json->data->object;

        // mail("jrdncchr@gmail.com","Test",$user->id);
        $this->load->model('user_model');
        if($this->user_model->deleteByStripeId($user->id)) {
            http_response_code(200);
        }
    }

    /*
     * Plans
     */

    public function create_plan() {
        $input = @file_get_contents("php://input");
        $event_json = json_decode($input);
        $plan = $event_json->data->object;
        // mail("jrdncchr@gmail.com","Create Plan",$input);

        /*
         * Get the plan information that was created in Stripe.
         */
        $publishable_key = STRIPE_PUBLISHABLE_KEY;
        $action = base_url() . "stripe_api/chargePackage";
        $amount = $plan->amount;
        $planName = $plan->name;
        $planId = $plan->id;

        /*
         * This stripe form is saved in the database, and is shown in the upgrade page.
         */
        $stripe_form = "<form id='payment-form' class='monthly-form payment-form' action='$action' method='POST'>
                            <script
                                src='https://checkout.stripe.com/checkout.js' class=stripe-button
                                data-key='$publishable_key'
                                data-amount='$amount'
                                data-name='$planName'>
                            </script>
                            <input type='hidden' name='planId' value='$planId' />
                            <input type='hidden' name='amount' value='$amount' />
                            <input type='hidden' name='planName' value='$planName' />
                        </form>";

        $new_plan = array(
            'stripe_plan_id' => $planId,
            'name' => $planName,
            'stripe_form' => $stripe_form
            );

        $this->load->model('package_model');
        if($this->package_model->addPackage($new_plan)) {
            http_response_code(200);
        }

    }

    public function delete_plan() {
        $input = @file_get_contents("php://input");
        $event_json = json_decode($input);
        $plan = $event_json->data->object;

        // mail("jrdncchr@gmail.com","Test",$user->id);
        $this->load->model('package_model');
        if($this->package_model->deletePackageByStripeId($plan->id)) {
            http_response_code(200);
        }
    }

    /*
     * Cards
     */

    public function create_card() {
        $user = $this->session->userdata('user');
        $customer = Stripe_Customer::retrieve($user->stripe_customer_id);
        $customer->card = array(
            'number' => $_POST['card_number'],
            'exp_month' => $_POST['exp_month'],
            'exp_year' => $_POST['exp_year'],
            'cvc' => $_POST['cvc'],
            'name' => $_POST['cardholder_name'],
            'address_city' => $_POST['address_city'] == "" ? NULL : $_POST['address_city'],
            'address_country' => $_POST['address_country'] == "" ? NULL :  $_POST['address_country'],
            'address_state' => $_POST['address_state'] == "" ? NULL : $_POST['address_state'],
            'address_line1' => $_POST['address_line1'] == "" ? NULL : $_POST['address_line1'],
            'address_line2' => $_POST['address_line2'] == "" ? NULL : $_POST['address_line2'],
            'address_zip' => $_POST['address_zip'] == "" ? NULL : $_POST['address_zip']
        );
        if($customer->save()) {
            echo "Success";
        }
    }

    public function update_card() {
        $user = $this->session->userdata('user');
        $customer = Stripe_Customer::retrieve($user->stripe_customer_id);
        $card_id = $this->session->userdata('stripe_card_id');
        $card = $customer->cards->retrieve($card_id);
        $card->name = $_POST['cardholder_name'] == "" ? NULL : $_POST['cardholder_name'];
        $card->exp_month = $_POST['exp_month'];
        $card->exp_year = $_POST['exp_year'];
        $card->address_city = $_POST['address_city'] == "" ? NULL : $_POST['address_city'];
        $card->address_country = $_POST['address_country'] == "" ? NULL :  $_POST['address_country'];
        $card->address_state = $_POST['address_state'] == "" ? NULL : $_POST['address_state'];
        $card->address_line1 = $_POST['address_line1'] == "" ? NULL : $_POST['address_line1'];
        $card->address_line2 = $_POST['address_line2'] == "" ? NULL : $_POST['address_line2'];
        $card->address_zip = $_POST['address_zip'] == "" ? NULL : $_POST['address_zip'];
        if($card->save()) {
            echo "Success";
        }
    }

}
