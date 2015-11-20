<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Term_Feature_Model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    public function getTF($id = 0) {
        if ($id == 0) {
            $result = $this->db->get('terms_features');
            if ($result->num_rows() > 0) {
                return $result->result();
            }
        } else {
            $result = $this->db->get_where('terms_features', array('id' => $id));
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return null;
            }
        }
    }

    public function addTF($tf) {
        $this->db->insert('terms_features', $tf);
        return "OK";
    }

    public function updateTF($tf, $id) {
        $this->db->where('id', $id);
        $this->db->update('terms_features', $tf);
        return "OK";
    }

    public function deleteTF($id) {
        $this->db->where('id', $id);
        $this->db->delete('terms_features');
        return "OK";
    }
}