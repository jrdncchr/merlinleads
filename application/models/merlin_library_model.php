<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class merlin_library_model extends CI_Model {

    private $merlin_post_table = 'merlin_post';
    private $merlin_category_table = 'merlin_category';
    private $merlin_blog_post_table = 'merlin_blog_post';

    private $scheduler_pp_table = 'scheduler_posted_post';

    function __construct() {
        $this->load->database();
    }

    /*
     * Merlin Category
     */
    public function get_category($where = array(), $list = true) {
        $this->db->select('*');
        $this->db->select('(SELECT count(post_id) FROM merlin_post WHERE merlin_post.post_category_id = merlin_category.category_id) as post_count');
        $result = $this->db->get_where($this->merlin_category_table, $where);
        return $list ? $result->result() : $result->row();
    }

    public function add_category($category) {
        $this->db->insert($this->merlin_category_table, $category);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update_category($id, $category) {
        $this->db->where('category_id', $id);
        $this->db->update($this->merlin_category_table, $category);
        return array('success' => true);
    }

    public function delete_category($id) {
        $this->db->where('category_id', $id);
        $this->db->delete($this->merlin_category_table);
        return array('success' => true);
    }

    public function get_scheduler_next_post($scheduler) {
        $this->db->reconnect();
        $result = $this->db->get_where($this->merlin_category_table, array('category_id' => $scheduler->category_id));
        $category = $result->row();

        $this->db->order_by('post_date_created', 'asc');
        $result = $this->db->get_where($this->merlin_post_table, array('post_category_id' => $category->category_id));
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
     * Merlin Post
     */
    public function get_post($where = array(), $list = true) {
        $this->db->join($this->merlin_category_table, 'merlin_category.category_id = merlin_post.post_category_id');
        $result = $this->db->get_where($this->merlin_post_table, $where);
        return $list ? $result->result() : $result->row();
    }

    public function add_post($post) {
        $this->db->insert($this->merlin_post_table, $post);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update_post($id, $post) {
        $this->db->where('post_id', $id);
        $this->db->update($this->merlin_post_table, $post);
        return array('success' => true);
    }

    public function delete_post($id) {
        $this->db->where('post_id', $id);
        $this->db->delete($this->merlin_post_table);
        return array('success' => true);
    }


    /*
     * Merlin Blog Post
     */
    public function get_blog_post($where = array(), $list = true) {
        $result = $this->db->get_where($this->merlin_blog_post_table, $where);
        return $list ? $result->result() : $result->row();
    }

    public function add_blog_post($post) {
        $this->db->insert($this->merlin_blog_post_table, $post);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update_blog_post($id, $post) {
        $this->db->where('bp_id', $id);
        $this->db->update($this->merlin_blog_post_table, $post);
        return array('success' => true);
    }

    public function delete_blog_post($id) {
        $this->db->where('bp_id', $id);
        $this->db->delete($this->merlin_blog_post_table);
        return array('success' => true);
    }

} 