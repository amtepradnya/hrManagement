<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . '/libraries/CreatorJwt.php';
require APPPATH . '/libraries/Permit.php';


// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
class User_controller extends REST_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->permit = new Permit();
        $this->auth = new CreatorJwt();
		$this->load->library('excel');
        $this->load->model(array("api/User_model"));
        // $this->load->library('upload');
        // date_default_timezone_set("Asia/Calcutta");
    }

    //login user
    public function login_post()
    {
        $email = $this->security->xss_clean($this->input->post("email"));
        $password = $this->security->xss_clean($this->input->post("password"));
        $output = $this->User_model->exist_user($email, $password);

        $this->form_validation->set_rules("email", "email", "valid_email|required");
        $this->form_validation->set_rules("password", "password", "required");
        if ($this->form_validation->run() == false) {
            $message = array(
                'status' => false,
                'message' => validation_errors(),
            );

            $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if (!empty($output) and $output != false) {
                 $return_data = [
                    'id' => $output->id,
                    'name' => $output->name,
                    'mobileNo' => $output->mobileNo,
                    'email' => $output->email,
                    'role' => $output->role,
                    'isDeleted' => $output->isDeleted
                                ];
                     $message = [
                        'status' => true,
                        'data' => $return_data,
                        'message' => "User login successful",
                    ];
                    return $this->response($message, REST_Controller::HTTP_OK);

            } else {
                $message = [
                    'status' => false,
                    'message' => "You can't login ! email & password not match",
                ];
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
    //upload file
 public function fileUpload_post()
  
    {

        if(isset($_FILES["file"]["name"]))
        {
         $path = $_FILES["file"]["tmp_name"];
         $object = PHPExcel_IOFactory::load($path);
         foreach($object->getWorksheetIterator() as $worksheet)
         {
          $highestRow = $worksheet->getHighestRow();
          $highestColumn = $worksheet->getHighestColumn();
          for($row=2; $row<=$highestRow; $row++)
          {
           $portalDetails = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
           $applicationSrNo = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
           $requirementId = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
           $name = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
           $firstName = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

           $lastName = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
           $emailId = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
           $resumeHeadline = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
           $revisedResumeHeadline = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

           $phoneNumber = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
           $currentLocation = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
           $totalExperience = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
           $functionalArea = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
           $role = $worksheet->getCellByColumnAndRow(13, $row)->getValue();

           $industry = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
           $keySkills = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
           $annualSalary = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
           $gender = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
           $dateOfBirth = $worksheet->getCellByColumnAndRow(18, $row)->getValue();


           $data[] = array(
            'portalDetails'  => $portalDetails,
            'applicationSrNo'   => $applicationSrNo,
            'requirementId'    => $requirementId,
            'name'  => $name,
            'firstName'   => $firstName,

            'lastName'  => $lastName,
            'emailId'   => $emailId,
            'resumeHeadline'  => $resumeHeadline,
            'revisedResumeHeadline'   => $revisedResumeHeadline,

            'phoneNumber'  => $phoneNumber,
            'currentLocation'   => $currentLocation,
            'totalExperience'  => $totalExperience,
            'functionalArea'   => $functionalArea,
            'role'   => $role,


            'industry'  => $industry,
            'keySkills'   => $keySkills,
            'annualSalary'    => $annualSalary,
            'gender'  => $gender,
            'dateOfBirth'   => $dateOfBirth

           );
          }
         }
        //   print_r($data);
         $output = $this->User_model->insert_user($data);

        //  $this->excel_import_model->insert($data);
         echo 'Data Imported successfully';
        } 
       }
    

 }


  
  

