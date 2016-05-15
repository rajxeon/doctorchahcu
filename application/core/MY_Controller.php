<?php 

class MY_Controller extends CI_Controller{
	public $data=array();
	
	
	public function __construct(){
		parent::__construct();
		$this->data['errors']='';
		$this->data['site_name']=config_item('site_name');
		$this->data['site_admin']=config_item('site_admin');
		}
	
	
	public function send_sms($msg,$number){
		return  $msg;
		}

	}
	
	
?>