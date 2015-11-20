<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Package_Model extends CI_Model
{

    function __construct()
    {
        $this->load->database();
    }

    /* Packages */

    public function getPackage($id = 0, $option = array())
    {
        if ($id > 0) {
            $option['id'] = $id;
            $result = $this->db->get_where('packages', $option);
            if ($result->num_rows() > 0) {
                return $result->row();
            }
        } else {
            $result = $this->db->get('packages');
            if ($result->num_rows() > 0) {
                return $result->result();
            }
        }
    }

    public function get_package_details($stripe_plan_id) {
        $this->db
            ->select("stripe_plan_id, features_json, stripe_form, packages.status, show")
            ->from("packages")
            ->join("packages_features", "packages.packages_features_id = packages_features.id")
            ->where("stripe_plan_id", $stripe_plan_id);

        return $this->db->get()->row();
    }

    public function getPackageByName($name)
    {
        $result = $this->db->get_where('packages', array('name' => $name));
        if ($result->num_rows() > 0) {
            return $result->row();
        }
    }

    public function getPackagesByStatus($status = "Active")
    {
        $result = $this->db->get_where('packages', array('status' => $status));
        if ($result->num_rows() > 0) {
            return $result->result();
        }
    }

    public function getPackageByStripePlanId($stripe_plan_id) {
        $result = $this->db->get_where('packages', array('stripe_plan_id' => $stripe_plan_id));
        if ($result->num_rows() > 0) {
            return $result->row();
        }
    }

    public function addPackage($package)
    {
        $this->load->dbforge();
        $this->db->trans_start();
        $this->db->insert('packages', $package);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return "SQL Transaction failed.";
        } else {
            return true;
        }
    }

    public function updatePackage($id, $package)
    {
        $this->db->where('stripe_plan_id', $id);
        if ($this->db->update('packages', $package)) {
            return true;
        }
    }

    public function deletePackage($id)
    {
        if ($id > 0) {
            $this->load->dbforge();
            $this->db->trans_start();
            $this->db->delete('packages', array('id' => $id));
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                return "SQL Transaction failed.";
            } else {
                return true;
            }
        } else {
            return "ID is missing";
        }
    }

    public function deletePackageByStripeId($id) {
        $this->load->dbforge();
        $this->db->trans_start();
        $this->db->delete('packages', array('stripe_plan_id' => $id));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return "SQL Transaction failed.";
        } else {
            return true;
        }
    }

    /*
     * Package Features
     */

    public function get_packages_features($id = 0, $option = array())
    {
        if ($id > 0) {
            $option['id'] = $id;
            $result = $this->db->get_where('packages_features', $option);
            return $result->num_rows() > 0 ?  $result->row() : false;
        } else {
            $result = $this->db->get_where('packages_features', $option);
            return $result->num_rows() > 0 ? $result->result() : false;
        }
    }

    public function update_packages_features($pf) {
        $data = [
            'status' => $pf['status'],
            'name' => $pf['name']
        ];
        $id = $pf['id'];
        unset($pf['id']);
        unset($pf['name']);
        unset($pf['status']);
        $data['features_json'] = json_encode($pf);

        $this->db->where('id', $id);
        return $this->db->update('packages_features', $data);
    }

    public function add_packages_features($pf) {
        $data = array(
            'name' => $pf['name'],
            'status' => $pf['status']
        );
        unset($pf['name']);
        unset($pf['status']);
        $data['features_json'] = json_encode($pf);
        return $this->db->insert('packages_features', $data);
    }

    public function delete_packages_features($id) {
        return $this->db->delete('packages_features', array('id' => $id));
    }

    /*
     * Features
     */

    public function get_features($id = 0, $options = array()) {
        if ($id > 0) {
            $options['id'] = $id;
            $result = $this->db->get_where('features', $options);
            return $result->num_rows() > 0 ?  $result->row() : false;
        } else {
            $result = $this->db->get('features');
            return $result->num_rows() > 0 ? $result->result() : false;
        }
    }

    public function refresh_features_list() {
        $input = "";
        $result = $this->db->get('features');
        if($result->num_rows() > 0) {
            foreach($result->result() as $feature) {
                $input .= "<option value ='$feature->id'>$feature->name</option>";
            }
        }
        return $input;
    }

    public function update_feature($id, $feature) {
        $this->db->where('id', $id);
        return $this->db->update('features', $feature);
    }

    public function add_feature($feature) {
        $this->load->dbforge();
        $this->db->trans_start();
        $this->db->insert('features', $feature);

        // UPDATE EACH PACKAGES FEATURES W/ THE NEW ADDED FEATURE
        $packages_features = $this->get_packages_features();
        foreach($packages_features as $pf) {
            $f = json_decode($pf->features_json);
            if($feature['input_type'] == "checkbox") {
                if($feature['default_value'] != 0) {
                    $f->$feature['key'] = $feature['default_value'];
                    $pf->features_json = json_encode($f);
                }
            } else {
                $f->$feature['key'] = $feature['default_value'];
                $pf->features_json = json_encode($f);
            }

            $this->db->where('id', $pf->id);
            $this->db->update('packages_features', $pf);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete_feature($id) {
        $this->load->dbforge();
        $this->db->trans_start();
        $feature = $this->get_features($id);

        // UPDATE EACH PACKAGES FEATURES W/ THE NEW ADDED FEATURE
        $packages_features = $this->get_packages_features();
        foreach($packages_features as $pf) {
            $f = json_decode($pf->features_json);
            unset($f->{$feature->key});
            $pf->features_json = json_encode($f);

            $this->db->where('id', $pf->id);
            $this->db->update('packages_features', $pf);
        }

        $this->db->delete('features', array('id' => $id));
        $this->db->trans_complete();
        return $this->db->trans_status();
    }


}
