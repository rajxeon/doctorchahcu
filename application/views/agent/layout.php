<?php  
 
	$this->load->model('agent_m');
	$this->data['userdata']=$this->agent_m->get($this->session->userdata('a_id'));
	$this->load->view('agent/components/head.php',$this->data); 
	$this->load->view('agent/components/navigation.php',$this->data); 
	$this->load->view('agent/sub_view/'.$sub_view,$this->data); 
	$this->load->view('agent/components/footer.php',$this->data);
   
?>
