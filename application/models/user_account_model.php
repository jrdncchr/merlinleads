<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class user_account_model extends CI_Model
{

    private $tbl = 'user_accounts';

    function __construct()
    {
        $this->load->database();
    }
    public function get($where = array(), $list = true)
    {
        $result = $this->db->get_where($this->tbl, $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($data)
    {
        $result = $this->db->get_where($this->tbl, array('user_id' => $data['user_id'], 'account_id' => $data['account_id']));
        if ($result->num_rows() > 0) {
            $this->db->where(array('user_id' => $data['user_id'], 'account_id' => $data['account_id']));
            $this->db->update($this->tbl, $data);
        } else {
            $this->db->insert($this->tbl, $data);
        }
        return array('success' => true);
    }

    public function delete($user_id, $id)
    {
        $this->db->delete($this->tbl, array('user_id' => $user_id, 'id' => $id));
    }

    public function get_scheduler_user_accounts($scheduler_id)
    {
        $this->db->select('ua.*');
        $this->db->join('user_accounts ua', 'ua.id = sua.user_account_id', 'left');
        $result = $this->db->get_where('scheduler_user_account sua', array('scheduler_id' => $scheduler_id));
        if ($result->num_rows() > 0) {
            return $result->result();
        }
        return null;
    }

    public function get_scheduler_otp_user_accounts($scheduler_post_id)
    {
        $this->db->select('ua.*');
        $this->db->join('user_accounts ua', 'ua.id = soua.user_account_id', 'left');
        $result = $this->db->get_where('scheduler_otp_user_account soua', array('scheduler_post_id' => $scheduler_post_id));
        if ($result->num_rows() > 0) {
            return $result->result();
        }
        return null;
    }

} 