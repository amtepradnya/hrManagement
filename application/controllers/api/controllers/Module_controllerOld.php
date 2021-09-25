<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . '/libraries/CreatorJwt.php';
require APPPATH . '/libraries/Permit.php';

class Module_controller extends REST_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->permit = new Permit();
        $this->auth = new CreatorJwt();
        $this->load->helper(array('date', 'string'));
        $this->load->model(array("api/Module_model"));
    }
    public function addModule_post()
    {
        $module_arr = array();
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);
            if ($valid) {
                $moduleName = $this->security->xss_clean($this->input->post("moduleName"));
                $this->form_validation->set_rules("moduleName", "moduleName", "alpha|required");
                if ($this->form_validation->run() == false) {
                    $message = array(
                        'status' => false,
                        'message' => validation_errors(),
                    );
                    $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $module_arr['moduleName'] = $moduleName;
                    $module_arr['createdBy'] = $valid;
                    $module_arr['createdOn'] = date('Y-m-d H:i:s');
                    $module = $this->Module_model->add_module($module_arr);
                    if ($module) {
                        $message = [
                            'status' => true,
                            'data' => $module_arr,
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
    public function fetchModule_get()
    {
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);

            if ($valid) {
                $module = $this->Module_model->getModule();
                if (!empty($module)) {
                    $message = [
                        'status' => true,
                        'data' => $module,
                        'message' => "All Data",
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
    public function updateModule_put($id = null)
    {
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);
            $jsonArray = json_decode(file_get_contents('php://input'), true);
            if ($valid) {
                $config = [
                    [
                        'field' => 'moduleName',
                        'label' => 'moduleName',
                        'rules' => 'alpha',

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
                    $module_arr = array();
                    if (isset($jsonArray['moduleName'])) {
                        $module_arr['moduleName'] = $jsonArray['moduleName'];
                    }
                    $checkid = $this->Module_model->checkId($id);
                    if (!empty($checkid)) {
                        if ($checkid->createdBy == $valid) {
                            $module = $this->Module_model->update_module($id, $module_arr);
                            if ($module) {
                                $message = [
                                    'status' => true,
                                    'data' => $module_arr,
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
                                'message' => "Your not Authorized user",
                            ];
                            $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);

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
    public function deleteModule_delete($id = null)
    {
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);
            $checkid = $this->Module_model->checkId($id);
            if ($valid) {

                if (!empty($checkid)) {
                    if ($checkid->createdBy == $valid) {
                        $deleteModule = $this->Module_model->delete_module($id);
                        if ($deleteModule) {
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
                            'message' => "Your not Authorized user",
                        ];
                        $this->response($message, REST_Controller::HTTP_UNAUTHORIZED);

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

    public function fetchParticularModule_get($id = null)
    {
        $received_Token = $this->input->request_headers();
        $token = array_key_exists('auth', $received_Token);
        if ($token == 1) {
            $valid = $this->permit->verify_token($received_Token['auth']);

            if ($valid) {

                $id = explode(',', $this->uri->segment(3));

                $checkid = $this->Module_model->checkMultipleModuleId($id);
                if (!empty($checkid)) {
                    $moduleData = $this->Module_model->getParticularModule($id);
                    if (!empty($moduleData)) {
                        $message = [
                            'status' => true,
                            'data' => $moduleData,
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
                        'message' => "id not found",
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
