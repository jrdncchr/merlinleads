<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Profile_Model extends CI_Model
{

    function __construct()
    {
        $this->load->database();
    }

    public function getProfile($id = 0)
    {
        if ($id > 0) {
            $result = $this->db->get_where('profiles', array('id' => $id));
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return null;
            }
        }
    }

    public function getProfilesByUser($user_id = 0)
    {
        if ($user_id > 0) {
            $result = $this->db->get_where('profiles', array('user_id' => $user_id, 'status' => 'Active'));
            if ($result->num_rows() > 0) {
                return $result->result();
            } else {
                return null;
            }
        }
    }

    public function getProfilesCount($user_id = 0)
    {
        if ($user_id > 0) {
            $result = $this->db->get_where('profiles', array('user_id' => $user_id, 'status' => 'Active'));
            return $result->num_rows();
        }
    }

    public function addProfile($profile)
    {
        $this->db->insert('profiles', $profile);
        $this->db->order_by('date_created', 'desc');
        $latest = $this->db->get('profiles', 1);
        $id = $latest->row()->id;
        return $id;
    }

    public function updateProfile($profile, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('profiles', $profile);
        return "OK";
    }

    public function deleteProfile($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('profiles');
        return "OK";
    }

}