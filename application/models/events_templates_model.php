<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class events_templates_model extends CI_Model
{

    private $tbl = 'properties_events_templates';
    private $tbl_custom = 'properties_events_templates_custom';

    function __construct()
    {
        $this->load->database();
    }

    /*
     * Properties Events Templates
     */
    public function get($where = array(), $list = true)
    {
        $result = $this->db->get_where($this->tbl, $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($data)
    {
        if ($data['is_default'] == 1) {
            $this->db->where('is_default', 1);
            $this->db->update($this->tbl, array('is_default' => 0));
        }
        if (isset($data['id']) && $data['id'] != "") {
            $this->db->where('id', $data['id']);
            $this->db->update($this->tbl, $data);
        } else {
            $this->db->insert($this->tbl, $data);
        }
        return array('success' => true);
    }

    public function delete($id)
    {
        $this->db->delete($this->tbl, array('id' => $id));
        return array('success' => true);
    }

    /*
     * Custom Templates
     */
    public function get_custom($where = array(), $list = true)
    {
        $this->db->select('properties_events_templates_custom.*, properties_events.name as event, properties_events.id as event_id');
        $this->db->join('properties_events', 'properties_events.id = properties_events_templates_custom.event_id', 'left');
        $result = $this->db->get_where($this->tbl_custom, $where);
        return $list ? $result->result() : $result->row();
    }

    public function save_custom($data)
    {
        if (isset($data['id']) && $data['id'] != "") {
            $this->db->where('id', $data['id']);
            $this->db->update($this->tbl_custom, $data);
        } else {
            $this->db->insert($this->tbl_custom, $data);
        }
        return array('success' => true);
    }

    public function delete_custom($id)
    {
        $this->db->delete($this->tbl_custom, array('id' => $id));
        return array('success' => true);
    }

} 