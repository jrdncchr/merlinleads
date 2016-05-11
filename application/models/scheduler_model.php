<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class scheduler_model extends CI_Model {

    private $scheduler_table = 'scheduler';
    private $scheduler_post_table = 'scheduler_post';
    private $scheduler_category_table = 'scheduler_category';
    private $merlin_category_table = 'merlin_category';

    function __construct() {
        $this->load->database();
    }

    /*
     * Scheduler
     */

    public function get_scheduler($where = array(), $list = true) {
        $this->db->join($this->scheduler_category_table, 'scheduler_category.category_id = scheduler.category_id', 'left');
        $result = $this->db->get_where($this->scheduler_table, $where);
        return $list ? $result->result() : $result->row();
    }

    public function get_scheduler_details($where = array()) {
        $list = array();
        $result = $this->db->get_where($this->scheduler_table, $where);
        if($result->num_rows() > 0) {
            $scheduler = $result->result();
            foreach($scheduler as $s) {
                if($s->library == "user") {
                    $category_details = $this->db->get_where($this->scheduler_category_table, array('category_id' => $s->category_id));
                    $s->category = $category_details->row();
                } else if($s->library == "merlin") {
                    $category_details = $this->db->get_where($this->merlin_category_table, array('category_id' => $s->category_id));
                    $s->category = $category_details->row();
                }
                $list[] = $s;
            }
        }
        return $list;
    }

    public function add_scheduler($scheduler) {
        $this->db->insert($this->scheduler_table, $scheduler);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update_scheduler($id, $scheduler) {
        $this->db->where('scheduler_id', $id);
        $this->db->update($this->scheduler_table, $scheduler);
        return array('success' => true);
    }

    public function delete_scheduler($id) {
        $this->db->where('scheduler_id', $id);
        $this->db->delete($this->scheduler_table);
        return array('success' => true);
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
    public function get_scheduler_post($where = array(), $list = true) {
        $this->db->join($this->scheduler_category_table, 'scheduler_category.category_id = scheduler_post.post_category_id');
        $result = $this->db->get_where($this->scheduler_post_table, $where);
        return $list ? $result->result() : $result->row();
    }

    public function add_scheduler_post($post) {
        $this->db->insert($this->scheduler_post_table, $post);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update_scheduler_post($id, $post) {
        $this->db->where('post_id', $id);
        $this->db->update($this->scheduler_post_table, $post);
        return array('success' => true);
    }

    public function delete_scheduler_post($post_id) {
        $this->db->where('post_id', $post_id);
        $this->db->delete($this->scheduler_post_table);
        return array('success' => true);
    }
} 