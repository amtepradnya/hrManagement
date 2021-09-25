<?php

class Project_model extends CI_Model
{
     public function __construct()
      {
          parent :: __construct();
      }
      public function add_projectLiveStatus($project){

        return $this->db->insert("projectlivestatus", $project);
      }
      
      public function add_project($project){

        return $this->db->insert("project", $project);
      }
      public function get_project()
      {
          $this->db->from("project");
          $query = $this->db->get();   
           if($query)
                  {
                      return $query->result();
                  } else {
                      return false;
                  }          
      }
      public function update_project($id, $project)
      {
           $this->db->where("id", $id);
           return $this->db->update("project", $project);
      }
      public function delete_project($id)
      {
      $this->db->where("id", $id);
      return $this->db->delete("project");

      }
      public function CheckId($id)
      {          
          $this->db->where("id",$id);
          $this->db->from("project");
          $query = $this->db->get();   
           if($query)
                  {
                      return $query->result();
                  } else {
                      return false;
                  }          
      }
      public function get_projectLiveStatus()
      {
          $this->db->from("projectlivestatus");
          $query = $this->db->get();   
           if($query)
                  {
                      return $query->result();
                  } else {
                      return false;
                  }          
      }
}
?>      