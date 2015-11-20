<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Slideshare_Model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    /* Methods for Slideshare Backgrounds */

    public function getBackgrounds() {
        $result = $this->db->get('properties_slideshare_bg');
        return $result->num_rows() > 0 ? $result->result() : null;
    }

    public function addBackground($bg) {
        if ($this->db->insert('properties_slideshare_bg', $bg)) {
            return $this->db->insert_id();
        }
    }

    public function deleteBackground($image) {
        if ($this->db->delete('properties_slideshare_bg', array('image' => $image))) {
            return true;
        }
    }

}
