<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class scheduler_model extends CI_Model {

    private $scheduler_table = 'scheduler';
    private $scheduler_content_table = 'scheduler_content';
    private $scheduler_library_table = 'scheduler_library';
    private $scheduler_user_templates_table = 'scheduler_user_templates';

    function __construct() {
        $this->load->database();
    }

    /*
     * Scheduler
     */
    public function get($user_id, $scheduler_id = 0) {
        if($scheduler_id == 0) {
            $query = $this->db->query("call spGetSchedulerListByUser($user_id)");
            $result = $query->result();
        } else {
            $query = $this->db->query("call spGetSchedulerById($scheduler_id, $user_id)");
            $result = $query->row();
        }
        return $result;
    }

    public function get_post($scheduler_id, $post_id = 0) {
        $where = array('scheduler_id' => $scheduler_id);
        if($post_id > 0) {
            $where['id'] = $post_id;
        }
        $result = $this->db->get_where('scheduler_posts', $where);
        return $result->result();
    }

    public function save($data) {
        $result = array('success' => false, 'message' => 'Something went wrong!');

        $this->db->trans_begin();

        if(isset($data['scheduler']['id'])) {
            $this->db->where('id', $data['scheduler']['id']);
            unset($data['scheduler']['id']);
            if($this->db->update($this->scheduler_table, $data['scheduler'])) {
                $this->db->where('id', $data['content']['id']);
                $this->db->update($this->scheduler_content_table, $data['content']);
            }
        } else {
            if($this->db->insert($this->scheduler_content_table, $data['content'])) {
                $content_id = $this->db->insert_id();
                $data['scheduler']['content_id'] = $content_id;
                if($this->db->insert($this->scheduler_table, $data['scheduler'])) {
                    $result['content_id'] = $content_id;
                    $result['scheduler_id'] = $this->db->insert_id();
                }
            }
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

    public function delete($scheduler_id, $content_id) {
        $result = array('success' => false, 'message' => 'Something went wrong!');

        $this->db->trans_begin();
        $this->db->where('id', $scheduler_id);
        if($this->db->delete($this->scheduler_table)) {
            $this->db->where('id', $content_id);
            $this->db->delete($this->scheduler_content_table);
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

    public function getListByTimeForScheduledPosting($time) {
        $query = $this->db->query("call spGetSchedulerListByTime('$time')");
        return $query->result();
    }

    /*
     * Scheduler Library
     */
    public function scheduler_library_get($user_id, $library_id = 0) {
        if($library_id == 0) {
            $this->db->reconnect();
            $query = $this->db->query("call spGetSchedulerLibraryListByUserId($user_id)");
            $result = $query->num_rows() > 0 ? $query->result() : array();
        } else {
            $query = $this->db->get_where($this->scheduler_library_table, array('user_id' => $user_id, 'id' => $library_id));
            $result = $query->row();
        }
        return $result;
    }

    public function scheduler_library_save($library) {
        $result = array('success' => false);
        if(isset($library['id'])) {
            $this->db->where('id', $library['id']);
            unset($library['id']);
            if($this->db->update($this->scheduler_library_table, $library)) {
                $result['success'] = true;
            }
        } else {
            if($this->db->insert($this->scheduler_library_table, $library)) {
                $result['success'] = true;
                $result['id'] = $this->db->insert_id();
            }
        }
        return $result;
    }

    public function scheduler_library_delete($library_id) {
        $result = array('success' => false, 'message' => 'Something went wrong!');

        $this->db->trans_begin();
        $this->db->where('id', $library_id);
        if($this->db->delete($this->scheduler_library_table)) {
            $this->db->where('library_id', $library_id);
            $this->db->delete($this->scheduler_user_templates_table);
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

    /*
     * Scheduler User Templates
     */
    public function scheduler_user_templates_get($library_id, $template_id = 0) {
        if($template_id == 0) {
            $query = $this->db->get_where($this->scheduler_user_templates_table, array('library_id' => $library_id));
            $result = $query->result();
        } else {
            $query = $this->db->get_where($this->scheduler_user_templates_table, array('library_id' => $library_id, 'id' => $template_id));
            $result = $query->row();
        }
        return $result;
    }

    public function scheduler_user_templates_save($template) {
        $result = array('success' => false);
        if(isset($template['id'])) {
            $this->db->where('id', $template['id']);
            unset($template['id']);
            if($this->db->update($this->scheduler_user_templates_table, $template)) {
                $result['success'] = true;
            }
        } else {
            if($this->db->insert($this->scheduler_user_templates_table, $template)) {
                $result['success'] = true;
                $result['id'] = $this->db->insert_id();
            }
        }
        return $result;
    }

    public function scheduler_user_templates_delete($ids) {
        $result = array("success" => false);
        $this->db->trans_begin();
        foreach($ids as $id) {
            $this->db->where('id', $id);
            $this->db->delete($this->scheduler_user_templates_table);
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