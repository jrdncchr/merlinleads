<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Property extends MY_Controller {

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

    /*
     * Shows the dashboard.
     */
    public function index() 
    {
        $user = $this->user;
        $this->load->model('input_model');
        $this->load->model('modules_model');
        $this->data['profiles'] = $this->input_model->getProfilesByUser($user->id);

        try {
            $selectedModule = $this->session->userdata('selectedModule');
            // $this->data['modules'] = $this->modules_model->get_modules("all", true);
            if (null == $selectedModule) {
                $this->data['modules'] = $this->modules_model->get_modules($this->main_f, true);
            } else {
                $this->data['modules'] = $this->modules_model->get_modules($this->main_f, true, $selectedModule);
            }
        } catch(Exception $e) { }

         $this->session->unset_userdata('poID');
         $this->session->unset_userdata('pmID');
         $this->session->unset_userdata('property_id');

        // $this->data['available_modules'] = $this->modules_model->get_modules("all");
         $this->data['available_modules'] = $this->modules_model->get_modules($this->main_f);
        $this->data['subscription'] = $this->subscription;
        $this->title = "Merlin Leads &raquo; Property";
        $this->_renderL('pages/property');
    }

    public function post($id = 0) 
    {
        if ($id > 0) {
            $user = $this->session->userdata('user');
            $po = $this->property_model->getOverview($id);
            $this->load->model('property_post_model');
            if ($user->id == $po->user_id) {
                $this->session->set_userdata('poID', $id);
                $selectedModule = $this->session->userdata('selectedModule');
                $this->load->library('stripe_library');
                // check subscription
//                $subscription = $this->stripe_library->get_main_subscription($user->stripe_customer_id);
//                $this->data['main_subscription'] = $subscription->plan->name;

                $subscriptions = $this->stripe_library->get_subscriptions($user->stripe_customer_id);
                $classified_error_message = "The module selected is not yet activated, please go to Edit Property -> <a href='" . base_url() . "property/edit/$id/classified'>Classified Module Details Tab.</a>";
                if(sizeof($subscriptions) > 0 || $user->type == "admin") {
                    $main_f = $this->main_f;

                    switch ($selectedModule) {
                        // Media Modules
                        case "Youtube":
                        case "Slideshare":
                            $property = $this->property_model->getProperty($po->property_id);
                            $this->load->model('template_model');
                            $this->load->model('profile_model');
                            $template_no = $this->property_module_model->getPropertyMediaNextTemplateNo($selectedModule, $po->property_id) + 1;
                            $this->data['po'] = $po;
                            $this->data['selectedModule'] = $selectedModule;

                            /*
                             * ---- YOUTUBE / SLIDESHARE POSTING FEATURE
                             */
                            $module_feature = $main_f->youtube_posting_templates;

                            if ($selectedModule == "Slideshare") {
                                $module_feature = $main_f->slideshare_posting_templates;
                                $this->load->model('slideshare_model');
                                $images = $this->property_module_model->getPropertyImage($property->id);
                                $available_slides = array();
                                if (null !== $images) {
                                    foreach ($images as $key => $value) {
                                        if ($key != "id" && $key != "property_id" && $key != "category" && $key != "date_created" && $key != "owner_image" && $key != "logo_image") {
                                            $image = json_decode($value);
                                            if ($image) {
                                                $available_slide = [];
                                                $available_slide['text'] = $image->text;
                                                foreach ($image as $k => $v) {
                                                    if ($k != "text" && !strpos($v, 'placeholder')) {
                                                        $available_slide['name'] = "$key - $k";
                                                        $available_slide['image'] = $v;
                                                        $available_slides[] = $available_slide;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                $this->data['availableSlides'] = $available_slides;
                                // get slideshare bg list
                                $bg = $this->slideshare_model->getBackgrounds();
                                if (null !== $bg) {
                                    $this->data['bg'] = $bg;
                                }
                            }
                            $this->data['template_count'] = $this->template_model->getPropertyMediaTemplatesForStaticInput($module_feature, $template_no);
                            $this->title = "Merlin Leads &raquo; Post Property";
                            $this->data['user'] = $this->session->userdata('user');
                            $this->data['features'] = $main_f;
                            $this->js[] = "custom/property_post_" . strtolower($selectedModule) . ".js";
                            $this->_renderL("pages/property_post_" . strtolower($selectedModule));
                            break;

                        // Classified Modules
                        case "Craiglist":
                            $this->load->model('input_model');
                            $property = $this->property_model->getProperty($po->property_id);
                            $module = $this->property_module_model->getClassifiedsModule($property->id);
                            if (null != $module) {
                                if ($module->status == "active") {
                                    $this->data['next'] = $this->_getNextTemplateNo('craiglist', $property->id);
                                    $this->data['nextVideo'] = $this->_getNextTemplateNo('craiglist_video', $property->id);
                                    $this->data['module'] = $module;
                                    $this->data['bath'] = $this->input_model->getClassifiedsBath();
                                    $this->data['housing_type'] = $this->input_model->getClassifiedsHousingType();
                                    $this->data['laundry'] = $this->input_model->getClassifiedsLaundry();
                                    $this->data['parking'] = $this->input_model->getClassifiedsParking();
                                    $this->data['po'] = $po;
                                    $this->data['selectedModule'] = $selectedModule;

                                    $this->title = "Merlin Leads &raquo; Post Property";
                                    $this->data['user'] = $this->session->userdata('user');
                                    $this->js[] = "custom/property_post_craiglist.js";
                                    $this->_renderL('pages/property_post_craiglist');
                                } else {
                                    $_SESSION['message'] = $classified_error_message;
                                    $this->index();
                                }
                            } else {
                                $_SESSION['message'] = $classified_error_message;
                                $this->index();
                            }
                            break;
                        case "Backpage":
                            $property = $this->property_model->getProperty($po->property_id);
                            $module = $this->property_module_model->getClassifiedsModule($property->id);

                            if (null != $module) {
                                if ($module->status == "active") {
                                    $this->data['next'] = $this->_getNextTemplateNo('backpage', $property->id);
                                    $this->data['nextVideo'] = $this->_getNextTemplateNo('backpage_video', $property->id);
                                    $this->data['po'] = $po;
                                    $this->data['selectedModule'] = $selectedModule;

                                    $this->title = "Merlin Leads &raquo; Post Property";
                                    $this->data['user'] = $this->session->userdata('user');
                                    $this->js[] = "custom/property_post_backpage.js";
                                    $this->_renderL('pages/property_post_backpage');
                                } else {
//                                    session_start();
                                    $_SESSION['message'] = $classified_error_message;
                                    $this->index();
                                }
                            } else {
//                                session_start();
                                $_SESSION['message'] = $classified_error_message;
                                $this->index();
                            }
                            break;
                        case "Ebay":
                            $property = $this->property_model->getProperty($po->property_id);
                            $module = $this->property_module_model->getClassifiedsModule($property->id);

                            if (null != $module) {
                                if ($module->status == "active") {
                                    $this->data['next'] = $this->_getNextTemplateNo('ebay', $property->id);
                                    $this->data['nextVideo'] = $this->_getNextTemplateNo('ebay_video', $property->id);
                                    $this->data['po'] = $po;
                                    $this->data['selectedModule'] = $selectedModule;

                                    $this->title = "Merlin Leads &raquo; Post Property";
                                    $this->data['user'] = $this->session->userdata('user');
                                    $this->js[] = "custom/property_post_ebay.js";
                                    $this->_renderL('pages/property_post_ebay');
                                } else {
                                    $_SESSION['message'] = $classified_error_message;
                                    $this->index();
                                }
                            } else {
                                $_SESSION['message'] = $classified_error_message;
                                $this->index();
                            }
                            break;
                        case "Twitter":
                            $user = $this->session->userdata('user');
                            $property = $this->property_model->getProperty($po->property_id);
                            //get twitter template count
                            $this->load->model("template_model");
                            $this->data['template_count'] = $this->template_model->getSocialTemplateCount("Twitter");

                            // get twitter autopost history
                            $this->load->model('property_module_model');
                            $this->data['tweets'] = $this->property_module_model->getPropertyPostTwitter($po->property_id);
                            // get twitter module info
                            $this->data['twitter_module'] = $this->property_module_model->getPropertyModuleTwitter($po->property_id);

                            $this->data['po'] = $po;
                            $this->data['selectedModule'] = $selectedModule;
                            $this->title = "Merlin Leads &raquo; Post Property";
                            $this->data['user'] = $user;
                            $this->js[] = "custom/property_post_twitter.js";
                            $this->_renderL('pages/property_post_twitter');
                            break;
                        default:
                            $_SESSION['message'] = "This module post feature is not yet implemented.";
                            $this->index();
                    }
                } else {
                    $_SESSION['message'] = "You are not subscribed, please upgrade your package in the <a href='" . base_url() . "main/upgrade'>upgrade page.</a>";
                    $this->index();
                }
            } else {
                show_404();
            }
        }
    }

    public function _getNextTemplateNo($module, $property_id) {
        $this->load->model('template_model');
        $templates_count = $this->template_model->getPropertyMediaTemplatesCount($module);

        $template_order = $this->property_module_model->getClassifiedsTemplateOrder($property_id);
        $batch_no = $this->property_module_model->getClassifiedModuleBatchNo($module, $property_id); //default 1

        $used_count = $this->template_model->getUsedTemplatesCount($module, $property_id, $batch_no);

        $templates = explode(',', $template_order->$module);

        if($used_count < $templates_count) {
            $v = $templates[$used_count];
            $this->session->set_userdata($module . "_next_template", array('template_no' => $v, 'batch_no' => $batch_no));
            return $v;
        } else {
            $v = $templates[0];
            $this->session->set_userdata($module . "_next_template", array('template_no' => $v, 'batch_no' => $batch_no + 1));
            return $v;
        }
    }

    public function add() {
        $user = $this->session->userdata('user');
        //get property total
        $this->load->library('stripe_library');
        $subscriptions = $this->stripe_library->get_subscriptions($user->stripe_customer_id);
        if($subscriptions || $user->type == "admin") {
            $available = $this->stripe_library->get_available_property_and_profile($user->stripe_customer_id);
            $available_property = $available['property'];
            //get property count
            $property_count = $this->property_model->getPropertiesCountByUser($user->id);

            /*
             * ------- FOR NUMBER OF PROPERTY FEATURE
             */
            if ($property_count < $available_property || $user->type == "admin" || $available_property == "*") {
                $this->load->model('input_model');
                $selectedProfile = explode(',', $this->session->userdata('selectedProfile'));
                $this->data['selected_profile'] = "<option value='$selectedProfile[0]'>$selectedProfile[1]</option>";
                $this->data['selected_module'] = $this->session->userdata('selectedModule');
                $this->data['property_categories'] = $this->input_model->getPropertyCategories();
                $this->data['sale_types'] = $this->input_model->getSaleTypes();
                $this->data['feature_main'] = $this->input_model->getFeatureMain();
                $this->data['feature_secondary'] = $this->input_model->getFeatureSecondary();

            // CLASSIFIED
                $this->data['bath'] = $this->input_model->getClassifiedsBath();
                $this->data['housing_type'] = $this->input_model->getClassifiedsHousingType();
                $this->data['laundry'] = $this->input_model->getClassifiedsLaundry();
                $this->data['parking'] = $this->input_model->getClassifiedsParking();
                $this->load->model('hs_cta_model');
                $this->data['headlineStatements'] = $this->hs_cta_model->getHsCta("Classified Ads", "Headline Statement");
                $this->data['callToActions'] = $this->hs_cta_model->getHsCta("Classified Ads", "Call to Action");
                $this->data['videoTerms'] = $this->hs_cta_model->getHsCta("Classified Ads", "Video Term");
                $this->data['videoCallToActions'] = $this->hs_cta_model->getHsCta("Classified Ads", "Video Call to Action");
                $this->js[] = "custom/property_module_classifieds.js";

            // MEDIA
                $this->js[] = "custom/property_images.js";

                $this->data['add'] = true;
                $this->title = "Merlin Leads &raquo; Add Property";
                $this->data['h2'] = "Add New Property";
                $this->data['user'] = $user;
                $this->data['redirect'] = "";

                $this->bower_components['js'][] = "cropper/dist/cropper.min.js";
                $this->bower_components['css'][] = "cropper/dist/cropper.min.css";
                $this->js[] = "custom/property_ae.js";
                $this->_renderL('pages/property_ae');
            } else {
                $_SESSION['message'] = "Sorry, you already have maximum used of your available property. <a href='" . base_url() . "main/upgrade'>Upgrade now </a>to be able to create more properties.";
                $this->index();
            }
        } else {
                $_SESSION['message'] = "Sorry, you are not subscribed. <a href='" . base_url() . "main/upgrade'>Upgrade now </a>to be able to create more properties.";
                $this->index();
        }
        
    }

    public function edit($id = 0, $redirect = "") {
        if ($id > 0) {
            $user = $this->session->userdata('user');
            $po = $this->property_model->getOverview($id);
            if ($user->id == $po->user_id) {
                $this->session->set_userdata('property_id', $po->property_id);
                $this->load->model('profile_model');
                // PROPERTY
                $selected_module = $this->session->userdata('selectedModule');
                $property = $this->property_model->getProperty($po->property_id);
                $selectedProfile = explode(',', $this->session->userdata('selectedProfile'));
                $this->data['selected_profile'] = $selectedProfile[0];
                $this->data['selected_module'] = $selected_module;
                $this->data['profiles'] = $this->profile_model->getProfilesByUser($user->id);
                $this->load->model('input_model');
                $this->data['states'] = $this->input_model->getCountryStates($property->country, $property->state_abbr);
                $this->data['property_categories'] = $this->input_model->getPropertyCategories();
                $this->data['sale_types'] = $this->input_model->getSaleTypes($property->sale_type);
                $this->data['feature_main'] = $this->input_model->getFeatureMain($property->main);
                $this->data['feature_secondary'] = $this->input_model->getFeatureSecondary($property->secondary);
                $this->data['property'] = $property;
                $this->data['po'] = $po;
                $this->session->set_userdata('poID', $id);

                $this->data['add'] = false;
                $this->title = "Merlin Leads &raquo; Edit Property";
                $this->data['h2'] = "Edit Property";
                $this->data['user'] = $user;
                $this->js[] = "custom/property_ae.js";

                // CLASSIFIED
                $module = $this->property_module_model->getClassifiedsModule($property->id);
                $this->load->model('input_model');
                if (null != $module) {
                    $this->data['module'] = $module;
                    $this->data['bath'] = $this->input_model->getClassifiedsBath($module->bath);
                    $this->data['housing_type'] = $this->input_model->getClassifiedsHousingType($module->housing_type);
                    $this->data['laundry'] = $this->input_model->getClassifiedsLaundry($module->laundry);
                    $this->data['parking'] = $this->input_model->getClassifiedsParking($module->parking);
                } else {
                    $this->data['bath'] = $this->input_model->getClassifiedsBath();
                    $this->data['housing_type'] = $this->input_model->getClassifiedsHousingType();
                    $this->data['laundry'] = $this->input_model->getClassifiedsLaundry();
                    $this->data['parking'] = $this->input_model->getClassifiedsParking();
                }
                $this->load->model('hs_cta_model');
                $this->data['headlineStatements'] = $this->hs_cta_model->getHsCta("Classified Ads", "Headline Statement");
                $this->data['callToActions'] = $this->hs_cta_model->getHsCta("Classified Ads", "Call to Action");
                $this->data['videoTerms'] = $this->hs_cta_model->getHsCta("Classified Ads", "Video Term");
                $this->data['videoCallToActions'] = $this->hs_cta_model->getHsCta("Classified Ads", "Video Call to Action");
                $this->js[] = "custom/property_module_classifieds.js";

                // IMAGES
                $images = $this->property_module_model->getPropertyImage($property->id);
                if (null == $images) {
                    $this->property_module_model->addPropertyImage($property->id);
                } else {
                    $this->data['images'] = $images;
                }
                $this->data['redirect'] = $redirect;

                $this->bower_components['js'][] = "cropper/dist/cropper.min.js";
                $this->bower_components['css'][] = "cropper/dist/cropper.min.css";
                $this->js[] = "custom/property_images.js";
                $this->_renderL('pages/property_ae');
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function status($status, $id) {
        $this->property_model->updateOverview(array('status' => $status), $id);
        $this->index();
    }

    public function setup() {
        if (null == $_POST['profile']) {
            echo 'No Profile';
        } else {
            $this->session->set_userdata('selectedProfile', $_POST['profile']);
            $this->session->set_userdata('selectedModule', $_POST['module']);
            echo 'OK';
        }
    }

    public function save() {
        $user = $this->session->userdata('user');
        $state = $_POST['state'] != null ? explode(' - ', $_POST['state']) : " - ";

        $property = array(
            'profile_id' => $_POST['profile'], 'property_type' => $_POST['propertyType'],
            'sale_type' => $_POST['saleType'], 'address' => $_POST['address'],
            'city' => $_POST['city'], 'city2' => $_POST['city2'], 'city3' => $_POST['city3'],
            'zipcode' => $_POST['zipcode'], 'country' => $_POST['country'],
            'state_name' => $state[1], 'state_abbr' => $state[0], 'area' => $_POST['area'],
            'mls_description' => $_POST['mlsDescription'], 'mls_id' => $_POST['mlsID'], 'bullets' => $_POST['bullets'],
            'school_district' => $_POST['schooldDistrict'], 'highschool' => $_POST['highschool'],
            'middleschool' => $_POST['middleschool'], 'elementaryschool' => $_POST['elementaryschool'],
            'no_bedrooms' => $_POST['noBedrooms'], 'no_bathrooms' => $_POST['noBathrooms'],
            'building_sqft' => $_POST['buildingSqFt'], 'year_built' => $_POST['yearBuilt'], 'lot_size' => $_POST['lotSize'],
            'main' => $_POST['main'], 'secondary' => $_POST['secondary'],
            'features' => $_POST['features'], 'keywords' => $_POST['keywords'],
            'webpage' => $_POST['propertyWebpageLUrl'], 'driving_instructions' => $_POST['drivingInstructions'],
            'map_url' => $_POST['mapUrl'], 'other_url' => $_POST['otherListingURL'], 'valid' => $_POST['valid']
        );
        $poID = $this->session->userdata('poID');
        if (null == $poID) {
            $propertyID = $this->property_model->addProperty($property);
            $this->load->model('property_post_model');
            $this->load->model('template_model');
            // Propert Overview setup
            $po = array(
                'name' => $_POST['name'],
                'user_id' => $user->id, 'property_id' => $propertyID,
                'status' => 'Edit',
                'craiglist' => "No Post",
                'ebay' => "No Post",
                'backpage' => "No Post",
                'youtube' => "No Post",
                'slideshare' => "No Post",
                'twitter' => 'n/a', 'pinterest' => 'n/a', 'facebook' => 'n/a', 'googleplus' => 'n/a'
            );
            $poID = $this->property_model->addOverview($po);
            $this->session->set_userdata('poID', $poID);
            echo 'OK';
        } else {
            $oldPo = $this->property_model->getOverview($poID);
            $po = array('name' => $_POST['name']);
            if ($this->property_model->updateOverview($po, $oldPo->id) == 'OK') {
                echo $this->property_model->updateProperty($property, $oldPo->property_id);
            }
        }
    }

    public function activate() {
        $id = $this->session->userdata('poID');
        $data = array('status' => 'Active');
        echo $this->property_model->updateOverview($data, $id);
    }

    public function deactivate() {
        $id = $this->session->userdata('poID');
        $data = array('status' => 'Inactive');
        echo $this->property_model->updateOverview($data, $id);
    }

    public function delete() {
        $id = $_POST['id'];
        if ($id > 0) {
            $po = $this->property_model->getOverview($id);
            echo $this->property_model->deleteProperty($po);
        }
    }

    public function getPropertyOverviewDetails($status = 'Active') {
        $user = $this->session->userdata('user');
        $property_overview = $this->property_model->getOverviews($user->id);

        $this->load->model("m2_post_model");

        $data = [];

        foreach($property_overview as $po) {
            if($po->status == $status) {
                $row['poId'] = $po->id;
                $row['propertyId'] = $po->property_id;
                $row['status'] = $po->status;
                $row['propertyName'] = $po->name;

//                var_dump($po);

                //CRAIGLIST
                $craiglist = json_decode($po->craiglist);
                $row['craiglistRegular'] = isset($craiglist->regular) ? $craiglist->regular : 0;
                $row['craiglistRegularHours'] = isset($craiglist->regular_ldp) ? ((time() - strtotime($craiglist->regular_ldp)) / 60) / 60 : 100;
                $row['craiglistVideo'] = isset($craiglist->video) ? $craiglist->video : 0;
                $row['craiglistVideoHours'] = isset($craiglist->video_ldp) ? ((time() - strtotime($craiglist->video_ldp)) / 60) / 60 : 100;

                //EBAY
                $ebay = json_decode($po->ebay);
                $row['ebayRegular'] = isset($ebay->regular) ? $ebay->regular : 0;
                $row['ebayRegularHours'] = isset($ebay->regular_ldp) ? ((time() - strtotime($ebay->regular_ldp)) / 60) / 60 : 100;
                $row['ebayVideo'] = isset($ebay->video) ? $ebay->video : 0;
                $row['ebayVideoHours'] = isset($ebay->video_ldp) ? ((time() - strtotime($ebay->video_ldp)) / 60) / 60 : 100;

                //BACKPAGE
                $backpage = json_decode($po->backpage);
                $row['backpageRegular'] = isset($backpage->regular) ? $backpage->regular : 0;
                $row['backpageRegularHours'] = isset($backpage->regular_ldp) ? ((time() - strtotime($backpage->regular_ldp)) / 60) / 60 : 100;
                $row['backpageVideo'] = isset($backpage->video) ? $backpage->video : 0;
                $row['backpageVideoHours'] = isset($backpage->video_ldp) ? ((time() - strtotime($backpage->video_ldp)) / 60) / 60 : 100;

                //YOUTUBE
                $row['youtube'] = isset($po->youtube) ? $po->youtube : 0;

                //SLIDE SHARE
                $row['slideshare'] = isset($po->slideshare) ? $po->slideshare : 0;

                //TWITTER
                $row['twitter'] = isset($po->twitter) ? $po->twitter : 0;

                //FACEBOOK
                $row['facebook'] = $this->m2_post_model->count(array('module' => 'FACEBOOK', 'user_id' => $user->id, 'property_id' => $po->property_id));

                //GOOGLE PLUS
                $row['googlePlus'] = $this->m2_post_model->count(array('module' => 'GOOGLE_PLUS', 'user_id' => $user->id, 'property_id' => $po->property_id));

                //LINKED IN
                $row['linkedIn'] = $this->m2_post_model->count(array('module' => 'LINKED_IN', 'user_id' => $user->id, 'property_id' => $po->property_id));

                //BLOG
                $row['blog'] = $this->m2_post_model->count(array('module' => 'BLOG', 'user_id' => $user->id, 'property_id' => $po->property_id));


                $data[] = $row;
            }
        }


        echo json_encode(array('data' => $data));
    }


    public function archiveProperty() {
        /*
         * ----- ARCHIVE PROPERTY FEATURE
         */
        if(isset($this->main_f->archive_property) || $this->user->type == 'admin') {
            echo $this->property_model->updateOverview(array('status' => 'Archive'), $_POST['id']);
        } else {
            echo 'You are not allowed to use this feature, please upgrade your subscription.';
        }
        
    }

    public function activateProperty() {
        $id = $_POST['id'];
        $po = $this->property_model->getOverview($id);
        $property = $this->property_model->getProperty($po->property_id);
        if ($property->valid == 'true') {
            echo $this->property_model->updateOverview(array('status' => 'Active'), $id);
        } else {
            echo "<div class='alert alert-warning'><i class='fa fa-warning'></i> The property selected has empty fields that are required. Please validate your property details first.</div>";
        }
    }

    public function getPropertyCategoryTypes() {
        $this->load->model('input_model');
        $category = $_POST['category'];
        echo $this->input_model->getPropertyCategoryTypes($category);
    }

    public function getFeatureCategories() {
        $this->load->model('input_model');
        $main = $_POST['main'];
        $secondary = $_POST['secondary'];
        echo $this->input_model->getFeatureCategories($main, $secondary);
    }

    public function getFeatureSelects() {
        $this->load->model('input_model');
        $main = $_POST['main'];
        $secondary = $_POST['secondary'];
        $category = $_POST['category'];
        echo $this->input_model->getFeatureSelects($main, $secondary, $category);
    }

    public function getOverview() {
        /**
         * Script:    DataTables server-side script for PHP 5.2+ and MySQL 4.1+
         * Notes:     Based on a script by Allan Jardine that used the old PHP mysql_* functions.
         *            Rewritten to use the newer object oriented mysqli extension.
         * Copyright: 2010 - Allan Jardine (original script)
         *            2012 - Kari S�derholm, aka Haprog (updates)
         * License:   GPL v2 or BSD (3-point)
         */
        mb_internal_encoding('UTF-8');

        $aColumns = array('id', 'name', 'status', 'craiglist', 'ebay', 'backpage', 'youtube', 'slideshare', 'twitter', 'pinterest', 'facebook', 'googleplus', 'googleplus');

        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";

        /* DB table to use */
        $sTable = "properties_overview";

        /* Database connection information */
        $gaSql['user'] = DB_USERNAME;
        $gaSql['password'] = DB_PASSWORD;
        $gaSql['db'] = DB_DATABASE;
        $gaSql['server'] = DB_HOST;
        $gaSql['port'] = 3306;

        $user = $this->session->userdata('user');

        $input = &$_GET;
        $gaSql['charset'] = 'utf8';

        /**
         * MySQL connection
         */
        $db = new mysqli($gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db'], $gaSql['port']);
        if (mysqli_connect_error()) {
            die('Error connecting to MySQL server (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }

        if (!$db->set_charset($gaSql['charset'])) {
            die('Error loading character set "' . $gaSql['charset'] . '": ' . $db->error);
        }


        /**
         * Paging
         */
        $sLimit = "";
        if (isset($input['iDisplayStart']) && $input['iDisplayLength'] != '-1') {
            $sLimit = " LIMIT " . intval($input['iDisplayStart']) . ", " . intval($input['iDisplayLength']);
        }


        /**
         * Ordering
         */
        $aOrderingRules = array();
        if (isset($input['iSortCol_0'])) {
            $iSortingCols = intval($input['iSortingCols']);
            for ($i = 0; $i < $iSortingCols; $i++) {
                if ($input['bSortable_' . intval($input['iSortCol_' . $i])] == 'true') {
                    $aOrderingRules[] = "`" . $aColumns[intval($input['iSortCol_' . $i])] . "` "
                            . ($input['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc');
                }
            }
        }

        if (!empty($aOrderingRules)) {
            $sOrder = " ORDER BY " . implode(", ", $aOrderingRules);
        } else {
            $sOrder = "";
        }


        /**
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $iColumnCount = count($aColumns);
//        
        if (isset($input['sSearch']) && $input['sSearch'] != "") {
            $aFilteringRules = array();
            for ($i = 0; $i < $iColumnCount; $i++) {
                if (isset($input['bSearchable_' . $i]) && $input['bSearchable_' . $i] == 'true') {
                    $aFilteringRules[] = "`" . $aColumns[$i] . "` LIKE '%" . $db->real_escape_string($input['sSearch']) . "%'";
                }
            }
            if (!empty($aFilteringRules)) {
                $aFilteringRules = array('(' . implode(" OR ", $aFilteringRules) . ')');
            }
        }

// Individual column filtering
        for ($i = 0; $i < $iColumnCount; $i++) {
            if (isset($input['bSearchable_' . $i]) && $input['bSearchable_' . $i] == 'true' && $input['sSearch_' . $i] != '') {
                $aFilteringRules[] = "`" . $aColumns[$i] . "` LIKE '%" . $db->real_escape_string($input['sSearch_' . $i]) . "%'";
            }
        }
        $sWhere = "WHERE user_id = " . $user->id . " AND status = 'Active'";
        if (!empty($aFilteringRules)) {
            $sWhere = " WHERE user_id = " . $user->id . " AND status = 'Active' " . implode(" AND ", $aFilteringRules);
        }


        /**
         * SQL queries
         * Get data to display
         */
        $aQueryColumns = array();
        foreach ($aColumns as $col) {
            if ($col != ' ') {
                $aQueryColumns[] = $col;
            }
        }

        $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS `" . implode("`, `", $aQueryColumns) . "`
    FROM `" . $sTable . "`" . $sWhere . $sOrder . $sLimit;

        $rResult = $db->query($sQuery) or die($db->error);

// Data set length after filtering
        $sQuery = "SELECT FOUND_ROWS()";
        $rResultFilterTotal = $db->query($sQuery) or die($db->error);
        list($iFilteredTotal) = $rResultFilterTotal->fetch_row();

// Total data set length
        $sQuery = "SELECT COUNT(`" . $sIndexColumn . "`) FROM `" . $sTable . "`";
        $rResultTotal = $db->query($sQuery) or die($db->error);
        list($iTotal) = $rResultTotal->fetch_row();


        /**
         * Output
         */
        $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array(),
        );

        while ($aRow = $rResult->fetch_assoc()) {
            $row = array();
            for ($i = 0; $i < $iColumnCount; $i++) {
                if ($aColumns[$i] == 'version') {
                    // Special output formatting for 'version' column
                    $row[] = ($aRow[$aColumns[$i]] == '0') ? '-' : $aRow[$aColumns[$i]];
                } elseif ($aColumns[$i] != ' ') {
                    // General output
                    $row[] = $aRow[$aColumns[$i]];
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function getOverviewArchive() {
        /**
         * Script:    DataTables server-side script for PHP 5.2+ and MySQL 4.1+
         * Notes:     Based on a script by Allan Jardine that used the old PHP mysql_* functions.
         *            Rewritten to use the newer object oriented mysqli extension.
         * Copyright: 2010 - Allan Jardine (original script)
         *            2012 - Kari S�derholm, aka Haprog (updates)
         * License:   GPL v2 or BSD (3-point)
         */
        mb_internal_encoding('UTF-8');

        $aColumns = array('id', 'name', 'status', 'craiglist', 'ebay', 'backpage', 'youtube', 'slideshare', 'twitter', 'pinterest', 'facebook', 'googleplus', 'googleplus');

        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";

        /* DB table to use */
        $sTable = "properties_overview";

        /* Database connection information */
        $gaSql['user'] = DB_USERNAME;
        $gaSql['password'] = DB_PASSWORD;
        $gaSql['db'] = DB_DATABASE;
        $gaSql['server'] = DB_HOST;
        $gaSql['port'] = 3306;

        $user = $this->session->userdata('user');

        $input = &$_GET;
        $gaSql['charset'] = 'utf8';

        /**
         * MySQL connection
         */
        $db = new mysqli($gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db'], $gaSql['port']);
        if (mysqli_connect_error()) {
            die('Error connecting to MySQL server (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }

        if (!$db->set_charset($gaSql['charset'])) {
            die('Error loading character set "' . $gaSql['charset'] . '": ' . $db->error);
        }


        /**
         * Paging
         */
        $sLimit = "";
        if (isset($input['iDisplayStart']) && $input['iDisplayLength'] != '-1') {
            $sLimit = " LIMIT " . intval($input['iDisplayStart']) . ", " . intval($input['iDisplayLength']);
        }


        /**
         * Ordering
         */
        $aOrderingRules = array();
        if (isset($input['iSortCol_0'])) {
            $iSortingCols = intval($input['iSortingCols']);
            for ($i = 0; $i < $iSortingCols; $i++) {
                if ($input['bSortable_' . intval($input['iSortCol_' . $i])] == 'true') {
                    $aOrderingRules[] = "`" . $aColumns[intval($input['iSortCol_' . $i])] . "` "
                            . ($input['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc');
                }
            }
        }

        if (!empty($aOrderingRules)) {
            $sOrder = " ORDER BY " . implode(", ", $aOrderingRules);
        } else {
            $sOrder = "";
        }


        /**
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $iColumnCount = count($aColumns);
//        
        if (isset($input['sSearch']) && $input['sSearch'] != "") {
            $aFilteringRules = array();
            for ($i = 0; $i < $iColumnCount; $i++) {
                if (isset($input['bSearchable_' . $i]) && $input['bSearchable_' . $i] == 'true') {
                    $aFilteringRules[] = "`" . $aColumns[$i] . "` LIKE '%" . $db->real_escape_string($input['sSearch']) . "%'";
                }
            }
            if (!empty($aFilteringRules)) {
                $aFilteringRules = array('(' . implode(" OR ", $aFilteringRules) . ')');
            }
        }

// Individual column filtering
        for ($i = 0; $i < $iColumnCount; $i++) {
            if (isset($input['bSearchable_' . $i]) && $input['bSearchable_' . $i] == 'true' && $input['sSearch_' . $i] != '') {
                $aFilteringRules[] = "`" . $aColumns[$i] . "` LIKE '%" . $db->real_escape_string($input['sSearch_' . $i]) . "%'";
            }
        }
        $sWhere = "WHERE user_id = " . $user->id . " AND status != 'Active'";
        if (!empty($aFilteringRules)) {
            $sWhere = " WHERE user_id = " . $user->id . " AND status != 'Active' " . implode(" AND ", $aFilteringRules);
        }


        /**
         * SQL queries
         * Get data to display
         */
        $aQueryColumns = array();
        foreach ($aColumns as $col) {
            if ($col != ' ') {
                $aQueryColumns[] = $col;
            }
        }

        $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS `" . implode("`, `", $aQueryColumns) . "`
    FROM `" . $sTable . "`" . $sWhere . $sOrder . $sLimit;

        $rResult = $db->query($sQuery) or die($db->error);

// Data set length after filtering
        $sQuery = "SELECT FOUND_ROWS()";
        $rResultFilterTotal = $db->query($sQuery) or die($db->error);
        list($iFilteredTotal) = $rResultFilterTotal->fetch_row();

// Total data set length
        $sQuery = "SELECT COUNT(`" . $sIndexColumn . "`) FROM `" . $sTable . "`";
        $rResultTotal = $db->query($sQuery) or die($db->error);
        list($iTotal) = $rResultTotal->fetch_row();


        /**
         * Output
         */
        $output = array(
            "sEcho" => intval($input['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array(),
        );

        while ($aRow = $rResult->fetch_assoc()) {
            $row = array();
            for ($i = 0; $i < $iColumnCount; $i++) {
                if ($aColumns[$i] == 'version') {
                    // Special output formatting for 'version' column
                    $row[] = ($aRow[$aColumns[$i]] == '0') ? '-' : $aRow[$aColumns[$i]];
                } elseif ($aColumns[$i] != ' ') {
                    // General output
                    $row[] = $aRow[$aColumns[$i]];
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function getPropertyExcelReport($id, $option) {
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('America/Chicago');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        /** Include PHPExcel */
        require_once OTHERS . "phpexcel/Classes/PHPExcel.php";


        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Get Logged User Details
        $user = $this->session->userdata('user');

        // Set document properties
        $objPHPExcel->getProperties()->setCreator($user->firstname . " " . $user->lastname)
                ->setLastModifiedBy($user->firstname . " " . $user->lastname)
                ->setTitle("Lead Generator Tool - Properties Report")
                ->setSubject("Lead Generator Tool - Properties Report")
                ->setDescription("Reports about the Properties.")
                ->setKeywords("Properties")
                ->setCategory("Properties");

        /// Get Property ID from the Property Overview
        $po = $this->property_model->getOverview($id);
        $property = $this->property_model->getProperty($po->property_id);

        $x = 1;
        $start = "A$x";
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Property Marketing Report");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", $user->firstname . " " . $user->lastname);
        $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("A$x:C$x")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $x++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", $property->address);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", $user->firstname . " " . $user->lastname);
        $x += 2;
        $end = "C$x";
        $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'FFFFFF')));

        // Add Youtube Data
        $youtubeData = $this->property_model->getAllDataOfModule('Youtube', $po->property_id, $option);
        if (null !== $youtubeData) {
            $start = "A$x";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Youtube");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $x++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Headline");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$x", "Link");
            $objPHPExcel->getActiveSheet()->getStyle("B$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", "Date Posted");
            $objPHPExcel->getActiveSheet()->getStyle("C$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()
                    ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array('rgb' => 'DB2725')
            ));
            $x++;
            $start = "A$x";
            for ($i = 0; $i < sizeof($youtubeData); $i++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", $youtubeData[$i]->title);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$x", $youtubeData[$i]->link);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", $youtubeData[$i]->date_created);
                $x++;
            }
            $x++;
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'FFFFFF')));
        }

        // Add SlideShare Data
        $slideshareData = $this->property_model->getAllDataOfModule('Slideshare', $po->property_id, $option);
        if (null !== $slideshareData) {
            $start = "A$x";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Slideshare");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $x++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Headline");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$x", "");
            $objPHPExcel->getActiveSheet()->getStyle("B$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", "Date Posted");
            $objPHPExcel->getActiveSheet()->getStyle("C$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()
                    ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array('rgb' => 'lightgrey')
            ));
            $x++;
            $start = "A$x";
            for ($i = 0; $i < sizeof($slideshareData); $i++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", $slideshareData[$i]->title);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", $slideshareData[$i]->date_created);
                $x++;
            }
            $x++;
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'FFFFFF')));
        }

        // Add Craiglist Data
        $craiglistData = $this->property_model->getAllDataOfModule('Craiglist', $po->property_id, $option);
        if (null !== $craiglistData) {
            $start = "A$x";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Craiglist");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $x++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Headline");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$x", "");
            $objPHPExcel->getActiveSheet()->getStyle("B$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", "Date Posted");
            $objPHPExcel->getActiveSheet()->getStyle("C$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()
                    ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array('rgb' => '5D018F')
            ));
            $x++;
            $start = "A$x";
            for ($i = 0; $i < sizeof($craiglistData); $i++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", $craiglistData[$i]->title);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", $craiglistData[$i]->date_created);
                $x++;
            }
            $x++;
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'FFFFFF')));
        }

        // Add Craiglist Video Data
        $craiglistVideoData = $this->property_model->getAllDataOfModule('Craiglist Video', $po->property_id, $option);
        if (null !== $craiglistVideoData) {
            $start = "A$x";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Craiglist Video");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $x++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Headline");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$x", "");
            $objPHPExcel->getActiveSheet()->getStyle("B$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", "Date Posted");
            $objPHPExcel->getActiveSheet()->getStyle("C$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()
                    ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array('rgb' => '5D018F')
            ));
            $x++;
            $start = "A$x";
            for ($i = 0; $i < sizeof($craiglistVideoData); $i++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", $craiglistVideoData[$i]->title);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", $craiglistVideoData[$i]->date_created);
                $x++;
            }
            $x++;
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'FFFFFF')));
        }

        // Add Backpage Data
        $backpageData = $this->property_model->getAllDataOfModule('Backpage', $po->property_id, $option);
        if (null !== $backpageData) {
            $start = "A$x";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Backpage");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $x++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Headline");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$x", "");
            $objPHPExcel->getActiveSheet()->getStyle("B$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", "Date Posted");
            $objPHPExcel->getActiveSheet()->getStyle("C$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()
                    ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array('rgb' => '5C80BB')
            ));
            $x++;
            $start = "A$x";
            for ($i = 0; $i < sizeof($backpageData); $i++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", $backpageData[$i]->title);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", $backpageData[$i]->date_created);
                $x++;
            }
            $x++;
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'FFFFFF')));
        }

        // Add Backpage Video Data
        $backpageVideoData = $this->property_model->getAllDataOfModule('Backpage Video', $po->property_id, $option);
        if (null !== $backpageVideoData) {
            $start = "A$x";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Backpage Video");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $x++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Headline");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$x", "");
            $objPHPExcel->getActiveSheet()->getStyle("B$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", "Date Posted");
            $objPHPExcel->getActiveSheet()->getStyle("C$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()
                    ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array('rgb' => '5C80BB')
            ));
            $x++;
            $start = "A$x";
            for ($i = 0; $i < sizeof($backpageVideoData); $i++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", $backpageVideoData[$i]->title);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", $backpageVideoData[$i]->date_created);
                $x++;
            }
            $x++;
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'FFFFFF')));
        }

        // Add Ebay Data
        $ebayData = $this->property_model->getAllDataOfModule('Ebay', $po->property_id, $option);
        if (null !== $ebayData) {
            $start = "A$x";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Ebay");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $x++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Headline");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$x", "");
            $objPHPExcel->getActiveSheet()->getStyle("B$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", "Date Posted");
            $objPHPExcel->getActiveSheet()->getStyle("C$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()
                    ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array('rgb' => 'E73039')
            ));
            $x++;
            $start = "A$x";
            for ($i = 0; $i < sizeof($ebayData); $i++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", $ebayData[$i]->title);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", $ebayData[$i]->date_created);
                $x++;
            }
            $x++;
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'FFFFFF')));
        }

        // Add Ebay Data
        $ebayVideoData = $this->property_model->getAllDataOfModule('Ebay Video', $po->property_id, $option);
        if (null !== $ebayVideoData) {
            $start = "A$x";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Ebay Video");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $x++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", "Headline");
            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$x", "");
            $objPHPExcel->getActiveSheet()->getStyle("B$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", "Date Posted");
            $objPHPExcel->getActiveSheet()->getStyle("C$x")->getFont()->setBold(true)->getColor()->setRGB('ffffff');
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()
                    ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array('rgb' => 'E73039 ')
            ));
            $x++;
            $start = "A$x";
            for ($i = 0; $i < sizeof($ebayVideoData); $i++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", $ebayVideoData[$i]->title);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$x", $ebayVideoData[$i]->date_created);
                $x++;
            }
            $x++;
            $end = "C$x";
            $objPHPExcel->getActiveSheet()->getStyle("$start:$end")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'FFFFFF')));
        }

        $objPHPExcel->getActiveSheet()->getStyle("A$x:C$x")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        foreach (range('A1', 'E500') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
        }

        for ($i = 1; $i < $x; $i++) {
            if ($i % 5 == 0) {
                $objPHPExcel->getActiveSheet()->getStyle("A$i:C$i")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            }
        }
        $objPHPExcel->getActiveSheet()->getStyle("C1:C$x")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


// Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Property Report');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client�s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="lgt.xls"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    function _getModuleCategory($module) {
        if ($module == "Craiglist" || $module == "Backpage" || $module == "Ebay") {
            return "Classified";
        } else if ($module == "Twitter" || $module == "Facebook" || $module == "Google+" || $module == "LinkedIn") {
            return "Social";
        } else if ($module == "Youtube" || $module == "Slideshare") {
            return "Media";
        }
    }

    function event_notification($property_id = 0)
    {
        $this->load->model('events_model');
        $this->load->model('events_templates_model');

        $action = $this->input->post('action');
        if ($action) {
            switch ($action) {
                case 'get_templates' :
                    $event_id = $this->input->post('event_id');
                    $type = $this->input->post('type');
                    if ($type == 'merlin') {
                        $result = $this->events_templates_model->get(array('event_id' => $event_id));
                    } else {
                        $result = $this->events_templates_model->get_custom(array('event_id' => $event_id));
                    }
                    echo json_encode($result);
                    break;
                case 'save_event_settings' :
                    $event_settings = $this->input->post('event_settings');
                    $result = $this->events_model->save_event_settings($event_settings);
                    echo json_encode($result);
                    break;
                default:
                    echo json_encode(array('success' => false));
            }
        } else {
            if ((int)$property_id > 0) {
                $po = $this->property_model->getOverview($property_id);
                if ($this->user->id == $po->user_id) {
                    $this->data['property'] = $this->property_model->getProperty($po->property_id);
                    $this->data['classified_module'] = $this->property_module_model->getClassifiedsModule($this->data['property']->id);
                    $this->data['merlin_templates'] = $this->events_templates_model->get(array('active' => 1));
                    $this->data['custom_templates'] = $this->events_templates_model->get_custom(array('user_id' => $this->user->id));

                    $event_settings = $this->events_model->get_event_settings();
                    if (!$event_settings) {
                        $this->events_model->add_event_settings($this->user);
                        $event_settings = $this->events_model->get_event_settings();
                    }
                    $this->data['event_settings'] = $event_settings;

                    $this->_renderL('pages/event_notification');
                }
            }
        }
    }

}
