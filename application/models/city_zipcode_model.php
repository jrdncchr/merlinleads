<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class city_zipcode_model extends CI_Model {

    private $cz_table = 'city_zipcode';
    private $czu_table = 'city_zipcode_user';
    private $users_table = 'users';

    function __construct() {
        $this->load->database();
    }

    /*
     * Merlin Post
     */
    public function get_cz($where = array(), $list = true) {
        $this->db->select('cz.cz_id, cz.cz_city, cz.cz_zipcode, u.email, cz.cz_date_created');
        $this->db->join($this->czu_table . ' as czu', 'czu.czu_cz_id = cz.cz_id', 'left');
        $this->db->join($this->users_table . ' as u', 'u.id = czu.czu_user_id', 'left');
        $result = $this->db->get_where($this->cz_table . ' as cz', $where);
        return $list ? $result->result() : $result->row();
    }

    public function add_cz($cz) {
        $this->db->insert($this->cz_table, $cz);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update_cz($id, $cz) {
        $this->db->where('cz_id', $id);
        $this->db->update($this->cz_table, $cz);
        return array('success' => true);
    }

    public function delete_cz($id) {
        $this->db->where('cz_id', $id);
        $this->db->delete($this->cz_table);
        return array('success' => true);
    }


    /*
     * Merlin Blog Post
     */
    public function get_blog_post($where = array(), $list = true) {
        $this->db->select('mbpt.*, mct.category_name');
        $this->db->from($this->merlin_blog_post_table . ' as mbpt');
        $this->db->join($this->merlin_category_table . ' as mct', 'mct.category_id = mbpt.bp_category', 'left');
        $this->db->where($where);
        $result = $this->db->get();
//        echo $this->db->last_query();exit;
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