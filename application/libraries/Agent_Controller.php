<?php 
 class Agent_Controller extends MY_Controller{
	 
	 public function __construct(){
		parent::__construct();	
		$this->load->model('agent_m');
		
		//Login Check
		$exception_uris=array( 'agent','agent/logout','agent/login' );
		//echo uri_string();
		if(!in_array(uri_string(),$exception_uris)){
			
			if($this->agent_m->loggedin()==FALSE){
				redirect(bu('agent'));
				}
			
			}
		
			
		}
	
	
	 
	 }

?>