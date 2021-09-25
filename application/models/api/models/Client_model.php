<?php

class Client_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function add_client($client)
    {

        return $this->db->insert("clientdetails", $client);
    }

    public function fetch_AllClient()
    {
        $this->db->from("clientdetails");
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
        $this->db->from("clientdetails");
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function update_clientDetails($id, $member)
    {
        $this->db->where("id", $id);
        return $this->db->update("clientdetails", $member);
    }

    public function checkMultipleClientId($id)
    {
        $this->db->select('*');
        $this->db->from("clientdetails");
        $this->db->where_in("id", $id);
        $query = $this->db->get();
        if ($query) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getParticularClient($id)
    {
        $this->db->select('*');
        $this->db->from("clientdetails");
        $this->db->where_in("id", $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_Client($id)
    {
    $this->db->where("id", $id);
    return $this->db->delete("clientdetails");

    }
}
