<?php 
 class Doctor_Controller extends MY_Controller{
	 
	 public function __construct(){
		parent::__construct();	
		$this->load->model('doctor_m');
		
		//Login Check
		$exception_uris=array( 'doctor','doctor/logout','doctor/login' );
		//echo uri_string();
		if(!in_array(uri_string(),$exception_uris)){
			
			if($this->doctor_m->loggedin()==FALSE){
				redirect('doctor/login');
				}
			
			}
		
			
		}
	
	
	 
	 }

?>