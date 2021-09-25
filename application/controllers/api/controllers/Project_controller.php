<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'libraries/REST_Controller.php';
require APPPATH.'libraries/Format.php';
require APPPATH . '/libraries/CreatorJwt.php';
require APPPATH . '/libraries/Permit.php';


class Project_controller extends REST_Controller {

    public function __construct(){

        parent::__construct();
        $this->permit = new Permit();
        $this->auth = new CreatorJwt();
        $this->load->helpers('mail_helper');  
        $this->load->helper(array('date','string'));
		$this->load->model(array("api/Project_model"));
        date_default_timezone_set("Asia/Calcutta");
    }
    public function addProject_post()
    {        
        $project_arr=array();
        $received_Token = $this->input->request_headers();
        $token=  array_key_exists('auth',$received_Token);
        if($token == 1)
        {
        $valid = $this->permit->verify_token($received_Token['auth']);
        if($valid)
       {  
        $projectName = $this->security->xss_clean($this->input->post("projectName"));
        $videoType = $this->security->xss_clean($this->input->post("videoType"));
        $videoDuration = $this->security->xss_clean($this->input->post("videoDuration"));
        $videoDurationUnit=$this->security->xss_clean($this->input->post("videoDurationUnit"));
        $projectStartDate = $this->security->xss_clean($this->input->post("projectStartDate"));
        $projectStartLater = $this->security->xss_clean($this->input->post("projectStartLater"));
        $expectedDelivery = $this->security->xss_clean($this->input->post("expectedDelivery"));
        $expectedDeliveryDate = $this->security->xss_clean($this->input->post("expectedDeliveryDate"));
        $projectLead = $this->security->xss_clean($this->input->post("projectLead"));
        $clientId = $this->security->xss_clean($this->input->post("clientId"));
        $projectStage = $this->security->xss_clean($this->input->post("projectStage"));
        $status = $this->security->xss_clean($this->input->post("status"));

        $this->form_validation->set_rules("projectName", "projectName", "alpha|required");
        $this->form_validation->set_rules("videoType", "videoType", "integer|required");
        $this->form_validation->set_rules("videoDuration", "videoDuration", "integer|required");
        $this->form_validation->set_rules("projectStartLater", "projectStartLater", "integer|required");
        $this->form_validation->set_rules("expectedDelivery", "expectedDelivery", "integer|required");
        $this->form_validation->set_rules("projectLead", "projectLead", "integer|required");
        $this->form_validation->set_rules("clientId", "clientId", "integer|required");
        $this->form_validation->set_rules("projectStage", "projectStage", "integer");
        $this->form_validation->set_rules("status", "status", "in_list[0,1]");

        if ($this->form_validation->run() == FALSE)
        {  
            $message = array(
                'status' => false,
                'message' => validation_errors()
            );
            $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
        }else {
            $project_arr['projectName']=  $projectName;
            $project_arr['videoType']=  $videoType;
            $project_arr['videoDuration']=  $videoDuration;
            $project_arr['projectStartDate']=  $projectStartDate;
            $project_arr['projectStartLater']=  $projectStartLater;
            $project_arr['expectedDelivery']=  $expectedDelivery;
            $project_arr['videoDurationUnit']=$videoDurationUnit;
            $project_arr['expectedDeliveryDate']= $expectedDeliveryDate;
            $project_arr['projectLead']=  $projectLead;
            $project_arr['clientId']=  $clientId;
            $project_arr['projectStage']=  $projectStage;
            $project_arr['status']=  $status;
            $project_arr['createBy']=  $valid;
            $project_arr['createOn']=date('Y-m-d H:i:s');

            $addProject= $this->Project_model->add_project($project_arr);
            if($addProject)
            {
                $message = [
                    'status' => true,
                    'client'=>$project_arr,
                    'message' => "Data Added Successfully"
                ];
                $this->response($message, REST_Controller::HTTP_OK);

            }else{
                $message = [
                    'status' => false,
                    'message' => "Failed to Add Data"
                ];
                return  $this->response($message, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);

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
    public function deleteProject_delete($id= null)
    {
        $received_Token = $this->input->request_headers();
        $token=  array_key_exists('auth',$received_Token);
        if($token == 1)
        {
        $valid = $this->permit->verify_token($received_Token['auth']);
        $checkid= $this->Project_model->checkId($id);
        if($valid)
       {  
       
        if(!empty($checkid))
        {
            $deleteProject= $this->Project_model->delete_project($id);
            if($deleteProject)
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
    public function updateProject_put($id=null)
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
                'field' => 'projectName',
                'label' => 'projectName',
                'rules' => 'alpha'

            ],
            [
                'field' => 'videoType',
                'label' => 'videoType',
                'rules' => 'integer'

            ],[
                'field' => 'videoDuration',
                'label' => 'videoDuration',
                'rules' => 'integer'

            ],[
                'field' => 'projectStartLater',
                'label' => 'projectStartLater',
                'rules' => 'integer'

            ],[
                'field' => 'expectedDelivery',
                'label' => 'expectedDelivery',
                'rules' => 'integer'

            ],[
                'field' => 'projectLead',
                'label' => 'projectLead',
                'rules' => 'integer'

            ],
            [
                'field' => 'clientId',
                'label' => 'clientId',
                'rules' => 'integer'

            ],
          
            [
                'field' => 'projectStage',
                'label' => 'projectStage',
                'rules' => 'integer'

            ],
         
            [
                'field' => 'status',
                'label' => 'status',
                'rules' => 'in_list[0,1]',

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
            $project_arr=array();
            if(isset($jsonArray['projectName']))
            {
                $project_arr['projectName']=$jsonArray['projectName'];

            }
            if(isset($jsonArray['videoType']))
            {
                $project_arr['videoType']=$jsonArray['videoType'];

            }
            if(isset($jsonArray['videoDuration']))
            {
                $project_arr['videoDuration']=$jsonArray['videoDuration'];

            }
            if(isset($jsonArray['videoDurationUnit']))
            {
                $project_arr['videoDurationUnit']=$jsonArray['videoDurationUnit'];

            }
            if(isset($jsonArray['projectStartDate']))
            {
                $project_arr['projectStartDate']=$jsonArray['projectStartDate'];

            }
            if(isset($jsonArray['expectedDelivery']))
            {
                $project_arr['expectedDelivery']=$jsonArray['expectedDelivery'];

            }
            if(isset($jsonArray['projectStartLater']))
            {
                $project_arr['projectStartLater']=$jsonArray['projectStartLater'];

            }
            if(isset($jsonArray['expectedDeliveryDate']))
            {
                $project_arr['expectedDeliveryDate']=$jsonArray['expectedDeliveryDate'];

            }
           
            if(isset($jsonArray['projectLead']))
            {
                $project_arr['projectLead']=$jsonArray['projectLead'];

            }
            if(isset($jsonArray['clientId']))
            {
                $project_arr['clientId']=$jsonArray['clientId'];

            }
           
            if(isset($jsonArray['projectStage'])){
            $project_arr['projectStage']=$jsonArray['projectStage'];
            }
            if(isset($jsonArray['status'])){
                $project_arr['status']=$jsonArray['status'];
            }
            
            $checkid= $this->Project_model->checkId($id);
           if(!empty($checkid) )
           {
            $project= $this->Project_model->update_project($id, $project_arr);
            if($project)
             {
                $message = [
                    'status' => true,
                    'data'=>$project_arr,
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
    public function fetchProject_get()
    {
        $received_Token = $this->input->request_headers();
        $token=  array_key_exists('auth',$received_Token);
        if($token == 1)
        {
        $valid = $this->permit->verify_token($received_Token['auth']);

        if($valid)
       {       
            $project= $this->Project_model->get_project();
            if(!empty($project))
            {
                $message = [
                    'status' => true,
                    'data' => $project,
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
    public function add_projectLiveStatus_post()
    {        
        $project_arr=array();
        $received_Token = $this->input->request_headers();
        $token=  array_key_exists('auth',$received_Token);
        if($token == 1)
        {
        $valid = $this->permit->verify_token($received_Token['auth']);
        if($valid)
       {  
        $projectId = $this->security->xss_clean($this->input->post("projectId"));
        $moduleId = $this->security->xss_clean($this->input->post("moduleId"));
        $workProgress = $this->security->xss_clean($this->input->post("workProgress"));
        $liveStatus = $this->security->xss_clean($this->input->post("liveStatus"));
        $this->form_validation->set_rules("projectId", "projectId", "integer|required");
        $this->form_validation->set_rules("moduleId", "moduleId", "integer|required");
        $this->form_validation->set_rules("workProgress", "workProgress", "integer|required");
        $this->form_validation->set_rules("liveStatus", "liveStatus", "required");
        if ($this->form_validation->run() == FALSE)
        {  
            $message = array(
                'status' => false,
                'message' => validation_errors()
            );
            $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
        }else {
            $project_arr['projectId']=  $projectId;
            $project_arr['moduleId']= $moduleId;
            $project_arr['workProgress']=  $workProgress;
            $project_arr['liveStatus']=  $liveStatus;
            $project_arr['addedBy']=  $valid;
            $project_arr['addedOn']=date('Y-m-d H:i:s');
            $addProjectLiveStatus= $this->Project_model->add_projectLiveStatus($project_arr);
            if($addProjectLiveStatus)
            {
                $message = [
                    'status' => true,
                    'client'=>$project_arr,
                    'message' => "ProjectLiveStatus Added Successfully"
                ];
                $this->response($message, REST_Controller::HTTP_OK);

            }else{
                $message = [
                    'status' => false,
                    'message' => "Failed to Add Data"
                ];
                return  $this->response($message, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);

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
    public function fetch_projectLiveStatus_get()
    {
        $received_Token = $this->input->request_headers();
        $token=  array_key_exists('auth',$received_Token);
        if($token == 1)
        {
        $valid = $this->permit->verify_token($received_Token['auth']);

        if($valid)
       {       
            $projectLiveStatus= $this->Project_model->get_projectLiveStatus();
            if(!empty($projectLiveStatus))
            {
                $message = [
                    'status' => true,
                    'data' => $projectLiveStatus,
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
}    