<?php

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function twitter_autopost() {
        // Include Codebird
        require_once OTHERS . "twitter/codebird.php";

        //get all properties and users information with enabled twitter module
        $this->load->model('property_module_model');
        $property_user = $this->property_module_model->getPropertyUserOfEnabledTwitterAutopost();

        if ($property_user) {
            foreach ($property_user as $pu) {
                //get user of the property and get api
                $user = $pu['user'];
                $property = $pu['property'];
                $module = $pu['module'];

                $twitter = json_decode($user->advance_twitter);
                \Codebird\Codebird::setConsumerKey($twitter->consumer_key, $twitter->consumer_secret);
                $cb = \Codebird\Codebird::getInstance();
                $cb->setToken($twitter->access_token, $twitter->access_token_secret);

                $reply = $cb->oauth2_token();
                if (isset($reply->errors)) {
                    echo $reply->errors[0]->message;
                } else {
                    $bearer_token = $reply->access_token;
                    \Codebird\Codebird::setBearerToken($bearer_token);

                    //get random property keyword
                    $keywords = $property->keywords;
                    $random_keyword = explode('|', $keywords)[rand(0, 17)];

                    //get a status and link and simplify a link
                    $this->load->library('custom_library');
                    $short_url = $this->custom_library->shorten_url($module->url);
                    $tweet = $random_keyword . "  " . $short_url;
                    $params = array('status' => $tweet);
                    $reply = $cb->statuses_update($params);

                    //save to property post twitter database
                    $this->property_module_model->addPropertyPostTwitter(array(
                        'property_id' => $property->id,
                        'tweet' => $tweet,
                        'url' => $module->url
                    ));

                    //update property overview with the new count
                    $count = $this->property_module_model->getPropertyPostTwitterCount($property->id);
                    $this->load->model('property_model');
                    $this->property_model->updateOverviewByPropertyId(array('twitter' => $count), $property->id);
                }
            }
        }
    }

    public function scheduled_posting($time) {
        $this->load->model('api_model');
        $this->api_model->load();

        $posts = array();

        $this->load->model('scheduler_model');
        $schedulers = $this->scheduler_model->getListByTimeForScheduledPosting($time . ":00");

        $this->load->model('api_model');
        foreach($schedulers as $s) {
            $result = [];

            if($s->type == "Custom") {
                $custom_content = $this->scheduler_model->scheduler_custom_content_get($s->content_id);
                $s->headline = $custom_content->headline;
                $s->content = $custom_content->content;
                $s->keywords = $custom_content->keywords;
                $s->url = $custom_content->url;
            } else if($s->type == "Library") {
                $template = $this->scheduler_model->scheduler_library_get_template($s);
                $s->headline = $template->headline;
                $s->content = $template->content;
                $s->keywords = $template->keywords;
                $s->url = $template->url;
                $s->template_id = $template->id;
            } else if($s->type == "Merlin Library") {
                $this->load->model('merlin_library_model');
                $template = $this->merlin_library_model->library_get_template($s);
                $s->headline = $template->headline;
                $s->content = $template->content;
                $s->keywords = $template->keywords;
                $s->url = $template->url;
                $s->template_id = $template->id;
            }

            switch($s->interval_code) {
                case "E":
                    $result = $this->api_model->post($s);
                    break;

                case "W":
                    // check if already a week has passed
                    break;

                case "S":
                    break;

                default;
            }

            if($result['success']) {
                $post = array(
                    'scheduler_id' => $s->scheduler_id,
                    'link' => $result['link'],
                    'module' => $s->module
                );
                if($s->type == "Library" || $s->type == "Merlin Library") {
                    $post['template_id'] = $s->template_id;
                }
                $posts[] = $post;
            }
        }

        $this->db->reconnect();
        for($i = 0; $i < sizeof($posts); $i++) {
            $this->api_model->insertPosts($posts[$i]);
        }
    }

}
