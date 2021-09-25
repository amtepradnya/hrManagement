<?php

class TeamMember_model extends CI_Model
{
    public function __construct()
    {
        parent :: __construct();
    }
    public function add_teamMember($member){

    return $this->db->insert("teammember", $member);
    }
    public function update_teamMember($id, $member)
    {
            $this->db->where("id", $id);
            return $this->db->update("teamMember", $member);
    }
    public function CheckId($id)
    {          
        $this->db->where("id",$id);
        $this->db->from("teammember");
        $query = $this->db->get();   
         if($query)
                {
                    return $query->row();
                } else {
                    return false;
                }          
    }
    public function delete_TeamMember($id)
    {
    $this->db->where("id", $id);
    return $this->db->delete("teammember");

    }
    public function getTeamMember()
    {
        $this->db->from("teammember");
        $query = $this->db->get();   
        if($query)
                {
                    return $query->result();
                } else {
                    return false;
                }          
    }
    
    public function getParticularTeamMember($memberId)
    {
        $this->db->select('*');
        $this->db->from("teammember");
        $this->db->where_in("memberId",$memberId);
        $query = $this->db->get();   
        return $query->result_array();       
    }

    public function checkMemberId($id)
    {          
        $this->db->where("memberId",$id);
        $this->db->from("teammember");
        $query = $this->db->get();   
         if($query)
                {
                    return $query->row();
                } else {
                    return false;
                }          
    }
       
    public function checkMultipleMemberId($id)
    {      
        $this->db->select('*');    
        $this->db->from("teammember");
        $this->db->where_in("memberId",$id);
        $query = $this->db->get();   
         if($query)
                {
                    return $query->result_array();
                } else {
                    return false;
                }          
    }

        
}
?>      