<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class User_Model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    public function get($id = 0) {
        if ($id == 0) {
            $result = $this->db->get('users');
            if ($result->num_rows() > 0) {
                return $result->result();
            }
        } else {
            $result = $this->db->get_where('users', array('id' => $id));
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return null;
            }
        }
    }

    public function getByEmail($email) {
        $result = $this->db->get_where('users', array('email' => $email));
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return null;
        }
    }

    public function add($user) {
        $this->db->insert('users', $user);
        return true;
    }

    public function update($update, $id) {
        $this->db->where('id', $id);
        $this->db->update('users', $update);

        $user = $this->db->get_where('users', array('id' => $id));
        $this->load->library('session');
        $this->session->set_userdata('user', $user->row());
//        session_start();
        $_SESSION['user'] = $user->row();
        echo "OK";
    }

    public function updateByUsername($update, $username) {
        $this->db->where('username', $username);
        $this->db->update('users', $update);
        echo "OK";
    }

    public function updateUser($update, $id) {
        $this->db->where('id', $id);
        $this->db->update('users', $update);
        echo "OK";
    }

    public function updateUserFP($update, $id) {
        $this->db->where('id', $id);
        $this->db->update('users', $update);
        return "OK";
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('users');
        echo "OK";
    }

    public function deleteByStripeId($id) {
        $this->db->where('stripe_customer_id', $id);
        return $this->db->delete('users');
    }

    public function checkUsername($username) {
        $result = $this->db->get_where('users', array('username' => $username));
        if ($result->num_rows() < 1) {
            echo "OK";
        }
    }

    public function checkEmail($email) {
        $result = $this->db->get_where('users', array('email' => $email));
        if ($result->num_rows() < 1) {
            echo "OK";
        }
    }

    public function checkEmailFP($email) {
        $result = $this->db->get_where('users', array('email' => $email));
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return null;
        }
    }

    public function login($email, $password) {
        $result = $this->db->get_where('users', array('email' => $email));
        if ($result->num_rows() > 0) {
            $user = $result->row();
            if ($this->_validatePassword($password, $user)) {
                if ($user->status == "active") {
                    session_start();
                    $_SESSION['user'] = $user;
                    $this->load->library('session');
                    $this->session->set_userdata('user', $user);
                    return "OK";
                } else {
                    return "Login failed, please confirm your email address.";
                }
            } else {
                return "Login failed, incorrect email/password.";
            }
        } else {
            return "Login failed, incorrect email/password.";
        }
    }

    public function _validatePassword($p, $u) {
        include OTHERS . "PasswordHash.php";
        $this->load->model('user_model');
        $password = $p . $u->salt;
        return validate_password($password, $u->password);
    }

    public function confirm_email($email, $key) {
        if ($this->db->update('users', array('status' => 'active'), array('email' => $email, 'confirmation_key' => $key))) {
            return "OK";
        } else {
            return "FAILED";
        }
    }

}
