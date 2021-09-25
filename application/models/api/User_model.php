<?php

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_user($user)
    {

        $this->db->insert("user", $user);
        return $insert_id = $this->db->insert_id();

    }
    public function insert_user($data)
    {

        return $this->db->insert_batch("prefilled", $data);
    }

    public function update_userType($id, $member)
    {
            $this->db->where("id", $id);
            return $this->db->update("usertype", $member);
    }

    public function add_loginlogs($loginlogs)
    {

        return $this->db->insert("loginlogs", $loginlogs);
    }

    public function getUser($userid)
    {
        $this->db->where("id", $userid);
        $this->db->from("user");
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }
    
    public function fetch_Alluser()
    {
        $this->db->from("user");
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function exist_user($email, $password)
    {
        $this->db->where("email", $email);
        $this->db->where("password", $password);
       // $this->db->where("password", md5($password));
         $this->db->from("user");
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function check_token($token)
    {
        $this->db->where("token", $token);
        $this->db->from("user");
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function update_loginlogs($id, $logdata)
    {
        $this->db->where("id", $id);
        return $this->db->update("loginlogs", $logdata);
    }

    public function update_token($id, $token)
    {
        $this->db->where("id", $id);
        return $this->db->update("user", $token);
    }
    public function check_loguserId($userid)
    {
        $this->db->where("userId", $userid);
        $this->db->from("loginlogs");
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function checkuserName($username)
    {
        $this->db->where("username", $username);
        $this->db->from("user");
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function check_email($email)
    {
        $this->db->where("email", $email);
        $this->db->from("user");
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function fetch_userType()
    {
        $this->db->select('*');
        $this->db->from("usertype");
        $query = $this->db->get();
        return $query->result();

    }

    public function get_userType($id)
    {
        $this->db->where("id",$id);
        $this->db->from("usertype");
        $query = $this->db->get();   
         if($query)
                {
                    return $query->row();
                } else {
                    return false;
                }  

    }

    public function get_multipleUserType($id)
    {
        $this->db->select('*');
        $this->db->from("usertype");
        $this->db->where_in("id",$id);
        $query = $this->db->get();   
        return $query->result_array();

    }

    public function delete_UserType($id)
    {
    $this->db->where_in("id", $id);
    return $this->db->delete("usertype");

    }

    public function CheckId($id)
    {
        $this->db->where("id", $id);
        $this->db->from("videotype");
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function add_videoType($user)
    {
        return $this->db->insert("videotype", $user);
    }

    public function fetch_videoType()
    {
        $this->db->select('*');
        $this->db->from("videotype");
        $query = $this->db->get();
        return $query->result();

    }

    public function getParticularVideo($id)
    {
        $this->db->where_in("id", $id);
        $this->db->from("videotype");
        $query = $this->db->get();
        if ($query) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function delete_videoType($id)
    {
        $this->db->where_in("id", $id);
        return $this->db->delete("videotype");

    }
    public function update_videoType($id, $videoName)
    {
        $this->db->where("id", $id);
        return $this->db->update("videotype", $videoName);
    }

    // update token for forgot password
    public function updateToken($email, $token)
    {
        $data = array(
            'token' => $token,
        );
        $this->db->where("email", $email);
        $update = $this->db->update("user", $data);
        if ($update) {
            $this->db->where('email', $email);
            $query = $this->db->get('user');
            return $query->row_array();
        }

    }

    // check the reset token present or not
    public function check_Reset_Token($token)
    {
        $this->db->where("token", $token);
        $this->db->from("user");
        $query = $this->db->get();
        if ($query) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    // password reset
    public function resetPassword($email, $newPassword)
    {
        $data = array(
            'password' => $newPassword,
            'token' => NULL
        );
        $this->db->where("email", $email);
        $update = $this->db->update("user", $data);
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    //check multiple id
    public function CheckMultipleId($id)
    {      
        $this->db->select('*');    
        $this->db->from("videotype");
        $this->db->where_in("id",$id);
        $query = $this->db->get();   
         if($query)
                {
                    return $query->result_array();
                } else {
                    return false;
                }          
    }

   

}
