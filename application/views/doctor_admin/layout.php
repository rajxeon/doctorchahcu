<?php  
 
	$this->load->model('doctor_m');
	$this->data['userdata']=$this->doctor_m->get($this->session->userdata('id'));
	$this->load->view('doctor_admin/components/head.php',$this->data); 
	$this->load->view('doctor_admin/components/navigation.php',$this->data); 
	$this->load->view('doctor_admin/sub_view/'.$sub_view,$this->data); 
	$this->load->view('doctor_admin/components/footer.php',$this->data);
   
?>
