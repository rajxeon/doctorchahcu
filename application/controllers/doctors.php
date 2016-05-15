<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Doctors extends Frontend_Controller {
	
	public function __construct(){
		parent::__construct();
		}

	public function index($username=''){
		$this->load->model('doctor_m');
		$doctor_data=$this->doctor_m->get_by(array("username"=>$username),true);
		if(!empty($doctor_data)){
			$this->data['doctor_data']=$doctor_data;
			$this->load->view('doctor_profile',$this->data);
			}
		else show_404();
		}
		
	public function image_preview($clinic_id=0,$img_name=0){
		echo $img_name=$img_name.'.jpg';
		
		}

}