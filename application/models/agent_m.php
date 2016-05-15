<?php 

class Agent_M extends MY_Model{
	
	
	public function __construct(){
		parent::__construct();
		
		  $this->_table_name		='agent';
		}
	
	function loggedin(){
		return (bool) $this->session->userdata('agent_loggedin');
		}
	function logout(){
		$this->session->sess_destroy();
		}
	
	function login(){
		$user=$this->get_by(array(
			'email'=>sql_filter($this->input->post('email')),
			'password'=>hash_it(sql_filter($this->input->post('password')))
			),TRUE);
			
		
		if(count($user)){
			
			$data=array(
				'a_name'		=>$user->name,
				'a_email'		=>$user->email, 
				'a_id'			=>$user->id,
				'a_role'		=>$user->role,
				'agent_loggedin'	=>TRUE,
				);			
			$this->session->set_userdata($data);
			}
		}
		
	function register($data,$user=FALSE){
		
		$this->save($data);
		$insert_id=$this->db->insert_id();
		
		if($user==FALSE){
			$username=strtolower(str_replace(' ','-',$data['name']));
			if($this->db->query("SELECT * FROM doctors WHERE username='$username'")->num_rows()){
				$username=$username.'-'.$insert_id;
				}
			$data['unique_id']=gen_unique_id($insert_id);
			$data['joined']	=date('d-m-Y');
			$data['username']	=$username;
			$path=('user_upload/'.$data['unique_id']);
			mkdir($path,'0755');
			$this->save($data,$insert_id);
			
			$data1=array(
				'name'	=>$data['name'],
				'email'	=>$data['email'],
				'unique_id'	=>$data['unique_id'],
				'id'		=>$insert_id,
				'loggedin'	=>TRUE,
				);	
			$this->session->set_userdata($data1);
			}
		
		return $insert_id;
			
		}
	}

?>