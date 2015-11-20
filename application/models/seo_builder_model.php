<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class seo_builder_model extends CI_Model
{

    function __construct()
    {
        $this->load->database();
    }

    public function get_list($user_id) {
        $this->db->select("
            seo_builder.id,
            seo_builder.name,
            seo_builder.status,
            seo_builder_admin.city_name", FALSE);
        $this->db->from('seo_builder');
        $this->db->join('seo_builder_admin', 'seo_builder.city_id = seo_builder_admin.id', 'left');
        $this->db->where(array("seo_builder.user_id" => $user_id));
        $result = $this->db->get();
        echo $result->num_rows() > 0 ?
            json_encode(array("data" => $result->result())) :
            json_encode(array("data" => []));
    }

    public function get($id = 0, $options = array()) {
        if ($id > 0) {
            $options['id'] = $id;
            $result = $this->db->get_where('seo_builder', $options);
            return $result->num_rows() > 0 ?  $result->row() : null;
        } else {
            $result = $this->db->get('seo_builder');
            return $result->num_rows() > 0 ? $result->result() : [];
        }
    }

    public function save($data)
    {
        /*
         * Validate data first, check if name already exists for a specific user.
         */
        $validate = $this->validate($data);
        if($validate['success']) {
            /*
             * Update data if ID is set.
             */
            if(isset($data['id'])) {
                $this->db->where('id', $data['id']);
                if($this->db->update('seo_builder', $data)) {
                    return array("success" => true);
                } else {
                    return array("success" => false, "error" => "Update failed, something went wrong..");
                }
            /*
             * Add data if ID is not set.
             */
            } else {
                if($this->db->insert('seo_builder', $data)) {
                    return array("success" => true, "last_inserted_id" => $this->db->insert_id());
                } else {
                    return array("success" => false, "error" => "Add failed, something went wrong..");
                }
            }
        /*
         * Return error message if validation failed.
         */
        } else {
            return array("success" => false, "error" => $validate['error']);
        }
    }


    public function delete($id)
    {
        $success = true;
        $this->db->where('id', $id);
        if (!$this->db->delete('seo_builder')) {
            $success = false;
            log_message('error', "Failed to delete id(". $id .") from the seo_builder table.");
        }
        return array("success" => $success);
    }

    public function validate($data) {
        if(isset($data['id'])) {
            $result = $this->db->get_where('seo_builder',
                array('id !=' => $data['id'], 'user_id' => $data['user_id'], 'name' => $data['name']));
        } else {
            $result = $this->db->get_where('seo_builder',
                array('user_id' => $data['user_id'], 'name' => $data['name']));
        }
        return $result->num_rows() > 0 ?
            array("success" => false, "error" => "SEO Builder Name already exists."):
            array("success" => true);
    }

    public function generate($id) {
        $CI =& get_instance();
        $CI->load->model("seo_builder_admin");

        // Details, Profile, City, Category and Search Criteria
        $details = $this->get($id);
        $details->city = $CI->seo_builder_admin->city_get(array("id" => $details->city_id));
        $details->category = $CI->seo_builder_admin->as_category_get($details->category);

        $CI->load->model("profile_model");
        $details->profile = $CI->profile_model->getProfile($details->profile_id);

        $details->search_criteria = json_decode($details->search_criteria);

        //Inputs
        $details->inputs = $this->seo_builder_admin->as_input_list();

        //Template
        $template = $CI->seo_builder_admin->template_get($details->template_id);

        $this->load->library("seo_templates");
        $result = array(
            'template_name' => $template->template_name,
            'page_name' => $this->seo_templates->generate_template($template->page_name, $details),
            'meta_description' => $this->seo_templates->generate_template($template->meta_description, $details),
            'meta_tags_keywords' => $this->seo_templates->generate_template($template->meta_tags_keywords, $details),
            'link_display' => $this->seo_templates->generate_template($template->link_display, $details),
            'link_description' => $this->seo_templates->generate_template($template->link_description, $details),
            'sub_header_paragraph' => $this->seo_templates->generate_template($template->sub_header_paragraph, $details),
        );

        return array(
            'success' => true,
            'result' => $result
        );
    }

    public function get_category_inputs($category_id) {
        $CI =& get_instance();
        $CI->load->model("seo_builder_admin");

        $inputs = $CI->seo_builder_admin->as_input_list(array("category_id" => $category_id, "show" => 1));
        foreach($inputs as $i) {
            if($i->type == "SELECT") {
                $i->options = $CI->seo_builder_admin->as_option_list(array("input_id" => $i->id, "show" => 1));
            }
        }
        return $inputs;
    }

}
