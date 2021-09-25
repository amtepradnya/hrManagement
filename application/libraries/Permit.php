<?php

require_once('CreatorJwt.php');

//require APPPATH . '/libraries/REST_Controller.php';

class Permit{
    
    public function __construct(){

        $this->auth = new CreatorJwt();
    }

    public function verify_token($token)
    {            
        try
        {
            $jwtData = $this->auth->DecodeToken($token);
            return $jwtData['id'];             
        }
        catch (Exception $e)
        {
            return false;
        } 
    }
}