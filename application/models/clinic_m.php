<?php 

class Clinic_M extends MY_Model{
	
	
	public function __construct(){
		parent::__construct();
		  $this->_table_name		='clinic';
		}
	
	public function get_clinic_number_limit($flag=NULL){
		$result=$this->db->query('SELECT plan FROM doctors WHERE id='.$this->session->userdata('id'))->result(); 
		$plan=$result[0]->plan;
		
		$num=$this->db->query('SELECT '.$plan.' FROM plans WHERE field="clinic"')->result(); 
		
		$used=$this->db->query('SELECT count(id) FROM clinic WHERE doctor_id='.$this->session->userdata('id').'')->result(); 
		$used=(array)$used[0];
		$arr=array();
		foreach($used as $a=>$b){
			$arr[]=$b;
			}
		if($flag!=NULL){
			return $num[0]->$plan-$arr[0];
			}
		echo 'You have '.$arr[0].' out of '.$num[0]->$plan.' clinic.'; 
		}
	

	

	}

?>