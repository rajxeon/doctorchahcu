<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent extends Agent_Controller {
	
	public function __construct(){
		parent::__construct();
		}

	public function index($username=''){
		
		$dashboard=base_url().'agent/dashboard';
		
		$this->agent_m->loggedin()==FALSE || redirect($dashboard);
		
		$rules	=array(
					'email'	=>array('field'=>'email','label'=>'Email','rules'=>'trim|required|valid_email|xss_clean'),
					'password'	=>array('field'=>'password','label'=>'Password','rules'=>'trim|required')
					);
					
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run()==TRUE){
			//Validation is passed
			$this->agent_m->login();
			
			if($this->agent_m->loggedin()==TRUE) {
				if(isset($_SERVER['HTTP_REFERER']))
				$dashboard=$_SERVER['HTTP_REFERER'];
				redirect($dashboard);
				}
			
			else {
			$this->data['post_message']='Username password combination does not match';
			//redirect('admin/user/login','refresh');
			}
			
			}
		else {$this->data['post_message']=validation_errors();}
		 
		$this->load->view('agent_login',$this->data);
		
		}
		
	public function dashboard(){
		$this->data['page_title']='Agent Dashboard';
		$this->data['sub_view']='dashboard';
		
		$this->load->view('agent/layout.php',$this->data);
		}
	 public function logout(){
		$this->agent_m->logout();		
		redirect(base_url().'agent');
		}
	
	public function doctors(){
		$q=sql_filter($this->input->post('q'));
		$allowed_role=array('dc_admin','dc_agent'); 
		if(!check_allowed_role($allowed_role)) {show_404();return;}
		$this->data['page_title']='Agent Dashboard';
		$this->data['sub_view']='doctors';	
		$this->data['q']		=($q);		
		$this->load->view('agent/layout.php',$this->data);
		}
		
	public function get_doctor_list($offset=0){ 
	 	$q=sql_filter($this->input->post('q'));
		$number_of_result=10;
		$offest_f=$offset*$number_of_result;  
		 
		$this->load->model('doctor_m');
		
		$this->db->order_by('id','desc');
		$role=$this->session->userdata('a_role');
		
		if($role=='dc_admin'){
			if(!empty($q))
			$sql="SELECT * FROM doctors WHERE name LIKE '%$q%' OR email LIKE '%$q%' OR phone LIKE '%$q%'  LIMIT $offest_f,$number_of_result";
			else $sql="SELECT * FROM doctors LIMIT $offest_f,$number_of_result"; 
			 
			$t_data=$this->db->query($sql)->result();   
			//$t_data	=$this->db->get('doctors',$number_of_result,$offest_f)->result();		
			$nos_doc=$this->db->query('SELECT id FROM doctors')->num_rows();
			}
			
		if($role=='dc_agent'){
			$a_id=$this->session->userdata('a_id');
			if(!empty($q))
			$sql="SELECT * FROM doctors WHERE name LIKE '%$q%' OR email LIKE '%$q%' OR phone LIKE '%$q%' AND agent=$a_id LIMIT $offest_f,$number_of_result";
			else $sql="SELECT * FROM doctors WHERE agent=$a_id LIMIT $offest_f,$number_of_result"; 
			 
			$t_data=$this->db->query($sql)->result();   
			//$t_data	=$this->db->get_where('doctors', array('agent'=>$a_id),$number_of_result,$offest_f)->result();	
			$nos_doc=$this->db->query("SELECT id FROM doctors WHERE agent= $a_id")->num_rows();
			}
		
		
		if(empty($t_data)){  echo  '<tr class="callout callout-danger"><td colspan="7">No more results found.</td></tr>';return;}
		?>
        
	 <?php echo  '<tr class="callout callout-info"><td colspan="7">'.($nos_doc).' doctor(s) found in your account.</td></tr>'?>

     
    
        
             <?php foreach($t_data as $a=>$b): ?>
             	<tr>
                	<td ><?=@$b->name?></td>
                    <td><?=@$b->phone?></td>
                    <td><?=@$b->email?></td>
                    <td><?=ucfirst(@$b->plan);?></td>
                    <td><?=@$b->joined?></td>
                    <td><?php $dcv=@$b->dc_verified; 
					if($dcv) echo '<i class="fa fa-check" style="color:#080"></i>';
					else echo '<i class="fa fa-times" style="color:#800"></i>';
					?></td>
                    <td><div class="btn-group np">
        <a target="_blank"  href="<?php echo bu('agent/expand_doctor/'.@$b->id);?>" class="btn btn-default btn-sm"  ><i class="fa fa-wa fa-expand"></i></a> 
        <button id="dLabel" class="btn btn-default btn-sm np" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-wa fa-bars"></i> </button>
          <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
           	<li role="presentation">
            	<a role="menuitem" target="_blank" href="<?php echo bu('agent/expand_doctor/'.@$b->id.'/1')?>"><i class="fa fa-wa fa-pencil"></i> Edit Profile</a>
            </li>
            <li role="presentation">
            	<a role="menuitem" href="<?php echo bu('doctor/delete_t_plan/' );?>">
                	<i class="fa fa-wa fa-trash-o"></i> Delete
                </a>
            </li>
            <hr />
            
             <li role="presentation" >
            	 
				<?php  if(@$b->dc_verified!=0) echo '<a role="menuitem"   href="'.bu('agent/dc_verified/'.$b->id).'"><i class="fa fa-check"></i>DC Verified</a>'; 
				else  echo '<a role="menuitem"   href="'.bu('agent/dc_verified/'.$b->id).'"><i class="fa fa-dot-circle-o"></i>DC Unverified</a>'; 
				
				?> 
            </li>
            <li role="presentation" class="printme" data-print_type="treatment_plans" data-pid="<?php  ?>"> 
            	<a role="menuitem"  href=""><i class="fa fa-wa fa-print"></i> Print</a>
            </li>
            <li role="presentation" class="printme_dot_matrix" data-print_type="treatment_plans" data-pid="<?php  ?>">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-print"></i> Dot Matrix Print</a>
            </li>
            <hr />
             <li role="presentation" class="save_me" data-print_type="treatment_plans" data-pid="<?php  ?>">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-file-text"></i> Save as PDF</a>
            </li>
             
            <li role="presentation">
            	<a role="menuitem"  href="<?php echo bu('doctor/printouts');?>"><i class="fa fa-wa fa-gear"></i> Print Settings</a>
            </li>
            <hr>
            <li role="presentation">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-tasks"></i> View Patient Timeline</a>
            </li>
          </ul> 
    </div></td>
                </tr>
                 
                <?php endforeach;?>
            

	

<?php		
		}
public function expand_doctor($d_id,$edit=0,$redirect=NULL){
	
	
	$this->load->model('doctor_m');
	
	//Role of the agent
	$role=$this->session->userdata('a_role');
	$a_id=$this->session->userdata('a_id');
	if($role=='dc_admin'){
		//Allow access
		$doctor_data=$this->doctor_m->get($d_id,true); 
		}
	else if($role=='dc_agent'){
		//Check if the d_id belongs to the agent 
		$doctor_data=$this->doctor_m->get_by(array('agent'=>$a_id,'id'=>$d_id),true); 
		}
	if(count($doctor_data)){
			$data=array(
				'name'	=>$doctor_data->name,
				'email'	=>$doctor_data->email,
				'unique_id'	=>$doctor_data->unique_id,
				'id'		=>$doctor_data->id,
				'loggedin'	=>TRUE,
				);			
			$this->session->set_userdata($data);
			if(!empty($redirect)) {redirect($redirect); return;}
			if($edit )redirect(bu('doctor/profile'));
			else redirect(bu('doctor/dashboard'));
			}
	else show_404();
		
	
	}

public function add_new_doctor(){
	$this->data['page_title']='Add new Doctor';
	$this->data['sub_view']='add_new_doctor';	 	
	$this->load->view('agent/layout.php',$this->data);
	
	}
	
public function  dc_verified($did=NULL){
	$did=sql_filter($did);
	$a_role=$this->session->userdata('a_role');
	if($a_role=='agent') if(!check_valid_doctor_for_agent($did)){show_404(); return;}
	 
	$this->data['page_title']='DC Verification';
	$this->data['did']=$did;
	$this->data['sub_view']='dc_verification';	 	
	$this->load->view('agent/layout.php',$this->data);
	}

public function dc_verified_list($return_error_count=0){ 
	$did=sql_filter($this->input->post('did'));
	$this->load->model('doctor_m');
	$a_id=$this->session->userdata('a_id');
	$doctor_data=$this->doctor_m->get_by(array('id'=>$did),true);	
	
	$errors=0;
	$data=array(
		'name'	=>$doctor_data->name,
		'email'	=>$doctor_data->email,
		'unique_id'	=>$doctor_data->unique_id,
		'id'		=>$doctor_data->id,
		'loggedin'	=>TRUE,
		);			
	$this->session->set_userdata($data);
	
	$array_checker=array(
	'email'		=>'Email address',
	'name'		=>'Name',
	'phone'		=>'Phone number',
	'address_1'	=>'Address',
	'facebook'	=>'Facebook',
	'speciality'=>'Speciality',
	'about'=>'Description',
	'education'=>'Education',
	'experience'=>'Experience',  
	'primary'=>'Primary Clinic',
	);
			
	$html='';
	foreach($array_checker as $a=>$b){
	if(empty($doctor_data->$a)) {$html.='<div class="callout callout-danger"> <p><strong><i class="fa fa-times"></i> '.ucfirst($a).' Check: </strong>'.$b.' required. <a href="'.bu('doctor/profile/').'">Edit Profile</a></p> </div>';
	$errors+=1;
	}
	else $html.='<div class="callout callout-success"> <p><strong><i class="fa fa-check"></i> '.$b.' Check: </strong>'.$b.' present. </p> </div>';
	
	}
	 
	if(!empty($doctor_data->primary)){
		//Get the primary clinic details here
		$this->load->model('clinic_m');
		$clinic_data=$this->clinic_m->get($doctor_data->primary,true);
		if(count($clinic_data)){
			$array_checker=array( 
				'name'		=>'Name',
				'phone'		=>'Clinic Phone number',
				'pin'		=>'Clinic Pin Code',
				'speciality'=>'Clinic Speciality', 
				'about'		=>'Clinic Description(About)', 
				);
		foreach($array_checker as $a=>$b){
				if(empty($clinic_data->$a)) {$html.='<div class="callout callout-danger"> <p><strong><i class="fa fa-times"></i> '.ucfirst($a).' Check: </strong>'.$b.' required. <a href="'.bu('doctor/edit_clinic/'.$clinic_data->id.'/'.$doctor_data->unique_id).'">Edit Clinic</a></p> </div>';
				$errors+=1;
				}
				else $html.='<div class="callout callout-success"> <p><strong><i class="fa fa-check"></i> '.$b.' Check: </strong>'.$b.' present. </p> </div>';
				
				}
			$time=json_decode(@$clinic_data->time,true);
			if(!count($time)){$html.='<div class="callout callout-danger"> <p><strong><i class="fa fa-times"></i> Timing Check: </strong>Atleast 1 doctor timing is required. <a href="'.bu('doctor/edit_clinic/'.$clinic_data->id.'/'.$doctor_data->unique_id).'">Edit Clinic</a></p> </div>';
			$errors+=1;
			}
				else $html.='<div class="callout callout-success"> <p><strong><i class="fa fa-check"></i> Timing Check: </strong>Timing present. </p> </div>';
			}
			
		}
	
	
	if($errors)
	$html.='<br><button class="btn btn-sm btn-warning btn-flat disabled">Fix the problem first</button>';
	else{
		if($doctor_data->dc_verified==0)
		$html.='<br><button class="btn btn-sm btn-primary btn-flat" data-toggle="modal" data-target="#selectPlan" onclick="calculate_total()">Proceed to Next Step</button>';
		else $html.='<br><a href="'.bu('agent/unverify/'.$doctor_data->id).'" class="btn btn-sm btn-info btn-flat">UnVerify Account</a>';
		}
	
	if($return_error_count){ return $errors;}
	echo $html;
	
	}

public function unverify($did){
	if(!check_valid_doctor_for_agent($did)){ show_404(); return;}
	$this->load->model('doctor_m');
	$data=array();
	$data['dc_verified']=0;
	 
	if($this->doctor_m->save($data,$did)){
		$this->session->set_flashdata('message','<i class="glyphicon glyphicon-ok"></i> &nbsp;Successfully updated');
		$this->session->set_flashdata('type','success');
	 
		redirect((bu('agent/doctors')));
		}
	}
public function validate_coupon(){
	$coupon=sql_filter($this->input->post('coupon'));
	$total =sql_filter($this->input->post('total'));
	$this->load->model('coupon_m');
	$coupon_data=$this->coupon_m->get_by(array('coupon'=>$coupon),true);
	if(!count($coupon_data)){
		
		}
	else{
		$value			=$coupon_data->value;
		$type			=$coupon_data->type;
		$max_discount	=$coupon_data->max_discount;
		$min_amount		=$coupon_data->min_amount;
		$expire			=$coupon_data->expire;
		
		if($total<$min_amount){
			echo '<div class="callout callout-warning">This coupon is only valid for a amount of more than <i class="fa fa-inr"></i> '.$min_amount.'</div>';
		return;}
		
		$today=date("Y-m-d");
		$today_time	=strtotime($today);		
		$expire_time=strtotime($expire);
		if($expire_time<$today_time){
			echo '<div class="callout callout-warning">This coupon has expired. Please use another one.</div>';
		return;}
		
		//Discount amount
		$discount_amount=$value;
		if($type=='percent'){$discount_amount=$total*$value*.01; }
		if($type=='amount') {$discount_amount= $value; }
		
		if($discount_amount>$max_discount){
			$discount_amount=$max_discount;
			echo '<div class="callout callout-success">You have reached maximimum discount amount. A discount of  <i class="fa fa-inr"></i> '.$discount_amount.' is added.<br><strong>Total:</strong> <i class="fa fa-inr"></i> '.($total-$discount_amount).'</div>';
			}
		else{
			echo '<div class="callout callout-success">A discount of  <i class="fa fa-inr"></i> '.$discount_amount.' is deducted.
			 <br><strong>Total:</strong> <i class="fa fa-inr"></i> '.($total-$discount_amount).'</div>';
			}
		}
		
	
	}

public  function pay_money(){
	$this->load->view('agent/sub_view/pay_money');
	}
 
}


