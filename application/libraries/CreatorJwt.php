<?php

require APPPATH . '/libraries/JWT.php';

class CreatorJwt
{
   

    /*************This function generate token private key**************/ 

    private $key = "J8cC2leRuNt4Mbr7DPAS6X8Zq4ChfMWmpWXq"; 
    
    public function GenerateToken($data)
    {          
        $jwt = JWT::encode($data, $this->key);
        return $jwt;
    }
    

   /*************This function DecodeToken token **************/

    public function DecodeToken($token)
    {          
        $decoded = JWT::decode($token, $this->key, array('HS256'));
        $decodedData = (array) $decoded;
        if($decodedData){
            return $decodedData;
        } else {
            return http_response_code(401);
        }
    }
}