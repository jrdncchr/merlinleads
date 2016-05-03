<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Templates_Lib_Properties {
    /*
     *  In the content, it will get all the [shortcodes] and put them in an array, 
     *  then loop each to replace the [shortcode] by its equivalent value using the method 'getScValue'
     */

    public function generateContent($content, $property, $profile, $module) {
        preg_match_all("/\[.*?\]/", $content, $matches);
        $sc = $matches[0];
        for ($i = 0; $i < sizeof($sc); $i++) {
            $value = $this->getScValue($sc[$i], $property, $profile, $module);
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

    public function getScValue($sc, $property, $profile, $module) {
        if (strpos($sc, 'Keyword') !== false) {
            $no = filter_var($sc, FILTER_SANITIZE_NUMBER_INT) - 1;
            $sc = "[Keyword]";
        }
        if (strpos($sc, '[Bullet') !== false) {
            $no = filter_var($sc, FILTER_SANITIZE_NUMBER_INT) - 1;
            $sc = "[Bullet]";
        }
        if (strpos($sc, 'Testimonial') !== false) {
            $no = filter_var($sc, FILTER_SANITIZE_NUMBER_INT) - 1;
            $sc = "[Testimonial]";
        }
        if (strpos($sc, 'Feature') !== false) {
            $no = filter_var($sc, FILTER_SANITIZE_NUMBER_INT) - 1;
            $sc = "[Feature]";
        }
        if (strpos($sc, 'Headline Statement') !== false) {
            $no = filter_var($sc, FILTER_SANITIZE_NUMBER_INT) - 1;
            $sc = "[Headline Statement]";
        }
        if (strpos($sc, 'Video Term') !== false) {
            $no = filter_var($sc, FILTER_SANITIZE_NUMBER_INT) - 1;
            $sc = "[Video Term]";
        }
        if (strpos($sc, 'Video-CTA Statement') !== false) {
            $no = abs(filter_var($sc, FILTER_SANITIZE_NUMBER_INT)) - 1;
            $sc = "[Video-CTA Statement]";
        } else if (strpos($sc, 'CTA Statement') !== false) {
            $no = filter_var($sc, FILTER_SANITIZE_NUMBER_INT) - 1;
            $sc = "[CTA Statement]";
        }

        switch ($sc) {
            case "[Agent First Name]": return $profile->firstname;
            case "[Agent Last Name]": return $profile->lastname;
            case "[Agent Company Name]": return $profile->company;
            case "[Agent Slogan]": return $profile->slogan;
            case "[Agent Email]": return $profile->email;
            case "[Agent Phone]": return $profile->phone;
            case "[Agent Contact Page]": return $profile->webpage;
            case "[Testimonial]": return explode('|', $profile->testimonials)[intval($no)];
            case "[Year Started]": return $profile->year_started;
            case "[Agent About]": return $profile->about;
            case "[Free Search Link]": return $profile->free_search_link;
            case "[Current Listings Link]": return $profile->current_listing_link;
            case "[Broker Name]": return $profile->broker_name;
            case "[Broker Address]": return $profile->broker_address;
            case "[Broker Phone]": return $profile->broker_phone;
            case "[Broker License #]":
            case "[Broker License]": return $profile->broker_license;
            case "[Company Link]": return $profile->company_website;
            case "[Company Name]": return $profile->company;
            case "[Profile Listing Book Url]": return $profile->listing_book_url;
            case "[Profile Facebook Url]": return $profile->facebook_url;
            case "[Profile Twitter Url]": return $profile->twitter_url;
            case "[Profile LinkedIn Url]": return $profile->linkedin_url;
            case "[Profile Youtube Channel Url]": return $profile->youtube_channel_url;

            case "[Main Term]": return $property->main;
            case "[Secondary Term]": return $property->secondary;
            case "[Property Type]": return $property->property_type;
            case "[Sales Type]": return $property->sale_type;
            case "[Address]": return $property->address;
            case "[City]": return $property->city;
            case "[City2]": return $property->city2;
            case "[City3]": return $property->city3;
            case "[State]": return $property->state_name;
            case "[State Abbr]": return $property->state_abbr;
            case "[Zipcode]": return $property->zipcode;
            case "[County]": return $property->country;
            case "[Area]": return $property->area;
            case "[MLS ID]": return $property->mls_id;
            case "[MLS Main Description]": return $property->mls_description;
            case "[Bed]": return $property->no_bedrooms;
            case "[Bath]": return $property->no_bathrooms;
            case "[Building Sq Ft]": return $property->building_sqft;
            case "[Building SqFt]": return $property->building_sqft;
            case "[Lot Size]": return $property->lot_size;
            case "[Year Built]": return $property->year_built;
            case "[Property Link]": return $property->webpage;
            case "[District Name]": return $property->school_district;
            case "[School High]": return $property->highschool;
            case "[School Middle]": return $property->middleschool;
            case "[School Elementary]": return $property->elementaryschool;
            case "[Driving Instructions]": return $property->driving_instructions;
            case "[Map URL]": return $property->map_url;
            case "[Map Link]": return $property->map_url;
            case "[Other Listing Link]": return $property->other_url;
            case "[Listing Link]": return $property->webpage;
            case "[Keyword]": return explode('|', $property->keywords)[intval($no)];
            case "[Bullet]": return explode('|', $property->bullets)[intval($no)];
            case "[Feature]": return explode('|', $property->features)[intval($no)];

            case "[Headline Statement]": return explode('|', $module->headline_statements)[intval($no)];
            case "[Open House Date]": return $module->oh_date;
            case "[Open House Start Time]": return $module->oh_start_time;
            case "[Open House End Time]": return $module->oh_end_time;
            case "[Open House Notes]": return $module->oh_notes;
            case "[CTA Statement]": return explode('|', $module->cta)[intval($no)];
            case "[Ad tags]": return $module->ad_tags;
            case "[Building SqFt]": return $property->building_sqft;
            case "[Price]": return $module->price;
            case "[CL-Bath]": return $module->bath;
            case "[Housing Type]": return $module->housing_type;
            case "[Laundry]": return $module->laundry;
            case "[Parking]": return $module->parking;
            case "[Wheelchair]": return $module->wheelchair_accessible;
            case "[No Smoking]": return $module->no_smoking;
            case "[Furnished]": return $module->furnished;
            case "[Cross Street]": return $module->cross_street;
            case "[Video-CTA Statement]": return explode('|', $module->video_cta)[$no];
            case "[CL Video Link]": return $module->youtube_url;
            case "[Video Term]": return explode('|', $module->video_term)[$no];

            case "[Youtube Link]":
                if (isset($module->link)) {
                    return $module->link;
                }
                break;
            case "[Short Listing Link]":
                return $this->shorten_url($property->webpage);
                break;
            default: return $sc;
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