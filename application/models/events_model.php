<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class events_model extends CI_Model
{

    private $tbl = 'properties_events';
    private $tbl_properties_events_settings = 'properties_events_settings';

    function __construct()
    {
        $this->load->database();
    }

    /*
     * Properties Events
     */
    public function get($where = array(), $list = true)
    {
        $result = $this->db->get_where($this->tbl, $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update($this->tbl, $data);
        return array('success' => true);
    }

    /*
     * Properties Event Settings
     */
    public function get_event_setting($where = array())
    {
        $this->db->join($this->tbl, 'properties_events.id = properties_events_settings.event_id');
        $result = $this->db->get_where($this->tbl_properties_events_settings, $where);
        return $result->row();
    }

    public function get_event_settings($where = array(), $list = true)
    {
        $where['properties_events.active'] = 1;
        $this->db->select('properties_events_settings.*, properties_events.name, properties_events.description, properties_events.event_key');
        $this->db->join($this->tbl, 'properties_events.id = properties_events_settings.event_id');
        $result = $this->db->get_where($this->tbl_properties_events_settings, $where);
        if ($list) {
            $events = $result->result();
            foreach ($events as &$event) {
                $event->active = (bool) $event->active;
            }
        }
        return $list ? $result->result() : $result->row();
    }

    public function save_event_settings($event_settings)
    {
        foreach ($event_settings as $es) {
            $this->db->where('id', $es['id']);
            $updated_settings = array(
                'template_id' => $es['template_id'],
                'template_type' => $es['template_type'],
                'active' => $es['active'] == 'true' ? 1 : 0,
                'modules' => $es['modules']
            );
            $this->db->update($this->tbl_properties_events_settings, $updated_settings);
        }
        return array('success' => true);
    }

    public function add_event_settings($user)
    {
        $events = $this->get();
        foreach ($events as $event) {
            $event_settings = array(
                'user_id' => $user->id,
                'event_id' => $event->id,
                'template_id' => $this->get_admin_default_event_template($event->id),
                'modules' => '',
                'last_update' => date('Y-m-d H:i:s')
            );
            $this->db->insert($this->tbl_properties_events_settings, $event_settings);
        }
        return true;
    }

    public function get_admin_default_event_template($event_id)
    {
        $tbl = 'properties_events_templates';
        $result = $this->db->get_where($tbl, array('active' => 1, 'is_default' => 1, 'event_id' => $event_id));
        return $result->row()->id;
    }
} 