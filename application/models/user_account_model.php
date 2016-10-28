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

} 