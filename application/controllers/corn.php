<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Corn extends Frontend_Controller {
	
	public function __construct(){
		parent::__construct();
		}
	public function delete_old_appointments(){
		$today=strtotime(date('m/d/y',config_item('now_time')));
		$sql="DELETE FROM appointment WHERE time<$today";
		$this->db->query($sql);
		}
	
	public function generate_hospital_slug(){
		//This function is only for 1 time use
		$sql="SELECT id,phone,slug FROM hospital";
		$results=$this->db->query($sql)->result();
		foreach($results as $a=>$b){
			echo ($b->id/4300)*100; echo '<br>';
			//$slug=str_replace('--','-',preg_replace('/[^A-Za-z0-9\-]/', '',str_replace('.','-',str_replace(',','',str_replace(' ','-',strtolower(trim($b->name)))))));
			$phone=str_replace('&',',',$b->phone);
			
			

			
			if($b->phone==$phone){
				$data = array(
				   'phone' => $phone
				);
				$this->db->where('id',$b->id);
				$this->db->update('hospital', $data); 
				}
			
			}
		
		}
	public function repopulate_email(){ 
	
		$data = array(
				   'remaining_email' => 50,
				   
				);
	 
		$this->db->update('clinic', $data);   
		}
}


?>