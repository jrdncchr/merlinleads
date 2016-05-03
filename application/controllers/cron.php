<?php

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
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
