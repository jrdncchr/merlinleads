<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Template_Model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    /*
     * Property Templates Shortcodes 
     */

    public function getPropertyTemplateScBySc($module, $sc) {
        $result = $this->db->get_where('properties_templates_sc', array('shortcode' => $sc, 'module' => $module));
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return null;
        }
    }

    public function getPropertyTemplatesScByType($module, $type) {
        $result = $this->db->get_where('properties_templates_sc', array('module' => $module, 'type' => $type));
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return null;
        }
    }

    public function getPropertyTemplatesShortcodes($module, $type) {
        $this->db->order_by('shortcode', 'asc');
        $result = $this->db->get_where('properties_templates_sc', array('module' => $module, 'type' => $type));
        $shortcodes = $result->result();
        $output = "";
        foreach ($shortcodes as $sc) {
            $output .= "<option value='$sc->id'>$sc->shortcode</option>";
        }
        $output = str_replace(array("\n", "\r"), '', $output);
        echo $output;
    }

    public function getPropertyTemplatesShortcodeVal($module, $type, $scid) {
        $result = $this->db->get_where('properties_templates_sc', array('id' => $scid, 'module' => $module, 'type' => $type));
        echo $result->row()->content;
    }

    public function addPropertyTemplateSc($sc) {
        $this->db->insert('properties_templates_sc', $sc);
        return "OK";
    }

    public function updatePropertyTemplateSc($data, $scid) {
        $this->db->update('properties_templates_sc', $data, array('id' => $scid));
        return "OK";
    }

    public function deletePropertyTemplateSc($scid) {
        $this->db->delete('properties_templates_sc', array('id' => $scid));
        return "OK";
    }

    public function getPropertyTemplateScTypesForInput($module) {
        $this->db->select('type')
                ->from('properties_templates_sc')
                ->where('module', $module);
        $this->db->distinct();
        $types = $this->db->get()->result();
        $output = "<option value=''>- Select Type -</option>";
        foreach ($types as $type) {
            $output .= "<option value='$type->type'>$type->type</option>";
        }
        return $output;
    }

    public function checkPropertyTemplateIfShortcodeExist($module, $shortcode) {
        $this->db->where(array('module' => $module));
        $this->db->like('shortcode', $shortcode);
        $this->db->from('properties_templates_sc');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return "Unavailable";
        } else {
            return "Available";
        }
    }

    /*
     *  ALL
     */

    public function getUsedTemplatesCount($module, $property_id, $batch_no) {
        $used = array();
        $result = $this->db->get_where('properties_post_' . strtolower($module), array('property_id' => $property_id, 'batch_no' => $batch_no));
        return $result->num_rows();
    }

    /*
     * Property Media Templates
     */

    public function getPropertyMediaTemplate($module, $id = 0) {
        if ($id > 0) {
            $result = $this->db->get_where('properties_templates_' . strtolower($module), array('number' => $id));
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return null;
            }
        }
    }

    public function getPropertyMediaTemplates($module) {
        $result = $this->db->get_where('properties_templates_' . strtolower($module));
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return null;
        }
    }

    public function addPropertyMediaTemplate($module, $data) {
        $this->db->insert('properties_templates_' . strtolower($module), $data);
        return "OK";
    }

    public function updatePropertyMediaTemplate($module, $template_no, $data) {
        $this->db->update('properties_templates_' . strtolower($module), $data, array('number' => $template_no));
        return "OK";
    }

    public function deletePropertyMediaTemplate($module, $template_no) {
        $this->db->delete('properties_templates_' . strtolower($module), array('number' => $template_no));
        return "OK";
    }

    public function getPropertyMediaTemplatesCount($module) {
        $result = $this->db->get_where('properties_templates_' . strtolower($module));
        return $result->num_rows();
    }

    public function getPropertyMediaTemplatesCountForInput($module, $template_no) {
        $result = $this->db->get_where('properties_templates_' . strtolower($module));
        $modules = $result->result();
        $output = "";
        foreach ($modules as $m) {
            if ($m->number == 1) {
                $output .= "<option value='" . $m->number . "'>Main</option>";
            } else {
                if ($m->number == $template_no) {
                    $output .= "<option value='" . $m->number . "' selected>" . $m->number . "</option>";
                } else {
                    $output .= "<option value='" . $m->number . "'>" . $m->number . "</option>";
                }
            }
        }
        return $output;
    }

    public function getPropertyMediaTemplatesForStaticInput($count, $template_no) {
        $output = "";
        for($i = 1; $i <= $count; $i++) {
            if ($i == 1) {
                $output .= "<option value='" . $i . "'>Main</option>";
            } else {
                if($template_no == $i) {
                    $output .= "<option value='" . $i . "' selected>" . $i . "</option>";
                } else {
                    $output .= "<option value='" . $i . "'>" . $i . "</option>";
                }
            }
        }
        return $output;
    }

    public function checkPropertyMediaTemplateIfTemplateNoExist($module, $template_no) {
        $result = $this->db->get_where('properties_templates_' . strtolower($module), array('number' => $template_no));
        if ($result->num_rows() > 0) {
            return "Unavailable";
        } else {
            return "Available";
        }
    }

    /* Property Media (Youtube, Slideshare) Templates Post */

    public function generatePropertyMediaTitle($selectedModule, $template, $property, $profile, $module) {
        $this->db->like('shortcode', $template->title);
        $sc = $this->db->get_where('properties_templates_sc', array('module' => $selectedModule));
        if ($sc->num_rows() > 0) {
            $this->load->library("templates_lib_properties", null, "templates");
            return $this->templates->generateContent($sc->row()->content, $property, $profile, $module);
        }
    }

    public function generatePropertyMediaDescription($selectedModule, $template, $property, $profile, $module) {
        $content = "";
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $template->description) as $line) {
            if (strlen($line) > 5) {
                $this->db->like('shortcode', $line);
                $sc = $this->db->get_where('properties_templates_sc', array('module' => $selectedModule));
                if ($sc->num_rows() > 0) {
                    if (strlen(trim($sc->row()->content)) > 1) {
                        $this->load->library("templates_lib_properties", null, "templates");
                        $content .= $this->templates->generateContent($sc->row()->content, $property, $profile, $module) . "\n";
                    } else {
                        $content = substr($content, 0, -2);
                    }
                }
            } else {
                $content .= "\r\n";
            }
        }
        return $content;
    }

    public function generatePropertyMediaKeyword($selectedModule, $template, $property, $profile, $module) {
        $this->db->like('shortcode', $template->keyword);
        $sc = $this->db->get_where('properties_templates_sc', array('module' => $selectedModule));
        if ($sc->num_rows() > 0) {
            $this->load->library("templates_lib_properties", null, "templates");
            return $this->templates->generateContent($sc->row()->content, $property, $profile, $module);
        }
    }

    /*
     * Property Classifieds
     */

    // Craiglist

    public function getPropertyCraiglistTemplates($id = 0) {
        if ($id > 0) {
            $result = $this->db->get_where('properties_templates_craiglist', array('number' => $id));
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return null;
            }
        }
    }

    public function getPropertyCraiglistVideoTemplates($id = 0) {
        if ($id > 0) {
            $result = $this->db->get_where('properties_templates_craiglist_video', array('number' => $id));
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return null;
            }
        }
    }

    public function addPropertyCraiglistTemplate($type, $data) {
        if ($type == "Regular") {
            $this->db->insert('properties_templates_craiglist', $data);
        } else {
            $this->db->insert('properties_templates_craiglist_video', $data);
        }
        return "OK";
    }

    public function deletePropertyCraiglistTemplate($type, $template_no) {
        if ($type == "Regular") {
            $this->db->delete('properties_templates_craiglist', array('number' => $template_no));
        } else {
            $this->db->delete('properties_templates_craiglist_video', array('number' => $template_no));
        }
        return "OK";
    }

    public function updatePropertyCraiglistTemplate($type, $template_no, $data) {
        if ($type == "Regular") {
            $this->db->update('properties_templates_craiglist', $data, array('number' => $template_no));
        } else {
            $this->db->update('properties_templates_craiglist_video', $data, array('number' => $template_no));
        }
        return "OK";
    }

    public function getPropertyCraiglistTemplatesCountForInput($type = "Regular") {
        if ($type == "Regular") {
            $result = $this->db->get('properties_templates_craiglist');
        } else {
            $result = $this->db->get('properties_templates_craiglist_video');
        }
        $output = "";
        $modules = $result->result();
        foreach ($modules as $m) {
            if ($m->number == 1) {
                $output .= "<option value='" . $m->number . "' selected>" . $m->number . "</option>";
            } else {
                $output .= "<option value='" . $m->number . "'>" . $m->number . "</option>";
            }
        }
        return $output;
    }

    public function getPropertyCraiglistTemplatesCount() {
        $result = $this->db->get('properties_templates_craiglist');
        return $result->num_rows();
    }

    // Backpage

    public function getPropertyBackpageTemplates($id = 0) {
        if ($id > 0) {
            $result = $this->db->get_where('properties_templates_backpage', array('number' => $id));
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return null;
            }
        }
    }

    public function getPropertyBackpageVideoTemplates($id = 0) {
        if ($id > 0) {
            $result = $this->db->get_where('properties_templates_backpage_video', array('number' => $id));
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return null;
            }
        }
    }

    public function getPropertyBackpageTemplatesCountForInput($type) {
        if ($type == "Regular") {
            $result = $this->db->get('properties_templates_backpage');
        } else {
            $result = $this->db->get('properties_templates_backpage_video');
        }
        $output = "";
        $modules = $result->result();
        foreach ($modules as $m) {
            if ($m->number == 1) {
                $output .= "<option value='" . $m->number . "' selected>" . $m->number . "</option>";
            } else {
                $output .= "<option value='" . $m->number . "'>" . $m->number . "</option>";
            }
        }
        return $output;
    }

    public function addPropertyBackpageTemplate($data) {
        $this->db->insert('properties_templates_backpage', $data);
        return "OK";
    }

    public function deletePropertyBackpageTemplate($template_no) {
        $this->db->delete('properties_templates_backpage', array('number' => $template_no));
        return "OK";
    }

    public function updatePropertyBackpageTemplate($type, $template_no, $data) {
        if ($type == "Regular") {
            $this->db->update('properties_templates_backpage', $data, array('number' => $template_no));
        } else {
            $this->db->update('properties_templates_backpage_video', $data, array('number' => $template_no));
        }
        return "OK";
    }

    public function getPropertyBackpageTemplatesCount() {
        $result = $this->db->get('properties_templates_backpage');
        return $result->num_rows();
    }

    // Ebay

    public function getPropertyEbayTemplates($id = 0) {
        if ($id > 0) {
            $result = $this->db->get_where('properties_templates_ebay', array('number' => $id));
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return null;
            }
        }
    }

    public function getPropertyEbayVideoTemplates($id = 0) {
        if ($id > 0) {
            $result = $this->db->get_where('properties_templates_ebay_video', array('number' => $id));
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return null;
            }
        }
    }

    public function getPropertyEbayTemplatesCountForInput($type) {
        if ($type == "Regular") {
            $result = $this->db->get('properties_templates_ebay');
        } else {
            $result = $this->db->get('properties_templates_ebay_video');
        }
        $output = "";
        $modules = $result->result();
        foreach ($modules as $m) {
            if ($m->number == 1) {
                $output .= "<option value='" . $m->number . "' selected>" . $m->number . "</option>";
            } else {
                $output .= "<option value='" . $m->number . "'>" . $m->number . "</option>";
            }
        }
        return $output;
    }

    public function addPropertyEbayTemplate($data) {
        $this->db->insert('properties_templates_ebay', $data);
        return "OK";
    }

    public function deletePropertyEbayTemplate($template_no) {
        $this->db->delete('properties_templates_ebay', array('number' => $template_no));
        return "OK";
    }

    public function updatePropertyEbayTemplate($type, $template_no, $data) {
        if ($type == "Regular") {
            $this->db->update('properties_templates_ebay', $data, array('number' => $template_no));
        } else {
            $this->db->update('properties_templates_ebay_video', $data, array('number' => $template_no));
        }
        return "OK";
    }

    public function getPropertyEbayTemplatesCount() {
        $result = $this->db->get('properties_templates_ebay');
        return $result->num_rows();
    }

    /* Property Classfieds Templates Post */
    public function generateData($data, $property, $profile) {
        $this->load->library("templates_lib_properties", null, "templates");
        return $this->templates->generateContent($data, $property, $profile, null) . "\n";
    }

    public function generatePropertyCraiglistData($data, $property, $profile, $module) {
        $this->load->library("templates_lib_properties", null, "templates");
        return $this->templates->generateContent($data, $property, $profile, $module) . "\n";
    }

    public function generatePropertyCraiglistFull($data, $property, $profile, $module) {
        $this->load->library('session');
        $selectedModule = $this->session->userdata('selectedModule');
        $content = "";
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $data) as $line) {
            if (strlen($line) > 5) {
                $this->db->like('shortcode', $line);
                $sc = $this->db->get_where('properties_templates_sc', array('module' => $selectedModule));
                if ($sc->num_rows() > 0) {
                    if (strlen(trim($sc->row()->content)) > 1) {
                        $this->load->library("templates_lib_properties", null, "templates");
                        $temp = $this->templates->generateContent($sc->row()->content, $property, $profile, $module) . "\n";
                        preg_match_all("/\[.*?\]/", $temp, $matches);

                        $sc2 = $matches[0];
                        if (sizeof($sc2) > 0) {
                            for ($i = 0; $i < sizeof($sc2); $i++) {
                                $this->db->like('shortcode', trim($sc2[$i]));
                                $sc3 = $this->db->get_where('properties_templates_sc', array('module' => $selectedModule));
                                if ($sc3->num_rows() > 0) {
                                    $temp = str_replace($sc2[$i], $sc3->row()->content, $temp);
                                }
                            }
                            $temp = $this->templates->generateContent($temp, $property, $profile, $module);
                            $content .= $temp;
                        } else {
                            $content .= $temp;
                        }
                    } else {
                        $content = substr($content, 0, -1);
                    }
                }
            } else {
                $content .= "\r\n";
            }
        }
        return $content;
    }

    /*
     * Social (Twitter, Facebook)
     */
    public function getSocialTemplate($module, $templateNo) {
        $result = $this->db->get_where("properties_templates_" . strtolower($module), array("template_no" => $templateNo));
        return $result->row();
    }

    public function getSocialTemplateCount($module) {
        $result = $this->db->query("SELECT MAX(template_no) AS max FROM properties_templates_" . strtolower($module));
        return $result->row()->max;
    }

    public function addSocialTemplate($module, $data) {
        $this->db->insert('properties_templates_' . strtolower($module), $data);
        return "OK";
    }

    public function updateSocialTemplate($module, $data, $template_no) {
        $this->db->update('properties_templates_' . strtolower($module), $data, array("template_no" => $template_no));
        return "OK";
    }

    public function deleteSocialTemplate($module, $template_no) {
        $this->db->delete('properties_templates_' . strtolower($module), array("template_no" => $template_no));
        return "OK";
    }

    public function generateSocialDescription($selectedModule, $template, $property, $profile) {
        $this->load->library("templates_lib_properties", null, "templates");
        switch($selectedModule) {
            case "Twitter":
                return $this->templates->generateContent($template, $property, $profile, null);
                break;
            default:
                return false;
        }

    }

    public function getPropertySocialTemplatesCount($module) {
        $result = $this->db->get("properties_templates_" . strtolower($module));
        return $result->num_rows() +  1;
    }

    public function generateSocialCountForInput($module) {
        $result = $this->db->get("properties_templates_" . strtolower($module));

        $output = "";
        $modules = $result->result();
        foreach ($modules as $m) {
            if ($m->template_no == 1) {
                $output .= "<option value='" . $m->template_no . "' selected>Main</option>";
            } else {
                $output .= "<option value='" . $m->template_no . "'>" . $m->template_no . "</option>";
            }
        }
        return $output;
    }

    // Slideshare Slides Template
//    public function getSlideTemplates($type, $no = 0) {
//        if ($no == 0) {
//            $result = $this->db->get('properties_templates_slideshare_slides', array('type' => $type));
//            if ($result->num_rows() > 0) {
//                return $result->result();
//            }
//        } else {
//            $result = $this->db->get_where('properties_templates_slideshare_slides', array('type' => $type, 'number' => $no));
//            if ($result->num_rows() > 0) {
//                return $result->row();
//            } else {
//                return null;
//            }
//        }
//    }
//
//    public function addSlideTemplate($template) {
//        if ($this->db->insert('properties_templates_slideshare_slides', $template)) {
//            return true;
//        }
//    }
//
//    public function update($template, $no) {
//        $this->db->where('number', $no);
//        if ($this->db->update('properties_templates_slideshare_slides', $template)) {
//            return true;
//        }
//    }

}