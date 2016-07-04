<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class city_zipcode_model extends CI_Model {
    private $cz_table = 'city_zipcode';
    private $czu_table = 'city_zipcode_user';
    private $czr_table = 'city_zipcode_request';
    private $users_table = 'users';

    function __construct() {
        $this->load->database();
    }

    /*
     * City Zip Code
     */

    public function get_cz($where = array(), $list = true) {
        $result = $this->db->get_where($this->cz_table, $where);
        return $list ? $result->result() : $result->row();
    }

    public function add_cz($cz) {
        $this->db->insert($this->cz_table, $cz);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update_cz($id, $cz) {
        $this->db->where('cz_id', $id);
        $this->db->update($this->cz_table, $cz);
        return array('success' => true);
    }

    public function delete_cz($id) {
        $this->db->where('cz_id', $id);
        $this->db->delete($this->cz_table);
        return array('success' => true);
    }

    /*
     * User City Zip Code
     */

    public function get_czu($where = array(), $list = true) {
        $this->db->select('czu.*, cz.cz_zipcode, cz_city, users.email');
        $this->db->join($this->users_table, 'users.id = czu.czu_user_id', 'left');
        $this->db->join($this->cz_table . ' as cz', 'cz.cz_id = czu.czu_cz_id', 'left');
        $result = $this->db->get_where($this->czu_table . ' as czu', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save_czu($cz, $user_id) {
        $old_cz = $this->get_czu(array('czu_user_id' => $user_id));
        if(sizeof($old_cz) > 0) {
            foreach($old_cz as $ocz) {
                if(isset($cz[$ocz->czu_type])) {
                    if($cz[$ocz->czu_type] != $ocz->czu_cz_id) {
                        if($cz[$ocz->czu_type]) {
                            $this->update_czu($ocz->czu_id, array('czu_cz_id' => $cz[$ocz->czu_type], 'czu_status' => 'pending'));
                        } else {
                            $this->delete_czu($ocz->czu_id);
                        }
                    }
                    unset($cz[$ocz->czu_type]);
                }
            }
        }
        foreach($cz as $k => $v) {
            if($v) {
                $data = array('czu_type' => $k, 'czu_cz_id' => $v, 'czu_user_id' => $user_id, 'czu_status' => 'pending');
                $this->add_czu($data);
            }
        }
        return array('success' => true);
    }

    public function add_czu($czu) {
        $this->db->insert($this->czu_table, $czu);
        $CI =& get_instance();
        $CI->load->model('email_model');
        $CI->email_model->sendNewCityZipcodeUserRequest($czu);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update_czu($id, $cz) {
        $this->db->where('czu_id', $id);
        $this->db->update($this->czu_table, $cz);
        return array('success' => true);
    }

    public function delete_czu($id) {
        $this->db->where('czu_id', $id);
        $this->db->delete($this->czu_table);
        return array('success' => true);
    }

    public function validate_czu($czu) {
        $result['success'] = true;
        $cz = $this->get_czu(array('czu_cz_id' => $czu['czu_cz_id'], 'czu_status' => 'active'), true);
        if($cz) {
            $result['success'] = false;
            $result['message'] = "City / Zip Code already used by other user.";
        }
        return $result;
    }

    /*
     * City Zip Code Request
     */

    public function get_czr($where = array(), $list = true) {
        $result = $this->db->get_where($this->czr_table, $where);
        return $list ? $result->result() : $result->row();
    }

    public function get_czr_admin($where = array(), $list = true) {
        $this->db->select('czr.*, users.email');
        $this->db->join($this->users_table, 'users.id = czr.czr_requested_by', 'left');
        $result = $this->db->get_where($this->czr_table . ' as czr', $where);
        return $list ? $result->result() : $result->row();
    }

    public function add_czr($czr) {
        $czr['czr_status'] = 'pending';
        $this->db->insert($this->czr_table, $czr);
        return array('success' => true, 'inserted_id' => $this->db->insert_id());
    }

    public function update_czr($id, $czr) {
        $this->db->where('czr_id', $id);
        $this->db->update($this->czr_table, $czr);
        return array('success' => true);
    }

    public function delete_czr($id) {
        $this->db->where('czr_id', $id);
        $this->db->delete($this->czr_table);
        return array('success' => true);
    }

} 