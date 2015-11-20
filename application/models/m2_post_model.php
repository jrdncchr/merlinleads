<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class m2_post_model extends CI_Model
{

    function __construct()
    {
        $this->load->database();
    }

    function generate($sc_id, $profile_id, $property_id = 0) {
        $this->load->model("profile_model");
        $profile = $this->profile_model->getProfile($profile_id);

        $property = null;
        if($property_id > 0) {
            $this->load->model("property_model");
            $property = $this->property_model->getProperty($property_id);
        }

        $this->load->model("m2_sub_category_model");
        $template = $this->m2_sub_category_model->get($sc_id);

        $this->load->library("templates_lib_properties");

        return array(
            "headline" => $this->templates_lib_properties
                ->generateContent($template->headline, $property, $profile, null),
            "body" => $this->templates_lib_properties
                ->generateContent($template->body, $property, $profile, null),
            "keywords" => $this->templates_lib_properties
                ->generateContent($template->keywords, $property, $profile, null)
        );
    }

    public function get($options = array()) {
        $options['deleted_flag'] = 0;

        $this->db->select('
            m2_posts.post_id,
            m2_posts.sub_category_id,
            m2_sub_categories.sub_category_name,
            m2_posts.category_id,
            m2_categories.category_name,
            m2_posts.headline,
            m2_posts.body,
            m2_posts.keywords,
            m2_posts.date_created');
        $this->db->from('m2_posts');
        $this->db->join('m2_categories', 'm2_posts.category_id = m2_categories.category_id', 'left');
        $this->db->join('m2_sub_categories', 'm2_posts.sub_category_id = m2_sub_categories.sub_category_id', 'left');
        $this->db->where($options);
        $result = $this->db->get();
        echo $result->num_rows() > 0 ? json_encode(array("data" => $result->result())) : json_encode(array("data" => []));
    }

    public function count($options) {
        $result = $this->db->get_where('m2_posts', $options);
        return $result->num_rows();
    }

    public function add($data)
    {
        if($this->db->insert('m2_posts', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }

    public function update($id, $data)
    {
        $this->db->where('post_id', $id);
        if($this->db->update('m2_posts', $data)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }

    public function delete($idList)
    {
        $success = true;
        foreach($idList as $id) {
            $this->db->where('post_id', $id);
            if (!$this->db->delete('m2_posts')) {
                $success = false;
            }
        }
        echo json_encode(array("success" => $success));
    }

    public function get_unsaved_subcategory($category_id, $user_id, $module, $property_id) {
        $this->db->select('
            sub_category_id,
            sub_category_name');
        $all_sc = $this->db->get_where('m2_sub_categories', array('status' => 1, 'category_id' => $category_id));

        $this->db->select('sub_category_id');
        $used_sc = $this->db->get_where('m2_posts',
            array('user_id' => $user_id, 'category_id' => $category_id, 'property_id' => $property_id, 'module' => $module, 'deleted_flag' => 0));

        $not_used = [];
        foreach($all_sc->result() as $sc) {
            $used = false;
            foreach($used_sc->result() as $u) {
                if($sc->sub_category_id == $u->sub_category_id) {
                    $used = true;
                }
            }
            if(!$used) {
                $not_used[] = $sc;
            }
        }

        return $not_used;
    }

}

