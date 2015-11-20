<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class SEO_Templates {

    public function generate_template($template, $data) {
        $generated_content = "";
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $template) as $line) {
            if(strstr($line, PHP_EOL)) {
                $generated_content .= PHP_EOL;
            } else {
                $generated_content .= $this->generate_content($line, $data);
            }
        }
        return $generated_content;
    }

    /*
     *  In the content, it will get all the [shortcodes] and put them in an array, 
     *  then loop each to replace the [shortcode] by its equivalent value using the method 'getScValue'
     *  Data should contain = details, profile, search_criteria
     */



    public function generate_content($content, $data) {
        preg_match_all("/\[.*?\]/", $content, $matches);
        $sc = $matches[0];
        for ($i = 0; $i < sizeof($sc); $i++) {
            $value = $this->get_sc_val($sc[$i], $data);
            if (strlen($value) < 1) {
                return "";
            } else {
                $content = str_replace($sc[$i], $value, $content);
            }
        }
        return $content;
    }

    /*
     * This method changes the [shortcode] passed to its equivalent value
     * from the passed property, profile or module data.
     */

    public function get_sc_val($sc, $data) {
        if (strpos($sc, 'Testimonial') !== false) {
            $no = filter_var($sc, FILTER_SANITIZE_NUMBER_INT) - 1;
            $sc = "[Testimonial]";
        }

        switch ($sc) {

            //PROPERTY
            case "[Status]": return $data->status;
            case "[Name]": return $data->name;
            case "[Bathrooms]": return $data->bathrooms;
            case "[Bedrooms]": return $data->bedrooms;
            case "[Square Ft]": return $data->square_ft;
            case "[Acres]": return $data->acres;
            case "[Min Price]": return $data->min_price;
            case "[Max Price]": return $data->max_price;

            //LOCATION
            case "[City]": return $data->city->city_name;
            case "[Zip Code]": return $data->city->zip_code;
            case "[State]": return $data->city->state;
            case "[State Abbr]": return $data->city->state_abbr;

            //CATEGORY
            case "[Category]": return $data->category->category_name;
            case "[Sub Category]": return $data->sub_category;

            //PROFILE
            case "[Agent First Name]": return $data->profile->firstname;
            case "[Agent Last Name]": return $data->profile->lastname;
            case "[Agent Company Name]": return $data->profile->company;
            case "[Agent Slogan]": return $data->profile->slogan;
            case "[Agent Email]": return $data->profile->email;
            case "[Agent Phone]": return $data->profile->phone;
            case "[Agent Contact Page]": return $data->profile->webpage;
            case "[Testimonial]": return explode('|', $data->profile->testimonials)[intval($no)];
            case "[Year Started]": return $data->profile->year_started;
            case "[Agent About]": return $data->profile->about;
            case "[Free Search Link]": return $data->profile->free_search_link;
            case "[Current Listings Link]": return $data->profile->current_listing_link;
            case "[Broker Name]": return $data->profile->broker_name;
            case "[Broker Address]": return $data->profile->broker_address;
            case "[Broker Phone]": return $data->profile->broker_phone;
            case "[Broker License #]": return $data->profile->broker_license;
            case "[Company Link]": return $data->profile->company_website;
            case "[Company Name]": return $data->profile->company;
            case "[Profile Listing Book Url]": return $data->profile->listing_book_url;
            case "[Profile Facebook Url]": return $data->profile->facebook_url;
            case "[Profile Twitter Url]": return $data->profile->twitter_url;
            case "[Profile LinkedIn Url]": return $data->profile->linkedin_url;
            case "[Profile Youtube Channel Url]": return $data->profile->youtube_channel_url;

            //OTHERS
            case "[IDX Link Signup]": return "<a href='http://www.idxbroker.com/features/custom-lead-signup-form'>IDX Sign Up</a>";
            case "[IDX Link Contact]": return "<a href='http://www.idxbroker.com/contact_idx'>IDX Contact</a>";


            default:
                //SEARCH CRITERIA
                foreach($data->inputs as $input) {
                    if($input->short_code == $sc) {
                        foreach($data->search_criteria as $k => $v) {
                            if($k == $input->field_id) {
                                return $v;
                            }
                        }
                    }
                }
                return $sc;
        }
    }

    /*
     *  Shorten a URL using google api url shortener
     */
    function shorten_url($longUrl) {
        $apiKey = 'AIzaSyDPCJHu5W3j3GNrFIBtPK7aWB_Fq82-Gzc';

        $postData = array('longUrl' => $longUrl);
        $jsonData = json_encode($postData);

        $curlObj = curl_init();

        curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key=' . $apiKey);
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($curlObj, CURLOPT_POST, 1);
        curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

        $response = curl_exec($curlObj);
        $json = json_decode($response);

        curl_close($curlObj);
        return $json->id;
    }

}