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
        $day = date('l');
        // $day = "Monday";

        $this->load->model('scheduler_model');
        $this->load->model('user_account_model');

        /*
         * WEEKLY SCHEDULED
         */
        $schedulers = $this->scheduler_model->get_scheduler(array('time' => $time, 'day' => $day, 'status' => 'Active'));

        foreach($schedulers as $s) {
            $user_accounts = $this->user_account_model->get_scheduler_user_accounts($s->scheduler_id);
            if ($user_accounts) {
                $post = $this->scheduler_model->get_scheduler_next_post($s);
                $result = $this->api_model->post($s, $post, $user_accounts);
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
        }

        /*
         * ONE TIME POST
         */
//        $date = date('Y-m-d');
         $date = '2016-07-28';
        $otp = $this->scheduler_model->get_scheduler_post(array('otp' => 1, 'otp_date' => $date, 'otp_time' => $time));
        foreach ($otp as $p) {
            $user_accounts = $this->user_account_model->get_scheduler_otp_user_accounts($p->post_id);
            $result = $this->api_model->ot_post($p, $user_accounts);
            foreach ($result as $r) {
                if($r['success']) {
                    $posted_post = array(
                        'scheduler_id' => $p->post_id,
                        'otp' => 1,
                        'link' => $r['link'],
                        'module' => $r['module'],
                        'post_id' => 0
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
