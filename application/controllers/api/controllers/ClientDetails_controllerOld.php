<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . '/libraries/CreatorJwt.php';
require APPPATH . '/libraries/Permit.php';

class ClientDetails_controller extends REST_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->permit = new Permit();
        $this->auth = new CreatorJwt();
        $this->load->helpers('mail_helper');
        $this->load->helper(array('date', 'string'));
        $this->load->model(array("api/Client_model"));
        $this->load->library('session');
        $this->load->library('user_agent');
        date_default_timezone_set("Asia/Calcutta");
    }
    public function fetch_client_get()
     {
         $received_Token = $this->input->request_headers();
         $token = array_key_exists('auth', $received_Token);
         if ($token == 1) {
             $valid = $this->permit->verify_token($received_Token['auth']);
             // print_r($valid); exit;
 
             if ($valid) {
                 $client = $this->Client_model->fetch_AllClient();
                 if (!empty($client)) {
                     $message = [
                         'status' => true,
                         'data' => $client,
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
    public function addClient_post()
    {
        $client_arr = array();
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);
            if ($valid) {
                $personName = $this->security->xss_clean($this->input->post("personName"));
                $companyName = $this->security->xss_clean($this->input->post("companyName"));
                $designation = $this->security->xss_clean($this->input->post("designation"));
                $mobileNo = $this->security->xss_clean($this->input->post("mobileNo"));
                $phoneNo = $this->security->xss_clean($this->input->post("phoneNo"));
                $skype = $this->security->xss_clean($this->input->post("skype"));
                $timezone = $this->security->xss_clean($this->input->post("timezone"));

                $this->form_validation->set_rules("personName", "personName", "alpha|required");
                $this->form_validation->set_rules("companyName", "companyName", "integer|required");
                $this->form_validation->set_rules("designation", "designation", "alpha|required");
                $this->form_validation->set_rules("mobileNo", "mobileNo", "integer|required|max_length[10]|min_length[10]|greater_than[0]");
                $this->form_validation->set_rules("phoneNo", "phoneNo", "integer|required|max_length[10]|min_length[10]|greater_than[0]");
                $this->form_validation->set_rules("skype", "skype", "required");
                $this->form_validation->set_rules("timezone", "timezone", "required");

                if ($this->form_validation->run() == false) {
                    $message = array(
                        'status' => false,
                        'message' => validation_errors(),
                    );
                    $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $client_arr['personName'] = $personName;
                    $client_arr['companyName'] = $companyName;
                    $client_arr['designation'] = $designation;
                    $client_arr['mobileNo'] = $mobileNo;
                    $client_arr['phoneNo'] = $phoneNo;
                    $client_arr['skype'] = $skype;
                    $client_arr['timezone'] = $timezone;
                    $client_arr['skype'] = $skype;
                    $client_arr['createdBy'] = $valid;
                    $client_arr['createdOn'] = date('Y-m-d H:i:s');
                    $addClient = $this->Client_model->add_client($client_arr);
                    if ($client_arr) {
                        $message = [
                            'status' => true,
                            'client' => $client_arr,
                            'message' => "Client Added Successfully",
                        ];
                        $this->response($message, REST_Controller::HTTP_OK);

                    } else {
                        $message = [
                            'status' => false,
                            'message' => "Failed to add client",
                        ];
                        return $this->response($message, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);

                    }
                }
            } else {
                $message = [
                    'status' => false,
                    'message' => "Your not Authorize user",
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

    public function editClient_put($id = null)
    {
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);
            $jsonArray = json_decode(file_get_contents('php://input'), true);
            if ($valid) {
                $config = [
                    [
                        'field' => 'personName',
                        'label' => 'personName',
                        'rules' => 'alpha',

                    ],
                    [
                        'field' => 'companyName',
                        'label' => 'companyName',
                        'rules' => 'integer',

                    ], [
                        'field' => 'designation',
                        'label' => 'designation',
                        'rules' => 'alpha',

                    ], [
                        'field' => 'mobileNo',
                        'label' => 'mobileNo',
                        'rules' => 'integer|max_length[10]|min_length[10]|greater_than[0]',

                    ], [
                        'field' => 'phoneNo',
                        'label' => 'phoneNo',
                        'rules' => 'integer|max_length[10]|min_length[10]|greater_than[0]',

                    ],
                ];
                $this->form_validation->set_data($jsonArray);
                $this->form_validation->set_rules($config);
                if ($this->form_validation->run() == false) {
                    $message = array(
                        'status' => false,
                        'message' => validation_errors(),
                    );

                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);

                } else {
                    $ClientDetail_arr = array();
                    if (isset($jsonArray['personName'])) {
                        $ClientDetail_arr['personName'] = $jsonArray['personName'];

                    }
                    if (isset($jsonArray['companyName'])) {
                        $ClientDetail_arr['companyName'] = $jsonArray['companyName'];

                    }
                    if (isset($jsonArray['designation'])) {
                        $ClientDetail_arr['designation'] = $jsonArray['designation'];

                    }
                    if (isset($jsonArray['mobileNo'])) {
                        $ClientDetail_arr['mobileNo'] = $jsonArray['mobileNo'];

                    }
                    if (isset($jsonArray['phoneNo'])) {
                        $ClientDetail_arr['phoneNo'] = $jsonArray['phoneNo'];

                    }
                    if (isset($jsonArray['skype'])) {
                        $ClientDetail_arr['skype'] = $jsonArray['skype'];

                    }
                    if (isset($jsonArray['timezone'])) {
                        $ClientDetail_arr['timezone'] = $jsonArray['timezone'];

                    }

                    $checkid = $this->Client_model->checkId($id);
                    if (!empty($checkid)) {
                        $ClientDetail = $this->Client_model->update_clientDetails($id, $ClientDetail_arr);
                        if ($ClientDetail) {
                            $message = [
                                'status' => true,
                                'data' => $ClientDetail_arr,
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

    public function fetchParticularClient_get($id = null)
    {
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);

            if ($valid) {

                $id = explode(',', $this->uri->segment(3));

                $checkid = $this->Client_model->checkMultipleClientId($id);
                if (!empty($checkid)) {
                    $ClientData = $this->Client_model->getParticularClient($id);
                    if (!empty($ClientData)) {
                        $message = [
                            'status' => true,
                            'data' => $ClientData,
                            'message' => "Particular Data",
                        ];
                         $this->response($message, REST_Controller::HTTP_OK);
                    } else {
                        $message = [
                            'status' => false,
                            'message' => "Data not found",
                        ];
                        $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                    }

                } else {
                    $message = [
                        'status' => false,
                        'message' => "Member not found",
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

    public function deleteClient_delete($id=null)
    {
        $received_Token = $this->input->request_headers();
        $token=  array_key_exists('auth',$received_Token);
        if($token == 1)
        {
            $valid = $this->permit->verify_token($received_Token['auth']);
            $checkid= $this->Client_model->checkId($id);
            if($valid)
           {
                if(!empty($checkid))
                {
                    // if($checkid->createdBy == $valid)
                    // {
                        $deleteClient= $this->Client_model->delete_Client($id);
                        if($deleteClient)
                        {
                            $message = [
                                'status' => true,
                                'message' => "Data deleted successfully"
                            ];
                            $this->response($message, REST_Controller::HTTP_OK);

                        }else{
                            $message = [
                                'status' => false,
                                'message' => "Failed to update data"
                            ];
                            return  $this->response($message, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
                        }
                    // }else{
                    //     $message = [
                    //         'status' => FALSE,
                    //         'message' => "Your not Authorized user",
                    //                     ];
                    //     $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
            
                    // }
                }else{
            $message = [
                'status' => FALSE,
                'message' => "Id not found",
                               ];
            $this->response($message, REST_Controller::HTTP_NOT_FOUND); 

        }  
           }else{
            $message = [
                'status' => FALSE,
                'message' => "Your not Authorized user",
                            ];
            $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
           }
        }else{
            $message = [
                'status' => FALSE,
                'message' => "Auth token is missing",
                            ];
            $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } 

    }
}
