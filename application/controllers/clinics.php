<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clinics extends Frontend_Controller {
	
	public function __construct(){
		parent::__construct();
		}

	public function index($clinic=''){
		$this->load->model('clinic_m');
		$clinic_data=$this->clinic_m->get_by(array("slug"=>$clinic),true);
		if(!empty($clinic_data)){
			$this->data['clinic_data']=$clinic_data;
			$this->load->view('clinic_view',$this->data);
			}
		else show_404();
		}
		
	public function image_preview($clinic_id=0,$img_name=0){
		echo $img_name=$img_name.'.jpg';
		
		}

}