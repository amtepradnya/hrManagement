<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . '/libraries/CreatorJwt.php';
require APPPATH . '/libraries/Permit.php';

require 'vendor/autoload.php';

class PusherController extends REST_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->permit = new Permit();
        $this->auth = new CreatorJwt();

        $this->load->helper(array('date', 'string'));
        date_default_timezone_set("Asia/Calcutta");
    }
    public function presence_auth_post()
    {
        $user_data=array();
        $channel = $this->security->xss_clean($this->input->post("channel"));
        $my_event = $this->security->xss_clean($this->input->post("my_event"));
        $user_id = $this->security->xss_clean($this->input->post("user_id"));
        $user_info = $this->security->xss_clean($this->input->post("user_info"));
        $this->form_validation->set_rules("channel", "channel", "required");
        $this->form_validation->set_rules("my_event", "my_event", "required");

        if ($this->form_validation->run() == false) {
            $message = array(
                'status' => false,
                'message' => validation_errors(),
            );
            $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($user_info) {
                $user_data = array('user_id' => $user_id);
            }
            
            $options = array(
                'cluster' => 'ap2',
                'useTLS' => true
              );
              $pusher = new Pusher\Pusher(
                'b1e260a0c04ecd949364',
                '1fd5a41b343d4c6199c5',
                '1095749',
                $options
              );

            $event = $pusher->trigger($channel, $my_event, "hii");
            if ($event === TRUE)
            {
                echo 'Event triggered successfully!';
            }
            else
            {
                echo 'Ouch, something happend. Could not trigger event.';
            }
    
        }
  
    }
    public function auth_post()
    {
        $data=$this->input->post();
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
          );
          $pusher = new Pusher\Pusher(
            'b1e260a0c04ecd949364',
            '1fd5a41b343d4c6199c5',
            '1095749',
            $options
          );
          $user_data = array();

        if (isset($data['user_id'])) {
          $user_data=$data['user_id'];
        }

        $data= $pusher->socket_auth($data['channel_name'],$data['socket_id']);
        return $this->response($data, REST_Controller::HTTP_OK);

    }

}