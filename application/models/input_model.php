<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Input_Model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    public function getSlideshareCategories($selected = "Homes") {
        $file = fopen(base_url() . OTHERS . "slideshare/categories.txt", "r");
        $categories = "";
        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            if ($selected == $line) {
                $categories .= "<option value='$line' selected>$line</option>";
            } else {
                $categories .= "<option value='$line'>$line</option>";
            }
        }
        return $categories;
    }

    public function getCountryStates($country, $abbr = 'NONE') {
        $result = $this->db->get_where('country_states', array('country' => $country));
        if ($result->num_rows() > 0) {
            $states = $result->result();
            $html = "";
            foreach ($states as $s) {
                if ($s->abbr == $abbr) {
                    $html .= "<option value='$s->abbr - $s->state' selected>$s->abbr - $s->state</option>";
                } else {
                    $html .= "<option value='$s->abbr - $s->state'>$s->abbr - $s->state</option>";
                }
            }
            return $html;
        }
    }

    /*
     * --- FEATURES POSTING
     */
    public function getModules($features, $selected = "Youtube") {
        if($features == "all") {
            $list = ["Youtube", "Slideshare", "Craiglist", "Ebay", "Backpage", "Twitter", "Facebook", "Blog", "Google Plus", "Linked In"];
        } else if ($features == "m1") {
            $list = ["Youtube", "Slideshare", "Craiglist", "Ebay", "Backpage", "Twitter"];
        } else {
            $list = ["Youtube", "Slideshare", "Facebook", "Blog", "Google+", "Linked In"];
//            $list = ["Youtube", "Slideshare"];
            if($features) {
                if(isset($features->craiglist_template_posting)) {
                    $list[] = "Craiglist";
                }
                if(isset($features->ebay_template_posting)) {
                    $list[] = "Ebay";
                }
                if(isset($features->backpage_template_posting)) {
                    $list[] = "Backpage";
                }
                if(isset($features->twitter_template_posting)) {
                    $list[] = "Twitter";
                }
                if(isset($features->google_plus_posting)) {
                    $list[] = "Google Plus";
                }
            }
        }

        $modules = "";
        foreach($list as $l) {
            if ($selected == $l) {
                $modules .= "<option value='$l' selected>$l</option>";
            } else {
                $modules .= "<option value='$l'>$l</option>";
            }
        }
        return $modules;
    }

    // Property Basic
    public function getSaleTypes($saleType = "") {
        $file = fopen(base_url() . OTHERS . "sale_types.txt", "r");
        $type = "<option value=''> -- Select Sales Type -- </option>";
        if ($file) {
            while (($line = fgets($file)) !== false) {
                $line = trim($line);
                if ($line == $saleType) {
                    $type .= "<option value='$line' selected>$line</option>";
                } else {
                    $type .= "<option value='$line'>$line</option>";
                }
            }
            return $type;
        } else {
            return "Can't get Sales Type, Server Error";
        }
    }

    public function getProfilesByUser($user_id) {
        $this->load->model('profile_model');
        $profiles = $this->profile_model->getProfilesByUser($user_id);
        $html = "";
        if ($profiles != null) {
            foreach ($profiles as $p) {
                $html .= '<option value="' . $p->id . ',' . $p->name . '">' . $p->name . '</option>';
            }
        }
        return $html;
    }

    public function getPropertyCategories() {
        $this->db->select('category');
        $this->db->distinct();
        $this->db->order_by('category', 'asc');
        $result = $this->db->get('properties_type');
        $data = $result->result();
        $html = "";
        foreach ($data as $d) {
            $c = ucwords($d->category);
            $html .= "<option value='$c'>$c</option>";
        }
        return $html;
    }

    public function getPropertyCategoryTypes($category) {
        $this->db->select('type');
        $this->db->distinct();
        $this->db->order_by('type', 'asc');
        $result = $this->db->get_where('properties_type', array('category' => $category));
        $data = $result->result();
        $html = "";
        foreach ($data as $d) {
            $t = ucwords($d->type);
            $html .= "<option value='$t'>$t</option>";
        }
        return $html;
    }

    // Property Features And Terms
    public function getFeatureMain($data = '') {
        $this->db->select('main');
        $this->db->distinct();
        $this->db->order_by('main', 'asc');
        $result = $this->db->get('terms_features');
        $main = $result->result();
        $html = "<option value=''> -- Select Main -- </option>";
        foreach ($main as $m) {
            if ($m->main == $data) {
                $html .= "<option value='$m->main' selected>$m->main</option>";
            } else {
                $html .= "<option value='$m->main'>$m->main</option>";
            }
        }
        return $html;
    }

    public function getFeatureSecondary($data = '') {
        $this->db->select('secondary');
        $this->db->distinct();
        $this->db->order_by('secondary', 'asc');
        $result = $this->db->get('terms_features');
        $secondary = $result->result();
        $html = "<option value=''> -- Select Secondary -- </option>";
        foreach ($secondary as $s) {
            if ($s->secondary == $data) {
                $html .= "<option value='$s->secondary' selected>$s->secondary</option>";
            } else {
                $html .= "<option value='$s->secondary'>$s->secondary</option>";
            }
        }
        return $html;
    }

    public function getFeatureCategories($main, $secondary) {
        $this->db->select('category');
        $this->db->distinct();
        $this->db->order_by('category', 'asc');
        $result = $this->db->get_where('terms_features', array('main' => $main, 'secondary' => $secondary));
        $category = $result->result();
        $html = "";
        foreach ($category as $c) {
            $html .= "<option value='$c->category'>$c->category</option>";
        }
        return $html;
    }

    public function getFeatureSelects($main, $secondary, $category) {
        $this->db->select('feature');
        $this->db->distinct();
        $this->db->order_by('feature', 'asc');
        $result = $this->db->get_where('terms_features', array('main' => $main, 'secondary' => $secondary, 'category' => $category));
        $feature = $result->result();
        $html = "";
        foreach ($feature as $f) {
            $html .= "<option value='$f->feature'>$f->feature</option>";
        }
        return $html;
    }

    //Classifieds Post
    public function getClassifiedsBath($selected = "") {
        $file = fopen(base_url() . OTHERS . "classifieds/bath.txt", "r");
        $data = "<option value=''>-</option>";
        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            if ($line == $selected) {
                $data .= "<option value='$line' selected>$line</option>";
            } else {
                $data .= "<option value='$line'>$line</option>";
            }
        }
        return $data;
    }

    public function getClassifiedsHousingType($selected = "") {
        $file = fopen(base_url() . OTHERS . "classifieds/housing_type.txt", "r");
        $data = "<option value=''>-</option>";
        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            if ($line == $selected) {
                $data .= "<option value='$line' selected>$line</option>";
            } else {
                $data .= "<option value='$line'>$line</option>";
            }
        }
        return $data;
    }

    public function getClassifiedsLaundry($selected = "") {
        $file = fopen(base_url() . OTHERS . "classifieds/laundry.txt", "r");
        $data = "<option value=''>-</option>";
        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            if ($line == $selected) {
                $data .= "<option value='$line' selected>$line</option>";
            } else {
                $data .= "<option value='$line'>$line</option>";
            }
        }
        return $data;
    }

    public function getClassifiedsParking($selected = "") {
        $file = fopen(base_url() . OTHERS . "classifieds/parking.txt", "r");
        $data = "<option value=''>-</option>";
        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            if ($line == $selected) {
                $data .= "<option value='$line' selected>$line</option>";
            } else {
                $data .= "<option value='$line'>$line</option>";
            }
        }
        return $data;
    }

}