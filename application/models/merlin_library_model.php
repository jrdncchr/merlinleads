<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class merlin_library_model extends CI_Model {

    private $merlin_post_table = 'merlin_post';
    private $merlin_category_table = 'merlin_category';

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

} 