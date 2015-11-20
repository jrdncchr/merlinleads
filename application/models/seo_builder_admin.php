<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class seo_builder_admin extends CI_Model
{

    function __construct()
    {
        $this->load->database();
    }

    public function checkAuth($user_id) {
        $sql = "SELECT * FROM seo_builder_admin WHERE user_id = ?;";
        $result = $this->db->query($sql, array($user_id));
        return $result->num_rows() > 0 ?
            array("auth" => true, "cities" => $result->result()) :
            array("auth" => false);
    }

    /*
     * CITY
     */

    public function city_get_list() {
        $this->db->select("
            seo_builder_admin.id,
            seo_builder_admin.city_name,
            seo_builder_admin.zip_code,
            seo_builder_admin.state,
            seo_builder_admin.state_abbr,
            seo_builder_admin.user_id,
            CONCAT(users.firstname, ' ', users.lastname) AS full_name,
            users.email,
            seo_builder_admin.status,
            seo_builder_admin.date_created", FALSE);
        $this->db->from('seo_builder_admin');
        $this->db->join('users', 'seo_builder_admin.user_id = users.id', 'left');
        $result = $this->db->get();
        echo $result->num_rows() > 0 ? json_encode(array("data" => $result->result())) : json_encode(array("data" => []));
    }

    public function city_get($options = array()) {
        if(isset($options['id'])) {
            $result = $this->db->get_where('seo_builder_admin', $options);
            return $result->num_rows() > 0 ?  $result->row() : null;
        } else {
            $result = $this->db->get_where('seo_builder_admin', $options);
            return $result->num_rows() > 0 ?  $result->result() : null;
        }
    }

    public function city_add($data)
    {
        if($this->db->insert('seo_builder_admin', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "message" => "Something went wrong."));
        }

    }

    public function city_update($id, $data)
    {
        $this->db->where('id', $id);
        if($this->db->update('seo_builder_admin', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }


    public function city_delete($idList)
    {
        $success = true;
        foreach($idList as $id) {
            $this->db->where('id', $id);
            if (!$this->db->delete('seo_builder_admin')) {
                $success = false;
                log_message('error', "Failed to delete id(". $id .") from the seo_builder_admin table.");
            }
        }
        echo json_encode(array("success" => $success));
    }

    public function city_validate($city) {
        $result = $this->db->get_where('seo_builder_admin', array('city_name' => $city));
        return $result->num_rows() > 0 ?  json_encode(array("already_exist" => true)) : json_encode(array("already_exist" => false));
    }

    /*
     * TEMPLATE
     */

    public function get_template($options = array()) {
        $result = $this->db->get_where('seo_builder_templates', $options);
        if($result->num_rows() > 0) {
            if(isset($options['id'])) {
                return $result->row();
            } else {
                return $result->result();
            }
        }
        return false;
    }

    public function template_get($id = 0, $options = array()) {
        if ($id > 0) {
            $options['id'] = $id;
            $result = $this->db->get_where('seo_builder_templates', $options);
            return $result->num_rows() > 0 ?  $result->row() : null;
        } else {
            $result = $this->db->get('seo_builder_templates');
            return $result->num_rows() > 0 ? json_encode(array("data" => $result->result())) : json_encode(array("data" => []));
        }
    }

    public function template_add($data)
    {
        if($this->db->insert('seo_builder_templates', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "message" => "Something went wrong."));
        }

    }

    public function template_update($id, $data)
    {
        $this->db->where('id', $id);
        if($this->db->update('seo_builder_templates', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }


    public function template_delete($idList)
    {
        $success = true;
        foreach($idList as $id) {
            $this->db->where('id', $id);
            if (!$this->db->delete('seo_builder_templates')) {
                $success = false;
                log_message('error', "Failed to delete id(". $id .") from the seo_builder_template table.");
            }
        }
        echo json_encode(array("success" => $success));
    }

    public function template_validate($template_name) {
        $result = $this->db->get_where('seo_builder_templates', array('template_name' => $template_name));
        return $result->num_rows() > 0 ?  json_encode(array("already_exist" => true)) : json_encode(array("already_exist" => false));
    }

    /*
     * ADVANCE SEARCH CATEGORIES
     */

    public function as_category_get($id = 0, $options = array()) {
        if ($id > 0) {
            $options['id'] = $id;
            $result = $this->db->get_where('seo_builder_as_categories', $options);
            return $result->num_rows() > 0 ?  $result->row() : null;
        } else {
            $result = $this->db->get('seo_builder_as_categories');
            return $result->num_rows() > 0 ? $result->result() : [];
        }
    }

    public function as_category_add($data)
    {
        if($this->db->insert('seo_builder_as_categories', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "message" => "Something went wrong."));
        }

    }

    public function as_category_update($id, $data)
    {
        $this->db->where('id', $id);
        if($this->db->update('seo_builder_as_categories', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }


    public function as_category_delete($idList)
    {
        $success = true;
        foreach($idList as $id) {
            $this->db->where('id', $id);
            if (!$this->db->delete('seo_builder_as_categories')) {
                $success = false;
                log_message('error', "Failed to delete id(". $id .") from the seo_builder_as_categories table.");
            }
        }
        echo json_encode(array("success" => $success));
    }

    public function as_category_validate($to_validate) {
        $result = $this->db->get_where('seo_builder_as_categories', array('category_name' => $to_validate));
        return $result->num_rows() > 0 ?  json_encode(array("already_exist" => true)) : json_encode(array("already_exist" => false));
    }

    /*
     * ADVANCE SEARCH INPUT
     */

    public function as_input_list($options = array()) {
        $result = $this->db->get_where('seo_builder_as_inputs', $options);
        return $result->num_rows() > 0 ? $result->result()  : [];
    }

    public function as_input_get($id = 0, $options = array()) {
        if ($id > 0) {
            $options['id'] = $id;
            $result = $this->db->get_where('seo_builder_as_inputs', $options);
            return $result->num_rows() > 0 ?  $result->row() : null;
        } else {
            $result = $this->db->get('seo_builder_as_inputs');
            return $result->num_rows() > 0 ? json_encode(array("data" => $result->result())) : json_encode(array("data" => []));
        }
    }

    public function as_input_add($data)
    {
        if($this->db->insert('seo_builder_as_inputs', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "message" => "Something went wrong."));
        }

    }

    public function as_input_update($id, $data)
    {
        $this->db->where('id', $id);
        if($this->db->update('seo_builder_as_inputs', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }


    public function as_input_delete($idList)
    {
        $success = true;
        foreach($idList as $id) {
            $this->db->where('id', $id);
            if (!$this->db->delete('seo_builder_as_inputs')) {
                $success = false;
                log_message('error', "Failed to delete id(". $id .") from the seo_builder_as_inputs table.");
            }
        }
        echo json_encode(array("success" => $success));
    }


    public function as_input_validate($category_id, $to_validate) {
        $result = $this->db->get_where('seo_builder_as_inputs', array('category_id' => $category_id, 'label' => $to_validate));
        return $result->num_rows() > 0 ?  json_encode(array("already_exist" => true)) : json_encode(array("already_exist" => false));
    }

    /*
     * ADVANCE SEARCH INPUT
     */

    public function as_option_list($options = array()) {
        $result = $this->db->get_where('seo_builder_as_options', $options);
        return $result->num_rows() > 0 ? $result->result() : [];
    }

    public function as_option_get($id = 0, $options = array()) {
        if ($id > 0) {
            $options['id'] = $id;
            $result = $this->db->get_where('seo_builder_as_options', $options);
            return $result->num_rows() > 0 ?  $result->row() : null;
        } else {
            $result = $this->db->get('seo_builder_as_options');
            return $result->num_rows() > 0 ? json_encode(array("data" => $result->result())) : json_encode(array("data" => []));
        }
    }

    public function as_option_add($data)
    {
        if($this->db->insert('seo_builder_as_options', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "message" => "Something went wrong."));
        }

    }

    public function as_option_update($id, $data)
    {
        $this->db->where('id', $id);
        if($this->db->update('seo_builder_as_options', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }


    public function as_option_delete($idList)
    {
        $success = true;
        foreach($idList as $id) {
            $this->db->where('id', $id);
            if (!$this->db->delete('seo_builder_as_options')) {
                $success = false;
                log_message('error', "Failed to delete id(". $id .") from the seo_builder_as_options table.");
            }
        }
        echo json_encode(array("success" => $success));
    }


    public function as_option_validate($input_id, $to_validate) {
        $result = $this->db->get_where('seo_builder_as_options', array('input_id' => $input_id, 'value' => $to_validate));
        return $result->num_rows() > 0 ?  json_encode(array("already_exist" => true)) : json_encode(array("already_exist" => false));
    }

}
