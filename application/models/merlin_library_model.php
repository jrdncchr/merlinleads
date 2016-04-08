<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class merlin_library_model extends CI_Model {

    private $merlin_library_table = 'merlin_library';
    private $merlin_templates_table = 'merlin_templates';
    private $scheduler_post_table = 'scheduler_posts';

    function __construct() {
        $this->load->database();
    }

    /*
     * Merlin Library
     */
    public function library_get($library_id = 0) {
        if($library_id == 0) {
            $this->db->reconnect();
            $query = $this->db->query("call getMerlinLibraries()");
            $result = $query->num_rows() > 0 ? $query->result() : array();
        } else {
            $query = $this->db->get_where($this->merlin_library_table, array('id' => $library_id));
            $result = $query->row();
        }
        return $result;
    }

    public function library_save($library) {
        $result = array('success' => false);
        if(isset($library['id'])) {
            $this->db->where('id', $library['id']);
            unset($library['id']);
            if($this->db->update($this->merlin_library_table, $library)) {
                $result['success'] = true;
            }
        } else {
            if($this->db->insert($this->merlin_library_table, $library)) {
                $result['success'] = true;
                $result['id'] = $this->db->insert_id();
            }
        }
        return $result;
    }

    public function library_delete($library_id) {
        $result = array('success' => false, 'message' => 'Something went wrong!');

        $this->db->trans_begin();
        $this->db->where('id', $library_id);
        if($this->db->delete($this->merlin_library_table)) {
            $this->db->where('library_id', $library_id);
            $this->db->delete($this->merlin_templates_table);
        }

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $result['success'] = true;
            unset($result['message']);
        }
        $this->db->trans_complete();
        return $result;
    }

    public function library_get_template($scheduler) {
        $this->db->reconnect();
        $result = $this->db->get_where($this->merlin_library_table, array('id' => $scheduler->library_id));
        $library = $result->row();

        $this->db->order_by('date_created', 'asc');
        $result = $this->db->get_where($this->merlin_templates_table, array('library_id' => $library->id));
        $templates = $result->result();

        $this->db->order_by('date_posted', 'desc');
        $result = $this->db->get_where($this->scheduler_post_table, array('scheduler_id' => $scheduler->scheduler_id));
        if($result->num_rows() > 0) {
            $posts = $result->result();
            if($posts[0]->template_id == $templates[sizeof($templates)-1]->id) {
                return $templates[0];
            } else {
                for($i = 0; $i < sizeof($templates); $i++) {
                    if($posts[0]->template_id == $templates[$i]->id) {
                        return $templates[$i+1];
                    }
                }
            }
        }
        return $templates[0];
    }

    /*
     * Templates
     */
    public function templates_get($library_id, $template_id = 0) {
        if($template_id == 0) {
            $query = $this->db->get_where($this->merlin_templates_table, array('library_id' => $library_id));
            $result = $query->result();
        } else {
            $query = $this->db->get_where($this->merlin_templates_table, array('library_id' => $library_id, 'id' => $template_id));
            $result = $query->row();
        }
        return $result;
    }

    public function templates_save($template) {
        $result = array('success' => false);
        if(isset($template['id'])) {
            $this->db->where('id', $template['id']);
            unset($template['id']);
            if($this->db->update($this->merlin_templates_table, $template)) {
                $result['success'] = true;
            }
        } else {
            if($this->db->insert($this->merlin_templates_table, $template)) {
                $result['success'] = true;
                $result['id'] = $this->db->insert_id();
            }
        }
        return $result;
    }

    public function templates_delete($ids) {
        $result = array("success" => false);
        $this->db->trans_begin();
        foreach($ids as $id) {
            $this->db->where('id', $id);
            $this->db->delete($this->merlin_templates_table);
        }

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $result['success'] = true;
            unset($result['message']);
        }
        $this->db->trans_complete();
        return $result;
    }

} 