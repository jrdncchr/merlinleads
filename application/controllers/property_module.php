<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Property_Module extends MY_Controller {

// Only logged in users can go to this controller.
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url());
        }
        $this->load->model('property_model');
        $this->load->model('property_module_model');
        $this->load->model('property_post_model');
    }

    /* Methods Used By ALL Modules */

// Updates a the overview everytime a new post of a module was made.
    public function updatePropertyOverviewModule($po, $module) {
        $this->load->model('template_model');
        $this->load->model('property_model');
        $this->load->model('property_module_model');
        $this->load->model('property_post_model');
        if ($module == "Youtube") {
            $usedCount = $this->property_module_model->getPropertyMediaPostCount('youtube', $po->property_id);
            $output = "$usedCount";
            $this->property_model->updateOverview(array('youtube' => $output), $po->id);
        } else if ($module == "Slideshare") {
            $usedCount = $this->property_module_model->getPropertyMediaPostCount('slideshare', $po->property_id);
            $output = "$usedCount";
            $this->property_model->updateOverview(array('slideshare' => $output), $po->id);
        } else if ($module == "Craiglist") {
            $usedCount = $this->property_module_model->getCraiglistModuleCount($po->property_id);
            $usedCountVideo = $this->property_module_model->getCraiglistModuleCountVideo($po->property_id);
            $ldp = $this->property_module_model->getLastDatePosted("Craiglist", $po->property_id);
            $ldp_video = $this->property_module_model->getLastDatePosted("Craiglist Video", $po->property_id);
            $output = $this->overviewOutputCheck($usedCount, $usedCountVideo, $ldp, $ldp_video);
            $this->property_model->updateOverview(array('craiglist' => json_encode($output)), $po->id);
        } else if ($module == "Backpage") {
            $usedCount = $this->property_module_model->getBackpageModuleCount($po->property_id);
            $usedCountVideo = $this->property_module_model->getBackpageModuleCountVideo($po->property_id);
            $ldp = $this->property_module_model->getLastDatePosted("Backpage", $po->property_id);
            $ldp_video = $this->property_module_model->getLastDatePosted("Backpage Video", $po->property_id);
            $output = $this->overviewOutputCheck($usedCount, $usedCountVideo, $ldp, $ldp_video);
            $this->property_model->updateOverview(array('backpage' => json_encode($output)), $po->id);
        } else if ($module == "Ebay") {
            $usedCount = $this->property_module_model->getEbayModuleCount($po->property_id);
            $usedCountVideo = $this->property_module_model->getEbayModuleCountVideo($po->property_id);
            $ldp = $this->property_module_model->getLastDatePosted("Ebay", $po->property_id);
            $ldp_video = $this->property_module_model->getLastDatePosted("Ebay Video", $po->property_id);
            $output = $this->overviewOutputCheck($usedCount, $usedCountVideo, $ldp, $ldp_video);
            $this->property_model->updateOverview(array('ebay' => json_encode($output)), $po->id);
        }
    }

    public function overviewOutputCheck($usedCount, $usedCountVideo, $ldp, $ldp_video) {
        if ($ldp && $ldp_video) {
            $output = array(
                'regular' => $usedCount,
                'regular_ldp' => $ldp->date_created,
                'video' => $usedCountVideo,
                'video_ldp' => $ldp_video->date_created
            );
        } else if ($ldp) {
            $output = array(
                'regular' => $usedCount,
                'regular_ldp' => $ldp->date_created
            );
        } else if ($ldp_video) {
            $output = array(
                'video' => $usedCountVideo,
                'video_ldp' => $ldp_video->date_created
            );
        }
        return $output;
    }

    /* Youtube Module 
     * Used in the Property Action 'Post'
     */

// Method called when the 'Post' is triggered, and when the template select is changes. 
// Checks if the Media module exists, if yes it returns a generated data based from a template no. 
    public function getMediaTemplate() {
        $this->load->model('template_model');
        $this->load->model('profile_model');
// Get the Media Property Overview ID, selected Module and template No Information to get the data.
        $po = $this->property_model->getOverview($_POST['poID']);
        $selectedModule = $this->session->userdata('selectedModule');
        $template = $this->template_model->getPropertyMediaTemplate($selectedModule, $_POST['templateNo']);
        $property = $this->property_model->getProperty($po->property_id);
        $profile = $this->profile_model->getProfile($property->profile_id);
        $module = $this->property_module_model->getPropertyMediaPost($selectedModule, $po->property_id, $_POST['templateNo']);
// Checks doesn't exist, returns a blank data if the module did not existed yet. (Means the 'template is available')
        if (null != $module) {
            $title = $this->template_model->generatePropertyMediaTitle($selectedModule, $template, $property, $profile, $module);
            $description = $this->template_model->generatePropertyMediaDescription($selectedModule, $template, $property, $profile, $module);
            $keyword = $this->template_model->generatePropertyMediaKeyword($selectedModule, $template, $property, $profile, $module);
            $data = array(
                'title' => $title,
                'description' => $description,
                'keyword' => $keyword,
                'module' => $module,
            );
            if ($selectedModule == "Youtube") {
                $data['link'] = $module->link;
            }
        } else {
            $data = array(
                'title' => "",
                'description' => "",
                'keyword' => "",
                'module' => ""
            );
        }
        echo json_encode($data);
    }

// Method called when the generate button is hit in 'Post' Media Module
// Generates a template based from a selected template no. and save the module data. 
    function generateMediaTemplate() {
        $this->load->model('template_model');
        $this->load->model('profile_model');
        $this->load->model('property_model');
        // Get the Media Property Overview ID, selected Module and template No Information to get the data.
        $po = $this->property_model->getOverview($_POST['poID']);
        $selectedModule = $this->session->userdata('selectedModule');
        $template = $this->template_model->getPropertyMediaTemplate($selectedModule, $_POST['templateNo']);
        $property = $this->property_model->getProperty($po->property_id);
        $profile = $this->profile_model->getProfile($property->profile_id);
        // Data to be added in the property_post_(media module selected) table. (This marks the template no. is already used)
        $data = array(
            'property_id' => $property->id,
            'template' => $_POST['templateNo']
        );
        if ($selectedModule == "Youtube") {
            $data['link'] = $_POST['link'];
        }
        // Adds and gets the module, if successful generates data based from the data template no. 
        $id = $this->property_module_model->addPropertyMediaPost($selectedModule, $data);
        $module = $this->property_module_model->getPropertyMediaPost($selectedModule, $po->property_id, $_POST['templateNo']);
        if (null != $module) {
            $title = $this->template_model->generatePropertyMediaTitle($selectedModule, $template, $property, $profile, $module);
            $description = $this->template_model->generatePropertyMediaDescription($selectedModule, $template, $property, $profile, $module);
            $keyword = $this->template_model->generatePropertyMediaKeyword($selectedModule, $template, $property, $profile, $module);
            $data = array(
                'title' => $title,
                'description' => $description,
                'keyword' => $keyword,
                'module' => $module
            );
            if ($selectedModule == "Youtube") {
                $data['link'] = $module->link;
            }
            $update = array('title' => $title);
            $this->property_module_model->updatePropertyMediaModule($selectedModule, $update, $id);
            $this->updatePropertyOverviewModule($po, $selectedModule);
        }
        echo json_encode($data);
    }

    /* Classifieds Module 
     * Used in the Property Action 'Post'
     */

//method called when the changing tab and save button is hit in the craiglist module.
    public function saveClassifiedsModule() {
        $poID = $this->session->userdata('poID');
        $po = $this->property_model->getOverview($poID);
        $data = array(
            'property_id' => $po->property_id,
            'headline_statements' => $_POST['headlineStatements'],
            'cta' => $_POST['cta'],
            'oh_date' => $_POST['ohDate'],
            'oh_start_time' => $_POST['ohStartTime'],
            'oh_end_time' => $_POST['ohEndTime'],
            'oh_notes' => $_POST['ohNotes'],
            'ad_tags' => $_POST['adTags'],
            'youtube_url' => $_POST['videoYoutubeUrl'],
            'video_cta' => $_POST['videoCta'],
            'video_term' => $_POST['videoTerm'],
            'price' => $_POST['price'],
            'housing_type' => $_POST['housingType'],
            'bath' => $_POST['bath'],
            'laundry' => $_POST['laundry'],
            'parking' => $_POST['parking'],
            'cross_street' => $_POST['crossStreet'],
            'wheelchair_accessible' => $_POST['wheelchairAccessible'],
            'no_smoking' => $_POST['noSmoking'],
            'furnished' => $_POST['furnished']
        );
        $classifieds = $this->property_module_model->getClassifiedsModule($po->property_id);
        if (null == $classifieds) {
            echo $this->property_module_model->addClassifiedsModule($data);
        } else {
            echo $this->property_module_model->updateClassifiedsModule($classifieds->id, $data);
        }
    }

    public function generateCraiglistModule() {
        $this->load->model('property_post_model');
        $type = $_POST['type'];
        $poID = $this->session->userdata('poID');
        $po = $this->property_model->getOverview($poID);

        $available = true;
        $message = "";

        if ($type == "Regular") {
            $ldp = $this->property_module_model->getLastDatePosted("Craiglist", $po->property_id);
            if($ldp) {
                $hour = $this->getTimeDiff($ldp->date_created);
                if ($hour < 12) {
                    $available = false;
                    $hour = 12 - $hour;
                    $message .= "You need to wait " . $hour . " hour(s) to be able to post the next template.";
                }
            }    
        } else {
            $ldp_video = $this->property_module_model->getLastDatePosted("Craiglist Video", $po->property_id);
            if($ldp_video) {
                $hour = $this->getTimeDiff($ldp_video->date_created);
                if ($hour < 12) {
                    $available = false;
                    $hour = 12 - $hour;
                    $message .= "You need to wait " . $hour . " hour(s) to be able to post the next template.";
                }    
            }
        }

        if ($available) {
            $this->load->model('template_model');
            $this->load->model('profile_model');
            $this->load->model('property_model');
            $this->load->model('property_post_model');

            if ($type == "Regular") {
                $next_template = $this->session->userdata('craiglist_next_template');
                $template_no = $next_template['template_no'];
                $template = $this->template_model->getPropertyCraiglistTemplates($template_no);
            } else {
                $next_template = $this->session->userdata('craiglist_video_next_template');
                $template_no = $next_template['template_no'];
                $template = $this->template_model->getPropertyCraiglistVideoTemplates($template_no);
            }
            $this->session->set_userdata('template_no', $template_no);
            $property = $this->property_model->getProperty($po->property_id);
            $profile = $this->profile_model->getProfile($property->profile_id);

            // Adds and gets the module, if successful generates data based from the data template no.
            $module = $this->property_module_model->getClassifiedsModule($po->property_id);
            if (null != $module) {
                $data = array(
                    'result' => "OK",
                    'phone' => $this->template_model->generatePropertyCraiglistData($template->phone, $property, $profile, $module),
                    'contact_name' => $this->template_model->generatePropertyCraiglistData($template->contact_name, $property, $profile, $module),
                    'posting_title' => $this->template_model->generatePropertyCraiglistFull($template->posting_title, $property, $profile, $module),
                    'posting_body' => $this->template_model->generatePropertyCraiglistFull($template->posting_body, $property, $profile, $module),
                    'specific_location' => $this->template_model->generatePropertyCraiglistFull($template->specific_location, $property, $profile, $module),
                    'postal_code' => $this->template_model->generatePropertyCraiglistData($template->postal_code, $property, $profile, $module),
                    'sqft' => $this->template_model->generatePropertyCraiglistData($template->sqft, $property, $profile, $module),
                    'price' => $this->template_model->generatePropertyCraiglistData($template->price, $property, $profile, $module),
                    'bathrooms' => $this->template_model->generatePropertyCraiglistData($template->bathrooms, $property, $profile, $module),
                    'bedrooms' => $this->template_model->generatePropertyCraiglistData($template->bedrooms, $property, $profile, $module),
                    'housing_type' => $this->template_model->generatePropertyCraiglistData($template->housing_type, $property, $profile, $module),
                    'laundry' => $this->template_model->generatePropertyCraiglistData($template->laundry, $property, $profile, $module),
                    'parking' => $this->template_model->generatePropertyCraiglistData($template->parking, $property, $profile, $module),
                    'wheelchair_accessible' => $this->template_model->generatePropertyCraiglistData($template->wheelchair_accessible, $property, $profile, $module),
                    'no_smoking' => $this->template_model->generatePropertyCraiglistData($template->no_smoking, $property, $profile, $module),
                    'furnished' => $this->template_model->generatePropertyCraiglistData($template->furnished, $property, $profile, $module),
                    'street' => $this->template_model->generatePropertyCraiglistData($template->maps_section, $property, $profile, $module),
                    'cross_street' => $this->template_model->generatePropertyCraiglistData($template->cross_street, $property, $profile, $module),
                    'city' => $this->template_model->generatePropertyCraiglistData($template->city, $property, $profile, $module),
                    'state_abbr' => $this->template_model->generatePropertyCraiglistData($template->state_abbr, $property, $profile, $module),
                    'start_time' => $module->oh_start_time,
                    'end_time' => $module->oh_end_time
                );
            }
        } else {
            $data = array(
                'result' => $message
            );
        }
        echo json_encode($data);
    }

    public function generateBackpageModule() {
        $type = $_POST['type'];
        $poID = $this->session->userdata('poID');
        $po = $this->property_model->getOverview($poID);

        $available = true;
        $message = "";
        if ($type == "Regular") {
            $ldp = $this->property_module_model->getLastDatePosted("Backpage", $po->property_id);
            if($ldp) {
                $hour = $this->getTimeDiff($ldp->date_created);
                if ($hour < 12) {
                    $available = false;
                    $hour = 12 - $hour;
                    $message .= "You need to wait " . $hour . " hour(s) to be able to post the next template.";
                }    
            }
        } else {
            $ldp_video = $this->property_module_model->getLastDatePosted("Backpage Video", $po->property_id);
            if($ldp_video) {
                $hour = $this->getTimeDiff($ldp_video->date_created);
                if ($hour < 12) {
                    $available = false;
                    $hour = 12 - $hour;
                    $message .= "You need to wait " . $hour . " hour(s) to be able to post the next template.";
                }   
            }
        }

        if ($available) {
            $this->load->model('template_model');
            $this->load->model('profile_model');

            if ($type == "Regular") {
                $next_template = $this->session->userdata('backpage_next_template');
                $template_no = $next_template['template_no'];
                $template = $this->template_model->getPropertyBackpageTemplates($template_no);
            } else {
                $next_template = $this->session->userdata('backpage_video_next_template');
                $template_no = $next_template['template_no'];
                $template = $this->template_model->getPropertyBackpageVideoTemplates($template_no);
            }
            $this->session->set_userdata('template_no', $template_no);
            $property = $this->property_model->getProperty($po->property_id);
            $profile = $this->profile_model->getProfile($property->profile_id);

// Adds and gets the module, if successful generates data based from the data template no. 
            $module = $this->property_module_model->getClassifiedsModule($po->property_id);
            if (null != $module) {
                $data = array(
                    'result' => "OK",
                    'title' => $this->template_model->generatePropertyCraiglistFull($template->title, $property, $profile, $module),
                    'description' => $this->template_model->generatePropertyCraiglistFull($template->description, $property, $profile, $module),
                    'specific_location' => $this->template_model->generatePropertyCraiglistFull($template->specific_location, $property, $profile, $module),
                    'zip_code' => $this->template_model->generatePropertyCraiglistData($template->postal_code, $property, $profile, $module),
                    'price' => $this->template_model->generatePropertyCraiglistData($template->price, $property, $profile, $module),
                    'bedrooms' => $this->template_model->generatePropertyCraiglistData($template->bedrooms, $property, $profile, $module),
                    'address' => $this->template_model->generatePropertyCraiglistData($template->address, $property, $profile, $module),
                    'location' => $this->template_model->generatePropertyCraiglistData($template->location, $property, $profile, $module),
                    'cross_street' => $this->template_model->generatePropertyCraiglistData($template->cross_street, $property, $profile, $module),
                    'email' => $this->template_model->generatePropertyCraiglistData($template->email, $property, $profile, $module),
                );
            }
        } else {
            $data = array(
                'result' => $message
            );
        }
        echo json_encode($data);
    }

    public function generateEbayModule() {
        $type = $_POST['type'];
        $poID = $this->session->userdata('poID');
        $po = $this->property_model->getOverview($poID);

        $available = true;
        $message = "";
        if ($type == "Regular") {
            $ldp = $this->property_module_model->getLastDatePosted("Ebay", $po->property_id);
            if($ldp) {
                $hour = $this->getTimeDiff($ldp->date_created);
                if ($hour < 12) {
                    $available = false;
                    $hour = 12 - $hour;
                    $message .= "You need to wait " . $hour . " hour(s) to be able to post the next template.";
                }   
            }
        } else {
            $ldp_video = $this->property_module_model->getLastDatePosted("Ebay Video", $po->property_id);
            if($ldp_video) {
                $hour = $this->getTimeDiff($ldp_video->date_created);
                if ($hour < 12) {
                    $available = false;
                    $hour = 12 - $hour;
                    $message .= "You need to wait " . $hour . " hour(s) to be able to post the next template.";
                }
            }
        }

        if ($available) {
            $this->load->model('template_model');
            $this->load->model('profile_model');

            if ($type == "Regular") {
                $next_template = $this->session->userdata('ebay_next_template');
                $template_no = $next_template['template_no'];
                $template = $this->template_model->getPropertyEbayTemplates($template_no);
            } else {
                $next_template = $this->session->userdata('ebay_video_next_template');
                $template_no = $next_template['template_no'];
                $template = $this->template_model->getPropertyEbayVideoTemplates($template_no);
            }
            $this->session->set_userdata('template_no', $template_no);
            $property = $this->property_model->getProperty($po->property_id);
            $profile = $this->profile_model->getProfile($property->profile_id);

// Adds and gets the module, if successful generates data based from the data template no. 
            $module = $this->property_module_model->getClassifiedsModule($po->property_id);
            if (null != $module) {
                $data = array(
                    'result' => "OK",
                    'title' => $this->template_model->generatePropertyCraiglistFull($template->title, $property, $profile, $module),
                    'description' => $this->template_model->generatePropertyCraiglistFull($template->description, $property, $profile, $module),
                    'zipcode' => $this->template_model->generatePropertyCraiglistData($template->zipcode, $property, $profile, $module),
                    'sqft' => $this->template_model->generatePropertyCraiglistData($template->sqft, $property, $profile, $module),
                    'price' => $this->template_model->generatePropertyCraiglistData($template->price, $property, $profile, $module),
                    'bedrooms' => $this->template_model->generatePropertyCraiglistData($template->bedrooms, $property, $profile, $module),
                    'bathrooms' => $this->template_model->generatePropertyCraiglistData($template->bathrooms, $property, $profile, $module),
                    'phone' => $this->template_model->generatePropertyCraiglistData($template->phone, $property, $profile, $module),
                    'year_built' => $this->template_model->generatePropertyCraiglistData($template->year_built, $property, $profile, $module),
                    'size' => $this->template_model->generatePropertyCraiglistData($template->size, $property, $profile, $module),
                    'street' => $this->template_model->generatePropertyCraiglistData($template->street, $property, $profile, $module),
                    'email' => $this->template_model->generatePropertyCraiglistData($template->email, $property, $profile, $module),
                    'city' => $this->template_model->generatePropertyCraiglistData($template->city, $property, $profile, $module),
                    'state' => $this->template_model->generatePropertyCraiglistData($template->state, $property, $profile, $module)
                );
            }
        } else {
            $data = array(
                'result' => $message
            );
        }
        echo json_encode($data);
    }

    public function craiglistPostComplete() {
        $type = $_POST['type'];
        $title = $_POST['title'];

        $this->load->model('property_model');
        $this->load->model('property_post_model');
        $template_no = $this->session->userdata('template_no');
        $this->session->unset_userdata('template_no');

        $poID = $this->session->userdata('poID');
        $po = $this->property_model->getOverview($poID);
        if ($type == "Regular") {
            $next_template = $this->session->userdata('craiglist_next_template');
            $this->property_post_model->addCraiglistPost(array('property_id' => $po->property_id, 'template_no' => $template_no, 'title' => $title, 'batch_no' => $next_template['batch_no']));
        } else {
            $next_template = $this->session->userdata('craiglist_video_next_template');
            $this->property_post_model->addCraiglistPostVideo(array('property_id' => $po->property_id, 'template_no' => $template_no, 'title' => $title, 'batch_no' => $next_template['batch_no']));
        }
        $this->updatePropertyOverviewModule($po, "Craiglist");
        echo "OK";
    }

    public function changeStatus() {
        $poID = $this->session->userdata('poID');
        $po = $this->property_model->getOverview($poID);
        $classifieds = $this->property_module_model->getClassifiedsModule($po->property_id);
        $data = array(
            'status' => $_POST['status']
        );
        echo $this->property_module_model->updateClassifiedsModule($classifieds->id, $data);
    }

    public function backpagePostComplete() {
        $type = $_POST['type'];
        $title = $_POST['title'];

        $this->load->model('property_model');
        $this->load->model('property_post_model');
        $template_no = $this->session->userdata('template_no');
        $this->session->unset_userdata('template_no');

        $poID = $this->session->userdata('poID');
        $po = $this->property_model->getOverview($poID);
        if ($type == "Regular") {
            $next_template = $this->session->userdata('backpage_next_template');
            $this->property_post_model->addBackpagePost(array('property_id' => $po->property_id, 'template_no' => $template_no, 'title' => $title, 'batch_no' => $next_template['batch_no']));
        } else {
            $next_template = $this->session->userdata('backpage_video_next_template');
            $this->property_post_model->addBackpagePostVideo(array('property_id' => $po->property_id, 'template_no' => $template_no, 'title' => $title, 'batch_no' => $next_template['batch_no']));
        }
        $this->updatePropertyOverviewModule($po, "Backpage");
        echo "OK";
    }

    public function ebayPostComplete() {
        $type = $_POST['type'];
        $title = $_POST['title'];

        $this->load->model('property_model');
        $this->load->model('property_post_model');
        $template_no = $this->session->userdata('template_no');
        $this->session->unset_userdata('template_no');

        $poID = $this->session->userdata('poID');
        $po = $this->property_model->getOverview($poID);
        if ($type == "Regular") {
            $next_template = $this->session->userdata('ebay_next_template');
            $this->property_post_model->addEbayPost(array('property_id' => $po->property_id, 'template_no' => $template_no, 'title' => $title, 'batch_no' => $next_template['batch_no']));
        } else {
            $next_template = $this->session->userdata('ebay_video_next_template');
            $this->property_post_model->addEbayPostVideo(array('property_id' => $po->property_id, 'template_no' => $template_no, 'title' => $title, 'batch_no' => $next_template['batch_no']));
        }
        $this->updatePropertyOverviewModule($po, "Ebay");
        echo "OK";
    }

    public function getTimeDiff($d) {
        $time = strtotime($d);
        $curtime = strtotime("now" - TIME_ADJUST);
        $seconds = $curtime - $time;
        $hours = round($seconds / 60 / 60);
        if ($hours < 0) {
            $hours *= -1;
        }
        return $hours;
    }

    /*
     * Twitter Module
     */


    /* Property Module */

    public function updatePropertyImage() {
        $property_id = $this->session->userdata('property_id');
        $update = array();
        $update[$_POST['field']] = json_encode(array(
            'image1' => $_POST['image1'],
            'image2' => $_POST['image2'],
            'image3' => $_POST['image3'],
            'text' => $_POST['text']
        ));
        echo $this->property_module_model->updatePropertyImage($update, $property_id);
    }

    public function updatePropertyImageAll() {
        $property_id = $this->session->userdata('property_id');
        $update = array();
        $fields = $_POST['fields'];
        foreach ($fields as $field) {
            $update[$field['field']] = json_encode(array(
                'image1' => $field['image1'],
                'image2' => $field['image2'],
                'image3' => $field['image3'],
                'text' => $field['text']
            ));
        }
        echo $this->property_module_model->updatePropertyImage($update, $property_id);
    }

    /*
     * Slideshare
     */

    public function postSlideShare() {
        //user provided settings
        $apikey = '1WUbB0I8';
        $secret = 'SGOjqsDh';
        $username = $_POST['username'];
        $password = $_POST['password'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $tags = $_POST['tags'];
        $file = rawurlencode($_POST['upload_url']);
        $public = "Y";

        $ts = time(); //unix timestamp
        $hash = sha1($secret.$ts); //SHA1 (sharedsecret + timestamp)

        $postdata = 'username='.$username.'&password='.$password.'&upload_url='.$file.'&slideshow_title='.$title.'&slideshow_description='.$description.'&slideshow_tags='.$tags.'&make_src_public='.$public.'&api_key='.$apikey.'&ts='.$ts.'&hash='.$hash;


        //cURL POST call with SSL
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://www.slideshare.net/api/2/upload_slideshow");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //execute
        $output = curl_exec($ch);

        if ($output === FALSE) {
            echo "cURL Error: " . curl_error($ch);
        } else {
            echo $this->Parse($output);
        }

        curl_close($ch);
    }

    public function Parse ($string) {
        $fileContents= $string;
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents);
        $json = json_encode($simpleXml);
        return $json;
    }

    public function getSlideshareRandomTitle() {
        // init
        $this->load->model('template_model');
        $this->load->model('property_model');
        $poId = $this->session->userdata('poID');
        // get needed data
        $po = $this->property_model->getOverview($poId);
        $template_no = rand(1, $this->template_model->getPropertyMediaTemplatesCount('slideshare'));
        $template = $this->template_model->getPropertyMediaTemplate('slideshare', $template_no);
        $property = $this->property_model->getProperty($po->property_id);
        if (null != $template) {
            return $this->template_model->generatePropertyMediaTitle('slideshare', $template, $property, null, null);
        }
        return false;
    }

    public function generateSlideshareSlide() {
        try {
            $this->load->model('profile_model');
            $this->load->model('template_model');

            $poID = $this->session->userdata('poID');
            $po = $this->property_model->getOverview($poID);
            $property = $this->property_model->getProperty($po->property_id);
            $img = $this->property_module_model->getPropertyImage($po->property_id);
            $profile = $this->profile_model->getProfile($property->profile_id);
            $template = $_POST['slides'];
            $bg = $_POST['bg'];
            $templateNo = $_POST['templateNo'];

            /** Include path * */
            set_include_path(get_include_path() . PATH_SEPARATOR . OTHERS . "Classes");

            /** PHPPowerPoint */
            include 'PHPPowerPoint.php';

            /** PHPPowerPoint_IOFactory */
            include 'PHPPowerPoint/IOFactory.php';
            $objPHPPowerPoint = new PHPPowerPoint();
            // Set properties
            $objPHPPowerPoint->getProperties()->setCreator("Merlin Leads");
            $objPHPPowerPoint->getProperties()->setLastModifiedBy("Merlin Leads");
            $objPHPPowerPoint->getProperties()->setTitle($po->name);
            $objPHPPowerPoint->getProperties()->setSubject($po->name);
            $objPHPPowerPoint->getProperties()->setDescription($property->mls_description);
            $objPHPPowerPoint->getProperties()->setKeywords(explode('|', $property->keywords)[0]);
            $objPHPPowerPoint->getProperties()->setCategory($property->property_type);
            // Removed first slide
            $objPHPPowerPoint->removeSlideByIndex(0);

            $slides = explode(',', $template);

            for ($i = 0; $i < sizeof($slides); $i++) {
                // Create templated slide
                $currentSlide = $this->createTemplatedSlide($objPHPPowerPoint, $img, $slides[$i], $bg, $profile);
                // Create a shape (text)
                $shape = $currentSlide->createRichTextShape();
                $shape->setHeight(100);
                $shape->setWidth(900);
                $shape->setOffsetX(10);
                $shape->setOffsetY(10);
                $shape->getAlignment()->setHorizontal(PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT);
                // Title of Slide
                $textRun = $shape->createTextRun("$po->name, $property->city $property->state_abbr $property->zipcode");
                $textRun->getFont()->setBold(true);
                $textRun->getFont()->setSize(35);
                $textRun->getFont()->setColor(new PHPPowerPoint_Style_Color('FFFFFFFF'));

                // Create a shape (text)
                $shape = $currentSlide->createRichTextShape();
                $shape->setHeight(100);
                $shape->setWidth(200);
                $shape->setOffsetX(720);
                $shape->setOffsetY(420 - 10 - 40);
                $shape->getAlignment()->setHorizontal(PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT);
                // Contact Information below owner image
                $textRun = $shape->createTextRun("$profile->firstname $profile->lastname");
                $textRun->getFont()->setSize(20);
                $textRun->getFont()->setBold(true);
                $textRun->getFont()->setColor(new PHPPowerPoint_Style_Color('FFFFFFFF'));
                $shape->createBreak();
                $textRun = $shape->createTextRun("$profile->company");
                $textRun->getFont()->setSize(18);
                $textRun->getFont()->setColor(new PHPPowerPoint_Style_Color('FFFFFFFF'));
                $shape->createBreak();
                $shape->createBreak();
                $shape->createBreak();
                $textRun = $shape->createTextRun("$profile->phone");
                $textRun->getFont()->setSize(18);
                $textRun->getFont()->setColor(new PHPPowerPoint_Style_Color('FFFFFFFF'));
                // Create a shape (text)
                $shape = $currentSlide->createRichTextShape();
                $shape->setHeight(100);
                $shape->setWidth(200);
                $shape->setOffsetX(380);
                $shape->setOffsetY(680);

                $textRun = $shape->createTextRun("$profile->email");
                $textRun->getFont()->setSize(16);
                $textRun->getFont()->setColor(new PHPPowerPoint_Style_Color('FFFFFFFF'));
            }
            // add ending slide
            $currentSlide = $objPHPPowerPoint->createSlide();

            // Add Background Image
            $shape = $currentSlide->createDrawingShape();
            $shape->setName('Background');
            $shape->setDescription('Background');
            $shape->setPath(getcwd() . "/resources/images/ppt/bg/" . $bg);
            $shape->setWidth(950);
            $shape->setHeight(720);
            $shape->setOffsetX(0);
            $shape->setOffsetY(0);

            // Create a shape (text)
            $shape = $currentSlide->createRichTextShape();
            $shape->setHeight(100);
            $shape->setWidth(900);
            $shape->setOffsetX(80);
            $shape->setOffsetY(80);
            $shape->getAlignment()->setHorizontal(PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT);
            // Title of Slide
            $textRun = $shape->createTextRun("Contact $profile->firstname TODAY...");
            $textRun->getFont()->setBold(true);
            $textRun->getFont()->setSize(45);
            $textRun->getFont()->setColor(new PHPPowerPoint_Style_Color('FFFFFFFF'));

            // Create a shape (text)
            $shape = $currentSlide->createRichTextShape();
            $shape->setHeight(100);
            $shape->setWidth(900);
            $shape->setOffsetX(80);
            $shape->setOffsetY(220);
            $shape->getAlignment()->setHorizontal(PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT);

            $textRun = $shape->createTextRun("$profile->phone");
            $textRun->getFont()->setSize(50);
            $textRun->getFont()->setBold(true);
            $textRun->getFont()->setColor(new PHPPowerPoint_Style_Color('FFFFFFFF'));
            $shape->createBreak();
            $shape->createBreak();
            $shape->createBreak();
            $textRun = $shape->createTextRun("$profile->email");
            $textRun->getFont()->setSize(40);
            $textRun->getFont()->setColor(new PHPPowerPoint_Style_Color('FFFFFFFF'));

            // Save PowerPoint 2007 file
            $objWriter = PHPPowerPoint_IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
//        $objWriter->save(str_replace('.php', '.pptx', __FILE__));
            $file = $this->_getRandomString() . ".pptx";
            $savePath = $this->_getLocalDirPath(base_url() . OTHERS) . "Classes/files/ppt/$file";
            $objWriter->save($savePath);
            //update property_slideshare_post
            $this->load->model('property_module_model');
            $this->property_module_model->updateSlidesharePost(array('ppt' => $file), $templateNo, $property->id);
            $result = array(
                'result' => "OK",
                'download_url' => base_url() . OTHERS . "Classes/files/ppt/$file",
                'title' => $this->getSlideshareRandomTitle()
            );
            echo json_encode($result);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function createTemplatedSlide(PHPPowerPoint $objPHPPowerPoint, $img, $data, $bg, $profile) {
        $logo = json_decode($profile->logo_image);
        $owner = json_decode($profile->owner_image);

        // Create slide
        $slide = $objPHPPowerPoint->createSlide();

        // Add Background Image
        $shape = $slide->createDrawingShape();
        $shape->setName('Background');
        $shape->setDescription('Background');
        $shape->setPath(getcwd() . "/resources/images/ppt/bg/" . $bg);
        $shape->setWidth(950);
        $shape->setHeight(720);
        $shape->setOffsetX(0);
        $shape->setOffsetY(0);

        // Add Owner Image
        $shape = $slide->createDrawingShape();
        $shape->setName($owner->text);
        $shape->setDescription($owner->text);
        $shape->setPath($this->_getLocalDirPath($owner->image1));
        $shape->setWidth(200);
        $shape->setHeight(270);
        $shape->setOffsetX(725);
        $shape->setOffsetY(150 - 10 - 40);

        // Add Logo Image
        $shape = $slide->createDrawingShape();
        $shape->setName($owner->text);
        $shape->setDescription($owner->text);
        $shape->setPath($this->_getLocalDirPath($logo->image1));
        $shape->setHeight(100);
        $shape->setWidth(150);
        $shape->setOffsetX(750);
        $shape->setOffsetY(650 - 10 - 40);

        // Add Property Image
        $data = explode(' - ', $data);
        $slideImg = json_decode($img->$data[0]);
        $shape = $slide->createDrawingShape();
        $shape->setName($slideImg->text);
        $shape->setDescription($slideImg->text);
        $shape->setPath($this->_getLocalDirPath($slideImg->$data[1]));
        $shape->setHeight(470);
        $shape->setWidth(650);
        $shape->setOffsetX(30);
        $shape->setOffsetY(100);

        $shape = $slide->createRichTextShape();
        $shape->setHeight(100);
        $shape->setWidth(200);
        $shape->setOffsetX(30);
        $shape->setOffsetY(580);
        $shape->getAlignment()->setHorizontal(PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT);

        $textRun = $shape->createTextRun("$slideImg->text");
        $textRun->getFont()->setSize(24);
        $textRun->getFont()->setBold(true);
        $textRun->getFont()->setColor(new PHPPowerPoint_Style_Color('FFFFFFFF'));

        //Return slide
        return $slide;
    }

    function _getLocalDirPath($url) {
        $start = strpos($url, '/resources');
        $path = substr($url, $start);
//        $clean_path = str_replace("/", "\\", $path);
        return getcwd() . $path;
//        return getcwd() . $clean_path;
    }

    function _getRandomString($length = 15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    /*
     * Twitter
     */

    public function generateTwitterBasic() {
        $template_no = $_POST['templateNo'];
        $this->load->model("profile_model");
        $this->load->model("template_model");
        $template = $this->template_model->getSocialTemplate("Twitter", $template_no);

        $poID = $this->session->userdata('poID');
        $po = $this->property_model->getOverview($poID);
        $property = $this->property_model->getProperty($po->property_id);
        $profile = $this->profile_model->getProfile($property->profile_id);
        $result = array(
            "description" => $this->template_model->generateSocialDescription("Twitter", $template->description, $property, $profile)
        );
        echo json_encode($result);
    }

    public function enableTwitterAutoPost() {
        $poId = $this->session->userdata('poID');
        $po = $this->property_model->getOverview($poId);
        $user = $this->session->userdata('user');

        $option = $_POST['option'];
        $data = array(
            'property_id' => $po->property_id,
            'user_id' => $po->user_id,
            'option' => $option,
            'url' => $_POST['url'],
            'autopost' => true
        );

        $valid = true;
        if ($option == "Property Website") {
            $property = $this->property_model->getProperty($po->property_id);
            if (filter_var($property->webpage, FILTER_VALIDATE_URL) === FALSE) {
                $valid = false;
            } else {
                $data['url'] = $property->webpage;
            }
        }
        if ($valid) {
            //check if property_module_twitter already exists
            $result = $this->property_module_model->getPropertyModuleTwitter($po->property_id) ? // check if existing
                    $this->property_module_model->editPropertyModuleTwitter($data, $po->property_id) // if yes edit
                    : $this->property_module_model->addPropertyModuleTwitter($data); // if no add
            if ($result == "OK") {
                echo json_encode(array(
                    'result' => "OK"
                ));
            } else {
                echo json_encode(array(
                    'error' => "Something went wrong in the server :("
                ));
            }
        } else {
            echo json_encode(array(
                'error' => "Property Wesite URL is empty or not valid. Please verify it in <a href='" . base_url() . "property/edit/" . $po->property_id . "'>Edit Property</a>"
            ));
        }
    }

    public function disableTwitterAutoPost() {
        $poId = $this->session->userdata('poID');
        if($poId) {
            $po = $this->property_model->getOverview($poId);
            $result = $this->property_module_model->editPropertyModuleTwitter(array('autopost' => false), $po->property_id);
            if ($result == "OK") {
                echo json_encode(array('result' => "OK"));
            } else {
                echo json_encode(array('error' => "Something wento wrong in the server :("));
            }
        }
    }

}
