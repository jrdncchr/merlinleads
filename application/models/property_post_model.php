<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Property_Post_Model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    /* Property Post Regular */

    // Called every time the user hits the post complete button so that template no to the next post will increment.
    public function addCraiglistPost($data) {
        $this->db->insert('properties_post_craiglist', $data);
    }

    // Gets the next template to be used
    public function getCraiglistNextTemplate($property_id) {
        $this->db->order_by("template_no", "desc");
        $result = $this->db->get_where('properties_post_craiglist', array('property_id' => $property_id), 1);
        if ($result->num_rows() > 0) {
            $old = $result->row()->template_no;
            $max = $this->getCraiglistMaxTemplateNo();
            if ($old == $max) {
                //
                return 0;
            } else {
                return $old + 1;
            }
        } else {
            return 1;
        }
    }

    // Get the total number of templates of Craiglist
    public function getCraiglistMaxTemplateNo() {
        $result = $this->db->get('properties_templates_craiglist');
        return $result->num_rows();
    }

    /* Propert Post Craiglist Video */

    // Called every time the user hits the post complete button so that template no to the next post will increment.
    public function addCraiglistPostVideo($data) {
        $this->db->insert('properties_post_craiglist_video', $data);
    }

    // Gets the next template to be used, activates every time the generate button is hit.
    public function getCraiglistNextVideoTemplate($property_id) {
        $this->db->order_by("template_no", "desc");
        $result = $this->db->get_where('properties_post_craiglist_video', array('property_id' => $property_id), 1);
        if ($result->num_rows() > 0) {
            $old = $result->row()->template_no;
            $max = $this->getCraiglistMaxVideoTemplateNo();
            if ($old == $max) {
                return 0;
            } else {
                return $old + 1;
            }
        } else {
            return 1;
        }
    }

    // Get the total number of templates of Craiglist
    public function getCraiglistMaxVideoTemplateNo() {
        $result = $this->db->get('properties_templates_craiglist_video');
        return $result->num_rows();
    }

    // --------- Backpage ------------
    // Called every time the user hits the post complete button so that template no to the next post will increment.
    public function addBackpagePost($data) {
        $this->db->insert('properties_post_backpage', $data);
    }

    // Gets the next template to be used
    public function getBackpageNextTemplate($property_id) {
        $this->db->order_by("template_no", "desc");
        $result = $this->db->get_where('properties_post_backpage', array('property_id' => $property_id), 1);
        if ($result->num_rows() > 0) {
            $old = $result->row()->template_no;
            $max = $this->getBackpageMaxTemplateNo();
            if ($old == $max) {
                return 0;
            } else {
                return $old + 1;
            }
        } else {
            return 1;
        }
    }

    // Get the total number of templates of Craiglist
    public function getBackpageMaxTemplateNo() {
        $result = $this->db->get('properties_templates_backpage');
        return $result->num_rows();
    }

    /* Propert Post Backpage Video */

    // Called every time the user hits the post complete button so that template no to the next post will increment.
    public function addBackpagePostVideo($data) {
        $this->db->insert('properties_post_backpage_video', $data);
    }

    // Gets the next template to be used, activates every time the generate button is hit.
    public function getBackpageNextVideoTemplate($property_id) {
        $this->db->order_by("template_no", "desc");
        $result = $this->db->get_where('properties_post_backpage_video', array('property_id' => $property_id), 1);
        if ($result->num_rows() > 0) {
            $old = $result->row()->template_no;
            $max = $this->getBackpageMaxVideoTemplateNo();
            if ($old == $max) {
                return 0;
            } else {
                return $old + 1;
            }
        } else {
            return 1;
        }
    }

    // Get the total number of templates of Backpage
    public function getBackpageMaxVideoTemplateNo() {
        $result = $this->db->get('properties_templates_backpage_video');
        return $result->num_rows();
    }

    // --------- Ebay ------------
    // Called every time the user hits the post complete button so that template no to the next post will increment.
    public function addEbayPost($data) {
        $this->db->insert('properties_post_ebay', $data);
    }

    // Gets the next template to be used
    public function getEbayNextTemplate($property_id) {
        $this->db->order_by("template_no", "desc");
        $result = $this->db->get_where('properties_post_ebay', array('property_id' => $property_id), 1);
        if ($result->num_rows() > 0) {
            $old = $result->row()->template_no;
            $max = $this->getEbayMaxTemplateNo();
            if ($old == $max) {
                return 0;
            } else {
                return $old + 1;
            }
        } else {
            return 1;
        }
    }

    // Get the total number of templates of Craiglist
    public function getEbayMaxTemplateNo() {
        $result = $this->db->get('properties_templates_ebay');
        return $result->num_rows();
    }

    /* Propert Post Backpage Video */

    // Called every time the user hits the post complete button so that template no to the next post will increment.
    public function addEbayPostVideo($data) {
        $this->db->insert('properties_post_ebay_video', $data);
    }

    // Gets the next template to be used, activates every time the generate button is hit.
    public function getEbayNextVideoTemplate($property_id) {
        $this->db->order_by("template_no", "desc");
        $result = $this->db->get_where('properties_post_ebay_video', array('property_id' => $property_id), 1);
        if ($result->num_rows() > 0) {
            $old = $result->row()->template_no;
            $max = $this->getBackpageMaxVideoTemplateNo();
            if ($old == $max) {
                return 0;
            } else {
                return $old + 1;
            }
        } else {
            return 1;
        }
    }

    // Get the total number of templates of Backpage
    public function getEbayMaxVideoTemplateNo() {
        $result = $this->db->get('properties_templates_ebay_video');
        return $result->num_rows();
    }

}