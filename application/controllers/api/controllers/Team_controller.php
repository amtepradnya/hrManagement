<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . '/libraries/CreatorJwt.php';
require APPPATH . '/libraries/Permit.php';

class Team_controller extends REST_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->permit = new Permit();
        $this->auth = new CreatorJwt();
        $this->load->helper(array('date', 'string'));
        $this->load->model(array("api/Team_model"));
        $this->load->library('session');
        $this->load->library('user_agent');
        date_default_timezone_set("Asia/Calcutta");
    }
    public function addTeam_post()
    {
        $team_arr = array();
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);
            if ($valid) {
                $projectId = $this->security->xss_clean($this->input->post("projectId"));
                $this->form_validation->set_rules("projectId", "projectId", "integer|required");

                if ($this->form_validation->run() == false) {
                    $message = array(
                        'status' => false,
                        'message' => validation_errors(),
                    );
                    $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $team_arr['projectId'] = $projectId;
                    $team_arr['createdBy'] = $valid;
                    $team_arr['createdOn'] = date('Y-m-d H:i:s');
                    $addClient = $this->Team_model->add_team($team_arr);
                    if ($team_arr) {
                        $message = [
                            'status' => true,
                            'client' => $team_arr,
                            'message' => "Team Added Successfully",
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
    public function team_get()
    {
        $received_Token = $this->input->request_headers();
        $token=  array_key_exists('auth',$received_Token);
        if($token == 1)
        {
        $valid = $this->permit->verify_token($received_Token['auth']);

        if($valid)
       {       
            $Team= $this->Team_model->get_team();
            if(!empty($Team))
            {
                $message = [
                    'status' => true,
                    'data' => $Team,
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
    public function updateTeam_put($id =null)
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
                'rules' => 'integer|required',

            ]];
        $this->form_validation->set_data($jsonArray);
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $message = array(
                'status' => false,
                'message' => validation_errors(),
            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);

        }else{
            $team_arr=array();
            if(isset($jsonArray['projectId']))
            {
            $team_arr['projectId']=$jsonArray['projectId'];
            }
            $checkid= $this->Team_model->checkId($id);
          if(!empty($checkid) )
           {
            $team= $this->Team_model->update_team($id, $team_arr);
            if($team)
             {
                $message = [
                    'status' => true,
                    'data'=>$team_arr,
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
    public function deleteTeam_delete($id=null)
    {
        $received_Token = $this->input->request_headers();
        $token=  array_key_exists('auth',$received_Token);
        if($token == 1)
        {
        $valid = $this->permit->verify_token($received_Token['auth']);

        $checkid= $this->Team_model->checkId($id);
        if($valid)
       {  
       
        if(!empty($checkid))
        {
            $deleteTeam= $this->Team_model->delete_team($id);
            if($deleteTeam)
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

    public function fetchParticularTeam_get()
    {
        $received_Token = $this->input->request_headers();
        $token=  array_key_exists('auth',$received_Token);
        if($token == 1)
        {
            $valid = $this->permit->verify_token($received_Token['auth']);

            if($valid)
            {
                $id =  $this->uri->segment(3);
                $checkid= $this->Team_model->CheckId($id);
                if(!empty($checkid) )
                {
                    $teamData= $this->Team_model->getParticularTeam($id);
                    if(!empty($teamData))
                    {
                        $message = [
                            'status' => true,
                            'data' => $teamData,
                            'message' => "Particular Data",
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
                        'message' => "Team not found",
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
