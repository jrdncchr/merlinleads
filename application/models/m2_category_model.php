<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class m2_category_model extends CI_Model
{

    function __construct()
    {
        $this->load->database();
    }

    public function get_list($type = false) {
        if($type) {
            $result = $this->db->get_where('m2_categories', array('category_type' => $type));
        } else {
            $result = $this->db->get('m2_categories');
        }
        return $result->result();
    }

    public function get($id = 0, $options = array()) {
        if ($id > 0) {
            $options['id'] = $id;
            $result = $this->db->get_where('m2_categories', $options);
            echo $result->num_rows() > 0 ?  $result->row() : null;
        } else {
            $result = $this->db->get('m2_categories');
            echo $result->num_rows() > 0 ? json_encode(array("data" => $result->result())) : json_encode(array("data" => []));
        }
    }

    public function add($data)
    {
        if($this->db->insert('m2_categories', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }

    public function update($id, $data)
    {
        $this->db->where('category_id', $id);
        if($this->db->update('m2_categories', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }


    public function delete($idList)
    {
        $success = true;
        foreach($idList as $id) {
            $this->db->where('category_id', $id);
            if (!$this->db->delete('m2_categories')) {
                $success = false;
            }
        }
        echo json_encode(array("success" => $success));
    }

}
