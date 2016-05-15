<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends Doctor_Controller {
	
	public function __construct(){
		parent::__construct();
		}

	public function indexs(){
		$pid		=sql_filter($this->input->post('pid'));
		$to			=sql_filter($this->input->post('to'));
		$subject	=stripslashes(sql_filter($this->input->post('subject')));
		
		if(!valid_pid_for_completed_procedure($pid)) {show_404();return;}
		
		$primary				=$this->session->userdata('primary');
		$message				=$this->session->userdata('email_body');
		$attachment				=$this->session->userdata('attachment');
		$attach_filename		=$this->session->userdata('attach_filename'); 
		
		$this->load->model('clinic_m');
		$data=$this->clinic_m->get($primary,true);
		$remaining_email=$data->remaining_email;
		
		require 'includes/php_mailer/class.phpmailer.php';
		 
		//require_once('../class.phpmailer.php');

		$mail             = new PHPMailer(); // defaults to using php "mail()"
		
		$body             = "<h3>This is a test</h3>"; 
		
		$mail->SetFrom('info@doctorchachu.com', 'Doctor Chachu');
		
		$mail->AddReplyTo("name@yourdomain.com","First Last");
		
		$address = "rajxeon@gmail.com";
		$mail->AddAddress($address);
		
		$mail->Subject    = $subject;
		
		if(empty($message)) { $message="<p>This is a system generated mail. Please do not reply.</p>";}
		
		$mail->MsgHTML($message);
		
		$mail->AddAttachment($attachment);      // attachment
		
		
		 
		
		 
		
		}
		
	public function index(){
		$pid		=sql_filter($this->input->post('pid'));
		$to			=sql_filter($this->input->post('to'));
		$subject	=stripslashes(sql_filter($this->input->post('subject')));
		
		if(!valid_pid_for_completed_procedure($pid)) {show_404();return;}
		
		$primary				=$this->session->userdata('primary');
		$message				=$this->session->userdata('email_body');
		$attachment				=$this->session->userdata('attachment');
		$attach_filename		=$this->session->userdata('attach_filename'); 
		
		$this->load->model('clinic_m');
		$data=$this->clinic_m->get($primary,true);
		$remaining_email=$data->remaining_email;
		
		require 'includes/php_mailer/class.phpmailer.php';
		   
		include("includes/php_mailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
		
		
		
		$mail             = new PHPMailer();
		
		$body             = "<h2>This is a test</h2>";
		
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "mail.doctorchachu.com"; // SMTP server
		$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Host       = "mail.doctorchachu.com"; // sets the SMTP server
		//$mail->Port       = 26;                    // set the SMTP port for the GMAIL server
		$mail->Username   = "info@doctorchachu.com"; // SMTP account username
		$mail->Password   = "nikitarn_0";        // SMTP account password
		
		$mail->SetFrom('info@doctorchachu.com', 'DoctorChachu.com');
		
		$mail->AddReplyTo($data->email,$data->name);
		
		$mail->Subject    = $subject;
		
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		
		$mail->IsHTML(true); 
		
		$message.='<p>This is a system generated mail. Please do not reply.</p>';
 		//$message='';
		$mail->MsgHTML($message);
		
		$address = $to;
		$mail->AddAddress($address, $data->name);
		
		if(!empty($attachment))
		$mail->AddAttachment($attachment);      // attachment 
		
		$array_items = array('email_body' => '', 'attachment' => '','attach_filename'=>'');
 		$this->session->unset_userdata($array_items);
		
		if($remaining_email>0){
			if(!$mail->Send()) {
			  "Mailer Error: " . $mail->ErrorInfo;
			  return 0;
			} else {
				$remaining_email-=1;
				$this->clinic_m->save(array('remaining_email'=>$remaining_email),$primary);
				return 1; 
			} 
			
			
			}
		else return 0;
    
		}
		

}