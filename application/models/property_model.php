<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Property_Model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    public function getPropertiesForMerlinLibrary($user_id) {
        $this->db->select('properties_overview.property_id, properties_overview.name, properties_overview.status');
        $this->db->from('properties_overview');
        $this->db->where(array('properties_overview.user_id' => $user_id, 'properties_overview.status' => 'Active'));
        $this->db->order_by('date_created', 'desc');
        $result = $this->db->get();
        return $result->result();
    }

    // Propert Overview
    public function getOverviews($userId) {
        $this->db->select('po.*, p.profile_id');
        $this->db->from('properties_overview po');
        $this->db->join('properties p', 'po.property_id = p.id', 'left');
        $this->db->where('po.user_id', $userId);
        $result = $this->db->get();
        return $result->num_rows() > 0 ? $result->result() : [];
    }

    public function getOverview($id) {
        $result = $this->db->get_where('properties_overview', array('id' => $id));
        return $result->num_rows() > 0 ? $result->row() : null;
    }

    public function addOverview($po) {
        $this->db->insert('properties_overview', $po);
        $this->db->order_by('date_created', 'desc');
        $latest = $this->db->get('properties_overview', 1);
        $id = $latest->row()->id;
        return $id;
    }

    public function updateOverview($po, $id) {
        $this->db->where('id', $id);
        $this->db->update('properties_overview', $po);
        return "OK";
    }

    public function updateOverviewByPropertyId($po, $property_id) {
        $this->db->where('property_id', $property_id);
        $this->db->update('properties_overview', $po);
        return "OK";
    }

    // Property

    public function getProperty($id = 0) {
        if ($id == 0) {
            $result = $this->db->get('properties');
            if ($result->num_rows() > 0) {
                return $result->result();
            }
        } else {
            $result = $this->db->get_where('properties', array('id' => $id));
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return null;
            }
        }
    }

    public function getPropertiesCountByUser($user_id = 0) {
        if ($user_id > 0) {
            $this->db->select('property_id');
            $this->db->from('properties');
            $this->db->join('properties_overview', 'properties_overview.property_id = properties.id');
            $this->db->where(array('user_id' => $user_id));
            $result = $this->db->get();
            return $result->num_rows() > 0 ? $result->num_rows() : 0;
        }
    }

    public function addProperty($property) {
        $this->db->insert('properties', $property);
        $this->db->order_by('date_created', 'desc');
        $latest = $this->db->get('properties', 1);
        $id = $latest->row()->id;
        return $id;
    }

    public function updateProperty($property, $id) {
        $this->db->where('id', $id);
        $this->db->update('properties', $property);
        return "OK";
    }

    /*
     * Added for Event Notification
     */
    public function update_property($id, $data)
    {
        $result = array('success' => false);
        $this->db->where('id', $id);
        if ($this->db->update('properties', $data)) {
            $result = array('success' => true);
        }
        return $result;
    }

    public function update_property_overview_by_property_id($property_id, $data)
    {
        $result = array('success' => false);
        $this->db->where('property_id', $property_id);
        if ($this->db->update('properties_overview', $data)) {
            $result = array('success' => true);
        }
        return $result;
    }

    public function update_property_classified($property_id, $data) {
        $result = array('success' => false);
        $this->db->where('property_id', $property_id);
        if ($this->db->update('properties_modules_classifieds', $data)) {
            $result = array('success' => true);
        }
        return $result;
    }

    public function deleteProperty($po) {
        $this->db->where('id', $po->property_id);
        $this->db->delete('properties');
        $this->db->where('id', $po->id);
        $this->db->delete('properties_overview');
        $this->db->where('property_id', $po->property_id);
        $this->db->delete('properties_images');
        $this->db->where('property_id', $po->property_id);
        $this->db->delete('properties_modules_classifieds');
        return "OK";
    }

    // PHP Excel Gets

    public function getAllDataOfModule($module, $id, $option) {
        switch ($module) {
            case "Youtube":
                if ($option == "ALL") {
                    $result = $this->db->get_where('properties_post_youtube', array('property_id' => $id));
                } elseif ($option == "30DAYS") {
                    $sql = "SELECT * FROM `properties_post_youtube` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 30 DAY AND NOW();";
                    $result = $this->db->query($sql);
                } elseif ($option == "7DAYS") {
                    $sql = "SELECT * FROM `properties_post_youtube` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 7 DAY AND NOW();";
                    $result = $this->db->query($sql);
                }
                break;
            case "Slideshare":
                if ($option == "ALL") {
                    $result = $this->db->get_where('properties_post_slideshare', array('property_id' => $id));
                } elseif ($option == "30DAYS") {
                    $sql = "SELECT * FROM `properties_post_slideshare` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 30 DAY AND NOW();";
                    $result = $this->db->query($sql);
                } elseif ($option == "7DAYS") {
                    $sql = "SELECT * FROM `properties_post_slideshare` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 7 DAY AND NOW();";
                    $result = $this->db->query($sql);
                }
                break;
            case "Craiglist":
                if ($option == "ALL") {
                    $result = $this->db->get_where('properties_post_craiglist', array('property_id' => $id));
                } elseif ($option == "30DAYS") {
                    $sql = "SELECT * FROM `properties_post_craiglist` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 30 DAY AND NOW();";
                    $result = $this->db->query($sql);
                } elseif ($option == "7DAYS") {
                    $sql = "SELECT * FROM `properties_post_craiglist` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 7 DAY AND NOW();";
                    $result = $this->db->query($sql);
                }
                break;
            case "Craiglist Video":
                if ($option == "ALL") {
                    $result = $this->db->get_where('properties_post_craiglist_video', array('property_id' => $id));
                } elseif ($option == "30DAYS") {
                    $sql = "SELECT * FROM `properties_post_craiglist_video` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 30 DAY AND NOW();";
                    $result = $this->db->query($sql);
                } elseif ($option == "7DAYS") {
                    $sql = "SELECT * FROM `properties_post_craiglist_video` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 7 DAY AND NOW();";
                    $result = $this->db->query($sql);
                }
                break;
            case "Backpage":
                if ($option == "ALL") {
                    $result = $this->db->get_where('properties_post_backpage', array('property_id' => $id));
                } elseif ($option == "30DAYS") {
                    $sql = "SELECT * FROM `properties_post_backpage` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 30 DAY AND NOW();";
                    $result = $this->db->query($sql);
                } elseif ($option == "7DAYS") {
                    $sql = "SELECT * FROM `properties_post_backpage` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 7 DAY AND NOW();";
                    $result = $this->db->query($sql);
                }
                break;
            case "Backpage Video":
                if ($option == "ALL") {
                    $result = $this->db->get_where('properties_post_backpage_video', array('property_id' => $id));
                } elseif ($option == "30DAYS") {
                    $sql = "SELECT * FROM `properties_post_backpage_video` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 30 DAY AND NOW();";
                    $result = $this->db->query($sql);
                } elseif ($option == "7DAYS") {
                    $sql = "SELECT * FROM `properties_post_backpage_video` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 7 DAY AND NOW();";
                    $result = $this->db->query($sql);
                }
                break;
            case "Ebay":
                if ($option == "ALL") {
                    $result = $this->db->get_where('properties_post_ebay', array('property_id' => $id));
                } elseif ($option == "30DAYS") {
                    $sql = "SELECT * FROM `properties_post_ebay` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 30 DAY AND NOW();";
                    $result = $this->db->query($sql);
                } elseif ($option == "7DAYS") {
                    $sql = "SELECT * FROM `properties_post_ebay` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 7 DAY AND NOW();";
                    $result = $this->db->query($sql);
                }
                break;
            case "Ebay Video":
                if ($option == "ALL") {
                    $result = $this->db->get_where('properties_post_ebay_video', array('property_id' => $id));
                } elseif ($option == "30DAYS") {
                    $sql = "SELECT * FROM `properties_post_ebay_video` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 30 DAY AND NOW();";
                    $result = $this->db->query($sql);
                } elseif ($option == "7DAYS") {
                    $sql = "SELECT * FROM `properties_post_ebay_video` WHERE `property_id` = " . $id . " AND `date_created` BETWEEN NOW() - INTERVAL 7 DAY AND NOW();";
                    $result = $this->db->query($sql);
                }
                break;
            default:
        }
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return null;
        }
    }

}
