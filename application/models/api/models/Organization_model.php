<?php

class Organization_model extends CI_Model
{
     public function __construct()
      {
          parent :: __construct();
      }
     
      
      public function fetch_Organizations()
      {
          $this->db->from("organization");
          $query = $this->db->get();
          if ($query) {
              return $query->result();
          } else {
              return false;
          }
      }
      public function CheckId($id)
      {
          $this->db->where("id", $id);
          $this->db->from("organization");
          $query = $this->db->get();
          if ($query) {
              return $query->row();
          } else {
              return false;
          }
      }
  
      public function add_Organization($organization)
      {
        return $this->db->insert("organization", $organization);
      }
      public function fetch_clients($id)
      {
        $this->db->select('personName,id');
        $this->db->where('companyName',$id);
          $this->db->from("clientdetails");
          $query = $this->db->get();
         
              return $query->result_array();
        
      }
      public function update_organization($id, $module)
    {
        $this->db->where("id", $id);
        return $this->db->update("organization", $module);
    }
    public function delete_organization($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete("organization");

    }
}
?>      