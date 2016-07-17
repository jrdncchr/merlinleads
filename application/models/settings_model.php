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

    public function save($settings)
    {
        foreach($settings as $s) {
            $this->db->where('id', $s['id']);
            $this->db->update($this->tbl, array('v' => $s['v']));
        }
        return array('success' => true);
    }

} 