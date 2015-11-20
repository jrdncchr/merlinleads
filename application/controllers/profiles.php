<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Profiles extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url());
        }
        $this->load->model('profile_model');
    }

    public function index()
    {
        //get user info
        $user = $this->session->userdata('user');

        $this->title = "Merlin Leads &raquo; Profiles";
        $this->data['user'] = $user;
        $this->js[] = "custom/profiles.js";
        $this->_renderL('pages/profiles');
    }

    public function add($type = "aab")
    {
        $this->title = "Merlin Leads &raquo; Add Profile";
        $user = $this->session->userdata('user');
        $this->data['user'] = $user;
        $this->data['h2'] = "Add Profile";
        $this->session->unset_userdata('profileID');

        //get profiles total
        $this->load->library('stripe_library');
        $subscriptions = $this->stripe_library->get_subscriptions($user->stripe_customer_id);
        if($subscriptions) {
            $available = $this->stripe_library->get_available_property_and_profile($user->stripe_customer_id);
            $available_profiles = $available['profile'];
            //get profiles count
            $profiles_count = $this->profile_model->getProfilesCount($user->id);

            /*
             * ------- FOR NUMBER OF PROFILE FEATURE
             */
            if ($profiles_count < $available_profiles || $user->type == "admins" || $available_profiles == "*") {
                if ($type == "aab") {
                    $this->js[] = "custom/profiles_aab.js";
                    $this->_renderL('pages/profiles_aab');
                } else if ($type == "cac") {
                    $this->_renderL('pages/profiles_cac');
                }
            } else {
                $_SESSION['message'] = "Sorry, you already have maximum used of your available profiles. <a href='" . base_url()  ."main/upgrade'>Upgrade now </a>to be able to create more profiles.";
                $this->index();
            }    
        } else {
            $_SESSION['message'] = "Sorry, you are not yet subscribed. <a href='" . base_url()  ."main/upgrade'>Upgrade now </a>to be able to create more profiles.";
            $this->index();
        }
        
    }

    public function edit($id = 0)
    {
        $profile = $this->profile_model->getProfile($id);
        if ($profile != null) {
            $user = $this->session->userdata('user');
            if ($profile->user_id == $user->id) {
                $this->data['profile'] = $profile;
                $this->data['user'] = $user;
                $this->session->unset_userdata('profileID');
                $this->session->set_userdata('profileID', $id);

                $this->title = "Merlin Leads &raquo; Edit Profile";
                $this->data['h2'] = "Edit Profile";
                if ($profile->type == "Agent and Broker") {
                    $this->js[] = "custom/profiles_aab.js";
                    $this->_renderL('pages/profiles_aab');
                } else if ($profile->type == "Contact and Company") {
                    $this->_renderL('pages/profiles_cac');
                }
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function save()
    {
        $user = $this->session->userdata('user');
        $profile = array(
            'user_id' => $user->id,
            'type' => $_POST['profileType'],
            'name' => $_POST['profileName'],
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'company' => $_POST['company'],
            'slogan' => $_POST['slogan'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'webpage' => $_POST['contactWebpage'],
            'testimonials' => $_POST['testimonials'],
            'year_started' => $_POST['yearStarted'],
            'about' => $_POST['about'],
            'free_search_link' => $_POST['linkFreeSearch'],
            'current_listing_link' => $_POST['linkCurrentListing'],
            'company_website' => $_POST['companyWebsite'],
            'broker_name' => $_POST['brokerName'],
            'broker_address' => $_POST['brokerAddress'],
            'broker_phone' => $_POST['brokerPhone'],
            'broker_license' => $_POST['brokerLicenseNo'],
            'listing_book_url' => $_POST['listingBookUrl'],
            'facebook_url' => $_POST['facebookUrl'],
            'twitter_url' => $_POST['twitterUrl'],
            'linkedin_url' => $_POST['linkedInUrl'],
            'youtube_channel_url' => $_POST['youtubeChannelUrl']
            );

$profileID = $this->session->userdata('profileID');
if (null == $profileID) {
            // First Save Attempt so ADD
    $profile['status'] = 'Edit';
    $profileID = $this->profile_model->addProfile($profile);
    $this->session->set_userdata('profileID', $profileID);
    echo 'OK';
} else {
    echo $this->profile_model->updateProfile($profile, $profileID);
}
}

public function updateProfileImage()
{
    $profile_id = $this->session->userdata('profileID');
    $update = array();
    $update[$_POST['field']] = json_encode(array(
        'image1' => $_POST['image1'],
        'image2' => $_POST['image2'],
        'image3' => $_POST['image3'],
        'text' => $_POST['text']
        ));
    echo $this->profile_model->updateProfile($update, $profile_id);
}

public function updateProfileImageAll()
{
    $profile_id = $this->session->userdata('profileID');
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
    echo $this->profile_model->updateProfile($update, $profile_id);
}

public function delete()
{
    $id = $_POST['id'];
    if ($id > 0) {
        $profile = $this->profile_model->getProfile($id);
        echo $this->profile_model->deleteProfile($profile->id);
    }
}

public function activate()
{
    $id = $this->session->userdata('profileID');
    $profile = array('status' => 'Active');
    echo $this->profile_model->updateProfile($profile, $id);
}

public function deactivate()
{
    $id = $this->session->userdata('profileID');
    $profile = array('status' => 'Inactive');
    echo $this->profile_model->updateProfile($profile, $id);
}

public function getProfiles()
{
    mb_internal_encoding('UTF-8');

    $aColumns = array('id', 'name', 'type', 'status');

    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "id";

    /* DB table to use */
    $sTable = "profiles";

    /* Database connection information */
    $gaSql['user'] = DB_USERNAME;
    $gaSql['password'] = DB_PASSWORD;
    $gaSql['db'] = DB_DATABASE;
    $gaSql['server'] = DB_HOST;
    $gaSql['port'] = 3306;

    $user = $this->session->userdata('user');
    // Input method (use $_GET, $_POST or $_REQUEST)
    $input = &$_GET;

        /**         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP server-side, there is
         * no need to edit below this line
         */
        /**
         * Character set to use for the MySQL connection.
         * MySQL will return all strings in this charset to PHP (if the data is stored correctly in the database).
         */
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
                    $aOrderingRules[] =
                    "`" . $aColumns[intval($input['iSortCol_' . $i])] . "` "
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
        $sWhere = "WHERE user_id = " . $user->id;
        if (!empty($aFilteringRules)) {
            $sWhere = " WHERE user_id = " . $user->id . implode(" AND ", $aFilteringRules);
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

}