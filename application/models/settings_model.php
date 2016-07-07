<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class settings_model extends CI_Model
{

    private $tbl = 'settings';

    function __construct()
    {
        $this->load->database();
    }

    /*
     * Settings
     */
    public function get($where = array(), $list = true)
    {
        $result = $this->db->get_where($this->tbl, $where);
        return $list ? $result->result() : $result->row();
    }

    public function add($data)
    {
        $this->db->insert($this->tbl, $data);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $data);
        return array('success' => true);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl);
        return array('success' => true);
    }

} 