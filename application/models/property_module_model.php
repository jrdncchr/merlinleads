<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Property_Module_Model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    /* Property Media Module */

    public function getPropertyMediaPost($module, $property_id, $template_no) {
        $result = $this->db->get_where('properties_post_' . strtolower($module), array('property_id' => $property_id, 'template' => $template_no));
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return null;
        }
    }

    public function getPropertyMediaPostCount($module, $property_id) {
        $result = $this->db->get_where('properties_post_' . strtolower($module), array('property_id' => $property_id));
        return $result->num_rows();
    }

    public function addPropertyMediaPost($module, $data) {
        $this->db->insert('properties_post_' . strtolower($module), $data);
        $this->db->order_by('date_created', 'desc');
        $latest = $this->db->get('properties_post_' . strtolower($module), 1);
        $id = $latest->row()->id;
        return $id;
    }

    public function updatePropertyMediaModule($module, $data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update('properties_post_' . strtolower($module), $data)) {
            return "OK";
        }
    }

    public function updateSlidesharePost($data, $template_no, $property_id) {
        $this->db->where(array('property_id' => $property_id, 'template_no' => $template_no));
        if ($this->db->update('properties_post_slideshare', $data)) {
            return "OK";
        }
    }

    public function getPropertyMediaNextTemplateNo($module, $property_id) {
        $result = $this->db->get_where('properties_post_' . strtolower($module), array('property_id' => $property_id));
        return $result->num_rows();
    }

    /* Classifieds Module = Craiglist, Backpage, Ebay */

    public function getClassifiedModuleBatchNo($module, $property_id) {
        $this->db->select_max('batch_no');
        $this->db->where('property_id', $property_id);
        $q = $this->db->get('properties_post_' . strtolower($module));
        return $q->num_rows() > 1 ? $q->row()->batch_no : 1;   
    }

    public function getClassifiedsModule($property_id) {
        $result = $this->db->get_where('properties_modules_classifieds', array('property_id' => $property_id));
        return ($result->num_rows() > 0) ? $result->row() : null;
    }

    public function addClassifiedsModule($data) {
        $this->db->insert('properties_modules_classifieds', $data);
        return "OK";
    }

    public function updateClassifiedsModule($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('properties_modules_classifieds', $data);
        return "OK";
    }

    public function getCraiglistModuleCount($property_id) {
        $result = $this->db->get_where('properties_post_craiglist', array('property_id' => $property_id));
        return $result->num_rows();
    }

    public function getCraiglistModuleCountVideo($property_id) {
        $result = $this->db->get_where('properties_post_craiglist_video', array('property_id' => $property_id));
        return $result->num_rows();
    }

    public function getBackpageModuleCount($property_id) {
        $result = $this->db->get_where('properties_post_backpage', array('property_id' => $property_id));
        return $result->num_rows();
    }

    public function getBackpageModuleCountVideo($property_id) {
        $result = $this->db->get_where('properties_post_backpage_video', array('property_id' => $property_id));
        return $result->num_rows();
    }

    public function getEbayModuleCount($property_id) {
        $result = $this->db->get_where('properties_post_ebay', array('property_id' => $property_id));
        return $result->num_rows();
    }

    public function getEbayModuleCountVideo($property_id) {
        $result = $this->db->get_where('properties_post_ebay_video', array('property_id' => $property_id));
        return $result->num_rows();
    }

    public function getLastDatePosted($module, $id) {
        switch ($module) {
            case "Craiglist":
                $this->db->order_by('date_created', 'desc');
                $result = $this->db->get_where('properties_post_craiglist', array('property_id' => $id), 1);
                return $result->row();
                break;
            case "Craiglist Video":
                $this->db->order_by('date_created', 'desc');
                $result = $this->db->get_where('properties_post_craiglist_video', array('property_id' => $id), 1);
                return $result->row();
                break;
            case "Backpage":
                $this->db->order_by('date_created', 'desc');
                $result = $this->db->get_where('properties_post_backpage', array('property_id' => $id), 1);
                return $result->row();
                break;
            case "Backpage Video":
                $this->db->order_by('date_created', 'desc');
                $result = $this->db->get_where('properties_post_backpage_video', array('property_id' => $id), 1);
                return $result->row();
                break;
            case "Ebay":
                $this->db->order_by('date_created', 'desc');
                $result = $this->db->get_where('properties_post_ebay', array('property_id' => $id), 1);
                return $result->row();
                break;
            case "Ebay Video":
                $this->db->order_by('date_created', 'desc');
                $result = $this->db->get_where('properties_post_ebay_video', array('property_id' => $id), 1);
                return $result->row();
                break;
            default:
        }
    }

    public function getClassifiedsTemplateOrder($property_id) {
        $result = $this->db->get_where('properties_modules_classifieds_order', array('property_id' => $property_id));
        if($result->num_rows() > 0) {
            // return existing
            return $result->row();
        } else {
            // create new and return
            return $this->_generateTemplateOrder($property_id);
        }
    }

    public function _generateTemplateOrder($property_id) {
        $this->db->trans_start();
        // get templates
        $craiglist = $this->db->get('properties_templates_craiglist');
        $craiglist_video = $this->db->get('properties_templates_craiglist_video');
        $backpage = $this->db->get('properties_templates_backpage');
        $backpage_video = $this->db->get('properties_templates_backpage_video');
        $ebay = $this->db->get('properties_templates_ebay');
        $ebay_video = $this->db->get('properties_templates_ebay_video');

        // make an array with count of the number of templates, shuffle it and implode to save in db
        $craiglist_range = range(1, $craiglist->num_rows());
        shuffle($craiglist_range);
        $craiglist_order = implode(",", $craiglist_range);

        $craiglist_video_range = range(1, $craiglist_video->num_rows());
        shuffle($craiglist_video_range);
        $craiglist_video_order = implode(",", $craiglist_video_range);

        $backpage_range = range(1, $backpage->num_rows());
        shuffle($backpage_range);
        $backpage_order = implode(",", $backpage_range);

        $backpage_video_range = range(1, $backpage_video->num_rows());
        shuffle($backpage_video_range);
        $backpage_video_order = implode(",", $backpage_video_range);

        $ebay_range = range(1, $ebay->num_rows());
        shuffle($ebay_range);
        $ebay_order = implode(",", $ebay_range);

        $ebay_video_range = range(1, $ebay_video->num_rows());
        shuffle($ebay_video_range);
        $ebay_video_order = implode(",", $ebay_video_range);

        // save
        $this->db->insert('properties_modules_classifieds_order', array(
            'property_id' => $property_id,
            'craiglist' => $craiglist_order,
            'craiglist_video' => $craiglist_video_order,
            'backpage' => $backpage_order,
            'backpage_video' => $backpage_video_order,
            'ebay' => $ebay_order,
            'ebay_video' => $ebay_video_order
            ));
        $id = $this->db->insert_id();
        $q = $this->db->get_where('properties_modules_classifieds_order', array('id' => $id));
        
        $this->db->trans_complete();
        return $q->row();
    }

    /* Properties Images */

    public function getPropertyImage($property_id) {
        $result = $this->db->get_where('properties_images', array('property_id' => $property_id));
        return ($result->num_rows() > 0) ? $result->row() : null;
    }

    public function addPropertyImage($property_id) {
        $this->db->insert('properties_images', array('property_id' => $property_id));
    }

    public function updatePropertyImage($update, $id) {
        $this->db->where('property_id', $id);
        if ($this->db->update('properties_images', $update)) {
            return "OK";
        }
    }

    /*
     * Property Module Twitter
     */

    public function getPropertyModuleTwitter($property_id) {
        $result = $this->db->get_where('properties_modules_twitter', array('property_id' => $property_id));
        return ($result->num_rows() > 0) ? $result->row() : null;
    }

    public function addPropertyModuleTwitter($data) {
        if ($this->db->insert('properties_modules_twitter', $data)) {
            return "OK";
        }
    }

    public function editPropertyModuleTwitter($update, $id) {
        $this->db->where('property_id', $id);
        if ($this->db->update('properties_modules_twitter', $update)) {
            return "OK";
        }
    }

    public function getPropertyUserOfEnabledTwitterAutopost() {
        $result = $this->db->get_where('properties_modules_twitter', array('autopost' => true));
        if ($result->num_rows() > 0) {
            $modules = $result->result();
            $properties_users = array();
            foreach ($modules as $m) {
                $property_user = array(
                    'module' => $m,
                    'user' => $this->db->get_where('users', array('id' => $m->user_id))->row(),
                    'property' => $this->db->get_where('properties', array('id' => $m->property_id))->row()
                );
                array_push($properties_users, $property_user);
            }
            return $properties_users;
        }
    }

    /*
     * Property Post Twitter
     */

    public function getPropertyPostTwitter($property_id) {
        $this->db->order_by("date_created", "desc");
        $result = $this->db->get_where('properties_post_twitter', array('property_id' => $property_id), 10);
        return ($result->num_rows() > 0) ? $result->result() : null;
    }

    public function getPropertyPostTwitterCount($property_id) {
        $result = $this->db->get_where('properties_post_twitter', array('property_id' => $property_id));
        return $result->num_rows();
    }

    public function addPropertyPostTwitter($data) {
        if ($this->db->insert('properties_post_twitter', $data)) {
            return "OK";
        }
    }

}
