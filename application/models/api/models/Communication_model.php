<?php

class Communication_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function add_communication($communication)
    {

        return $this->db->insert("communication", $communication);
    }
    public function get_communication()
    {
        $this->db->from("communication");
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }
    // public function CheckId($id)
    // {
    //     $this->db->where("id", $id);
    //     $this->db->from("module");
    //     $query = $this->db->get();
    //     if ($query) {
    //         return $query->row();
    //     } else {
    //         return false;
    //     }
    // }

    // public function update_module($id, $module)
    // {
    //     $this->db->where("id", $id);
    //     return $this->db->update("module", $module);
    // }
    // public function delete_module($id)
    // {
    //     $this->db->where("id", $id);
    //     return $this->db->delete("module");

    // }

    // public function checkMultipleModuleId($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from("module");
    //     $this->db->where_in("id", $id);
    //     $query = $this->db->get();
    //     if ($query) {
    //         return $query->result_array();
    //     } else {
    //         return false;
    //     }
    // }

    // public function getParticularModule($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from("module");
    //     $this->db->where_in("id", $id);
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

}
