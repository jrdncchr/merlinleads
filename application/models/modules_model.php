<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Modules_Model extends CI_Model {

    function __construct() 
    {
        $this->load->database();
    }

    public function toggle($id, $module_enabled) {
    	$this->db->where('module_id', $id);
    	$this->db->update('modules', array("module_enabled" => $module_enabled));
    	return true;
    }

    public function get($options = array()) 
    {
        if(isset($options['id'])) {
            $result = $this->db->get_where('modules', $options);
            return $result->num_rows() > 0 ?  $result->row() : null;
        } else {
            $result = $this->db->get_where('modules', $options);
            return $result->num_rows() > 0 ?  $result->result() : null;
        }
    }

    public function get_modules($features, $for_input_options = false, $selected = "Youtube") 
    {
    	$modules = $this->get();
    	$list = [];

    	/*
    	 * Return ALL MODULES (Used in ADMIN)
    	 */
        if($features == "all") {
            foreach($modules as $m) {
            	$list[] = $m->module_name;
            }

    	/*
    	 * Return modules with M1 category (Used in ADMIN)
    	 */
        } else if ($features == "M1") {
            foreach($modules as $m) {
            	if($m->module_category == "M1") {
            		$list[] = $m->module_name;
            	}
            }

    	/*
    	 * Return all available modules (USED in CLIENT)
    	 */
        } else {
            /*
             * Checks if a user is allowed to use a specific module.
             * Edit and add a case inside the switch on a new added mdoule.
             */
            if($features) {
            	foreach($modules as $m) {
	        		if($m->module_enabled) {
	        			switch ($m->module_name) {
	        				case 'Craiglist':
	        					if(isset($features->craiglist_template_posting)) {
	        						$list[] = $m->module_name;
 	        					}
	        					break;
	        				case 'Ebay':
	        					if(isset($features->ebay_template_posting)) {
	        						$list[] = $m->module_name;
 	        					}
	        					break;
	        				case 'Backpage':
	        					if(isset($features->backpage_template_posting)) {
	        						$list[] = $m->module_name;
 	        					}
	        					break;
                            case 'Youtube':
                                if(isset($features->youtube_posting_templates)) {
                                    $list[] = $m->module_name;
                                }
                                break;
//	        				case 'Twitter':
//	        					if(isset($features->twitter_template_posting)) {
//	        						$list[] = $m->module_name;
// 	        					}
//	        					break;
                            case 'Slideshare':
                                if(isset($features->slideshare_slide_generator)) {
                                    $list[] = $m->module_name;
                                }
                                break;
//                            case 'Facebook':
//                                if(isset($features->facebook_posting)) {
//                                    $list[] = $m->module_name;
//                                }
//                                break;
//                            case 'Google Plus':
//	        					if(isset($features->google_plus_posting)) {
//	        						$list[] = $m->module_name;
// 	        					}
//	        					break;
//                            case 'LinkedIn':
//                                if(isset($features->linkedin_posting)) {
//                                    $list[] = $m->module_name;
//                                }
//                                break;
//                            case 'Blog':
//                                if(isset($features->blog_posting)) {
//                                    $list[] = $m->module_name;
//                                }
//                                break;
	        				default: break;
	        			}
	            	}
				}
            }
        }

        /*
         * Check if the return value should be an array or a string for select input.
         */
        if($for_input_options) {
        	$modules = "";
	        foreach($list as $l) {
	            if ($selected == $l) {
	                $modules .= "<option value='$l' selected>$l</option>";
	            } else {
	                $modules .= "<option value='$l'>$l</option>";
	            }
	        }
	        return $modules;
        } else {
        	return $list;
        }
    }

}	