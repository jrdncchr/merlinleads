<?php

class MY_Session extends CI_Session {

    function set_userdata($newdata = array(), $newval = '', $write_session = true)
    {
        if (is_string($newdata))
        {
            $newdata = array($newdata => $newval);
        }

        if (count($newdata) > 0)
        {
            foreach ($newdata as $key => $val)
            {
                $this->userdata[$key] = $val;
            }
        }

// Do not write the session (set the cookies) unless explicitly specified
        if ($write_session) {
            $this->sess_write();
        }
    }

    function set_flashdata($newdata = array(), $newval = '')
    {
        if (is_string($newdata))
        {
            $newdata = array($newdata => $newval);
        }

        if (count($newdata) > 0)
        {
            foreach ($newdata as $key => $val)
            {
                $flashdata_key = $this->flashdata_key.':new:'.$key;
                $this->set_userdata($flashdata_key, $val, false); // Do not update the cookie in the foreach
            }
        }

// Save the cookie now that all userdata has been set
        $this->sess_write();
    }

    function _flashdata_mark()
    {
        $userdata = $this->all_userdata();
        $newUserData = array();
        $userDataToUnset = array();
        foreach ($userdata as $name => $value)
        {
            $parts = explode(':new:', $name);
            if (is_array($parts) && count($parts) === 2)
            {
                $new_name = $this->flashdata_key.':old:'.$parts[1];
                $newUserData[$new_name] = $value;
                $userDataToUnset[$name] = '';
// Cookies were originally set in this loop. Moved to the end of the function
            }
        }

// Save all changes outside of the loop
        if (count($newUserData) > 0) {
            $this->set_userdata($newUserData);
            $this->unset_userdata($userDataToUnset);
        }
    }
}
?>