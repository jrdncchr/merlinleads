<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class m2_sub_category_model extends CI_Model
{

    function __construct()
    {
        $this->load->database();
    }

    public function get_list($category_id) {
        $this->db->select('
            sub_category_id,
            sub_category_name');
        $result = $this->db->get_where('m2_sub_categories', array('status' => 1, 'category_id' => $category_id));
        return $result->result();
    }

    public function get($id = 0, $options = array()) {
        if ($id > 0) {
            $options['sub_category_id'] = $id;
            $result = $this->db->get_where('m2_sub_categories', $options);
            return $result->num_rows() > 0 ?  $result->row() : null;
        } else {
            $this->db->select('
            sub_category_id,
            sub_category_name,
            m2_sub_categories.category_id,
            category_name,
            category_type,
            headline,
            body,
            keywords,
            status');
            $this->db->from('m2_sub_categories');
            $this->db->join('m2_categories', 'm2_sub_categories.category_id = m2_categories.category_id', 'left');
            $result = $this->db->get();
            echo $result->num_rows() > 0 ? json_encode(array("data" => $result->result())) : json_encode(array("data" => []));
        }
    }

    public function add($data)
    {
        if($this->db->insert('m2_sub_categories', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }

    public function update($id, $data)
    {
        $this->db->where('sub_category_id', $id);
        if($this->db->update('m2_sub_categories', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }


    public function delete($idList)
    {
        $success = true;
        foreach($idList as $id) {
            $this->db->where('sub_category_id', $id);
            if (!$this->db->delete('m2_sub_categories')) {
                $success = false;
            }
        }
        echo json_encode(array("success" => $success));
    }

}
