<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Stripe_Library{

	public function __construct() {
		include_once OTHERS . 'stripe/lib/Stripe.php';
        Stripe::setApiKey(STRIPE_SECRET_KEY);
	}

	public function get_all_plans() {
		$plans = Stripe_Plan::all();
		return $plans->data;
	}

	public function get_subscriptions($customer_id) {
		$result = Stripe_Customer::retrieve($customer_id)->subscriptions->all();
		$CI =& get_instance();
		$CI->load->model('package_model');

		$subscriptions = [];
		foreach ($result->data as $subscription) {
			$plan = $subscription->plan;
            if($plan) {
                $pkg = $CI->package_model->get_package_details($plan->id);

                $features = json_decode($pkg->features_json);
                $plan->features = $features;
                $subscription->plan = $plan;
                $subscriptions[] = $subscription;
            }
		}
		if(sizeof($subscriptions) > 0) {
			return $subscriptions;	
		} else {
			return false;
		}
	} 

    /*
     * ------- FOR NUMBER OF PROPERTY/PROFILE FEATURE
     */
	public function get_available_property_and_profile($customer_id) {
		$subscriptions = $this->get_subscriptions($customer_id);
		$count = array(
			'property' => 0,
			'profile' => 0
			);
        if($subscriptions) {
            foreach ($subscriptions as $s) {
            	if($s->plan->features->number_of_properties == "*") {
            		$count['property'] = "*";
            	} else {
                    $count['property'] += (int)$s->plan->features->number_of_properties;
                }
                if($s->plan->features->number_of_profiles == "*") {
                    $count['profile'] = "*";
                } else {
                    $count['profile'] += (int)$s->plan->features->number_of_profiles;
                }
            }
        }

		return $count;
	}

	public function get_main_subscription_id($customer_id) {
		$result = Stripe_Customer::retrieve($customer_id)->subscriptions->all();
		foreach ($result->data as $subscription) {
			$plan = $subscription->plan;
			if($plan->statement_descriptor == "Main") {
				return $subscription->id;
			}
		}
		return false;
	}

	public function get_main_subscription($customer_id) {
		$result = Stripe_Customer::retrieve($customer_id)->subscriptions->all();
		foreach ($result->data as $subscription) {
			$plan = $subscription->plan;
			if($plan->statement_descriptor == "Main") {
				return $subscription;
			}
		}
		return false;
	}

    /*
     * Cards
     */

    public function getDefaultCard($customer_id) {
        $cards = Stripe_Customer::retrieve($customer_id)->cards->all();
        if(sizeof($cards->data) > 0) {
            return $cards->data[0];
        }

    }

}