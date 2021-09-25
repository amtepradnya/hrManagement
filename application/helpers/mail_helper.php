<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

    function sendMail($emaildata)
    {
        $ci = get_instance();
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'advidsweb@gmail.com',
            'smtp_pass' => 'Sharpspring@lotus#$e',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
            );
        $ci->load->library('email', $config);
        $ci->email->set_newline("\r\n"); 
        $ci->email->initialize($config);
        $ci->email->set_mailtype('html');
        $ci->email->from('advidsweb@gmail.com', 'Advids');
        $ci->email->to($emaildata['email']);
        $ci->email->subject('AdvidsApp - Accept invitation for joining the AdvidsApp');
        $body = $ci->load->view('emails/inviteuser.php',$emaildata,TRUE);
        // $body = $ci->load->view('emails/inviteuser.php');
        $ci->email->message($body); 

       
        if($ci->email->send()){
           return true;
        }else{
            return false;
        }
        
    
}
?>