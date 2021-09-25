<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . '/libraries/CreatorJwt.php';
require APPPATH . '/libraries/Permit.php';

class Organization_controller extends REST_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->permit = new Permit();
        $this->auth = new CreatorJwt();
        $this->load->helpers('mail_helper');
        $this->load->helper(array('date', 'string'));
        $this->load->model(array("api/Organization_model"));
        $this->load->library('session');
        $this->load->library('user_agent');
        date_default_timezone_set("Asia/Calcutta");
    }
   public function addOrganisation_post()
    {
        $Organization_arr = array();
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);
            if ($valid) {
                $organizationName = $this->security->xss_clean($this->input->post("organizationName"));
                $website = $this->security->xss_clean($this->input->post("website"));

                $this->form_validation->set_rules("organizationName", "organizationName", "alpha|required");
                $this->form_validation->set_rules("website", "website", "required");

                if ($this->form_validation->run() == false) {
                    $message = array(
                        'status' => false,
                        'message' => validation_errors(),
                    );
                    $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $Organization_arr['organizationName'] = $organizationName;
                    $Organization_arr['website'] = $website;
                    $Organization_arr['createdBy'] = $valid;
                    $Organization_arr['createdOn'] = date('Y-m-d H:i:s');
                    $Organization = $this->Organization_model->add_Organization($Organization_arr);
                    if ($Organization) {
                        $message = [
                            'status' => true,
                            'data' => $Organization_arr,
                            'message' => "Data Added Successfully",
                        ];
                        $this->response($message, REST_Controller::HTTP_OK);
                    } else {
                        $message = [
                            'status' => false,
                            'message' => "Failed to Add Data",
                        ];
                        return $this->response($message, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
                    }
                }
            } else {
                $message = [
                    'status' => false,
                    'message' => "Your not Authorized user",
                ];
                $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $message = [
                'status' => false,
                'message' => "Auth token is missing",
            ];
            $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function fetch_organization_get()
     {
         $received_Token = $this->input->request_headers();
         $token = array_key_exists('auth', $received_Token);
         if ($token == 1) {
             $valid = $this->permit->verify_token($received_Token['auth']);
             // print_r($valid); exit;
 
             if ($valid) {
                 $Organization= $this->Organization_model->fetch_Organizations();
                 if (!empty($Organization)) {
                     $message = [
                         'status' => true,
                         'data' => $Organization,
                         'message' => "All Data",
                     ];
                     $this->response($message, REST_Controller::HTTP_OK);
                 }
             } else {
                 $message = [
                     'status' => false,
                     'message' => "Your not Authorized user",
                 ];
                 $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
 
             }
         } else {
             $message = [
                 'status' => false,
                 'message' => "Auth token is missing",
             ];
             $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
         }
     }
     public function getclientbyOrg_get($id = null)
     {
         $orgId=$id;
         $module_arr = array();
         $received_Token = $this->input->request_headers();
         $token = array_key_exists('auth', $received_Token);
         if ($token == 1) {
             $valid = $this->permit->verify_token($received_Token['auth']);
             if ($valid) {
                $getClient= $this->Organization_model->fetch_clients($orgId);
                if(!empty($getClient))
                {
                    $message = [
                        'status' => true,
                        'data' => $getClient,
                        'message' => "All Data",
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);

                }else{
                    $message = [
                        'status' => false,
                        'message' => "Data not found",
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);

                }
               
             } else {
                 $message = [
                     'status' => false,
                     'message' => "Your not Authorized user",
                 ];
                 $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
             }
         } else {
             $message = [
                 'status' => false,
                 'message' => "Auth token is missing",
             ];
             $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
         }
     }
     
     public function updateOrganization_put($id = null)
     {
         $received_Token = $this->input->request_headers();
         $token = array_key_exists('auth', $received_Token);
         if ($token == 1) {
             $valid = $this->permit->verify_token($received_Token['auth']);
             $jsonArray = json_decode(file_get_contents('php://input'), true);
             if ($valid) {
                 $config = [
                     [
                         'field' => 'organizationName',
                         'label' => 'organizationName',
                         'rules' => 'alpha|required',
 
                     ],
                     [
                        'field' => 'website',
                        'label' => 'website',
                        'rules' => 'required',

                    ]];
                 $this->form_validation->set_data($jsonArray);
                 $this->form_validation->set_rules($config);
                 if ($this->form_validation->run() == false) {
                     $message = array(
                         'status' => false,
                         'message' => validation_errors(),
                     );
 
                     $this->response($message, REST_Controller::HTTP_NOT_FOUND);
 
                 } else {
                     $Organization_arr = array();
                     if (isset($jsonArray['organizationName'])) {
                         $Organization_arr['organizationName'] = $jsonArray['organizationName'];
                     }
                     if (isset($jsonArray['website'])) {
                        $Organization_arr['website'] = $jsonArray['website'];
                    }
                    

                     $checkid = $this->Organization_model->checkId($id);
                     if (!empty($checkid)) {
                             $Organization = $this->Organization_model->update_organization($id, $Organization_arr);
                             if ($Organization) {
                                 $message = [
                                     'status' => true,
                                     'data' => $Organization_arr,
                                     'message' => "Data updated successfully",
                                 ];
                                 $this->response($message, REST_Controller::HTTP_OK);
 
                             } else {
                                 $message = [
                                     'status' => false,
                                     'message' => "Failed to update data",
                                 ];
                                 return $this->response($message, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
 
                             }
                     
                     } else {
                         $message = [
                             'status' => false,
                             'message' => "Id not found",
                         ];
                         $this->response($message, REST_Controller::HTTP_NOT_FOUND);
 
                     }
                 }
 
             } else {
                 $message = [
                     'status' => false,
                     'message' => "Your not Authorized user",
                 ];
                 $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
             }
         } else {
             $message = [
                 'status' => false,
                 'message' => "Auth token is missing",
             ];
             $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
         }
     }
      
     public function deleteOrganization_delete($id = null)
     {
         $received_Token = $this->input->request_headers();
         $token = array_key_exists('auth', $received_Token);
         if ($token == 1) {
             $valid = $this->permit->verify_token($received_Token['auth']);
             $checkid = $this->Organization_model->checkId($id);
             if ($valid) {
 
                 if (!empty($checkid)) {
                     
                         $deleteOrganization = $this->Organization_model->delete_organization($id);
                         if ($deleteOrganization) {
                             $message = [
                                 'status' => true,
                                 'message' => "Data deleted successfully",
                             ];
                             $this->response($message, REST_Controller::HTTP_OK);
 
                         } else {
                             $message = [
                                 'status' => false,
                                 'message' => "Failed to update data",
                             ];
                             return $this->response($message, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
                         }
                 } else {
                     $message = [
                         'status' => false,
                         'message' => "Id not found",
                     ];
                     $this->response($message, REST_Controller::HTTP_NOT_FOUND);
 
                 }
 
             } else {
                 $message = [
                     'status' => false,
                     'message' => "Your not Authorized user",
                 ];
                 $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
             }
         } else {
             $message = [
                 'status' => false,
                 'message' => "Auth token is missing",
             ];
             $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
         }
     }

}
