<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class scheduler_model extends CI_Model {

    private $scheduler_table = 'scheduler';
    private $scheduler_post_table = 'scheduler_post';
    private $scheduler_category_table = 'scheduler_category';
    private $merlin_category_table = 'merlin_category';

    private $scheduler_pp_table = 'scheduler_posted_post';

    function __construct() {
        $this->load->database();
    }

    /*
     * Scheduler
     */

    public function get_scheduler($where = array(), $list = true) {
        $this->db->select('s.*, scheduler_category.category_name as user_category, merlin_category.category_name as merlin_category');
        $this->db->join($this->scheduler_category_table, 'scheduler_category.category_id = s.category_id', 'left');
        $this->db->join($this->merlin_category_table, 'merlin_category.category_id = s.category_id', 'left');
        $result = $this->db->get_where($this->scheduler_table . ' as s', $where);
        return $list ? $result->result() : $result->row();
    }

    public function get_scheduler_details($where = array()) {
        $list = array();
        $result = $this->db->get_where($this->scheduler_table, $where);
        if($result->num_rows() > 0) {
            $scheduler = $result->result();
            foreach($scheduler as $s) {
                if ($s->library == "user") {
                    $category_details = $this->db->get_where($this->scheduler_category_table, array('category_id' => $s->category_id));
                    $s->category = $category_details->row();
                } else if($s->library == "merlin") {
                    $category_details = $this->db->get_where($this->merlin_category_table, array('category_id' => $s->category_id));
                    $s->category = $category_details->row();
                }
                $s->user_accounts = $this->db->get_where('scheduler_user_account', array('scheduler_id' => $s->scheduler_id))->result();
                $list[] = $s;
            }
        }
        return $list;
    }

    public function add_scheduler($scheduler) {
        $user_accounts = $scheduler['user_accounts'];
        unset($scheduler['user_accounts']);
        $this->db->insert($this->scheduler_table, $scheduler);
        $scheduler_id = $this->db->insert_id();
        $this->save_scheduler_user_accounts($scheduler_id, $user_accounts);
        return array('success' => true, 'inserted_id' => $scheduler_id);
    }

    public function update_scheduler($id, $scheduler) {
        $user_accounts = $scheduler['user_accounts'];
        unset($scheduler['user_accounts']);
        $this->db->where('scheduler_id', $id);
        $this->db->update($this->scheduler_table, $scheduler);
        $this->save_scheduler_user_accounts($id, $user_accounts);
        return array('success' => true);
    }

    public function delete_scheduler($id) {
        $this->db->where('scheduler_id', $id);
        $this->db->delete($this->scheduler_table);
        return array('success' => true);
    }

    /*
     * Scheduler User Accounts
     */

    public function save_scheduler_user_accounts($scheduler_id, $user_accounts)
    {
        foreach ($user_accounts as $ua) {
            $result = $this->db->get_where('scheduler_user_account', array('scheduler_id' => $scheduler_id, 'user_account_id' => $ua['id']));
            if ($result->num_rows() > 0) {
                if ($ua['status'] == 'off') {
                    $this->db->where(array('scheduler_id' => $scheduler_id, 'user_account_id' => $ua['id']));
                    $this->db->delete('scheduler_user_account');
                }
            } else {
                if ($ua['status'] == 'on') {
                    $this->db->insert('scheduler_user_account', array('scheduler_id' => $scheduler_id, 'user_account_id' => $ua['id']));
                }
            }
        }
    }

    /*
     * Scheduler OTP User Accounts
     */

    public function save_scheduler_otp_user_accounts($scheduler_post_id, $user_accounts)
    {
        foreach ($user_accounts as $ua) {
            $result = $this->db->get_where('scheduler_otp_user_account', array('scheduler_post_id' => $scheduler_post_id, 'user_account_id' => $ua['id']));
            if ($result->num_rows() > 0) {
                if ($ua['status'] == 'off') {
                    $this->db->where(array('scheduler_post_id' => $scheduler_post_id, 'user_account_id' => $ua['id']));
                    $this->db->delete('scheduler_otp_user_account');
                }
            } else {
                if ($ua['status'] == 'on') {
                    $this->db->insert('scheduler_otp_user_account', array('scheduler_post_id' => $scheduler_post_id, 'user_account_id' => $ua['id']));
                }
            }
        }
    }

    /*
     * Scheduler Category
     */
    public function get_scheduler_category($where = array(), $list = true) {
        $this->db->select('*');
        $this->db->select('(SELECT count(post_id) FROM scheduler_post WHERE post_category_id = scheduler_category.category_id) as post_count');
        $result = $this->db->get_where($this->scheduler_category_table, $where);
        return $list ? $result->result() : $result->row();
    }

    public function add_scheduler_category($category) {
        $this->db->insert($this->scheduler_category_table, $category);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update_scheduler_category($id, $category) {
        $this->db->where('category_id', $id);
        $this->db->update($this->scheduler_category_table, $category);
        return array('success' => true);
    }

    public function delete_scheduler_category($id) {
        $this->db->where('category_id', $id);
        $this->db->delete($this->scheduler_category_table);
        return array('success' => true);
    }

    /*
     * Scheduler Post
     */
    public function get_scheduler_post($where = array(), $list = true)
    {
        $this->db->select('scheduler_post.*, scheduler_category.category_name as user_category, merlin_category.category_name as merlin_category');
        $this->db->join($this->scheduler_category_table, 'scheduler_category.category_id = scheduler_post.post_category_id', 'left');
        $this->db->join($this->merlin_category_table, 'merlin_category.category_id = scheduler_post.post_category_id', 'left');
        $result = $this->db->get_where($this->scheduler_post_table, $where);
        if ($list) {
            return $result->result();
        } else {
            $post = $result->row();
            $post->user_accounts = $this->db->get_where('scheduler_otp_user_account', array('scheduler_post_id' => $where['post_id']))->result();
            return $post;
        }
    }

    public function add_scheduler_post($post) {
        $user_accounts = $post['user_accounts'];
        unset($post['user_accounts']);
        $this->db->insert($this->scheduler_post_table, $post);
        $post_id = $this->db->insert_id();
        $this->save_scheduler_otp_user_accounts($post_id, $user_accounts);
        return array('success' => true, 'inserted_id' =>$post_id);
    }

    public function update_scheduler_post($id, $post) {
        $user_accounts = $post['user_accounts'];
        unset($post['user_accounts']);
        $this->db->where('post_id', $id);
        $this->db->update($this->scheduler_post_table, $post);
        $this->save_scheduler_otp_user_accounts($id, $user_accounts);
        return array('success' => true);
    }

    public function delete_scheduler_post($post_id) {
        $this->db->where('post_id', $post_id);
        $this->db->delete($this->scheduler_post_table);
        return array('success' => true);
    }

    public function get_scheduler_next_post($scheduler) {
        $this->db->reconnect();
        $result = $this->db->get_where($this->scheduler_category_table, array('category_id' => $scheduler->category_id));
        $category = $result->row();

        $this->db->order_by('post_date_created', 'asc');
        $result = $this->db->get_where($this->scheduler_post_table, array('post_category_id' => $category->category_id, 'post_library' => $scheduler->library));
        $posts = $result->result();

        $this->db->order_by('date_posted', 'desc');
        $result = $this->db->get_where($this->scheduler_pp_table, array('scheduler_id' => $scheduler->scheduler_id));
        if($result->num_rows() > 0) {
            $pp = $result->result();
            if($pp[0]->post_id == $posts[sizeof($posts)-1]->post_id) {
                return $posts[0];
            } else {
                for($i = 0; $i < sizeof($posts); $i++) {
                    if($pp[0]->post_id == $posts[$i]->post_id) {
                        return $posts[$i+1];
                    }
                }
            }
        }
        return $posts[0];
    }

    /*
     * Scheduler Queue
     */
    public function get_queue($user_id, $until_date = false, $start_date = false) {
        date_default_timezone_set('America/Los_Angeles');

        if(!$until_date) {
            $until_date = date('F j, Y', strtotime('12/31'));
        }

        $otp_schedule = $this->get_scheduler_post(array('post_user_id' => $user_id, 'otp' => 1));

        $otp_posts = array();
        foreach($otp_schedule as $os) {
            $obj = new stdClass();
            if(strtotime($until_date) >= strtotime($os->otp_date)) {

                if($start_date) {
                    if(strtotime($start_date) >= strtotime($os->otp_date)) {
                        continue;
                    }
                }

                $schedule_date = date('F j, Y', strtotime($os->otp_date));

                $obj->schedule = $schedule_date . " " . date("g:i a", strtotime($os->otp_time));
                $obj->time = $os->otp_time;
                $obj->type = "One Time Post";
                $obj->library = $os->post_library;
                $obj->category = $os->post_library == "user" ? $os->user_category : $os->merlin_category;
                $obj->post_name = $os->post_name;
                $obj->modules = $os->otp_modules;

                $otp_posts[] = $obj;
            }
        }

        $weekly_schedule = $this->get_scheduler(array('user_id' => $user_id, 'status' => 'Active'));

        $weekly_posts = array();
        foreach($weekly_schedule as $ws) {
            $next_schedule = strtotime('next ' . $ws->day);
            while(strtotime($until_date) >= $next_schedule) {
                if($start_date) {
                    if(strtotime($start_date) >= $next_schedule) {
                        $next_schedule = strtotime("+7 day", $next_schedule);
                        continue;
                    }
                }
                $obj = new stdClass();
                $next_schedule_date = date('F j, Y', $next_schedule);

                $obj->schedule = $next_schedule_date . " " . date("g:i a", strtotime($ws->time));
                $obj->time = $ws->time;
                $obj->type = "Weekly";
                $obj->library = $ws->library;
                $obj->category = $ws->library == "user" ? $ws->user_category : $ws->merlin_category;
                $obj->post_name = "";
                $obj->modules = $ws->modules;

                $weekly_posts[] = $obj;
                $next_schedule = strtotime("+7 day", $next_schedule);
            }
        }

        return array_merge($otp_posts, $weekly_posts);
    }

} 