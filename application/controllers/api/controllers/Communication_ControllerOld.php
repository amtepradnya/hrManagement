<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . '/libraries/CreatorJwt.php';
require APPPATH . '/libraries/Permit.php';

class Communication_Controller extends REST_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->permit = new Permit();
        $this->auth = new CreatorJwt();
        $this->load->helper(array('date', 'string'));
        $this->load->model(array("api/Communication_model"));
    }
   public function addCommunication_post()
    {
        $Communication_arr = array();
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);
            if ($valid) {
                $senderId = $this->security->xss_clean($this->input->post("senderId"));
                $groupRoom = $this->security->xss_clean($this->input->post("groupRoom"));
                $groupName = $this->security->xss_clean($this->input->post("groupName"));
                $projectId = $this->security->xss_clean($this->input->post("projectId"));
                $message = $this->security->xss_clean($this->input->post("message"));
                $filetype= $this->security->xss_clean($this->input->post("filetype"));
                $fileUrl = $this->security->xss_clean($this->input->post("fileUrl"));

                $this->form_validation->set_rules("senderId", "senderId", "integer|required");
                $this->form_validation->set_rules("groupRoom", "groupRoom", "required");
                $this->form_validation->set_rules("groupName", "groupName", "alpha|required");
                $this->form_validation->set_rules("projectId", "projectId", "integer|required");
                $this->form_validation->set_rules("message", "message", "required");
                $this->form_validation->set_rules("filetype", "filetype", "required");
                $this->form_validation->set_rules("fileUrl", "fileUrl", "required");


                if ($this->form_validation->run() == false) {
                    $message = array(
                        'status' => false,
                        'message' => validation_errors(),
                    );
                    $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $Communication_arr['senderId'] = $senderId;
                    $Communication_arr['groupRoom'] = $groupRoom;
                    $Communication_arr['groupName'] = $groupName;
                    $Communication_arr['projectId'] = $projectId;
                    $Communication_arr['message'] = $message;
                    $Communication_arr['filetype'] = $filetype;
                    $Communication_arr['fileUrl'] = $fileUrl;
                    $Communication = $this->Communication_model->add_communication($Communication_arr);
                    if ($Communication) {
                        $message = [
                            'status' => true,
                            'data' => $Communication_arr,
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
    public function fetchCommunication_get()
     {
         $received_Token = $this->input->request_headers();
         $token = array_key_exists('auth', $received_Token);
         if ($token == 1) {
             $valid = $this->permit->verify_token($received_Token['auth']);
             // print_r($valid); exit;
 
             if ($valid) {
                 $Communication= $this->Communication_model->get_communication();
                 if (!empty($Communication)) {
                     $message = [
                         'status' => true,
                         'data' => $Communication,
                         'message' => "All Data",
                     ];
                     $this->response($message, REST_Controller::HTTP_OK);
                 }else{
                    $message = [
                        'status' => false,
                        'message' => "Data Not found",
                    ];
                    return $this->response($message, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);

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