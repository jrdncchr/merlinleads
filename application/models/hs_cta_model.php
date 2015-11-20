<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Hs_Cta_Model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    public function getHsCta($module, $type) {
        $this->db->order_by('id', 'RANDOM');
        $result = $this->db->get_where('hs_cta', array('module' => $module, 'type' => $type));
        if ($result->num_rows() > 0) {
            $cta = $result->result();
            $html = "";
            foreach ($cta as $c) {
                $html .= '<option value="' . $c->content . '">' . $c->content . '</option>';
            }
            return $html;
        }
    }

    public function getHsCtaId($module, $type) {
        $result = $this->db->get_where('hs_cta', array('module' => $module, 'type' => $type));
        if ($result->num_rows() > 0) {
            $cta = $result->result();
            $html = "";
            foreach ($cta as $c) {
                $html .= "<option value='$c->id'>$c->content</option>";
            }
            return $html;
        }
    }

    public function updateHsCta($id, $content) {
        $this->db->where('id', $id);
        if ($this->db->update('hs_cta', array('content' => $content))) {
            return "OK";
        }
    }

    public function addHsCta($data) {
        if ($this->db->insert('hs_cta', $data)) {
            return "OK";
        }
    }

    public function deleteHsCta($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('hs_cta')) {
            return "OK";
        }
    }

    public function getHeadlineStatementsKeywords($keywords) {
        $keywords = explode('|', $keywords);
        $html = "";
        for ($i = 0; $i < sizeof($keywords); $i++) {
            $html .= "<option value='" . $keywords[$i] . "'>" . $keywords[$i] . "</option>";
        }
        return $html;
    }

}