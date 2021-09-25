<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . '/libraries/CreatorJwt.php';
require APPPATH . '/libraries/Permit.php';

class TeamMember_controller extends REST_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->permit = new Permit();
        $this->auth = new CreatorJwt();
        $this->load->helper(array('date', 'string','mail'));
        $this->load->model(array("api/TeamMember_model"));
        $this->load->library('session');
        $this->load->library('user_agent');
        date_default_timezone_set("Asia/Calcutta");
    }

    public function add_post()
    {
        $teamMember_arr = array();
        $baseurl = base_url();
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);
            if ($valid) {
                $projectId = $this->security->xss_clean($this->input->post("projectId"));
                $memberId = $this->security->xss_clean($this->input->post("memberId"));

                $this->form_validation->set_rules("projectId", "projectId", "integer|required");
                $this->form_validation->set_rules("memberId", "memberId", "integer|required");
                
                if ($this->form_validation->run() == false) {
                    $message = array(
                        'status' => false,
                        'message' => validation_errors(),
                    );

                    $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $teamMember_arr['projectId'] = $projectId;
                    $teamMember_arr['memberId'] = $memberId;
                    $teamMember_arr['createdBy']=  $valid;
                    $teamMember_arr['createdOn']=date('Y-m-d H:i:s');
                    $teamMember= $this->TeamMember_model->add_teamMember($teamMember_arr);
                    if($teamMember){
                        $message = [
                            'status' => true,
                            'data'=>$teamMember_arr,
                            'message' => "TeamMember Added Successfully"
                        ];
                        $this->response($message, REST_Controller::HTTP_OK);
                    }else{
                        $message = [
                            'status' => false,
                            'message' => "Failed to Add TeamMember"
                        ];
                        return  $this->response($message, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
                    }   
                }
            } else {
                $message = [
                    'status' => false,
                    'message' => "Your not authorize to Add data",
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
   
    public function edit_put($id=null)
    {
        $received_Token = $this->input->request_headers();
        $token=  array_key_exists('auth',$received_Token);
        if($token == 1)
        {
            $valid = $this->permit->verify_token($received_Token['auth']);
            $jsonArray = json_decode(file_get_contents('php://input'), true);
            if($valid ){
                $config = [
                    [
                        'field' => 'projectId',
                        'label' => 'projectId',
                        'rules' => 'integer',
        
                    ],
                    [
                        'field' => 'memberId',
                        'label' => 'memberId',
                        'rules' => 'integer',
        
                    ]
                ];
                $this->form_validation->set_data($jsonArray);
                $this->form_validation->set_rules($config);
                if ($this->form_validation->run() == false) {
                    $message = array(
                        'status' => false,
                        'message' => validation_errors(),
                    );
        
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        
                }else{
                    $temMember_arr=array();
                    $temMember_arr['projectId']=$jsonArray['projectId'];
                    $temMember_arr['memberId']=$jsonArray['memberId'];
                    $checkid= $this->TeamMember_model->checkId($id);
                    if(!empty($checkid) )
                    {
                        if($checkid->createdBy == $valid){
                            $teamMember= $this->TeamMember_model->update_teamMember($id, $temMember_arr);
                            if($teamMember)
                            {
                                $message = [
                                    'status' => true,
                                    'data'=>$temMember_arr,
                                    'message' => "Data updated successfully"
                                ];
                                $this->response($message, REST_Controller::HTTP_OK);

                            }else{
                                $message = [
                                    'status' => false,
                                    'message' => "Failed to update data"
                                ];
                                return  $this->response($message, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);

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
                            'message' => "Id not found",
                                           ];
                        $this->response($message, REST_Controller::HTTP_NOT_FOUND); 
        
                    }
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

    public function deleteTeamMember_delete($id=null)
    {
        $received_Token = $this->input->request_headers();
        $token=  array_key_exists('auth',$received_Token);
        if($token == 1)
        {
            $valid = $this->permit->verify_token($received_Token['auth']);
            $checkid= $this->TeamMember_model->checkId($id);
            if($valid)
           {
                if(!empty($checkid))
                {
                    if($checkid->createdBy == $valid)
                    {
                        $deleteModule= $this->TeamMember_model->delete_TeamMember($id);
                        if($deleteModule)
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

    public function fetchAllTeamMember_get()
    {
        $received_Token = $this->input->request_headers();
        $token=  array_key_exists('auth',$received_Token);
        if($token == 1)
        {
            $valid = $this->permit->verify_token($received_Token['auth']);

            if($valid)
            {
                $module= $this->TeamMember_model->getTeamMember();
                if(!empty($module))
                {
                    $message = [
                        'status' => true,
                        'data' => $module,
                        'message' => "All Data",
                                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                }else{
                    $message = [
                        'status' => FALSE,
                        'message' => "Data not found",
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

    
    public function fetchParticularTeamMember_get($memberId = null)
    {
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);

            if ($valid) {

                $memberId = explode(',', $this->uri->segment(3));

                $checkid = $this->TeamMember_model->checkMultipleMemberId($memberId);
                if (!empty($checkid)) {
                    $teamMemberData = $this->TeamMember_model->getParticularTeamMember($memberId);
                    if (!empty($teamMemberData)) {
                        $message = [
                            'status' => true,
                            'data' => $teamMemberData,
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
    
    
}

