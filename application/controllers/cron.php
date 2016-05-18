<?php

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function scheduled_posting($time) {
        $posted_posts = array();

        $this->load->model('api_model');
        $this->api_model->load();

        $time = str_replace('_', ' ', $time);
        $date = date('Y-m-d');
        $day = date('l');

        $this->load->model('scheduler_model');
        $this->load->model('user_model');

        /*
         * WEEKLY SCHEDULED
         */
        $schedulers = $this->scheduler_model->get_scheduler(array('time' => $time, 'day' => $day, 'status' => 'Active'));
        foreach($schedulers as $s) {
            $user = $this->user_model->get($s->user_id);
            if($s->library == "user") {
                $post = $this->scheduler_model->get_scheduler_next_post($s);
            } else if($s->library == "merlin") {
                $this->load->model('merlin_library_model');
                $post = $this->merlin_library_model->get_scheduler_next_post($s);
                $this->load->model('property_model');
                $property = $this->property_model->getProperty($s->property_id);
                $this->load->model('profile_model');
                $profile = $this->profile_model->getProfile($s->profile_id);
                $this->load->model('template_model');
                $post->post_body = $this->template_model->generateData($post->post_body, $property, $profile);
            }

            $result = $this->api_model->post($s, $post, $user);
            foreach($result as $r) {
                if($r['success']) {
                    $posted_post = array(
                        'scheduler_id' => $s->scheduler_id,
                        'link' => $r['link'],
                        'module' => $r['module'],
                        'post_id' => $post->post_id
                    );
                    $posted_posts[] = $posted_post;
                }
            }
        }

        /*
         * ONE TIME POST
         */
        $otp = $this->scheduler_model->get_scheduler_post(array('otp' => 1, 'otp_date' => $date, 'otp_time' => $time));
        foreach($otp as $p) {
            $user = $this->user_model->get($p->post_user_id);
            $result = $this->api_model->ot_post($p, $user);
            foreach($result as $r) {
                if($r['success']) {
                    $posted_post = array(
                        'scheduler_id' => null,
                        'link' => $r['link'],
                        'module' => $r['module'],
                        'post_id' => $p->post_id
                    );
                    $posted_posts[] = $posted_post;
                }
            }
        }

        for($i = 0; $i < sizeof($posted_posts); $i++) {
            $this->api_model->insertPosts($posted_posts[$i]);
        }
    }


}
