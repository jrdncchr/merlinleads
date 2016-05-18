<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class merlin_library_model extends CI_Model {

    private $scheduler_content_table = 'merlin_content';
    private $scheduler_library_table = 'merlin_library';

    function __construct() {
        $this->load->database();
    }

    /*
     * Merlin Library
     */
    public function get_library($where = array(), $list = true) {
        $this->db->select('*');
        $this->db->select('(SELECT count(content_id) FROM merlin_content WHERE merlin_content.library_id = merlin_library.library_id) as content_count');
        $result = $this->db->get_where($this->scheduler_library_table, $where);
        return $list ? $result->result() : $result->row();
    }

    public function add_library($library) {
        $this->db->insert($this->scheduler_library_table, $library);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update_library($library_id, $library) {
        $this->db->where('library_id', $library_id);
        $this->db->update($this->scheduler_library_table, $library);
        return array('success' => true);
    }

    public function delete_library($library_id) {
        $this->db->where('library_id', $library_id);
        $this->db->delete($this->scheduler_library_table);
        return array('success' => true);
    }


    /*
     * Scheduler Content
     */
    public function get_scheduler_content($where = array(), $list = true) {
        $this->db->join($this->scheduler_library_table, 'merlin_library.library_id = merlin_content.library_id');
        $result = $this->db->get_where($this->scheduler_content_table, $where);
        return $list ? $result->result() : $result->row();
    }

    public function add_scheduler_content($content) {
        $this->db->insert($this->scheduler_content_table, $content);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update_scheduler_content($content_id, $content) {
        $this->db->where('content_id', $content_id);
        $this->db->update($this->scheduler_content_table, $content);
        return array('success' => true);
    }

    public function delete_scheduler_content($content_id) {
        $this->db->where('content_id', $content_id);
        $this->db->delete($this->scheduler_content_table);
        return array('success' => true);
    }

} 