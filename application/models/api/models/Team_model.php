<?php

class Team_model extends CI_Model
{
     public function __construct()
      {
          parent :: __construct();
      }
      public function add_team($team){

        return $this->db->insert("team", $team);
      }
      public function get_team()
      {
          $this->db->from("team");
          $query = $this->db->get();   
           if($query)
                  {
                      return $query->result();
                  } else {
                      return false;
                  }          
      }
      public function CheckId($id)
      {          
          $this->db->where("id",$id);
          $this->db->from("team");
          $query = $this->db->get();   
           if($query)
                  {
                      return $query->result();
                  } else {
                      return false;
                  }          
      }
   
      public function update_team($id, $team)
        {
             $this->db->where("id", $id);
             return $this->db->update("team", $team);
        }
        public function delete_team($id)
        {
        $this->db->where("id", $id);
        return $this->db->delete("team");

        }

        public function getParticularTeam($id)
        {
            $this->db->where("id",$id);
            $this->db->from("team");
            $query = $this->db->get();   
            if($query)
                    {
                        return $query->row();
                    } else {
                        return false;
                    }         
        }
        
}
?>      