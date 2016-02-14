<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class scheduler_model extends CI_Model {

    private $scheduler_table = 'scheduler';
    private $scheduler_content_table = 'scheduler_content';

    function __construct() {
        $this->load->database();
    }

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

} 