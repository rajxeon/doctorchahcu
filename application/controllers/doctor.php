<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Doctor extends Doctor_Controller {
	
	public function __construct(){
		parent::__construct();
		}

	public function index(){
		//This is also the regiseter page for the doctors
		$rule=array(
			'email'	=>array('field'=>'primary_email_address','label'=>'Email','rules'=>'trim|required|xss_clean|max_length[50]|valid_email|is_unique[doctors.email]'),
			'name'	=>array('field'=>'name','label'=>'Name','rules'=>'trim|required|xss_clean|max_length[50]'),
			'phone'	=>array('field'=>'primary_contact_number','label'=>'Phone Number','rules'=>'trim|numeric|required|xss_clean|max_length[50]'),
			'password_1'=>array('field'=>'password','label'=>'Password','rules'=>'trim|required|min_length[6]|matches[c_password]'),
			'password_2'=>array('field'=>'c_password','label'=>'Confirm Password','rules'=>'trim|required'),
			);
		$this->form_validation->set_rules($rule);
		$this->form_validation->set_message('is_unique', 'The %s is already registered. Please 
		<a href="'.base_url().'doctor/login'.'" style="color:#fff"><button type="button" class="btn btn-danger btn-xs">Login</button></a>
		 with this email.');
		 
		$this->load->library('form_validation');		
		if($this->form_validation->run()==TRUE){
			if(isset($_POST['agent'])) $agent=$this->input->post('agent');
			else $agent='';
			
			$email		=sql_filter($this->input->post('primary_email_address'));
			$name		=sql_filter($this->input->post('name'));
			$phone		=sql_filter($this->input->post('primary_contact_number'));
			
			$password=sql_filter($this->input->post('password'));
			$password=hash_it($password);
			$data=array('email'=>$email,'name'=>$name,'phone'=>$phone,'password'=>$password,'review'=>'','agent'=>$agent);
			$id=$this->doctor_m->register($data);
			if($id){
				$this->load->model('doc_m');
				$this->doc_m->save(array('doctor_id'=>$id));
				redirect(base_url().'doctor/dashboard');
				}
			
			
			}
		else {$this->data['post_message']=validation_errors();}
		
		
		$this->data['sub_view']='register';
		$this->load->view('template',$this->data);
		
		
	}
	
	public function login(){
		
		$dashboard=base_url().'doctor/dashboard';
		
		$this->doctor_m->loggedin()==FALSE || redirect($dashboard);
		
		$rules	=array(
					'email'	=>array('field'=>'email','label'=>'Email','rules'=>'trim|required|valid_email|xss_clean'),
					'password'	=>array('field'=>'password','label'=>'Password','rules'=>'trim|required')
					);
					
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run()==TRUE){
			//Validation is passed
			$this->doctor_m->login();
			
			if($this->doctor_m->loggedin()==TRUE) {
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
		
		$this->data['sub_view']='login';
		$this->load->view('template',$this->data);
		
		}
		
	public function logout(){
		$this->doctor_m->logout();		
		redirect(base_url().'doctor');
		}
	
	public function dashboard(){
		$this->data['page_title']='Dashboard';
		$this->data['sub_view']='dashboard';
		$this->load->view('doctor_admin/layout',$this->data);
		}
		
	
	public function upload_clinic_logo($id=NULL){   
	 	
		if($id==NULL) {echo 'No arguements';return;}
		include(('includes/resize-class.php'));
		
		$data=$this->doctor_m->get($id,TRUE);
		$dir=(config_item('clinic_image').$id.'/');
		
		
		if ( 0 < $_FILES['file']['error'] ) {
			  echo 'Error: ' . $_FILES['file']['error'] . '<br>';
			 
		    }
		    else { 	
			    $path= $dir;
			    if(!is_dir($path)){mkdir($path,0755); }
			    {$path;
				 $size=$_FILES['file']['size']/1024;  
				 $type=$_FILES['file']['type'];
				 $name=urlencode($_FILES['file']['name']);
				 if($size>300) echo 'Use a file that is less than 300kb';
				 elseif($type!='image/gif'&&$type!='image/jpeg'&&$type!='image/png'&& $type!='image/jpeg')				 echo 'Only image files are allowed';
			     elseif(empty($name)) echo 'File name can not be empty';
				 else {
					 //Upload the file and resize it to 150x150
					 $norm_path=$path.'/logo.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
					 
					 if			(is_file($path.'/logo'.'.png')){unlink($path.'/logo'.'.png');}
					 elseif		(is_file($path.'/logo'.'.jpg')){unlink($path.'/logo'.'.jpg');}
					 elseif		(is_file($path.'/logo'.'.gif')){unlink($path.'/logo'.'.gif');}
					 elseif		(is_file($path.'/logo'.'.jpeg')){unlink($path.'/logo'.'.jpeg');}
					 
					
					 move_uploaded_file($_FILES['file']['tmp_name'],$norm_path );
					 $resizeObj = new resize($norm_path);
					 $resizeObj -> resizeImage(200, 200, 'crop');
					 $resizeObj -> saveImage($norm_path, 80);  //80% Quality
					 echo 'TRUE';
					 
					 }
			  	
				    }
		    }
		}
	public function upload_profile_image($id=NULL){   //This is a ajax function call from 'views/doctor_Admin/sub_view/profile.php'
	 	
		if($id==NULL) {echo 'No arguements';return;}
		include(('includes/resize-class.php'));
		
		$data=$this->doctor_m->get($id,TRUE);
		$dir=$data->unique_id;
		
		if ( 0 < $_FILES['file']['error'] ) {
			  echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		    }
		    else {
			    $path= ('user_upload/'.$dir);
			    if(!is_dir($path)){mkdir($path,0755); }
			     {
				 $size=$_FILES['file']['size']/1024;  
				 $type=$_FILES['file']['type'];
				 $name=urlencode($_FILES['file']['name']);
				 if($size>300) echo 'Use a file that is less than 300kb';
				 elseif($type!='image/gif'&&$type!='image/jpeg'&&$type!='image/png'&& $type!='image/jpeg')				 echo 'Only image files are allowed';
			       elseif(empty($name)) echo 'File name can not be empty';
				 else {
					 //Upload the file and resize it to 150x150
					 $norm_path=$path.'/dp.' .pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
					 
					 if			(is_file($path.'/dp'.'.png')){unlink($path.'/dp'.'.png');}
					 elseif		(is_file($path.'/dp'.'.jpg')){unlink($path.'/dp'.'.jpg');}
					 elseif		(is_file($path.'/dp'.'.gif')){unlink($path.'/dp'.'.gif');}
					 elseif		(is_file($path.'/dp'.'.jpeg')){unlink($path.'/dp'.'.jpeg');}
					 
					 move_uploaded_file($_FILES['file']['tmp_name'],$norm_path );
					 $resizeObj = new resize($norm_path);
					 $resizeObj -> resizeImage(200, 200, 'crop');
					 $resizeObj -> saveImage($norm_path, 80);  //80% Quality
					 echo 'TRUE';
					 }
			  	
				    }
		    }
		}
		
	public function profile(){		
		$rule=array(
			//Personal Details
			'name'	=>array('field'=>'name','label'=>'Name','rules'=>'trim|required|xss_clean|max_length[100]'),
			'gender'	=>array('field'=>'gender','label'=>'Gender','rules'=>'trim|xss_clean'),
			'address_1'	=>array('field'=>'address_1','label'=>'Address Line 1','rules'=>'trim|xss_clean|max_length[100]'),
			'address_2'	=>array('field'=>'address_2','label'=>'Address Line 2','rules'=>'trim|xss_clean|max_length[100]'),
			'landline'	=>array('field'=>'landline','label'=>'Land Line','rules'=>'trim|xss_clean|max_length[100]'),
			
			//Social details
			'facebook'		=>array('field'=>'facebook','label'=>'Facebook profile','rules'=>'trim|xss_clean|max_length[100]'),
			'twitter'		=>array('field'=>'twitter','label'=>'Twitter','rules'=>'trim|xss_clean|max_length[100]'),
			'google_plus'	=>array('field'=>'google_plus','label'=>'Google +','rules'=>'trim|xss_clean|max_length[100]'),
			'website'		=>array('field'=>'website','label'=>'Website','rules'=>'trim|xss_clean|max_length[100]'),
			'about'			=>array('field'=>'about','label'=>'About','rules'=>'trim|xss_clean|max_length[3000]'),
			
			//Professional Details
			
			//'achivements'	=>array('field'=>'achivements','label'=>'Achivements','rules'=>'trim|xss_clean|max_length[500]'),
			
			 
			);
		$this->form_validation->set_rules($rule);
		
		$this->load->helper('security');
		
		if($this->form_validation->run()==TRUE){
			$errors			='';
			
			$name				=sql_filter($this->input->post('name'));
			$gender				=sql_filter($this->input->post('gender'));
			$address_1			=sql_filter($this->input->post('address_1'));
			$address_2			=sql_filter($this->input->post('address_2'));
			$landline			=sql_filter($this->input->post('landline'));
			$facebook			=sql_filter($this->input->post('facebook'));
			$twitter			=sql_filter($this->input->post('twitter'));
			$google_plus		=sql_filter($this->input->post('google_plus'));
			$website			=sql_filter($this->input->post('website'));
			$about				=sql_filter($this->input->post('about'));
			
			
			//Membership
			$membership			=$this->input->post('membership');
			if(is_array($membership) and sizeof($membership)>0){
				echo 1;
				$membership			=array_filter(array_unique($membership));
				$membership			=xss_clean(implode(':-:',$membership));	
				}
			else $membership='';
		
			//Service
			$service			=$this->input->post('service');
			if(is_array($service) and sizeof($service)>0){
				$service			=array_filter(array_unique($service));
				$service			=xss_clean(implode(':-:',$service));	
				}
			else $service='';
			
			
			//Speciality
			$speciality				=$this->input->post('speciality');
			if(is_array($speciality) and sizeof($speciality)>0){
				$speciality			=array_filter(array_unique($speciality));
				$sp_fib				=$speciality	;
				$speciality			=xss_clean(implode(',',$speciality));
				}
			else $speciality='';
			
			$speciality_parent=',';
			if(!empty($sp_fib)){
				$sql="SELECT COLUMN_NAME from information_schema.COLUMNS where TABLE_NAME='speciality'";
				$res=$this->db->query($sql)->result();
				$speciality_parent=array();
				foreach($sp_fib as $aa=>$bb){
					foreach($res as $cc=>$dd){
						$sql="SELECT `".$dd->COLUMN_NAME."` FROM `speciality` WHERE `".$dd->COLUMN_NAME."`='$bb'";
						if($this->db->query($sql)->num_rows()){ $speciality_parent[]=$dd->COLUMN_NAME; }
						
						}
					
					
					}
				$speciality_parent=array_unique($speciality_parent);
				$speciality_parent=implode(',',$speciality_parent);
				$speciality_parent=','.$speciality_parent.',';
				}
			
			
			
				
			
			//Education
			$education			=$this->input->post('education');
						
			if(is_array($education) and sizeof($education)%3==0){
					$edu_str='';
					for($i=0;$i<sizeof($education);$i+=3){
						$edu_str.=$education[$i];
						$edu_str.='<::>';
						$edu_str.=$education[$i+1];
						$edu_str.='<::>';
						$edu_str.=$education[$i+2];
						$edu_str.=':-:';
						}
					$edu_str=xss_clean($edu_str);
					}
			else $edu_str='';
			
			//Experience
			$experience			=$this->input->post('experience');
			
			if(is_array($experience) and sizeof($experience)%5==0){
					$exp_str='';
					for($i=0;$i<sizeof($experience);$i+=5){
						$exp_str.=$experience[$i];
						$exp_str.='<::>';
						$exp_str.=$experience[$i+1];
						$exp_str.='<::>';
						$exp_str.=$experience[$i+2];
						$exp_str.='<::>';
						$exp_str.=$experience[$i+3];
						$exp_str.='<::>';
						$exp_str.=$experience[$i+4];
						$exp_str.=':-:';
						}
					$exp_str=xss_clean($exp_str);
					
				}
			else $exp_str='';
			
			//Achivements
			$achivements			=$this->input->post('achivements');
						
			if(is_array($achivements) and sizeof($achivements)%2==0){
				$ach_str='';
				for($i=0;$i<sizeof($achivements);$i+=2){
					$ach_str.=$achivements[$i];
					$ach_str.='<::>';
					$ach_str.=$achivements[$i+1];
					$ach_str.=':-:';
					}
				$ach_str=xss_clean($ach_str);
				}
			else $ach_str='';
			
			
			//Registration
			$registration			=$this->input->post('registration');
			
			if(is_array($registration) and sizeof($registration)%3==0){
				$reg_str='';
				for($i=0;$i<sizeof($registration);$i+=3){
					$reg_str.=$registration[$i];
					$reg_str.='<::>';
					$reg_str.=$registration[$i+1];
					$reg_str.='<::>';
					$reg_str.=$registration[$i+2];
					$reg_str.=':-:';
					}
				$reg_str=xss_clean($reg_str);					
				}
			else $reg_str='';
			
			
			
			
			$data=array('name'=>$name,
					'gender'=>$gender,
					'address_1'=>$address_1,
					'address_2'=>$address_2,
					'landline'=>$landline,
					'facebook'=>$facebook,
					'twitter'=>$twitter,
					'google_plus'=>$google_plus,
					'website'=>$website,
					'speciality'=>$speciality,
					'speciality_parent'=>$speciality_parent,
					'address_1'=>$address_1,
					'education'=>$edu_str,
					'achivements'=>$ach_str,
					'registration'=>$reg_str,
					'experience'=>$exp_str,
					'membership'=>$membership,
					'about'=>$about,
					'service'=>$service);
			
			
			if($this->doctor_m->save($data,$this->session->userdata('id'))){
				$this->session->set_flashdata('message', 'Successfully Updated');
				$this->session->set_flashdata('type', 'success');
				
			
				//redirect(base_url().'doctor/profile');
				}
			
			}
		else {$this->data['post_message']=validation_errors();}
		
		
		$this->data['page_title']='Doctor Profile';
		$this->data['sub_view']='profile';
		$this->load->view('doctor_admin/layout',$this->data);
		}
	
	public function clinic(){	
	
		$this->load->model('clinic_m');	
		$rule=array(
			'name'	=>array('field'=>'name','label'=>'Clinic Name','rules'=>'trim|required|xss_clean|max_length[100]'),
			'pin'		=>array('field'=>'pin','label'=>'Pin code','rules'=>'trim|required|xss_clean|max_length[6]|numeric'),
			);
		$this->form_validation->set_rules($rule);
		
		if($this->clinic_m->get_clinic_number_limit(TRUE)<=0){
			$this->data['message']='<strong>Clinic limit reached! </strong>You can not add more clinic. Please upgrade your plan.
			<a href="'.bu('doctor/plans').'"><button type="button" class="btn btn-success">View plans</button></a> ';
			$this->data['type']='danger';
			}
		
		elseif($this->form_validation->run()==TRUE){
			$name				=sql_filter($this->input->post('name'));
			$pin				=sql_filter($this->input->post('pin'));
			$doctor_id			=sql_filter($this->session->userdata('id'));
			$d_s				='{"'.$doctor_id.'":"0"}';	//Default shedule
			$data=array('name'	=>$name,
					'pin'		=>$pin,
					'doctor_id'	=>$doctor_id,
					'sunday'	=>$d_s,	
					'monday'	=>$d_s,	
					'tuesday'	=>$d_s,	
					'wednesday'	=>$d_s,	
					'thursday'	=>$d_s,	
					'friday'	=>$d_s,	
					'saturday'	=>$d_s,		
					'review'=>''			
					);
			
			
			$temp=$this->db->query("SELECT id FROM clinic WHERE doctor_id='".$this->session->userdata('id')."'")->result();
			$data['sort_order']=sizeof($temp)+1;
			
			$insert_id=$this->clinic_m->save($data);
			
			$slug=strtolower(str_replace(' ','-',$name));
			$temp_c=$this->db->query("SELECT id FROM clinic WHERE slug='$slug'")->num_rows();
			if($temp_c) $slug=$slug.'-'.$insert_id;
			$data['slug']=$slug;
			//var_dump($data);
			$this->clinic_m->save($data,$insert_id);
			
			$data=array('clinic_id'=>$insert_id,'doctor_id'=>$this->session->userdata('id'));			
			$this->db->insert('shedule',$data);
			
			
			$this->data['message']='<i class="glyphicon glyphicon-ok"></i> New clinic added successfully.
			Click on the <i class="glyphicon glyphicon-pencil"></i>(Edit) button below to schedule your appointments.
			';
			$this->data['type']='success';
			}
		else {
			$this->data['message']=validation_errors();
			$this->data['type']='danger';
			}
		$this->data['page_title']='Available Clinic';	
		$this->data['sub_view']='clinic';
		$this->load->view('doctor_admin/layout',$this->data);
		}
	
	public function delete_clinic($clinic_id,$doctor_id){
		//Ckeck for authentic user
		
		if($doctor_id!=$this->session->userdata('unique_id')){
			$this->session->set_flashdata('message','<i class="glyphicon glyphicon-exclamation-sign"></i> User id is not authentic');
			$this->session->set_flashdata('type','danger');
			redirect(bu('doctor/clinic'));
			}
		if($this->db->query("DELETE FROM clinic WHERE doctor_id='$doctor_id' AND id=$clinic_id")){
			$this->db->query("DELETE FROM shedule WHERE doctor_id='$doctor_id' AND clinic_id=$clinic_id");
			if($this->db->affected_rows()){
				$this->session->set_flashdata('message','<i class="glyphicon glyphicon-ok"></i> Successfully deleted');
				$this->session->set_flashdata('type','success');
				redirect(bu('doctor/clinic'));
				}
			else {
				$clinic_id=mysql_real_escape_string($clinic_id);
				$other_doctors=$this->db->query("SELECT id,other_doctors FROM clinic WHERE id=$clinic_id")->result();
				$other_doctors=(array) $other_doctors[0];
				$others=array_unique(array_filter(explode(',',$other_doctors['other_doctors'])));
				
				$doc_id=explode('_',$doctor_id);
				$doc_id=$doc_id[0];
				if(in_array($doc_id,$others)){
					$temp_array=array();
					foreach($others as $a=>$b){if($b!=$doc_id) $temp_array[]=$b;}
					$temp_array=','.implode(',',$temp_array).',';
					$data['other_doctors']=$temp_array;
					$this->load->model('clinic_m');
					$this->clinic_m->save($data,$clinic_id);
					$this->session->set_flashdata('message','<i class="glyphicon glyphicon-remove"></i> Successfully deleted');				$this->session->set_flashdata('type','success');
					redirect(bu('doctor/clinic'));
					}
				
				$this->session->set_flashdata('message','<i class="glyphicon glyphicon-remove"></i> This clinic does not belong to you');				$this->session->set_flashdata('type','danger');
				redirect(bu('doctor/clinic'));
				}
			
			}
		
		}
	public function edit_clinic_ext($clinic_id,$doctor_id){
		$this->load->model('clinic_m');
		
		if($doctor_id!=$this->session->userdata('unique_id')){
			$this->session->set_flashdata('message','<i class="glyphicon glyphicon-exclamation-sign"></i> User id is not authentic');
			$this->session->set_flashdata('type','danger');
			redirect(bu('doctor/clinic'));
			}
		
		$clinic_id=mysql_real_escape_string($clinic_id);
		$other_doctors=$this->db->query("SELECT id,other_doctors FROM clinic WHERE id=$clinic_id")->result();
		
		if(!sizeof($other_doctors)){
			
			$this->session->set_flashdata('message','<i class="glyphicon glyphicon-exclamation-sign"></i> No clinic found.');
			$this->session->set_flashdata('type','danger');
			redirect(bu('doctor/clinic'));
			}
			
		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			
			$rules=array(
			
			'fee'		=>array('field'=>'fee','label'=>'Fee','rules'=>'trim|required|xss_clean|max_length[100]|numeric'),
			'time'	=>array('field'=>'time','
			 label'=>'Time allocated','rules'=>'trim|required|xss_clean|max_length[100]|numeric|callback__time_check'),
			);
		
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run()==TRUE){
				$ddata=array();
				
				$time			=$this->input->post('time');
				$fee			=$this->input->post('fee');
				
				$res=$this->db->query("SELECT id,fee,time FROM clinic WHERE id=$clinic_id LIMIT 1")->result();
				$res=$res[0];
				
				$parent_time=json_decode($res->time,true);
				$parent_time[$this->session->userdata('id')]=$time;
				$parent_time=json_encode($parent_time);
				
				$parent_fee=json_decode($res->fee,true);
				$parent_fee[$this->session->userdata('id')]=$fee;
				$parent_fee=json_encode($parent_fee);
				
				
				$ddata['fee']	=$parent_fee;
				$ddata['time']	=$parent_time;
				
				if($this->clinic_m->save($ddata,$clinic_id)){
					$this->session->set_flashdata('message','<i class="glyphicon glyphicon-ok"></i> &nbsp;Successfully updated');
					$this->session->set_flashdata('type','success');
					redirect(bu('doctor/edit_clinic_ext/'.$clinic_id.'/'.$doctor_id));
					}
				}			
			else {
					$this->data['message']=validation_errors();
					$this->data['type']='danger';
					redirect(bu('doctor/edit_clinic_ext/'.$clinic_id.'/'.$doctor_id));
					}
			}	
		if(isset($other_doctors[0])){
			$other_doctors=(array) $other_doctors[0];
			$others=array_unique(array_filter(explode(',',$other_doctors['other_doctors'])));
			$doc_id=explode('_',$doctor_id);
			$doc_id=$doc_id[0];
			if(in_array($doc_id,$others)){
				
				$this->data['page_title']='Edit Clinic';	
				$this->data['sub_view']='clinic_edit_ext';
				$this->load->view('doctor_admin/layout',$this->data);
				
				}
			}
		}
	public function edit_clinic($clinic_id,$doctor_id){
		$this->load->model('clinic_m');
		if($doctor_id!=$this->session->userdata('unique_id')){
			$this->session->set_flashdata('message','<i class="glyphicon glyphicon-exclamation-sign"></i> User id is not authentic');
			$this->session->set_flashdata('type','danger');
			redirect(bu('doctor/clinic'));
			}
		$sql="SELECT * FROM clinic WHERE id='$clinic_id' AND doctor_id='".$this->session->userdata('id')."'";
		$row=$this->db->query($sql)->result();
		if(!sizeof($row)){
			
			$this->session->set_flashdata('message','<i class="glyphicon glyphicon-exclamation-sign"></i> No clinic found.');
			$this->session->set_flashdata('type','danger');
			redirect(bu('doctor/clinic'));
			}
			
		$rules=array(
			'name'	=>array('field'=>'name','label'=>'Clinic Name','rules'=>'trim|required|xss_clean|max_length[100]'),
			'phone'	=>array('field'=>'phone','label'=>'Phone Number','rules'=>'trim|xss_clean|max_length[100]'),
			'fee'		=>array('field'=>'fee','label'=>'Fee','rules'=>'trim|required|xss_clean|max_length[100]|numeric'),
			'visibility'=>array('field'=>'visibility','label'=>'Visibility','rules'=>'trim|required|xss_clean|max_length[1]|numeric'),
			'time'	=>array('field'=>'time','
			 label'=>'Time allocated','rules'=>'trim|required|xss_clean|max_length[100]|numeric|callback__time_check'),
			'pin'		=>array('field'=>'pin','label'=>'Postal Code','rules'=>'trim|required|xss_clean|max_length[6]|numeric|callback__pin_check'),
			'street'	=>array('field'=>'street','label'=>'Street address','rules'=>'trim|xss_clean|max_length[100]'),
			'locality'	=>array('field'=>'locality','label'=>'Locality','rules'=>'trim|xss_clean|max_length[100]'),
			'city'	=>array('field'=>'city','label'=>'City name','rules'=>'trim|xss_clean|max_length[100]'),
			'district'	=>array('field'=>'district','label'=>'District','rules'=>'trim|xss_clean|max_length[100]'),
			'state'	=>array('field'=>'state','label'=>'State','rules'=>'trim|xss_clean|max_length[100]'),
			'landmark'	=>array('field'=>'landmark','label'=>'Landmark','rules'=>'trim|xss_clean|max_length[100]'),
			'sort_order'=>array('field'=>'sort_order','label'=>'Sort order','rules'=>'trim|xss_clean|max_length[100]'),
			'latitude'=>array('field'=>'lat','label'=>'Latitude','rules'=>'trim|xss_clean|max_length[100]'),
			'longitude'=>array('field'=>'lon','label'=>'Longitude','rules'=>'trim|xss_clean|max_length[100]'),
			'about'=>array('field'=>'about','label'=>'About','rules'=>'trim|xss_clean|max_length[3000]'),
			 
			);
		
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run()==TRUE){
			$data=array();
			$data['name']		=sql_filter($this->input->post('name'));
			$data['phone']		=sql_filter($this->input->post('phone'));
			
			$time				=sql_filter($this->input->post('time'));
			$fee				=sql_filter($this->input->post('fee'));
			
			$res=$this->db->query("SELECT id,fee,time FROM clinic WHERE id=$clinic_id LIMIT 1")->result();
			$res								=$res[0];
			
			$parent_time						=json_decode($res->time,true);
			$parent_time[$this->session->userdata('id')]	=$time;
			$parent_time						=json_encode($parent_time);
			
			$parent_fee							=json_decode($res->fee,true);
			$parent_fee[$this->session->userdata('id')]	=$fee;
			$parent_fee							=json_encode($parent_fee);
			
			$this->load->helper('security');
			$speciality				=$this->input->post('speciality');
			if(is_array($speciality) and sizeof($speciality)>0){
				$speciality			=array_filter(array_unique($speciality));
				$speciality			=xss_clean(implode(',',$speciality));
				}
			else $speciality='';
			
			$data['speciality']		=sql_filter($speciality);
			
			$data['fee']			=$parent_fee;
			$data['time']			=$parent_time;
			
			$data['visibility']		=sql_filter($this->input->post('visibility'));
			$data['visibility']		=boolval($data['visibility']);
			$data['pin']			=sql_filter($this->input->post('pin'));
			$data['street']			=sql_filter($this->input->post('street'));
			$data['locality']		=sql_filter($this->input->post('locality'));
			$data['city']			=sql_filter($this->input->post('city'));
			$data['district']		=sql_filter($this->input->post('district'));
			$data['state']			=sql_filter($this->input->post('state'));
			$data['landmark']		=sql_filter($this->input->post('landmark'));
			$data['sort_order']		=sql_filter($this->input->post('sort_order'));
			$data['latitude']		=sql_filter($this->input->post('lat'));
			$data['longitude']		=sql_filter($this->input->post('lon'));
			$data['about']			=sql_filter($this->input->post('about'));
			
			if($this->clinic_m->save($data,$clinic_id)){
				$this->session->set_flashdata('message','<i class="glyphicon glyphicon-ok"></i> &nbsp;Successfully updated');
				$this->session->set_flashdata('type','success');
				redirect(bu('doctor/edit_clinic/'.$clinic_id.'/'.$doctor_id));
				}
			}
		else {
			$this->data['message']=validation_errors();
			$this->data['type']='danger';
			}
		$this->data['page_title']='Edit Clinic';	
		$this->data['sub_view']='clinic_edit';
		$this->load->view('doctor_admin/layout',$this->data);
		
		}
	
	public function _time_check($str){
		$array=array('3','5','7','10','15','20','30','45','60');
		if(!in_array($str,$array)){
			$this->form_validation->set_message('_time_check', 'The %s does not belongs to our database.');
			return FALSE;
			}
		else return TRUE;
		}
	
	public function _pin_check($str){
		$num_rows=$this->db->query('SELECT id FROM location WHERE pin="'.$str.'"')->num_rows();
		if(!$num_rows){
			$this->form_validation->set_message('_pin_check', 'The pin code is not valid or this pin is not in our database');
			return FALSE;
			}
		else return TRUE;
		}
	
	public function ajax_address_getter($pin=NULL){
		$pin=intval($pin);
		$result=$this->db->query("SELECT * FROM location WHERE pin='$pin'")->result();
		if(sizeof($result)==0){echo 0;return;}
		
		$locality=array();
		$city=array();
		$state=$result[0]->state;
		$district=$result[0]->district;
		foreach($result as $a=>$b){
			$locality[]	=$b->locality;
			$city[]	=$b->city;
			}
		$locality	=array_unique(array_filter($locality));
		$city		=array_unique(array_filter($city));
		
		$json='{';
		$json.='"state":"'.ucfirst(strtolower($state)).'",';
		$json.='"district":"'.ucfirst(strtolower($district)).'",';
		$json.='"city":"';
		foreach($city as $a=>$b){
			$json.=$b.',';
			}
		$json=rtrim($json,',');
		$json.='",';
		
		$json.='"locality":"';
		foreach($locality as $a=>$b){
			$json.=$b.',';
			}
		$json=rtrim($json,',');
		$json.='"';
		$json.='}';
		
		echo $json;
		}
	
	public function ajax_clone($day){
		echo '<div class="form-group">
		  <label>Select Day</label>
		  <select class="form-control">
			<option>option 1</option>
			<option>option 2</option>
			<option>option 3</option>
			<option>option 4</option>
			<option>option 5</option>
		  </select>
		</div>';
		}
	
	public function ajax_time_range($day,$clinic_id,$doctor_id){
		$doctor_id=explode('_',$doctor_id);
		$doctor_id=$doctor_id[0];
		$res=$this->db->query("SELECT $day from clinic WHERE id='$clinic_id' AND doctor_id='$doctor_id'")->result();
		$json=($res[0]->sunday);
		
		if(empty($json)){
			$time=explode(':',get_now());
			
			}
		else $time=array(0,0,'AM');
		
		echo '<table>
                  	<tr>
                        	<td><div class="input-group margin">
                    <div class="input-group-btn input-group">
                        <button type="button" class="btn disco btn-default dropdown-toggle">Start Time<span class="fa fa-caret-down"></span>
                        <ul class="dropdown-menu">
                        <i class="fa fa-fw fa-times-circle close_dropdown"></i>
                        <table class="mega_me">
                                <tbody>
                                    <tr class="change_inc">
                                    	<td>
                                                <a data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                                <input type="hidden" class="d_val" value="'.$time[0].'" />
                                                <div class="bootstrap-timepicker-hour">'.$time[0].'</div>
                                                <a data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                          </td>
                                          <td>:</td>
                                          <td>
                                                <a data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                                <input type="hidden" class="d_val" value="'.$time[1].'" />
                                                <div class="bootstrap-timepicker-minute">'.$time[1].'</div>
                                                <a data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                          </td>
                                          <td>&nbsp;</td>
                                          <td>
                                                <a data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                                <input type="hidden" class="d_val" value="'.$time[2].'" />
                                                <div class="bootstrap-timepicker-meridian">'.$time[2].'</div>
                                                <a >&nbsp;</a>
                                          </td>
                                        
                        
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </ul>
                        </button>
                        
                    </div>
                    <!-- /btn-group -->
                    <input type="text" class="form-control time_picker" value="'.$time[0].':'.$time[1].' '.$time[2].'" readonly="readonly">
                </div></td>
                			<td><div class="input-group margin">
                    <div class="input-group-btn input-group">
                        <button type="button" class="btn disco btn-default dropdown-toggle">End Time<span class="fa fa-caret-down"></span>
                        <ul class="dropdown-menu">
                        <i class="fa fa-fw fa-times-circle close_dropdown"></i>
                        <table class="mega_me">
                                <tbody>
                                    <tr class="change_inc">
                                    	<td>
                                                <a data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                                <input type="hidden" class="d_val" value="'.$time[0].'" />
                                                <div class="bootstrap-timepicker-hour">'.$time[0].'</div>
                                                <a data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                          </td>
                                          <td>:</td>
                                          <td>
                                                <a data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                                <input type="hidden" class="d_val" value="'.$time[1].'" />
                                                <div class="bootstrap-timepicker-minute">'.$time[1].'</div>
                                                <a data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                          </td>
                                          <td>&nbsp;</td>
                                          <td>
                                                <a data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                                <input type="hidden" class="d_val" value="'.$time[2].'" />
                                                <div class="bootstrap-timepicker-meridian">'.$time[2].'</div>
                                                <a >&nbsp;</a>
                                          </td>
                                        
                        
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </ul>
                        </button>
                        
                    </div>
                    <!-- /btn-group -->
                    <input type="text" class="form-control time_picker" value="'.$time[0].':'.$time[1].' '.$time[2].'" readonly="readonly">
                </div></td>
                        </tr>
                  </table>';
		}
	
	public function add_shedule($clinic_id=NULL,$doctor_id=NULL,$hash,$time){
		$this->load->model('shedule_m');
		$num_rows=$this->db->where('doctor_id',$doctor_id);
		$temp=$this->shedule_m->get();
		
		if(sizeof($temp)>=7){
			$this->session->set_flashdata('message','Your can not add more than 7 shedule.');
			$this->session->set_flashdata('type','danger');
			redirect($_SERVER['HTTP_REFERER']);
			}
		
		elseif(chash($time,$hash)){
			$dummy_json='[
					    {
						  "start": "'.get_now().'",
						  "end": "'.get_now().'"
					    },
					    {
						  "start": "'.get_now().'",
						  "end": "'.get_now().'"
					    }
					]';
					
			$data=array('clinic_id'=>$clinic_id,'doctor_id'=>$doctor_id,'json'=>$dummy_json);
			$this->shedule_m->save($data);
			$this->session->set_flashdata('message','New shedule added successfully');
			$this->session->set_flashdata('type','success');
			redirect($_SERVER['HTTP_REFERER']);
			}
		else {
			$this->session->set_flashdata('message','Your cadential is not recognised');
			$this->session->set_flashdata('type','danger');
			redirect($_SERVER['HTTP_REFERER']);
			}
		}
	public function ajax_form_submit_shedule(){
		if(!isset($_POST['data_array'])) return('No data feed');
		
		$data=$_POST['data_array'];
		$data=json_decode($data,true);
		
		$temp=array();
		
		foreach($data['days'] as $a=>$b){
			
			if($b) {
				$jdata=$this->db->query("SELECT ".$a." FROM clinic WHERE id=".$data['clinic_id'].' LIMIT 1')->result();
				$jdata=(array) $jdata[0];
				$jdata=json_decode($jdata[$a],true);
				$jdata[$this->session->userdata('id')]=$data['id'];
				$jdata=json_encode($jdata);
				print_r($jdata);
				$temp[$a]=$jdata;
				}
			}
			
		if(!empty($temp)){
			$this->load->model('clinic_m');
			$this->clinic_m->save($temp,$data['clinic_id']);
			}
		
		
		$json=$data['start_end'];
		if(json_decode($json,true)){
			$meta['clinic_id']	=$data['clinic_id'];
			$meta['doctor_id']	=$data['doctor_id'];
			$meta['json']=		$json;
			$this->load->model('shedule_m');
			$this->shedule_m->save($meta,$data['id']);
			}
		
		}
	public function delete_shedule($id=NULL,$doctor_id=NULL,$clinic_id=NULL,$time,$hash){
		if(chash($time,$hash)){
			$id		=$this->db->escape_str($id);
			$doctor_id	=$this->db->escape_str($doctor_id);
			$clinic_id	=$this->db->escape_str($clinic_id);
			if($this->db->query("DELETE FROM shedule WHERE id='$id' AND doctor_id='$doctor_id' AND clinic_id='$clinic_id' LIMIT 1")){
				$this->session->set_flashdata('message','Shedule Successfully deleted');
				$this->session->set_flashdata('type','succcess');
				redirect($_SERVER['HTTP_REFERER']);
				}
			else {
				$this->session->set_flashdata('message','Something went wrong. Please try again.');
				$this->session->set_flashdata('type','danger');
				redirect($_SERVER['HTTP_REFERER']);
				}
			
			}
		else {
			$this->session->set_flashdata('message','Error in hash check');
			$this->session->set_flashdata('type','danger');
			redirect($_SERVER['HTTP_REFERER']);
			}
		}
	
	public function get_institution_name($query_str){
		$query_str=str_replace('%20',' ',$this->db->escape(strtolower($query_str.'%')));
		$str='';
		$sql="SELECT * FROM `institution` WHERE `institution` LIKE $query_str";
		$results=$this->db->query($sql)->result();
		if(count($results)){
			$str.='<optgroup label="Institutions">';
			foreach($results as $a=>$b){
				if(!empty($b->institution)){
						$str.="<option class=\"p5\">".$b->institution."</option>";
					}
				}
			echo $str.='</optgroup>';
			}
		
		
		}
	
	public function get_register_council($query_str){
		$query_str=str_replace('%20',' ',$this->db->escape(strtolower($query_str.'%')));
		$str='';
		$sql="SELECT * FROM `registation_council` WHERE `registation_council` LIKE $query_str";
		$results=$this->db->query($sql)->result();
		if(count($results)){
			$str.='<optgroup label="Registration Council">';
			foreach($results as $a=>$b){
				if(!empty($b->registation_council)){
						$str.="<option class=\"p5\">".$b->registation_council."</option>";
					}
				}
			echo $str.='</optgroup>';
			}
		}
	public function get_membership_council($query_str){
		$query_str=str_replace('%20',' ',$this->db->escape(strtolower($query_str.'%')));
		$str='';
		$sql="SELECT * FROM `membership` WHERE `membership` LIKE $query_str";
		$results=$this->db->query($sql)->result();
		if(count($results)){
			$str.='<optgroup label="Membership">';
			foreach($results as $a=>$b){
				if(!empty($b->membership)){
						$str.="<option class=\"p5\">".$b->membership."</option>";
					}
				}
			echo $str.='</optgroup>';
			}
		}
	public function get_service_council($query_str){
		$query_str=str_replace('%20',' ',$this->db->escape(strtolower($query_str.'%')));
		$str='';
		$sql="SELECT * FROM `service` WHERE `service` LIKE $query_str";
		$results=$this->db->query($sql)->result();
		if(count($results)){
			$str.='<optgroup label="Service">';
			foreach($results as $a=>$b){
				if(!empty($b->service)){
						$str.="<option class=\"p5\">".$b->service."</option>";
					}
				}
			echo $str.='</optgroup>';
			}
		}
	public function off_days($clinic_id=NULL,$doctor_id=NULL){
		if($clinic_id!=NULL and $doctor_id!=NULL){
			$clinic_id=mysql_real_escape_string($clinic_id);
			$sql="SELECT sunday,monday,tuesday,wednesday,thursday,friday,saturday FROM clinic WHERE id=$clinic_id LIMIT 1";
			$results=$this->db->query($sql)->result();
			$results=$results[0];
			$array=array(
				'sunday'	=>0,
				'monday'	=>0,
				'tuesday'	=>0,
				'wednesday'	=>0,
				'thursday'	=>0,
				'friday'	=>0,
				'saturday'	=>0,
			);
			
			foreach($results as $a=>$b){
				$json=json_decode($b,true);
				if(isset($json[$doctor_id])){
					if($json[$doctor_id]!=0){
						$array[$a]=1;
						}
					}
				}
			echo json_encode($array);
			}
			return false;
		}
	public function post_off_days(){
		$clinic_id=$this->input->post('clinic_id');
		$doctor_id=$this->input->post('doctor_id');
		$data=array();
		$result=$this->db->query("SELECT `sunday`,`monday`,`tuesday`,`wednesday`,`thursday`,`friday`,`saturday` FROM clinic WHERE id=$clinic_id")->result();
		$result=$result[0];
		
		$dummy=array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
		foreach($dummy as $a=>$b){
			$json=json_decode($result->$b,true);
			if($this->input->post($b)=='on'){
				$json[$doctor_id]=0;
				}
				
			$data[$b]=json_encode($json);
			}
			$this->load->model('clinic_m');
			$this->clinic_m->save($data,$clinic_id);
			
			$this->session->set_flashdata('message','<i class="glyphicon glyphicon-exclamation-sign"></i> Off days altered successfully');
			$this->session->set_flashdata('type','success');
			redirect($_SERVER['HTTP_REFERER']);
			
		
		}
	
	public function upload_clinic_image($clinic_id=NULL,$name=1){
		if($clinic_id==NULL) return;
		if(!in_array($name,array(1,2,3))) return;
		
		include(('includes/resize-class.php'));
		
		$data=$this->doctor_m->get($id,TRUE);
		$dir=$data->unique_id;
		
		$ds='/';
 		if (!file_exists(config_item('clinic_image').$clinic_id)) {
		    mkdir(config_item('clinic_image').$clinic_id);
		    
		}
		$storeFolder = config_item('clinic_image').$clinic_id;   //2
 
		if (!empty($_FILES)) {
			
		 	$size		=$_FILES['file']['size']/1024;  
			if($size>3000) return;
			$type		=$_FILES['file']['type'];
			if($type!='image/jpeg') return;
			
		    $tempFile   = $_FILES['file']['tmp_name'];          //3     
		    
		  
		    $targetFile =  $storeFolder.'/'.$name.'.jpg';  //5
			$thumb_file	=  $storeFolder.'/thumb/'.$name.'.jpg';  //5
		    
		   // file_put_contents($storeFolder.'/file.txt',$targetFile);
		    
		    move_uploaded_file($tempFile,$targetFile); //6
			
			 $resizeObj = new resize($targetFile);
             $resizeObj -> resizeImage(1100, 310, 'crop');
             $resizeObj -> saveImage($targetFile, 70);
			 
			//Copy and make a thumb
			//Create a thumb dir if not exists
			if (!file_exists($storeFolder.'/'.'thumb')) {
				mkdir($storeFolder.'/'.'thumb', 0775,true);
				}
			
			copy ( $targetFile , $thumb_file );
			//Resize the uploaded thumb file
			$resizeObj = new resize($thumb_file);
            $resizeObj -> resizeImage(64, 64,0);
            $resizeObj -> saveImage($thumb_file, 90);
			}
		}
		public function appointments($clinic_id=NULL){
			if($clinic_id==NULL) die('Error occured');
			$data=array();
			$this->data['clinic_id']=$clinic_id;
			$this->data['page_title']='Appointments';
			$this->data['sub_view']='appointments';
			$this->load->view('doctor_admin/layout',$this->data);
			}
			
		public function generete_sheet(){ 
			if(isset($_POST['date']) and isset($_POST['clinic_id'])){
				if(isset($_POST['blue'])) $blue=true; 
				else $blue=NULL;
				$date=mysql_real_escape_string($_POST['date']);
				$clinic_id=mysql_real_escape_string($_POST['clinic_id']); 
				generate_appointment_sheet($date,$clinic_id,$blue);
				}
			
			}
		public function complete_appointment(){
			$app_id	=mysql_real_escape_string($this->input->post('app_id'));
			$sql="SELECT clinic_id,id FROM appointment WHERE doctor_id=".$this->session->userdata('id')." AND id=$app_id";
			if(!$this->db->query($sql)->num_rows()){
				echo 0;
				return;
				}
			$data['completed']=1;
			$this->load->model('appointment_m');
			if($this->appointment_m->save($data,$app_id)){
				echo 1;
				}
			else echo 0;
			return;
			}
			
		public function delete_appointment(){
			$app_id	=mysql_real_escape_string($this->input->post('app_id'));
			$sql="SELECT id FROM appointment WHERE doctor_id=".$this->session->userdata('id')." AND id=$app_id";
			if(!$this->db->query($sql)->num_rows()){
				echo 0;
				return;
				}
			$this->load->model('appointment_m');
			if($this->appointment_m->delete($app_id)){
				echo 1;
				return;
				}
			return;
			}
		public function get_patient_details($name=NULL,$offset=0){
			$number_of_results=5;
			$name=urldecode($name);
			$back_array=array('bg-blue','bg-red','bg-red','bg-red','bg-green','bg-aqua','bg-yellow');
			$phone=$this->input->post('phone'); 
			$this->load->model('patient_m');
			$where=array();
			$where['phone']=$phone;
			$data=$this->patient_m->get_by($where,true);
			if(sizeof($data)==0 or isset($_POST['update'])){
				if(!isset($_POST['update'])){
					echo '<div class="callout callout-warning">  We can not find any medical history of <strong>'.$name.'.</strong> Be the first one to save medical details  of <strong>'.$name.'</strong>  </div>';
					}
				
				echo '<ul class="timeline"> 
				<!-- timeline time label -->
    <li class="time-label">
        <span class="';
		echo $back_array[array_rand($back_array)];
		echo '">
            '.date('d/m/y',time()).'
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-envelope bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> '.date('h:i a',time()).'</span>';
			if(isset($_POST['update'])) echo '<form onclick="update_patient_report($(this))">';
			else echo '<form onclick="save_patient_report($(this))">';
            echo '<h5 class="timeline-header">
			<i class="fa fa-plus"></i> Add a report
			<div class="report_msg_holder"></div>
				<div class="input-group" style="margin-top:10px">
					<span class="input-group-addon">Title</span>
					<input required="required" type="text" class="form-control title_f" placeholder="A sort description">
				</div>
				
			</h5>
			
            <div class="timeline-body">
               <textarea required="required"  class="patient_report " style="width:100%; height:100px;"></textarea>
            </div>

            <div class="timeline-footer">
                <button type="submit"  class="btn btn-primary btn-sm submit_rt"><i class="fa fa-save"></i> Save</button>
            </div>
			<input type="hidden" class="phone_number" value="'.$phone.'"> 
			</form>
        </div>
    </li>
    <!-- END timeline item -->

</ul>';
return;
				}
			else{	
					$raw_data=($data->data);
					$json=json_decode($raw_data,true);
					$extra_data=array();
					if(!sizeof($json)) die;
					
					$extra_data=$json;
					unset($extra_data[$this->session->userdata('id')]);
					
					if(isset($json[$this->session->userdata('id')])){
						$json=$json[$this->session->userdata('id')];
						}
					else $json=array();
					$ini_size=sizeof($json);
					$json=array_slice($json,$offset*$number_of_results,$number_of_results);
					$html='<button class="btn btn-info btn-sm" style="margin:3px 0; margin-right:5px" 
					onclick="add_report_form($(this),'.$phone.',\''.$name.'\')"> <strong>+ Add new report </strong></button>';	
					if(count($extra_data)>0){
					$html.='<button class="btn btn-success btn-sm" style="margin:3px 0" 
					onclick="verify_phone_total_report($(this),'.$phone.',\''.$name.'\')">
					<i class="fa fa-fw fa-plus-square"></i>   View reports from other doctors  </button>';	
						}
					
					$html.='<ul class="timeline"><!-- timeline time label -->';
	  		if(empty($json)){
				$html.='<div class="callout callout-warning" style="margin-left: 40px;">
                                        <h4>You have not added any report</h4>
                                        <p>To add a report please click <button class="btn btn-info btn-xs" style="margin:2px 5px; margin-right:5px" 
					onclick="add_report_form($(this),'.$phone.',\''.$name.'\')"> <strong>+ Add new report </strong></button></p>
                                    </div>';
				}
				
			$sql="SELECT name,username FROM doctors WHERE id=".$this->session->userdata('id').' LIMIT 1';
			$doctor_data=$this->db->query($sql)->result();
			$doctor_data=$doctor_data[0];
			foreach($json as $a=>$b){
				$html.='  <li class="time-label">
							<span class="'.$back_array[array_rand($back_array)].'">
								'.date('d-M-y',$b['timestamp']).'
							</span>
						</li>
						<!-- /.timeline-label -->
					
						<!-- timeline item -->
						<li>
							<!-- timeline icon -->
							<i class="fa fa-envelope bg-blue"></i>
							<div class="timeline-item">
								<span class="time"><i class="fa fa-clock-o"></i> '.date('h:i a',$b['timestamp']).'</span>
					
								<h3 class="timeline-header">'.$b['title'].'</h3>
					
								<div class="timeline-body">
									'.$b['report'].'
								</div>
					
								<div class="timeline-footer">
									<a target="new" href="'.bu('doctors/'.$doctor_data->username).'" 
									class="btn btn-flat btn-xs bg-purple">
									<i class="fa fa-fw fa-user-md"></i> Dr.'.$doctor_data->name.'</a>
								</div>
							</div>
						</li>
						 <!-- END timeline item -->
	
						';
						}
				$prev=$offset-1;
				if($prev<0) $prev=0;
				
				if($offset>0)
				$html.='
				<button class="btn btn-success btn-sm" style="margin:0 60px"
				onclick="append_report(\''.$name.'\','.($prev).','.$phone.')"><i class="fa fa-fw fa-chevron-left"></i> Prev</button>';
				
				if($ini_size>($number_of_results*$offset+$number_of_results))
				$html.='<button class="btn btn-success btn-sm"  style="float: right; margin:0 25px"
				onclick="append_report(\''.$name.'\','.($offset+1).','.$phone.')"> Next <i class="fa fa-fw fa-chevron-right"></i></button>
				
				
				</ul>';
				echo $html;
				//var_dump(($json));
					}
			
			}


	public function save_report(){
		$rule=array(
			//Personal Details
			'title'		=>array('field'=>'title','label'=>'Title','rules'=>'trim|required|xss_clean|max_length[100]'),
			'phone'		=>array('field'=>'phone','label'=>'Phone','rules'=>'trim|xss_clean|numeric|max_length[15]'),
			'report'	=>array('field'=>'report','label'=>'Report','rules'=>'trim|xss_clean|required|max_length[300]'),
			);
		$this->form_validation->set_rules($rule);
		
		$this->load->helper('security');
		
		if($this->form_validation->run()==TRUE){
			$errors			='';
			
			$title				=mysql_real_escape_string($this->input->post('title'));
			$phone				=mysql_real_escape_string($this->input->post('phone'));
			$report				=mysql_real_escape_string($this->input->post('report'));
			
			$json='{';
			$json.='
					"'.$this->session->userdata('id').'": [
						{
							"timestamp": "'.time().'",
							"title": "'.$title.'",
							"report": "'.$report.'"
						}
					]
				}';
			
			$data=array('phone'=>$phone,'data'=>$json);
			$this->load->model('patient_m');
			if($this->patient_m->save($data)){
				echo 1;
				}
			
		}
		else{
			echo '<div class="callout callout-danger">
                                        <h4>Errors</h4>
                                        '.validation_errors().'
                                    </div>';
			}
	}
	
	public function update_report(){
		$rule=array(
			//Personal Details
			'title'		=>array('field'=>'title','label'=>'Title','rules'=>'trim|required|xss_clean|max_length[100]'),
			'phone'		=>array('field'=>'phone','label'=>'Phone','rules'=>'trim|xss_clean|numeric|max_length[15]'),
			'report'	=>array('field'=>'report','label'=>'Report','rules'=>'trim|xss_clean|required|max_length[300]'),
			);
		$this->form_validation->set_rules($rule);
		
		$this->load->helper('security');
		if($this->form_validation->run()==TRUE){
			$errors			='';
			
			$title				=mysql_real_escape_string($this->input->post('title'));
			$phone				=mysql_real_escape_string($this->input->post('phone'));
			$report				=mysql_real_escape_string($this->input->post('report'));
			
			$dummy_array=array(
				"timestamp"=>(string)(time()),
				"title"=>$title,
				"report"=>$report
				);
			

			$this->load->model('patient_m');
			
			$where=array('phone'=>$phone);
			$dummy=$this->patient_m->get_by($where,true);
			$id=$dummy->id;
			$d_data=json_decode($dummy->data,true);
			
			if(!isset($d_data[$this->session->userdata('id')])) {
				$d_data[$this->session->userdata('id')]='';
				};
			
			$doctor_array=$d_data[$this->session->userdata('id')];
			$doctor_array[]=( $dummy_array);
			$d_data[$this->session->userdata('id')]=$doctor_array;
			$json=json_encode($d_data);
			
			$data=array('phone'=>$phone,'data'=>$json);
			//var_dump($data);
			if($this->patient_m->save($data,$id)){ echo 1; }
			
		}
		else{
			echo '<div class="callout callout-danger">
                                        <h4>Errors</h4>
                                        '.validation_errors().'
                                    </div>';
			}
	}
	
	public function generate_verification_and_sms(){
		if(isset($_POST['phone'])){
			$phone=$this->input->post('phone');
			$rand=rand ( 100000 , 999999);
			$data = array( 'verification_code' => $rand  );
			
			$this->db->where('phone', $phone);
			if($this->db->update('patient', $data)){
				$this->send_sms('Message',$phone);
				echo 1;
				}
			}
		}
		
	public function get_patient_details_full($name=NULL,$offset=0,$code=NULL){		
			$number_of_results=5;
			$name=urldecode($name);
			$back_array=array('bg-blue','bg-red','bg-red','bg-red','bg-green','bg-aqua','bg-yellow');
			$phone=$this->input->post('phone'); 
			if(isset($_POST['code'])) $code=$this->input->post('code');			
			$this->load->model('patient_m');
			$code=mysql_real_escape_string($code);
			if(!$this->db->query("SELECT id FROM patient WHERE phone='$phone' AND verification_code='$code' LIMIT 1")->num_rows()){
				echo 0;
				return;
				}
			$where=array();
			$where['phone']=$phone;
			$data=$this->patient_m->get_by($where,true);
			
			$raw_data=($data->data);
			$json=json_decode($raw_data,true);
			$extra_data=array();
			if(!sizeof($json)) die;
			
			$doctor_ids=array();
			foreach($json as $a=>$b){
				$doctor_ids[]=$a;
			}
			$doctor_ids=mysql_real_escape_string(implode(',',$doctor_ids));
			$sql="SELECT id,name,username FROM doctors WHERE id in($doctor_ids)";
			$doc_data=$this->db->query($sql)->result();
			$doctor_data=array();
			foreach($doc_data as $a=>$b){
				$doctor_data[$b->id]=$b;
				}
			$jay_array=array();
			
			foreach($json as $a=>$b){
				foreach($b as $x=>$y){
					$jay_array[$y['timestamp']]=array(
						'doctor_id'=>$a,
						'title'=>$y['title'],
						'report'=>$y['report'],
						);
					}
				
				}
			ksort($jay_array);
			
			
			
			$ini_size=sizeof($jay_array);
			$jay_array=array_slice($jay_array,$offset*$number_of_results,$number_of_results,$preserve_keys = true);
			$html='<button class="btn btn-info btn-sm" style="margin:3px 0; margin-right:5px" 
			onclick="add_report_form($(this),'.$phone.',\''.$name.'\')"> <strong>+ Add new report </strong></button>';	
			
			$html.='<ul class="timeline"><!-- timeline time label -->';
	  		if(empty($json)){
				$html.='<div class="callout callout-warning" style="margin-left: 40px;">
                                        <h4>You have not added any report</h4>
                                        <p>To add a report please click <button class="btn btn-info btn-xs" style="margin:2px 5px; margin-right:5px" 
					onclick="add_report_form($(this),'.$phone.',\''.$name.'\')"> <strong>+ Add new report </strong></button></p>
                                    </div>';
				}
				
			
			foreach($jay_array as $a=>$b){
				$html.='  <li class="time-label">
							<span class="'.$back_array[array_rand($back_array)].'">
								'.date('d-M-y',$a).'
							</span>
						</li>
						<!-- /.timeline-label -->
					
						<!-- timeline item -->
						<li>
							<!-- timeline icon -->
							<i class="fa fa-envelope bg-blue"></i>
							<div class="timeline-item">
								<span class="time"><i class="fa fa-clock-o"></i> '.date('h:i a',$a).'</span>
					
								<h3 class="timeline-header">'.$b['title'].'</h3>
					
								<div class="timeline-body">
									'.$b['report'].'
								</div>
								<div class="timeline-footer">
									<a target="new" href="'.bu('doctors/'.$doctor_data[$b['doctor_id']]->username).'" 
									class="btn btn-flat btn-xs bg-purple">
									<i class="fa fa-fw fa-user-md"></i> Dr.'.$doctor_data[$b['doctor_id']]->name.'</a>
								</div>
							</div>
						</li>
						 <!-- END timeline item -->
	
						';
						}
				$prev=$offset-1;
				if($prev<0) $prev=0;
				
				if($offset>0)
				$html.='
				<button class="btn btn-success btn-sm" style="margin:0 60px"
				onclick="append_full_report(\''.$name.'\','.($prev).','.$phone.','.$code.')"><i class="fa fa-fw fa-chevron-left"></i> Prev</button>';
				
				if($ini_size>($number_of_results*$offset+$number_of_results))
				$html.='<button class="btn btn-success btn-sm"  style="float: right; margin:0 25px"
				onclick="append_full_report(\''.$name.'\','.($offset+1).','.$phone.','.$code.')"> Next <i class="fa fa-fw fa-chevron-right"></i></button>
				
				
				</ul>';
				echo $html;
				//var_dump(($json));
					
			
			}
		
		public function patients($id=NULL,$tab='tab1'){//
			
			$this->data['id']=$id;
			$this->data['tab']=$tab;
			
			$rule=array(
			'email'	=>array('field'=>'email','label'=>'Email','rules'=>'trim|required|xss_clean|max_length[50]|valid_email'),
			'name'	=>array('field'=>'name','label'=>'Name','rules'=>'trim|required|xss_clean|max_length[50]'),
			'phone'	=>array('field'=>'phone','label'=>'Phone Number','rules'=>'trim|numeric|required|xss_clean|max_length[50]'),
			
			'date'	=>array('field'=>'date','label'=>'Date','rules'=>'trim|xss_clean|max_length[2]|numeric'),
			'month'	=>array('field'=>'month','label'=>'Month','rules'=>'trim|xss_clean|max_length[2]|numeric'),
			'year'	=>array('field'=>'year','label'=>'Year','rules'=>'trim|xss_clean|max_length[4]|numeric'),
			);
		$this->form_validation->set_rules($rule);
		
		if($this->form_validation->run()==TRUE){
			$this->load->model('patient_m');
			$name		=sql_filter($this->input->post('name'));
			$email		=sql_filter($this->input->post('email'));
			$phone		=ltrim((sql_filter($this->input->post('phone'))),'0');
			
			
			
			$date		=sql_filter($this->input->post('date'));
			$month		=sql_filter($this->input->post('month'));
			$year		=sql_filter($this->input->post('year'));
			
			if(!empty($date) and !empty($month) and !empty($year))
			$dob=$date.'/'.$month.'/'.$year;
			
			else $dob='';
			
			$sql="SELECT * FROM patient WHERE phone=$phone LIMIT 1";
			$num_rows=$this->db->query($sql)->num_rows();
			
			if($num_rows){
				$data=array();
				$result=$this->db->query($sql)->result();
				$result=$result[0];
				
				if(empty($result->email))   	$data['email']=$email;
				if(empty($result->dob))  		$data['dob']=$dob;
				if(empty($result->name))  		$data['name']=$name;
				$data['clinical_notes']='';
				$data['treatment_plans']='';
				$data['prepscription']='';
				
				if(empty($result->doctors))  	$data['doctors']=','.$this->session->userdata('id').',';
				else if(!empty($result->doctors)){
					$doc_array=explode(',',$result->doctors);
					$doc_array[]=$this->session->userdata('id');
					$doc=implode(',',array_unique(array_filter($doc_array)));
					$data['doctors']=','.$doc.',';					
					}
				$this->data['msg']=$result->id;
				$this->db->where('id', $result->id);
				$return=$this->db->update('patient', $data); 
				if($return){
					$this->data['msg']='New patient added successfully';
					$this->data['type']='success';
					}
				}
			else{
				$data=array();
				
				
				$data['name']=$name;
				$data['phone']=$phone;
				$data['email']=$email;
				$data['dob']=$dob;
				$data['clinical_notes']='';
				$data['treatment_plans']='';
				$data['prepscription']='';
				$data['data']='';
				$data['doctors']=','.$this->session->userdata('id').',';
				if($this->patient_m->save($data)) {
					$this->data['msg']='New patient added successfully';
					$this->data['type']='success';
					}
					
				
				
				}
			
			}
			
		else if(!empty(validation_errors())){
			$this->data['msg']=validation_errors();
			$this->data['type']='danger';
			}
			
			$this->data['page_title']='Virtual Nurse';	
			$this->data['sub_view']='virtual_nurse';
			$this->load->view('doctor_admin/layout',$this->data);
			
			
}
		
		public function delete_patient($id=NULL){
			if($id==NULL) return;
			$id=sql_filter($id);
			
			$did=$this->session->userdata('id');
			//Check if the patient belongs to the doctor
			$sql="SELECT id FROM patient WHERE doctors like '%,$did,%' and id='$id'";
			$num_rows=$this->db->query($sql)->num_rows();
			
			if(!$num_rows) {show_404();return;}
			
			$this->load->model('patient_m');
			$data=$this->patient_m->get($id,true);
			$array=array_filter(explode(',',$data->doctors));
			
			if(($key = array_search($this->session->userdata('id'), $array)) !== false) {
				unset($array[$key]);
			}
			$array=','.implode(',',$array).',';
			
			if( $this->patient_m->save(array('doctors'=>$array),$id)){
				$this->session->set_flashdata('message', 'Successfully Updated');
				$this->session->set_flashdata('type', 'success');
				redirect(bu('doctor/records'));
				}
		
}
			
		
		
		public function handle_post_patirnt_expand($id=NULL,$tab='tab1',$type='clinical_notes'){//
			
			if($id==NULL) return;
			$refferer=$_SERVER['HTTP_REFERER'];
			if(!strpos($refferer,'tab')) $refferer.='/'.$tab;
			$this->load->model('patient_m');
			
			$tab		=sql_filter($this->input->post('tab'));
			
			switch($type){
				case('clinical_notes'):
				$rule=array(
			'complaints'	=>array('field'=>'complaints','label'=>'Complaints','rules'=>'trim|required|xss_clean|max_length[300]'),
			'observations'	=>array('field'=>'observations','label'=>'Observations','rules'=>'trim|required|xss_clean|max_length[300]'),
			'diagnoses'	=>array('field'=>'diagnoses','label'=>'Diagnoses','rules'=>'trim|required|xss_clean|max_length[300]'));
			$this->form_validation->set_rules($rule);
			if($this->form_validation->run()==TRUE){
				$complaints			=str_replace('::',' ',sql_filter($this->input->post('complaints')));
				$observations		=str_replace('::',' ',sql_filter($this->input->post('observations')));
				$diagnoses			=str_replace('::',' ',sql_filter($this->input->post('diagnoses')));
				
				$date=date('d-m-y');
				$array=array();
				
				$p_data=$this->patient_m->get_by(array('id'=>$id),true);
				$json=json_decode($p_data->clinical_notes,true);
				
				if(isset($json[$this->session->userdata('id')])){
					$temp_array=$json[$this->session->userdata('id')];
						$temp_array[$date][]=$complaints.'-::-'.$observations.'-::-'.$diagnoses;
						$json[$this->session->userdata('id')]=$temp_array;
						$data['clinical_notes']=json_encode($json);
						$this->patient_m->save($data,$id);
						$this->session->set_flashdata('message','Clinic note added successfully');
						$this->session->set_flashdata('type', 'success');
						redirect($refferer);
						
					}
				else{
					$temp_array=array();
					$t_array=array();
					$t_array[]=$complaints.'-::-'.$observations.'-::-'.$diagnoses;
					$temp_array[$date]=$t_array;
					$json[$this->session->userdata('id')]=$temp_array;
					$data['clinical_notes']=json_encode($json);
					$this->patient_m->save($data,$id);
					$this->session->set_flashdata('message','Clinic note added successfully');
					$this->session->set_flashdata('type', 'success');
					redirect($refferer);
					}
				
				
				
				}
			elseif(!empty(validation_errors())) {
				
				$this->session->set_flashdata('message', validation_errors());
				$this->session->set_flashdata('type', 'danger');
				redirect($refferer);
				
				
				}
				break;
				
				case('plan'):
				$rule=array(
			'treatment_plan'	=>array('field'=>'treatment_plan','label'=>'Treatment Plan','rules'=>'trim|required|xss_clean|max_length[300]'),
			'cost'	=>array('field'=>'cost','label'=>'Cost','rules'=>'trim|required|xss_clean|max_length[10]|numeric|is_natural_no_zero'),
			'discount'	=>array('field'=>'discount','label'=>'Discount','rules'=>'trim|xss_clean|max_length[10]|is_natural'),
			'advance'	=>array('field'=>'advance','label'=>'Advance','rules'=>'trim|xss_clean|max_length[10]|is_natural'),
			'note'	=>array('field'=>'note','label'=>'Note','rules'=>'trim|xss_clean|max_length[300]'));
			
			$this->form_validation->set_rules($rule);
			
			if($this->form_validation->run()==TRUE){
				
				$treatment_plan		=str_replace('::',' ',sql_filter($this->input->post('treatment_plan')));
				$cost				=str_replace('::',' ',sql_filter($this->input->post('cost')));
				$discount			=str_replace('::',' ',sql_filter($this->input->post('discount')));
				$advance			=str_replace('::',' ',sql_filter($this->input->post('advance')));
				$note				=str_replace('::',' ',sql_filter($this->input->post('note')));
				
				if(empty($discount)) 	$discount=0;
				if(empty($advance)) 	$advance=0;
				$paid=0;
				
				if($discount>$cost)$discount=$cost;
				$total=abs($cost-$discount);
				$completed=0;
				
				if($advance>$total)$advance=$total;
				
				
				$due=abs($total-$advance);
				
				$date=date('d-m-y');
				$array=array();
				
				$p_data=$this->patient_m->get_by(array('id'=>$id),true);
				$json=json_decode($p_data->treatment_plans,true);
				
				if(isset($json[$this->session->userdata('id')])){
					$temp_array=$json[$this->session->userdata('id')];
						$temp_array[$date][]=$completed.'-::-'.$treatment_plan.'-::-'.$cost.'-::-'.$discount.'-::-'.$total.'-::-'.$advance.'-::-'.$due.'-::-'.$note;
						$json[$this->session->userdata('id')]=$temp_array;
						$data['treatment_plans']=json_encode($json);
						$this->patient_m->save($data,$id);
						$this->session->set_flashdata('message','Treatment plan added successfully');
						$this->session->set_flashdata('type', 'success');
						redirect($refferer);
						
					}
				else{
					$temp_array=array();
					$t_array=array();
					$t_array[]=$completed.'-::-'.$treatment_plan.'-::-'.$cost.'-::-'.$discount.'-::-'.$total.'-::-'.$advance.'-::-'.$due.'-::-'.$note;
					$temp_array[$date]=$t_array;
					$json[$this->session->userdata('id')]=$temp_array;
					$data['treatment_plans']=json_encode($json);
					$this->patient_m->save($data,$id);
					$this->session->set_flashdata('message','Treatment plan added successfully');
					$this->session->set_flashdata('type', 'success');
					redirect($refferer);
					}
				
				
				
			}
			elseif(!empty(validation_errors())) {
				
				$this->session->set_flashdata('message', validation_errors());
				$this->session->set_flashdata('type', 'danger');
				redirect($refferer);
				
				
				}
				break;
				
				case('com_pro'):
				$rule=array(
			'treatment_plan'	=>array('field'=>'treatment_plan','label'=>'Treatment Plan','rules'=>'trim|required|xss_clean|max_length[300]'),
			'cost'	=>array('field'=>'cost','label'=>'Cost','rules'=>'trim|required|xss_clean|max_length[10]|numeric|is_natural_no_zero'),
			'discount'	=>array('field'=>'discount','label'=>'Discount','rules'=>'trim|xss_clean|max_length[10]|is_natural'),
			'advance'	=>array('field'=>'advance','label'=>'Advance','rules'=>'trim|xss_clean|max_length[10]|is_natural'),
			'note'	=>array('field'=>'note','label'=>'Note','rules'=>'trim|xss_clean|max_length[300]'));
			
			$this->form_validation->set_rules($rule);
			
			if($this->form_validation->run()==TRUE){
				
				$treatment_plan		=str_replace('::',' ',sql_filter($this->input->post('treatment_plan')));
				$cost				=str_replace('::',' ',sql_filter($this->input->post('cost')));
				$discount			=str_replace('::',' ',sql_filter($this->input->post('discount')));
				$advance			=str_replace('::',' ',sql_filter($this->input->post('advance')));
				$note				=str_replace('::',' ',sql_filter($this->input->post('note')));
				
				if(empty($discount)) 	$discount=0;
				if(empty($advance)) 	$advance=0;
				$paid=0;
				
				if($discount>$cost)$discount=$cost;
				$total=abs($cost-$discount);
				$completed=1;
				
				if($advance>$total)$advance=$total;
				
				
				$due=abs($total-$advance);
				
				$date=date('d-m-y');
				$array=array();
				
				$p_data=$this->patient_m->get_by(array('id'=>$id),true);
				$json=json_decode($p_data->treatment_plans,true);
				
				if(isset($json[$this->session->userdata('id')])){
					$temp_array=$json[$this->session->userdata('id')];
						$temp_array[$date][]=$completed.'-::-'.$treatment_plan.'-::-'.$cost.'-::-'.$discount.'-::-'.$total.'-::-'.$advance.'-::-'.$due.'-::-'.$note;
						$json[$this->session->userdata('id')]=$temp_array;
						$data['treatment_plans']=json_encode($json);
						$this->patient_m->save($data,$id);
						$this->session->set_flashdata('message','Treatment plan added successfully');
						$this->session->set_flashdata('type', 'success');
						redirect($refferer);
						
					}
				else{
					$temp_array=array();
					$t_array=array();
					$t_array[]=$completed.'-::-'.$treatment_plan.'-::-'.$cost.'-::-'.$discount.'-::-'.$total.'-::-'.$advance.'-::-'.$due.'-::-'.$note;
					$temp_array[$date]=$t_array;
					$json[$this->session->userdata('id')]=$temp_array;
					$data['treatment_plans']=json_encode($json);
					$this->patient_m->save($data,$id);
					$this->session->set_flashdata('message','Treatment plan added successfully');
					$this->session->set_flashdata('type', 'success');
					redirect($refferer);
					}
				
				
				
			}
			elseif(!empty(validation_errors())) {
				
				$this->session->set_flashdata('message', validation_errors());
				$this->session->set_flashdata('type', 'danger');
				redirect($refferer);
				
				
				}
				break;
				
				case('com_pro_edit'):
				$rule=array(
			'treatment_plan'	=>array('field'=>'treatment_plan','label'=>'Treatment Plan','rules'=>'trim|required|xss_clean|max_length[300]'),
			'cost'	=>array('field'=>'cost','label'=>'Cost','rules'=>'trim|required|xss_clean|max_length[10]|numeric|is_natural_no_zero'),
			'discount'	=>array('field'=>'discount','label'=>'Discount','rules'=>'trim|xss_clean|max_length[10]|is_natural'),
			'advance'	=>array('field'=>'advance','label'=>'Advance','rules'=>'trim|xss_clean|max_length[10]|is_natural'),
			'note'	=>array('field'=>'note','label'=>'Note','rules'=>'trim|xss_clean|max_length[300]'));
			
			$this->form_validation->set_rules($rule);
			
			if($this->form_validation->run()==TRUE){
				
				$treatment_plan		=str_replace('::',' ',sql_filter($this->input->post('treatment_plan')));
				$cost				=str_replace('::',' ',sql_filter($this->input->post('cost')));
				$discount			=str_replace('::',' ',sql_filter($this->input->post('discount')));
				$advance			=str_replace('::',' ',sql_filter($this->input->post('advance')));
				$note				=str_replace('::',' ',sql_filter($this->input->post('note')));
				$index				=str_replace('::',' ',sql_filter($this->input->post('index')));
				$date				=str_replace('::',' ',sql_filter($this->input->post('date')));
				
				if(empty($discount)) 	$discount=0;
				if(empty($advance)) 	$advance=0;
				$paid=0;
				
				if($discount>$cost)$discount=$cost;
				$total=abs($cost-$discount);
				$completed=1;
				
				if($advance>$total)$advance=$total;
				
				
				$due=abs($total-$advance);
				
				$date=date('d-m-y');
				$array=array();
				
				$p_data=$this->patient_m->get_by(array('id'=>$id),true);
				$json=json_decode($p_data->treatment_plans,true);
				
				if(isset($json[$this->session->userdata('id')])){
					$temp_array=$json[$this->session->userdata('id')];
					if(isset($temp_array[$date][$index])){
						$temp_array[$date][$index]=$completed.'-::-'.$treatment_plan.'-::-'.$cost.'-::-'.$discount.'-::-'.$total.'-::-'.$advance.'-::-'.$due.'-::-'.$note;
						$json[$this->session->userdata('id')]=$temp_array;
						$data['treatment_plans']=json_encode($json);
						if($this->patient_m->save($data,$id)){
							$this->session->set_flashdata('message', 'Successfully edited');
							$this->session->set_flashdata('type', 'success');
							echo 1;
							}
						
						
						}
					}
				
				
				
			}
			
				break;
				
				case('prepscriptions'):
				
				if((isset($_POST['name']) and isset($_POST['drug']))){
					//SQL filter will not work as we are passing array
					//APPLY SQL FILTER AFTER transfering array to text
					$errors='';
					$array=array();
					
					$name				=str_replace('::',' ', ($this->input->post('name')));
					$drug				=str_replace('::',' ', ($this->input->post('drug')));
					$duration			=str_replace('::',' ', ($this->input->post('duration')));
					$instruction		=str_replace('::',' ', ($this->input->post('instruction')));
					$morning			=str_replace('::',' ', ($this->input->post('morning')));
					$noon				=str_replace('::',' ', ($this->input->post('noon')));
					$night				=str_replace('::',' ', ($this->input->post('night')));
					
					
					
					for($i=0;$i<sizeof($name);$i++){
						if(empty($name[$i]) or empty($drug[$i])) {
							 $this->session->set_flashdata('message','<p>Template name is required</p><p>Drug name is required</p>');
				   $this->session->set_flashdata('type','danger');
				   redirect($_SERVER['HTTP_REFERER']);
				   return;}
				   
				   $str='';
				   //Filtering is done here
				   $str.=sql_filter(substr($name[$i],0,50)).'-::-'.sql_filter(substr($drug[$i],0,50)).'-::-'.sql_filter(substr($duration[$i],0,50)).'-::-'.sql_filter(substr($instruction[$i],0,200)).'-::-'.sql_filter(substr($morning[$i],0,30)).'-::-'.sql_filter(substr($noon[$i],0,30)).'-::-'.sql_filter(substr($night[$i],0,30));
				   
				   $array[]=$str;
						}
					$array_x=array();
					foreach($array as $c=>$d){
						$array_x[$c]=$d;
						}
					$array=$array_x;
					
					
					$date=date('d-m-y');
					
					$this->load->model('patient_m');
					$prep=$this->patient_m->get($id);
					$prep=json_decode($prep->prepscription,true);
					
					if(isset($prep[$this->session->userdata('id')])){
						$dfi=$prep[$this->session->userdata('id')];
						if(isset($dfi[$date])){
							//If date exists
							$temp=$dfi[$date];
							$temp_x=array_merge($temp,$array);
							$dfi[$date]=$temp_x;
							$temp_x=array_reverse($temp_x);
							$ini_size=sizeof($temp_x);
							$temp_x=array_slice($temp_x,0,10);
							$fin_size=sizeof($temp_x);
							
							$prep[$this->session->userdata('id')][$date]=$temp_x;
							$dfi=json_encode($prep);
							if($this->patient_m->save(array('prepscription'=>$dfi),$id)){
								
								if($ini_size!=$fin_size) $mssg='<strong>Success </strong>You crossed the limit of 10. So data is truncated from end.';
								else $mssg='Successfully added';
								 $this->session->set_flashdata('message','<p>'.$mssg.'</p>');
								 $this->session->set_flashdata('type','success');
								 redirect($_SERVER['HTTP_REFERER']);
								}
							
							}
						
						else{
							//If date not exists
							$ini_size=sizeof($array);
							$array=array_slice($array,0,10);
							$fin_size=sizeof($array);
							
							$prep[$this->session->userdata('id')][$date]=$array;
							$dfi=json_encode($prep);
							if($this->patient_m->save(array('prepscription'=>$dfi),$id)){
								
								if($ini_size!=$fin_size) $mssg='<strong>Success </strong>You crossed the limit of 10. So data is truncated from end.';
								else $mssg='Successfully added';
								
								 $this->session->set_flashdata('message','<p>'.$mssg.'</p>');
								 $this->session->set_flashdata('type','success');
								 redirect($_SERVER['HTTP_REFERER']);
								
								}
							}
						}
					else{
						
						$dfi=$prep;
						$ini_size=sizeof($array);
						$array=array_slice($array,0,10);
						$fin_size=sizeof($array);
						
						
						$dfi[$this->session->userdata('id')][$date]=$array;
						//var_dump($dfi);
						$dfi=json_encode($dfi);
						
						if($this->patient_m->save(array('prepscription'=>$dfi),$id)){
							if($ini_size!=$fin_size) $mssg='<strong>Success </strong>You crossed the limit of 10. So data is truncated from end.';
								else $mssg='Successfully added';
								
								 $this->session->set_flashdata('message','<p>'.$mssg.'</p>');
								 $this->session->set_flashdata('type','success');
								 redirect($_SERVER['HTTP_REFERER']);
							}
						
						}
					
					}
				else {
				   $this->session->set_flashdata('message','<p>Template name is required</p><p>Drug name is required</p>');
				   $this->session->set_flashdata('type','danger');
				   redirect($_SERVER['HTTP_REFERER']);
					}
			
				break;
				
				}
			
}

		public function edit_prep(){
			$name				=sql_filter(str_replace('::',' ', ($this->input->post('name'))));
			$drug				=sql_filter(str_replace('::',' ', ($this->input->post('drug'))));
			$duration			=sql_filter(str_replace('::',' ', ($this->input->post('duration'))));
			$instruction		=sql_filter(str_replace('::',' ', ($this->input->post('instruction'))));
			$morning			=sql_filter(str_replace('::',' ', ($this->input->post('morning'))));
			$noon				=sql_filter(str_replace('::',' ', ($this->input->post('noon'))));
			$night				=sql_filter(str_replace('::',' ', ($this->input->post('night'))));
			$pid				=sql_filter(str_replace('::',' ', ($this->input->post('pid'))));
			$index				=sql_filter(str_replace('::',' ', ($this->input->post('index'))));
			$date				=sql_filter(str_replace('::',' ', ($this->input->post('date'))));
			
			//Get all the patient
			$this->load->model('patient_m');
			$p_data=$this->patient_m->get($pid);
			$prep=json_decode($p_data->prepscription,true);
			$id=$this->session->userdata('id');
			if(isset($prep[$id][$date][$index])){
				$str=(substr($name,0,50)).'-::-'.(substr($drug,0,50)).'-::-'.(substr($duration,0,50)).'-::-'.(substr($instruction,0,200)).'-::-'.(substr($morning,0,30)).'-::-'.(substr($noon,0,30)).'-::-'.(substr($night,0,30));
				$prep[$id][$date][$index]=$str;
				$data=json_encode($prep);
				if($this->patient_m->save(array('prepscription'=>$data),$pid)){
				   	$this->session->set_flashdata('message','Successfully edited');
				   	$this->session->set_flashdata('type','success');
					echo 1; return;
					}
				else {
					$this->session->set_flashdata('message','Something went wrong');
				   	$this->session->set_flashdata('type','warning');
					echo 1; return;
					
					}
				}
			else{
					$this->session->set_flashdata('message','No matched data found');
				   	$this->session->set_flashdata('type','warning');
					echo 1; return;
				}
			
			
		}
			
		public function ajax_delete_plan(){
			$index				=sql_filter($this->input->post('index'));
			$date				=sql_filter($this->input->post('date'));
			$id					=sql_filter($this->input->post('id'));
			$doctor_id			=$this->session->userdata('id');
			
			$this->load->model('patient_m');
			$data=$this->patient_m->get($id,true);
			$json=json_decode($data->treatment_plans,true);
			if(isset($json[$doctor_id][$date][$index]))
			unset($json[$doctor_id][$date][$index]);
			if(!sizeof($json[$doctor_id][$date]))
			unset($json[$doctor_id][$date]);
			$json=json_encode($json);
			$meta=array('treatment_plans'=>$json);
			if($this->patient_m->save($meta,$id)) echo 1;
			else echo 0;
			//echo 1;
			}
			
		
			
		public function ajax_complete_plan(){
			
			$index				=sql_filter($this->input->post('index'));
			$date				=sql_filter($this->input->post('date'));
			$id					=sql_filter($this->input->post('id'));
			$doctor_id			=$this->session->userdata('id');
			
			$this->load->model('patient_m');
			$data=$this->patient_m->get($id,true);
			$json=json_decode($data->treatment_plans,true);
			if(isset($json[$doctor_id][$date][$index])){
				$exploded=explode('-::-',$json[$doctor_id][$date][$index]);
				if($exploded[0]==1) return;
				$exploded[0]=1;
				$imploded=implode('-::-',$exploded);
				$json[$doctor_id][$date][$index]=$imploded;
				}
			$json=json_encode($json);
			$meta=array('treatment_plans'=>$json);
			if($this->patient_m->save($meta,$id)) echo 1;
			else echo 0;
			//echo 1;
			}
		public function ajax_add_fund(){
			
			$index				=sql_filter($this->input->post('index'));
			$date				=sql_filter($this->input->post('date'));
			$id					=sql_filter($this->input->post('id'));
			$val				=abs(sql_filter($this->input->post('val')));
			$doctor_id			=$this->session->userdata('id');
			
			$this->load->model('patient_m');
			$data=$this->patient_m->get($id,true);
			$json=json_decode($data->treatment_plans,true);
			
			if(isset($json[$doctor_id][$date][$index])){
				$exploded=explode('-::-',$json[$doctor_id][$date][$index]);
				if($exploded[0]==1) return;
				
				$total	=$exploded[4];
				$paid	=$exploded[5];
				$due	=$exploded[6];
				
				$paid=$paid+abs($val);
				
				if($paid>$total) $paid=$total;
				$due=$total-$paid;
				
				$exploded[5]=$paid;
				$exploded[6]=$due;
				
				$imploded=implode('-::-',$exploded);
				$json[$doctor_id][$date][$index]=$imploded;
				}
			$json=json_encode($json);
			$meta=array('treatment_plans'=>$json);
			if($this->patient_m->save($meta,$id)) echo 1;
			else echo 0;
			}
		 
	public function add_patient(){ 
		$rule=array(
			'email'	=>array('field'=>'primary_email_address','label'=>'Email','rules'=>'trim|required|xss_clean|max_length[50]|valid_email|is_unique[doctors.email]'),
			'name'	=>array('field'=>'name','label'=>'Name','rules'=>'trim|required|xss_clean|max_length[50]'),
			'phone'	=>array('field'=>'primary_contact_number','label'=>'Phone Number','rules'=>'trim|numeric|required|xss_clean|max_length[50]'),
			'password_1'=>array('field'=>'password','label'=>'Password','rules'=>'trim|required|min_length[6]|matches[c_password]'),
			'password_2'=>array('field'=>'c_password','label'=>'Confirm Password','rules'=>'trim|required'),
			);
		$this->form_validation->set_rules($rule);
		$this->form_validation->set_message('is_unique', 'The %s is already registered. Please 
		<a href="'.base_url().'doctor/login'.'" style="color:#fff"><button type="button" class="btn btn-danger btn-xs">Login</button></a>
		 with this email.');
		 
		$this->load->library('form_validation');		
		if($this->form_validation->run()==TRUE){
			$email	=sql_filter($this->input->post('primary_email_address'));
			$name		=sql_filter($this->input->post('name'));
			$phone	=sql_filter($this->input->post('primary_contact_number'));
			
			$password=sql_filter($this->input->post('password'));
			$password=hash_it($password);
			$data=array('email'=>$email,'name'=>$name,'phone'=>$phone,'password'=>$password,'review'=>'');
			$id=$this->doctor_m->register($data);
			if($id){
				redirect(base_url().'doctor/dashboard');
				}
			
			
			}
		else {$this->data['post_message']=validation_errors();}
		
		
		$this->data['page_title']='Add patient';
		$this->data['sub_view']='add_patient';
		$this->load->view('doctor_admin/layout',$this->data);
		
		
	
		
		}
		
		public function ajax_load_medical_history_from_meta(){
			$this->load->model('doc_m');
			$meta_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true); 
			$exploded=explode('-::-',$meta_data->medical_history);
			foreach($exploded as $a=>$b):

 
			echo '<input type="checkbox" class="mofet mofet_history" value="'.$b.'" > <label>  &nbsp; &nbsp;'.$b.'&nbsp;</label>
			<i class="fa fa-fw fa-trash-o" onclick="if(confirm(\'Are you sure?\')) delete_medical_history(\''.$a.'\');"></i>
			<hr style="margin:3px">';
			
			  endforeach;
			}
		public function ajax_get_group_history(){
			$this->load->model('doc_m');
			$meta_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true); 
			$exploded=array_filter(explode('-::-',$meta_data->groups));
			if(empty($exploded)) {echo '<p>No groups found. Please add new group.</p>';return;}
			foreach($exploded as $a=>$b):
			echo '<input type="checkbox" class="mofet mofet_group"  value="'.$b.'"> <label>  &nbsp; &nbsp;'.$b.'&nbsp;</label>
			<i class="fa fa-fw fa-trash-o" onclick="if(confirm(\'Are you sure?\')) delete_group(\''.$a.'\');"></i>
			<hr style="margin:3px">';
			
			endforeach;
			}
		
		
		public function ajax_save_history(){
			if(!isset($_POST['text'])) return;
			else{
				
				$text=sql_filter($_POST['text']);
				$text=str_replace('::','',$this->security->xss_clean($text));
				$text=substr($text,0,30);
				$this->load->model('doc_m');
				$meta_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true);
				$id=$meta_data->id;
				$exploded=explode('-::-',$meta_data->medical_history);
				$exploded[]=$text;
				$exploded=array_filter(array_unique($exploded));
				$exploded=array_reverse($exploded);
				$exploded=array_slice($exploded,0,20);
				$exploded=array_reverse($exploded);
				$exploded=implode('-::-',$exploded);
				if($this->doc_m->save(array('medical_history'=>$exploded),$id)){echo 1;}
				
				}
			}
		public function ajax_save_group(){
			if(!isset($_POST['text'])) return;
			else{
				
				$text=sql_filter($_POST['text']);
				$text=str_replace('::','',$this->security->xss_clean($text));
				$text=substr($text,0,30);
				$this->load->model('doc_m');
				$meta_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true);
				$id=$meta_data->id;
				$exploded=explode('-::-',$meta_data->groups);
				$exploded[]=$text;
				$exploded=array_filter(array_unique($exploded));
				$exploded=array_reverse($exploded);
				$exploded=array_slice($exploded,0,20);
				$exploded=array_reverse($exploded);
				$exploded=implode('-::-',$exploded);
				if($this->doc_m->save(array('groups'=>$exploded),$id)){echo 1;}
				
				}
			}
		
			
		public function delete_medical_history(){
			if(!isset($_POST['index'])) return; 
			$index=sql_filter($_POST['index']);
			$this->load->model('doc_m');
			$meta_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true);
			$id=$meta_data->id;
			$exploded=explode('-::-',$meta_data->medical_history);
			if(isset($exploded[$index])) {
				unset($exploded[$index]);
				$exploded=implode('-::-',$exploded);
				if($this->doc_m->save(array('medical_history'=>$exploded),$id)){echo 1;}
				}
			
			}
			
		public function delete_group(){
			if(!isset($_POST['index'])) return; 
			$index=sql_filter($_POST['index']);
			$this->load->model('doc_m');
			$meta_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true);
			$id=$meta_data->id;
			$exploded=explode('-::-',$meta_data->groups);
			if(isset($exploded[$index])) {
				unset($exploded[$index]);
				$exploded=implode('-::-',$exploded);
				if($this->doc_m->save(array('groups'=>$exploded),$id)){echo 1;}
				}
			
			}
		
		public function ajax_save_referer(){
			if(!isset($_POST['text'])) return;
			else{
				
				$text=sql_filter($_POST['text']);
				$text=str_replace('::','',$this->security->xss_clean($text));
				$text=substr($text,0,30);
				$this->load->model('doc_m');
				$meta_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true);
				$id=$meta_data->id;
				$exploded=explode('-::-',$meta_data->referer);
				$exploded[]=$text;
				$exploded=array_filter(array_unique($exploded));
				$exploded=array_reverse($exploded);
				$exploded=array_slice($exploded,0,20);
				$exploded=array_reverse($exploded);
				$exploded=implode('-::-',$exploded);
				if($this->doc_m->save(array('referer'=>$exploded),$id)){echo 1;}
				
				}
			
			}
		
		public function populate_referer(){
			$this->load->model('doc_m');
			$meta_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true); 
			$exploded=array_filter(explode('-::-',$meta_data->referer));
			if(empty($exploded)) {echo '<option disabled="disabled">Please add referer</option>';return;}
			echo '<option selected="selected" value="">No reference</option>';
			foreach($exploded as $a=>$b):
			echo '<option value="'.$b.'">'.$b.'</option>';
			endforeach;
			}
			
		public function get_p_details_by_phone(){
			if(!isset($_POST['phone'])) return;
			else{
				
				$phone=sql_filter($_POST['phone']);
				$phone=str_replace('::','',$this->security->xss_clean($phone));
				$this->load->model('patient_m');
				$data=$this->patient_m->get_by(array('phone'=>$phone,'parent'=>'1'),true);
				if(empty($data)){
					echo 'empty';
					}
				else{
					echo json_encode($data);
					}
			}
			
			}
		public function get_p_details_by_id(){
			if(!isset($_POST['pid'])) return;
			else{
				
				$pid=sql_filter($_POST['pid']); 
				$this->load->model('patient_m');
				$data=$this->patient_m->get_by(array('id'=>$pid),true);
				if(empty($data)){
					echo 'empty';
					}
				else{
					echo json_encode($data);
					}
			}
			
			}
		
		public function sad(){
			$asd='';
			$temp=array(
				'name'=>'Raj',
				'phone'=>'9475956719',
				'aadhaar'=>'',
				'family'=>'-::-',
				'gender'=>'',
				'refered_by'=>'{"29":""}',
				'medical_history'=>'',
				'blood_group'=>'',
				'group'=>'-::--::-',
				'email'=>'',
				'street'=>$asd,
				'locality'=>$asd,
				'city'=>$asd,
				'pin'=>$asd,
				'parent'=>'1',
				'doctors'=>'29',
				'clinical_notes'=>'',
				'treatment_plans'=>'',
				'prepscription'=>'',
				'medical_history'=>'',
				
				);
				
			$this->load->model('patient_m');
			$this->patient_m->save($temp);
			}
			
		public function save_patient_handler(){
			$this->load->helper('security');
			$this->load->model('doc_m');
			$this->load->model('patient_m');
			
			$rules=array(
			'name'	=>array('field'=>'p_name','label'=>'Name','rules'=>'trim|required|xss_clean|max_length[50]|min_length[3]'),
			'phone'	=>array('field'=>'p_phone','label'=>'Phone Number','rules'=>'trim|numeric|required|xss_clean|max_length[10]|min_length[10]'));
		 
		$this->load->library('form_validation');	
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$name		=xss_clean(sql_filter($this->input->post('p_name')));
			$phone		=xss_clean(sql_filter($this->input->post('p_phone')));
			
			//First check the existance of name and number
			
			$data=$this->patient_m->get_by(array('phone'=>$phone,'name'=>$name,'parent'=>1),true);
			//echo $this->db->last_query();
			
			$aadhaar				=xss_clean(sql_filter($this->input->post('p_aadhaar')));
			$blood_group			=xss_clean(sql_filter($this->input->post('blood_group')));
			$family					=xss_clean(sql_filter($this->input->post('family')));
			$relation				=xss_clean(sql_filter($this->input->post('relation')));
			$email					=xss_clean(sql_filter($this->input->post('p_email')));
			$email					=xss_clean(sql_filter($this->input->post('p_email')));
			$address				=xss_clean(sql_filter($this->input->post('p_address')));
			$locality				=xss_clean(sql_filter($this->input->post('p_locality')));
			$city					=xss_clean(sql_filter($this->input->post('p_city')));
			$pin					=xss_clean(sql_filter($this->input->post('p_pin')));
			$medical_history		=xss_clean(sql_filter($this->input->post('medical_history')));
			$group					=xss_clean(sql_filter($this->input->post('group')));
			$referer				=xss_clean(sql_filter($this->input->post('referer')));
			$gender					=xss_clean(sql_filter($this->input->post('gender')));
			$occupation				=xss_clean(sql_filter($this->input->post('occupaton')));
			$dob					=xss_clean(sql_filter($this->input->post('dob')));
			$optional_id			=str_replace('::','',xss_clean(sql_filter($this->input->post('p_o_id'))));
			
			
			
			if(empty($data)){
				
				//Optional ID
				$initial_optional_id=$optional_id;
				$temp=array();
				$temp[$this->session->userdata['id']]=$optional_id;
				$optional_id=json_encode($temp);
					
				$family=$family.'-::-'.$relation;
				
				
				$initial_referer=$referer;
				$temp=array();
				$temp[$this->session->userdata['id']]=$referer;
				$referer=json_encode($temp);
				
				$temp=array();
				$initial_medical_history=$medical_history;
				$temp[$this->session->userdata['id']]= array_reverse(array_slice(array_reverse(array_filter(explode('-::-',$medical_history))),0,10));
				
				$medical_history=json_encode($temp);
				
				$temp=array();
				$initial_group=$group;
				$group=array_filter(explode('-::-',$group));				
				$sid=$this->session->userdata['id'];
				foreach($group as $a=>$b){
					$temp[]=$sid.'_'.$b;
					}
				$group=implode('-::-',$temp);
				$group='-::-'.$group.'-::-';
				
				
				$doctors=','.$sid.',';
				
				$phone_number_existance=$this->patient_m->get_by(array('phone'=>$phone),true);
				if(!empty($phone_number_existance)) $parent=0;
				else $parent=1;
				
				$sne=$this->patient_m->get_by(array('phone'=>$phone,'parent'=>0),true);
				if(!empty($sne)) $name_exists=$sne->id;
				else $name_exists=0;
				
				$temp=array(
				'name'=>$name,
				'phone'=>$phone,
				'aadhaar'=>$aadhaar,
				'family'=>$family,
				'gender'=>$gender,
				'refered_by'=>$referer,
				'medical_history'=>$medical_history,
				'blood_group'=>$blood_group,
				'group'=>$group,
				'email'=>$email,
				'street'=>$address,
				'locality'=>$locality,
				'city'=>$city,
				'pin'=>$pin,
				'parent'=>$parent,
				'doctors'=>$doctors,
				'clinical_notes'=>'',
				'treatment_plans'=>'',
				'prepscription'=>'',
				'medical_history'=>$medical_history,
				'occupation'=>$occupation,
				'dob'=>$dob,
				'optional_id'=>$optional_id
				
				);
				//
				if($name_exists){
					//Just edit the record $sne
					$docs=$sne->doctors;
					$docs=explode(',',$docs);
					$docs[]=$this->session->userdata('id');
					$docs=implode(',',array_unique(array_filter($docs)));
					$doctors=','.$docs.',';
					
					$saved_referer=json_decode($sne->refered_by,true); 
					$tempu=array();
					
					$tempu[$this->session->userdata['id']]=$initial_referer;
					if(isset($saved_referer[$this->session->userdata['id']])) 
					$saved_referer[$this->session->userdata['id']]=$initial_referer;
					$mar_array=($saved_referer+$tempu);					
					$referer=json_encode($mar_array);
					
					$tempu=array();
					$tempu=json_decode($sne->optional_id,true);
					$tempu[$this->session->userdata['id']]=$initial_optional_id;
					$optional_id=json_encode($tempu);
					
					//Medical history
					$tempu=array();
					$tempu[$this->session->userdata['id']]= array_reverse(array_slice(array_reverse(array_filter(explode('-::-',$initial_medical_history))),0,10));
					
					$saved_history=json_decode($sne->medical_history,true);
					$id_d=$this->session->userdata['id'];
					$saved_history[$id_d]=$tempu[$id_d];
					$medical_history=json_encode($saved_history);
					//var_dump($medical_history);
					//return;
					//---Medical history
					
					//Group----------------------
					 $saved_group=$sne->group;
					
					$tempu=array();
					$saved_group=array_filter(explode('-::-',$saved_group));
					$group=array_filter(explode('-::-',$initial_group));
					$sid=$this->session->userdata['id'];
					
					foreach($group as $a=>$b){
						$tempu[]=$sid.'_'.$b;
						}
									
					$new_group=array_unique(array_merge($saved_group,$tempu));
					$group=implode('-::-',$new_group);
					$group='-::-'.$group.'-::-';
					//Group----------------------
					
					$temp['refered_by']		=$referer;
					$temp['doctors']		=$doctors;
					$temp['optional_id']	=$optional_id;
					$temp['medical_history']=$medical_history;
					$temp['group']			=$group;
					
					
					//var_dump($referer);
					//return;
					
					
					$return_id=$this->patient_m->save($temp,$name_exists);
					if($return_id){
						echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Success!</b>'.'Record updated successfully. <a href="'.bu('doctor/view_patient/'.$return_id).'">View Patient Profile</a>'.'</div>';
									return;
						}
					}
				 
				$return_id=$this->patient_m->save($temp);
				if($return_id){
					if(!file_exists('patients/'.$return_id))
					mkdir('patients/'.$return_id);
					echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Success!</b>'.'New patient added successfully. <a href="'.bu('doctor/view_patient/'.$return_id).'">View Patient Profile</a>'.'</div>';
					}
				
				
				}
			else {
				$saved_name=$data->name;
				
				if($saved_name==$name){
					//Edit the existing record
					$family=$family.'-::-'.$relation;
					
					
					$saved_referer=json_decode($data->refered_by,true);
					$temp=array();
					$temp[$this->session->userdata['id']]=$referer;
					if(isset($saved_referer[$this->session->userdata['id']])) 
					$saved_referer[$this->session->userdata['id']]=$referer;
					$mar_array=($saved_referer+$temp);					
					$referer=json_encode($mar_array);
					
					//Optional ID
					$temp=json_decode($data->optional_id,true);
					$temp[$this->session->userdata['id']]=$optional_id;
					$optional_id=json_encode($temp);
					
					
					//Medical history
					$temp=array();
					$temp[$this->session->userdata['id']]= array_reverse(array_slice(array_reverse(array_filter(explode('-::-',$medical_history))),0,10));
					
					$saved_history=json_decode($data->medical_history,true);
					$id_d=$this->session->userdata['id'];
					$saved_history[$id_d]=$temp[$id_d];
					$medical_history=json_encode($saved_history);
					//var_dump($medical_history);
					//return;
					//---Medical history
					
					//Group----------------------
					$saved_group=$data->group;
					
					$temp=array();
					$saved_group=array_filter(explode('-::-',$saved_group));
					$group=array_filter(explode('-::-',$group));
					$sid=$this->session->userdata['id'];
					
					foreach($group as $a=>$b){
						$temp[]=$sid.'_'.$b;
						}
									
					$new_group=array_unique(array_merge($saved_group,$temp));
					$group=implode('-::-',$new_group);
					$group='-::-'.$group.'-::-';
					//Group----------------------
					
					
					$docs=$data->doctors;
					$docs=explode(',',$docs);
					$docs[]=$this->session->userdata('id');
					$docs=implode(',',array_unique(array_filter($docs)));
					$doctors=','.$docs.',';
					
					$parent=$data->parent;
					$temp=array(
					'name'=>$name,
					'phone'=>$phone,
					'aadhaar'=>$aadhaar,
					'family'=>$family,
					'gender'=>$gender,
					'refered_by'=>$referer,
					'medical_history'=>$medical_history,
					'blood_group'=>$blood_group,
					'group'=>$group,
					'email'=>$email,
					'street'=>$address,
					'locality'=>$locality,
					'city'=>$city,
					'pin'=>$pin,
					'parent'=>$parent,
					'doctors'=>$doctors,
					'clinical_notes'=>'',
					'treatment_plans'=>'',
					'prepscription'=>'',
					'medical_history'=>$medical_history,
					'occupation'=>$occupation,
					'dob'=>$dob,
					'optional_id'=>$optional_id
					
					);
					$return_id=$this->patient_m->save($temp,$data->id);
					if($return_id){
						echo '<div class="alert alert-success alert-dismissable">
											<i class="fa fa-ban"></i>
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
											<b>Success!</b>'.'Successfully edited. <a href="'.bu('doctor/view_patient/'.$return_id).'">View Patient Profile</a>'.'</div>';
						}
						
						}
				else{
					//Add new record
					echo 2;
					
					}
				
				} 
			
			}
		else {echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b>'. validation_errors().'</div>';}
			
			
			}





public function records($show_head=1,$link='view_patient'){
	$this->load->model('patient_m');
	$this->load->model('doctor_m');
	$this->load->model('doc_m');
	$id=$this->session->userdata('id');
	
	$q=sql_filter($this->input->post('q'));
	
	$sql="SELECT * FROM patient WHERE doctors LIKE '%,".$id.",%'";
	$patient_count=$this->db->query("SELECT * FROM patient WHERE doctors LIKE '%,".$id.",%'")->num_rows();
	$patient_data='';
	
	//Groups and patient number
	$group_array=array();
	$temp=$this->doc_m->get_by(array('doctor_id'=>$id),true);
	$temp=@$temp->groups;
	$group_array=explode('-::-',$temp);
	
	//Patient number in the corrosponding group
	$group_ar_count=array();
	foreach($group_array as $a=>$b){
		$group_name=$id.'_'.$b;
		$sql="SELECT (id) FROM patient WHERE doctors LIKE '%,".$id.",%' AND `group` LIKE '%-::-".$group_name."-::-%'";
		$gr_count=$this->db->query($sql)->num_rows();
		$group_ar_count[$b]=$gr_count;
		}
	
	$this->data['link']=$link;
	$this->data['q']=$q;
 	$this->data['show_head']=$show_head;
	$this->data['debug']='';
	$this->data['patient_count']=$patient_count;
	$this->data['group_ar_count']=$group_ar_count;	
	$this->data['page_title']='Records';	
	$this->data['sub_view']='records';
	
	
	if($show_head==0) {
	$this->data['sub_view']='records_x';
	$this->load->view('doctor_admin/layout_simple',$this->data);
	return;
	}
	$this->load->view('doctor_admin/layout',$this->data);
			

	
	}
			
			
public function get_all_patient($offset=0,$link='view_patient'){
	$rows=12;
	$low=$offset*$rows;
	$high=$rows;
	
	$id=$this->session->userdata('id');
	$sql="SELECT * from patient where doctors like '%,$id,%' LIMIT $low,$high";
	$data=$this->db->query($sql)->result();
	$this->serve_patient($data,$link);
	echo '<div style="clear:both" class="mmoj"><hr style="margin:3px">
	<button class="btn btn-primary btn-sm" style=" margin:0 auto; display:block" 
	onclick="append_patients('.($offset+1).',\''.$link.'\')">Load more results</button></div>';
	}
public function get_recent_patient($offset=0,$link='view_patient'){
	$rows=12;
	$low=$offset*$rows;
	$high=$rows;
	
	$id=$this->session->userdata('id');
	$sql="SELECT * from patient where added >'".date('Y-m-d', strtotime(' -2 day'))."' AND doctors like '%,$id,%'  LIMIT $low,$high";
	$data=$this->db->query($sql)->result();
	$this->serve_patient($data,$link);
	echo '<div style="clear:both" class="mmoj"><hr style="margin:3px">
	<button class="btn btn-primary btn-sm" style=" margin:0 auto; display:block" onclick="append_recent_patients('.($offset+1).')">Load more results</button></div>';
	}

public function get_all_patient_from_group($offset=0,$link='view_patient'){
	$rows=12;
	$low=$offset*$rows;
	$high=$rows;
	
	if(!isset($_POST['g_name'])) return;
	$id=$this->session->userdata('id');
	$group_name=sql_filter($this->input->post('g_name'));
	$formated_g_name=$id.'_'.$group_name;
	$sql="SELECT * from patient where `group` like '%-::-$formated_g_name-::-%' LIMIT $low,$high";
	$data=$this->db->query($sql)->result();
	$this->serve_patient($data,$link);
	echo '<div style="clear:both" class="mmoj"><hr style="margin:3px">
	<button class="btn btn-primary btn-sm" style=" margin:0 auto; display:block" 
	onclick="append_patients_by_group('.($offset+1).',\''.$group_name.'\',\''.$link.'\')">Load more results</button></div>';
	}
	
	

public function serve_patient($data=NULL,$link='view_patient'){
	if($data==NULL) return;
	foreach($data as $a=>$b){
		$gender=$b->gender;
		echo '<a href="'.bu('doctor/'.$link.'/'.$b->id).'"><div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 smml row" >
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-pad">
		<img src="';
		
		if(file_exists('patients/'.$b->id.'/dp.jpg'))
		echo bu('patients/'.$b->id.'/dp.jpg');
		else{
			if($gender=='M') echo bu('images/avatar5.png');
			else if($gender=='F') echo bu('images/avatar_lady.jpg');
			else  echo bu('images/user.png');
			echo '" class="h_h"></div>';
			}
		
		
		echo '<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 no-pad"><strong>'.$b->name.'</strong>
		';
		if($gender=='M') echo '<br>Male';
		else if($gender=='F') echo '<br>Female';
		if(!empty($b->phone)) echo '<br>'.$b->phone;
		
		$opt_id=json_decode($b->optional_id,true);
		if(isset($opt_id[$this->session->userdata('id')])) echo '<br><u>'.$opt_id[$this->session->userdata('id')].'</u>';
		
		echo '</div>';
		echo '</div></a>';
		}
	
	
	}

public function search_patient($link='view_patient'){
	
	
	if(!isset($_POST['g_name'])) return;
	$id=$this->session->userdata('id');
	
	$query=sql_filter($this->input->post('g_name'));
	$op_id=$id.'":"'.$query;
	
	$sql="SELECT * from patient where (`optional_id` like '%$op_id%' or name like '%$query%' or phone like '%$query%' or aadhaar like '%$query%') AND doctors like '%,$id,%' LIMIT 24";
	$data=$this->db->query($sql)->result();
	$this->serve_patient($data,$link);
	
	}

public function view_patient($pid=NULL){
	if($pid==NULL) return;
	$pid=sql_filter($pid);
	
	$id=$this->session->userdata('id');
	//Check if the patient belongs to the doctor
	$sql="SELECT id FROM patient WHERE doctors like '%,$id,%' and id='$pid'";
	$num_rows=$this->db->query($sql)->num_rows();
	
	if(!$num_rows) {show_404();return;}
	
	$this->load->model('patient_m');
	$p_data=$this->patient_m->get($pid,true);
	
	//
//	$this->load->model('doc_m');
//	$doc_m=$this->doc_m->get(array('doctor_id'=>$this->session->userdata('id')),true);
//	
//	$this->data['doc_m']=$doc_m;
	$this->data['p_data']=$p_data;
	$this->data['debug']='';	
	$this->data['page_title']=$p_data->name.' Details';	
	$this->data['sub_view']='view_patient';
	$this->load->view('doctor_admin/layout',$this->data);
	}

public function edit_patient($pid=NULL){
	if($pid==NULL) return;
	$pid=sql_filter($pid);
	
	$id=$this->session->userdata('id');
	//Check if the patient belongs to the doctor
	$sql="SELECT id FROM patient WHERE doctors like '%,$id,%' and id='$pid'";
	$num_rows=$this->db->query($sql)->num_rows();
	
	if(!$num_rows) {show_404();return;}
	
	$this->load->model('patient_m');
	$p_data=$this->patient_m->get($pid,true);
	
	$this->data['p_data']=$p_data;
	$this->data['debug']='';	
	$this->data['page_title']='Edit:'.$p_data->name;	
	$this->data['sub_view']='edit_patient';
	$this->load->view('doctor_admin/layout',$this->data);
	}

public function edit_patient_handler($pid=NULL){
	$pid=sql_filter($pid);
	
	$id=$this->session->userdata('id');
	//Check if the patient belongs to the doctor
	$sql="SELECT id FROM patient WHERE doctors like '%,$id,%' and id='$pid'";
	$num_rows=$this->db->query($sql)->num_rows();
	
	if(!$num_rows) {show_404();return;}
	
			$this->load->helper('security');
			$this->load->model('doc_m');
			$this->load->model('patient_m');
			
			$rules=array(
			'name'	=>array('field'=>'p_name','label'=>'Name','rules'=>'trim|required|xss_clean|max_length[50]|min_length[3]'));
		 
		$this->load->library('form_validation');	
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			
			
			//First check the existance of name and number
			
			$data=$this->patient_m->get_by(array('id'=>$pid),true);
			//echo $this->db->last_query();
			
			$name					=xss_clean(sql_filter($this->input->post('p_name')));
			$aadhaar				=xss_clean(sql_filter($this->input->post('p_aadhaar')));
			$blood_group			=xss_clean(sql_filter($this->input->post('blood_group')));
			$family					=xss_clean(sql_filter($this->input->post('family')));
			$relation				=xss_clean(sql_filter($this->input->post('relation')));
			$email					=xss_clean(sql_filter($this->input->post('p_email')));
			$email					=xss_clean(sql_filter($this->input->post('p_email')));
			$address				=xss_clean(sql_filter($this->input->post('p_address')));
			$locality				=xss_clean(sql_filter($this->input->post('p_locality')));
			$city					=xss_clean(sql_filter($this->input->post('p_city')));
			$pin					=xss_clean(sql_filter($this->input->post('p_pin')));
			$medical_history		=xss_clean(sql_filter($this->input->post('medical_history')));
			$group					=xss_clean(sql_filter($this->input->post('group')));
			$referer				=xss_clean(sql_filter($this->input->post('referer')));
			$gender					=xss_clean(sql_filter($this->input->post('gender')));
			$occupation				=xss_clean(sql_filter($this->input->post('occupaton')));
			$dob					=xss_clean(sql_filter($this->input->post('dob')));
			$optional_id			=str_replace('::','',xss_clean(sql_filter($this->input->post('p_o_id'))));
			
			 {
				
					//Edit the existing record
					$family=$family.'-::-'.$relation;
					
					$saved_referer=json_decode($data->refered_by,true);
					$temp=array();
					$temp[$this->session->userdata['id']]=$referer;
					if(isset($saved_referer[$this->session->userdata['id']])) 
					$saved_referer[$this->session->userdata['id']]=$referer;
					$mar_array=($saved_referer+$temp);					
					$referer=json_encode($mar_array);
					
					//Optional ID
					$temp=json_decode($data->optional_id,true);
					$temp[$this->session->userdata['id']]=$optional_id;
					$optional_id=json_encode($temp);
					
					
					//Medical history
					$temp=array();
					$temp[$this->session->userdata['id']]= array_reverse(array_slice(array_reverse(array_filter(explode('-::-',$medical_history))),0,10));
					
					$saved_history=json_decode($data->medical_history,true);
					$id_d=$this->session->userdata['id'];
					$saved_history[$id_d]=$temp[$id_d];
					$medical_history=json_encode($saved_history);
					//var_dump($medical_history);
					//return;
					//---Medical history
					
					//Group----------------------
					$saved_group=$data->group;
					
					$temp=array();
					$saved_group=array_filter(explode('-::-',$saved_group));
					$group=array_filter(explode('-::-',$group));
					$sid=$this->session->userdata['id'];
					
					foreach($group as $a=>$b){
						$temp[]=$sid.'_'.$b;
						}
									
					$new_group=array_unique(array_merge($saved_group,$temp));
					$group=implode('-::-',$new_group);
					$group='-::-'.$group.'-::-';
					//Group----------------------
					
					
					$docs=$data->doctors;
					$docs=explode(',',$docs);
					$docs[]=$this->session->userdata('id');
					$docs=implode(',',array_unique(array_filter($docs)));
					$doctors=','.$docs.',';
					
					$parent=$data->parent;
					$temp=array(
					'name'=>$name, 
					'aadhaar'=>$aadhaar,
					'family'=>$family,
					'gender'=>$gender,
					'refered_by'=>$referer,
					'medical_history'=>$medical_history,
					'blood_group'=>$blood_group,
					'group'=>$group,
					'email'=>$email,
					'street'=>$address,
					'locality'=>$locality,
					'city'=>$city,
					'pin'=>$pin,
					'parent'=>$parent,
					'doctors'=>$doctors,
					'clinical_notes'=>'',
					'treatment_plans'=>'',
					'prepscription'=>'',
					'medical_history'=>$medical_history,
					'occupation'=>$occupation,
					'dob'=>$dob,
					'optional_id'=>$optional_id
					
					);
					$return_id=$this->patient_m->save($temp,$pid);
					if($return_id){
						$this->session->set_flashdata('message','Successfully edited.');
						$this->session->set_flashdata('type','success');
						
						echo '<div class="alert alert-success alert-dismissable">
											<i class="fa fa-check"></i>
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
											<b>Success!</b>'.'Successfully edited. <a href="'.bu('doctor/view_patient/'.$return_id).'">View Patient Profile</a>'.'</div>';
						}
						
						
				
				} 
			
			}
		else {echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b>'. validation_errors().'</div>';}
			
			
			}

public function change_primary($cid=NULL){
	$cid=sql_filter($cid);
	if($cid==NULL) {show_404();return;}
	
	$id=$this->session->userdata('id');
	 
	
	$this->load->model('doctor_m');
	$data=array();
	
	$data['primary']=$cid;
	$this->doctor_m->save($data,$id);
	if(isset($_SERVER['HTTP_REFERER'])) redirect($_SERVER['HTTP_REFERER']);
	}

public function treatment_plans($pid=NULL){
	
	if($pid==NULL){
		//Show all the treatment plans available
		
		 
		$this->data['debug']=''; 	
		$this->data['page_title']='Treatment Plans';	
		$this->data['sub_view']='treatment_plan_home';
		
		$this->load->view('doctor_admin/layout',$this->data);
			
		}
	else{
		filter_pid($pid);
		
		
		//Extract patient data
		$this->load->model('patient_m');
		$patient_data=$this->patient_m->get($pid,true);
		$this->load->model('doc_m');
		$doc_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true);
		
	 	$primary=sql_filter($this->session->userdata('primary'));
		
		$sql="SELECT speciality,treatment_plans,id FROM clinic WHERE id=$primary";
		$clinic_data=$this->db->query($sql)->result();
		@$clinic_data=$clinic_data[0];
		$speciality=$clinic_data->speciality;
		
		$this->load->model('sbs_m');
		$sbs_data=$this->sbs_m->get_by(array('speciality'=>$speciality),true);
		
		$this->data['clinic_data']	=$clinic_data;
		$this->data['sbs_data']		=$sbs_data;
		$this->data['patient_data']	=$patient_data;
		$this->data['doc_data']		=$doc_data; 	
		$this->data['page_title']	='Treatment Plans';	
		$this->data['sub_view']		='treatment_plan_add';
		
		$this->load->view('doctor_admin/layout',$this->data);
		
		}
	
	
	}
	
public function patient_treatment_plans($pid=NULL){
	
	if($pid==NULL){show_404(); return; }
	else{
		filter_pid($pid);
		//Show only the treatment plans available  to the patient
		
		$this->load->model('patient_m');
		$patient_data=$this->patient_m->get($pid,true);
		$this->load->model('doc_m');
		$doc_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true);
		
	 	$primary=sql_filter($this->session->userdata('primary'));
		
		$sql="SELECT speciality,treatment_plans,id FROM clinic WHERE id=$primary";
		$clinic_data=$this->db->query($sql)->result();
		@$clinic_data=$clinic_data[0];
		$speciality=$clinic_data->speciality;
		
		$this->load->model('sbs_m');
		$sbs_data=$this->sbs_m->get_by(array('speciality'=>$speciality),true);
		
		$this->data['clinic_data']	=$clinic_data;
		$this->data['sbs_data']		=$sbs_data;
		$this->data['patient_data']	=$patient_data;
		$this->data['p_data']		=$patient_data;
		$this->data['doc_data']		=$doc_data; 	
		$this->data['pid']			=$pid; 	
		
		$this->data['debug']=''; 	
		$this->data['page_title']='Treatment Plans';	
		$this->data['sub_view']='treatment_plan_home_single';
		
		$this->load->view('doctor_admin/layout',$this->data);
		
		}
	
	
	}

public function add_treatment_plan_template(){
	$rule=array( 
			'name'			=>array('field'=>'name','label'=>'Name','rules'=>'trim|required|xss_clean|max_length[50]'),
			'price'			=>array('field'=>'price','label'=>'Price','rules'=>'trim|numeric|xss_clean|max_length[50]'),
			'speciality'	=>array('field'=>'speciality','label'=>'Speciality','rules'=>'trim|xss_clean|max_length[50]|required|'),
			);
		$this->form_validation->set_rules($rule);
		$this->load->library('form_validation');		
		if($this->form_validation->run()==TRUE){ 
			$name			=sql_filter($this->input->post('name'));
			$price			=sql_filter($this->input->post('price'));
			$speciality		=sql_filter($this->input->post('speciality'));
			
			$name=str_replace("\\",'',$name);
			$name=str_replace("/",'',$name);
			
			$speciality=str_replace("/",'',$speciality);
			$speciality=str_replace("\\",'',$speciality);
			$speciality=str_replace("'-::-",'',$speciality);
			
			$price=str_replace("/",'',$price);
			$price=str_replace("\\",'',$price);
			$price=str_replace("'-::-",'',$price);
			
			if(empty($price)) $price='0';
			$this->load->model('clinic_m');
			$doc_data=$this->clinic_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true); 
			$t_plan=(json_decode($doc_data->treatment_plans,true));
			if(empty($t_plan)){
				$t_plan=array();
				$t_plan[$name]=$speciality.'-::-'.$price;
				}
			else $t_plan[$name]=$speciality.'-::-'.$price;
			$t_plan=json_encode($t_plan); 
			if($this->clinic_m->save(array('treatment_plans'=>$t_plan),$doc_data->id)){
				$this->session->set_flashdata('message', 'Successfully added');
				$this->session->set_flashdata('type', 'success');
				}
			
			
			}
		else {
			$this->session->set_flashdata('message', validation_errors());
			$this->session->set_flashdata('type', 'danger');			
			}
		
		redirect($_SERVER['HTTP_REFERER']);
	
	
	}
public function delete_treatment_plan_template($index=NULL){
	if($index==NULL) return;
	$index=urldecode($index);
	$this->load->model('doc_m');
	$doc_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true); 
	$t_plan=(json_decode($doc_data->treatment_plans,true));
	if(isset($t_plan[$index])) unset($t_plan[$index]);
	$t_plan=json_encode($t_plan); 
	if($this->doc_m->save(array('treatment_plans'=>$t_plan),$doc_data->id)){
		$this->session->set_flashdata('message', 'Successfully deleted');
		$this->session->set_flashdata('type', 'success');
		}
	redirect($_SERVER['HTTP_REFERER']);
	}

public function ajax_save_treaatment_plan(){
	
	$rule=array( 
			'doctor_id'			=>array('field'=>'doctor_id','label'=>'Doctor id','rules'=>'trim|required|xss_clean|max_length[10]'),
			'clinic_id'			=>array('field'=>'clinic_id','label'=>'Clinic id','rules'=>'trim|required|xss_clean|max_length[10]'),
			
			'patient_id'	=>array('field'=>'patient_id','label'=>'Patient id','rules'=>'trim|required|xss_clean|max_length[10]'),
			'json'			=>array('field'=>'patient_id','label'=>'Patient id','rules'=>'trim|required|xss_clean'),
			);
		$this->form_validation->set_rules($rule);
		$this->load->library('form_validation');	echo 222;
	die();	
		if($this->form_validation->run()==TRUE){ 
			$doctor_id			=sql_filter($this->input->post('doctor_id'));
			$clinic_id			=sql_filter($this->input->post('clinic_id'));
			$patient_id			=sql_filter($this->input->post('patient_id'));
			$json				=($this->input->post('json'));
			$json				=json_decode($json,true);
			
			$filtered_json=array();
			foreach($json as $a=>$b){ 
				$filtered_json[$a]=array();
				foreach($b as $aa=>$bb){
					$filtered_json[$a][$aa]=sql_filter($bb); 
					}
				}
			$filtered_json=array_filter($filtered_json);
			if(empty($filtered_json)) {echo 2; return;}
			$filtered_json=json_encode($filtered_json);
			 
			$this->load->model('treat_m');
			
			$data_array=array();
			$data_array['doctor_id']	=$doctor_id;
			$data_array['clinic_id']	=$clinic_id;
			$data_array['patient_id']	=$patient_id;
			$data_array['json']			=$filtered_json;
			$saved=0;
			 
			if(isset($_POST['t_id'])){
				$t_id			=sql_filter($this->input->post('t_id'));
				$saved=$this->treat_m->save($data_array,$t_id);
				if($saved){
				$this->session->set_flashdata('message', 'Treatment plan edited successfully');
				$this->session->set_flashdata('type', 'success');			
				echo 1;
				return;
				}
				}
			else $saved=$this->treat_m->save($data_array);
			if($saved){
				$this->session->set_flashdata('message', 'Treatment plan added successfully');
				$this->session->set_flashdata('type', 'success');			
				echo 1;
				}
			else echo 2; 
			 
			
			}
		else {
			//echo $validation_errors();
			echo 2;
			} 
	}
	

public function ajax_save_new_completed_procedure($inv=0){
	$rule=array( 
			'doctor_id'			=>array('field'=>'doctor_id','label'=>'Doctor id','rules'=>'trim|required|xss_clean|max_length[10]'),
			'clinic_id'			=>array('field'=>'clinic_id','label'=>'Clinic id','rules'=>'trim|required|xss_clean|max_length[10]'),
			
			'patient_id'	=>array('field'=>'patient_id','label'=>'Patient id','rules'=>'trim|required|xss_clean|max_length[10]'),
			'json'			=>array('field'=>'patient_id','label'=>'Patient id','rules'=>'trim|required|xss_clean'),
			);
		$this->form_validation->set_rules($rule);
		$this->load->library('form_validation');		
		if($this->form_validation->run()==TRUE){ 
			$doctor_id			=sql_filter($this->input->post('doctor_id'));
			$clinic_id			=sql_filter($this->input->post('clinic_id'));
			$patient_id			=sql_filter($this->input->post('patient_id'));
			$json				=($this->input->post('json'));
			$json				=json_decode($json,true);
			
			 
			$filtered_json=array();
			foreach($json as $a=>$b){ 
				$filtered_json[$a]=array();
				foreach($b as $aa=>$bb){
					$filtered_json[$a][$aa]=sql_filter($bb); 
					}
				}
			$filtered_json=array_filter($filtered_json);
			if(empty($filtered_json)) {echo 2; return;}
			$filtered_json=json_encode($filtered_json);
			  
			
			$data_array=array();
			$data_array['doctor_id']	=$doctor_id;
			$data_array['clinic_id']	=$clinic_id;
			$data_array['patient_id']	=$patient_id;
			$data_array['json']			=$filtered_json;
			$saved=0;
			
			$this->load->model('completed_m');
			$date=date('d-M-Y');
			$data=$this->completed_m->get_by(array('patient_id'=>$patient_id,'clinic_id'=>$clinic_id,'date'=>$date),true);
			
			$this->load->model('treat_m');
			
			
			//Check if a record exists with patient id,clinic id and date
			//If found then edit the json 
			
			//Also save in treatment plan
			$data_arries['doctor_id']		=$doctor_id;
			$data_arries['clinic_id']		=$clinic_id;
			$data_arries['patient_id']		=$patient_id;
			$data_arries['json']			=$filtered_json;
			
			
			$tp_id=$this->treat_m->save($data_arries);
			
			
			//if inv==1 then also update the invoice also
			$ids=$this->single_invoice_selected($doctor_id,$clinic_id,$patient_id,$filtered_json); 
			$ids_imploded=trim(implode('-::-',$ids));
			
			
			
			
			if(!empty($data)){ 
				$c_id=$data->id;
				$pre_json=$data->json;
				$pre_json=json_decode($pre_json,true);
				$sub_json=json_decode($filtered_json,true);
				$all_json=json_encode(array_merge($pre_json,$sub_json));
				$data_array['json']				=$all_json;
				$data_array['tp_id']			=$tp_id;
				$saved=$this->completed_m->save($data_array,$c_id);
				if($saved){ 
					if($inv){ echo $ids_imploded; return; }
					$this->session->set_flashdata('message', 'Procedure added successfully');
					$this->session->set_flashdata('type', 'success');			
					echo 1;
					return;
					} 
				}
			
			//else save as it is
			else{
				$data_array=array();
				$data_array['doctor_id']	=$doctor_id;
				$data_array['clinic_id']	=$clinic_id;
				$data_array['patient_id']	=$patient_id;
				$data_array['json']			=$filtered_json;
				$data_array['date']			=$date;
				$data_array['tp_id']		=$tp_id;
				$saved=0;
				$saved=$this->completed_m->save($data_array);
				if($saved){
					if($inv){ echo $ids_imploded; return; }
					$this->session->set_flashdata('message', 'Procedure added successfully');
					$this->session->set_flashdata('type', 'success');			
					echo 1;
					return;
					} 
				}
		 
			$saved=$this->completed_m->save($data_array);
			if($saved){
				if($inv){ echo $ids_imploded; return; }
				$this->session->set_flashdata('message', 'Treatment plan added successfully');
				$this->session->set_flashdata('type', 'success');			
				echo 1;
				}
			else echo 2; 
			 
			
			}
		else {
			//echo $validation_errors();
			echo 2;
			} 
	}

public function get_treatment_plans($offset=0){
		if(isset($_POST['pid'])) $pid=sql_filter($_POST['pid']);
		$number_of_result=10;
		$offest_f=$offset*$number_of_result;
		$primary=$this->session->userdata('primary');
		if(empty($primary)){ echo '<p>Please select a clinic from top left to get the treatment plans</p>'; return;}
		$this->load->model('treat_m');
		$this->load->model('patient_m');
		$this->load->model('doctor_m');
		
		$this->db->order_by('date','desc');
		if(isset($pid)){
			
			$t_data	=$this->db->get_where('treatment_plan', 
			array('clinic_id'=>$primary,'patient_id'=>$pid),$number_of_result,$offest_f)->result();		
			}
		else
		$t_data	=$this->db->get_where('treatment_plan', array('clinic_id'=>$primary),$number_of_result,$offest_f)->result();		
		
		
		foreach($t_data as $a=>$b):
		$p_data	=$this->patient_m->get($b->patient_id,true);
		$doctor_data=$this->doctor_m->get($b->doctor_id,true);
		?>
	
    	<h5><?php echo date('d-M-Y',strtotime($b->date));?></h5>
<div class="box box-primary tp p_parent">
	<div class="box-header">
    <div class="s-menu">
    
    <div class="btn-group np">
        <button class="btn btn-default btn-sm printme np" data-print_type="treatment_plans" data-pid="<?php echo $p_data->id?>" ><i class="fa fa-wa fa-print"></i></button> 
        <button id="dLabel" class="btn btn-default btn-sm np" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-wa fa-bars"></i> </button>
          <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
           	<li role="presentation">
            	<a role="menuitem"  href="<?php echo bu('doctor/edit_treatment_plans/'.$b->id)?>"><i class="fa fa-wa fa-pencil"></i> Edit</a>
            </li>
            <li role="presentation">
            	<a role="menuitem" href="<?php echo bu('doctor/delete_t_plan/'.$b->id);?>">
                	<i class="fa fa-wa fa-trash-o"></i> Delete
                </a>
            </li>
            <hr />
             <li role="presentation" class="email_me" data-print_type="treatment_plans" data-pid="<?php echo $p_data->id?>">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-envelope"></i> Email</a>
            </li>
            <li role="presentation" class="printme" data-print_type="treatment_plans" data-pid="<?php echo $p_data->id?>"> 
            	<a role="menuitem"  href=""><i class="fa fa-wa fa-print"></i> Print</a>
            </li>
            <li role="presentation" class="printme_dot_matrix" data-print_type="treatment_plans" data-pid="<?php echo $p_data->id?>">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-print"></i> Dot Matrix Print</a>
            </li>
            <hr />
             <li role="presentation" class="save_me" data-print_type="treatment_plans" data-pid="<?php echo $p_data->id?>">
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
    </div>
                     
    </div> 
    	<a href="<?php echo bu('doctor/view_treatment_plans/'.$b->id);?>" class="np"><table class="detail_head">
        	
            	<tr class="np">
                    <td><img src="<?php echo get_dp($p_data)?>" class="sm_dp np" /></td>
                    <td><?php echo ucfirst($p_data->name)?></td>
                    <td>
                    <?php if($p_data->gender=="M")
                    echo 'Male';
                    elseif($p_data->gender=="F")
                    echo 'Female';
                    $te=@date_diff(date_create(str_replace('/','-',$p_data->dob)), date_create('today'))->y;
                    if(isset($te) and !empty($te)) echo ','.$te.' Years';
                    ?> 
                    
                    </td>
                    <td>ID:<?php $temp=(json_decode($p_data->optional_id,true));
                    if(isset($temp[$this->session->userdata('id')])){ echo $temp[$this->session->userdata('id')];}
                    ?> </td> 
           		</tr>
           
        </table> </a>
        <hr />
        
        <table class="table table-condensed">
        	<thead>
            	<th>PROCEDURE</th>
                <th>COST</th>
                <th>DISCOUNT</th>
                <th>TOTAL</th>
                <th>NOTE</th>
            </thead>
            <?php 
			$data=json_decode($b->json,true);
			$est_cost=0;
			foreach($data as $x=>$y):
			?>
        	<tr class="callout <?php if( $y['completed']) echo 'callout-success'; else echo 'callout-info' ?>">
            	<td>
				<?php if($y['completed']==1)
					echo '<i class="fa fa-fw fa-check-circle-o"></i>';
					else echo '<i class="fa fa-fw fa-circle-o"></i>';
				?>
				<?php echo $y['treatment_plan_name'];?></td>
                <td><i class="fa fa-wa fa-inr"></i><?php echo $y['qty']*$y['price'];?></td>
                <td></i> <i class="fa fa-wa fa-inr"></i>
				<?php echo (($y['qty']*$y['price'])-$y['total_price'])?> 
                (
                <?php 
				if($y['qty']*$y['price']>0)
				echo 100-(($y['total_price']*100)/($y['qty']*$y['price'])); ?>
                %)</td>
                <td><i class="fa fa-wa fa-inr"><?php echo $y['total_price']; $est_cost+=$y['total_price'];?></td>
                <td class="hid_text" title="<?php echo @$y['vig']; ?>">
                <?php if(!empty($y['note_txt'])) echo $y['note_txt'].'<hr>';
				echo @$y['vig']; ?>
                
                </td>
            </tr>
           <?php endforeach;?>
            
        </table>
    	<table class="table table-condensed">
        	<tfoot>
            	<tr>
                	<th>Planned by <strong><?php echo $doctor_data->name; ?></strong></th>
                    <th><strong>Estimated amount:<i class="fa fa-wa fa-inr"> <?php echo $est_cost;?>	</strong></th>
                </tr>
            </tfoot>
        </table>
    	
    </div>
</div>
<div align="center" class="sm_btn">
	<button class="btn btn-info btn-info" onclick="append_result('<?php echo $offset+1;?>')">Show More</button>
</div>
<?php		endforeach;
		}
	
public function delete_paymemnt($index=NULL,$pid=NULL,$date=NULL){
	if($index==NULL){show_404();return;} 
	if($pid==NULL){show_404();return;} 
	if($date==NULL){show_404();return;} 
	
	$clinic_id=$this->session->userdata('primary');
	
	$this->load->model('payment_m');
	$payments=$this->payment_m->get_by(array('patient_id'=>$pid,'clinic_id'=>$clinic_id),true);
	$json=json_decode($payments->json,true);
	if(isset($json[$date][$index])){ 
		unset($json[$date][$index]);
		}
	$json=json_encode($json);
	$id=$payments->id;
	if($this->payment_m->save(array('json'=>$json),$id)){
		$this->session->set_flashdata('message', 'Successfully Deleted');
		$this->session->set_flashdata('type', 'success');
		redirect(bu('doctor/payment/'.$pid)); 
		}
	}
	
public function delete_invoice($id=NULL,$pid=NULL){
	
	if($id==NULL){show_404();return;} 
	$id=sql_filter($id);
	//Check the id belongs to the admin of the clinic or the doctor
	$doctor_id=$this->session->userdata('id');
	$clinic_id=$this->session->userdata('primary');
	
	$sql="DELETE FROM invoice WHERE id=$id AND doctor_id=$doctor_id AND clinic_id=$clinic_id LIMIT 1";
	$result=$this->db->query($sql);
	
	$this->session->set_flashdata('message', 'Successfully Deleted');
	$this->session->set_flashdata('type', 'success');
	redirect(bu('doctor/invoice/'.$pid)); 
	
	
	}
public function delete_t_plan($id=NULL){
	if($id==NULL){show_404();return;}
	$can_delete=0;
	$completed=1;
	$id=sql_filter($id);
	//Check the id belongs to the admin of the clinic or the doctor
	$doctor_id=$this->session->userdata('id');
	 
	$sql="SELECT * FROM treatment_plan WHERE id=$id";
	$result=$this->db->query($sql)->result();
	if(isset($_SERVER['HTTP_REFERER'])) $referer=$_SERVER['HTTP_REFERER'];
	else $referer=bu('doctor/treatment_plans');
	if(isset($result[0])){
		$result=$result[0];
		
		$json=json_decode($result->json,true);
		
		//foreach($json as $ss=>$ii){//
//			if($ii['completed']==1) $completed=0;
//			if($completed==0){
//				$this->session->set_flashdata('message','Can not delete beacuse procedure is under completing procudure');
//				$this->session->set_flashdata('type','warning');
//				
//				redirect($referer);
//				return;
//				}
//			
//			}
		
		
		if($result->doctor_id==$doctor_id) $can_delete=1;
		$sql="SELECT id FROM clinic WHERE id=".$result->clinic_id." AND doctor_id='$doctor_id'";
		
		//Doctor is the admin of the clinic
		$num_rows=$this->db->query($sql)->num_rows();
		if($num_rows) $can_delete=1;
		
		if($can_delete){ 
			$this->db->delete('treatment_plan', array('id' => $id));
			$this->session->set_flashdata('message','Successfully deleted');
			$this->session->set_flashdata('type','success');
			redirect($referer);
				
			}
		else {
			$this->session->set_flashdata('message','You can not delete the plan. Either the owner doctor or the admin can delete');
			$this->session->set_flashdata('type','warning');
			redirect($referer);
			}
		
		}
	
	
	}
	
public function delete_c_procedure($id=NULL){
	if($id==NULL){show_404();return;} 
	$id=sql_filter($id);
	
	//Get the patient id
	$this->load->model('completed_m');
	$data=$this->completed_m->get($id);
	if(empty($data)) return;
	$pid=$data->patient_id;
	
	if(valid_pid_for_completed_procedure($pid)){
		
		//Delete from treatment plan if tp_id is available
		$this->load->model('completed_m');
		$data=$this->completed_m->get($id);
		if(isset($data->tp_id) and !empty($data->tp_id)){
			$this->load->model('treat_m');
			$this->treat_m->delete($data->tp_id);
			}
		$this->db->delete('completed_procedure', array('id' => $id));
		$this->session->set_flashdata('message','Successfully deleted');
		$this->session->set_flashdata('type','success');
		redirect(bu('doctor/completed_procedure/'.$pid));  
		}
	 
	else {
		$this->session->set_flashdata('message','You can not delete the plan. Either the owner doctor or the admin can delete');
		$this->session->set_flashdata('type','warning');
		redirect(bu('doctor/completed_procedure/'.$pid));  
		} 
	}

public function view_treatment_plans($id=NULL){
	
	if($id==NULL){show_404();return;}
	$can_view=0;
	$id=sql_filter($id);
	//Check the id belongs to the admin of the clinic or the doctor
	$doctor_id=$this->session->userdata('id');
	 
	$sql="SELECT * FROM treatment_plan WHERE id=$id";
	$result=$this->db->query($sql)->result();
	if(isset($result[0])){
		$result=$result[0];
		if($result->doctor_id==$doctor_id) $can_view=1;
		$sql="SELECT id FROM clinic WHERE id=".$result->clinic_id." AND doctor_id='$doctor_id'";
		
		//Doctor is the admin of the clinic
		$num_rows=$this->db->query($sql)->num_rows();
		if($num_rows) $can_view=1;
		else {show_404();return;}
		
		if($can_view){ 
			//Get the patient id from the treatment plan id 
			$this->load->model('treat_m'); 
			$temp=$this->treat_m->get_by(array('id'=>$id),true);
			
			$patient_id=$temp->patient_id;
			//Get all the treatment plan of the patient on the clinic
			
			$primary=$this->session->userdata('primary');  // Get the primary clinic id
			$t_plans=$this->treat_m->get_by(array('clinic_id'=>$primary,'patient_id'=>$patient_id)); 
			
			$this->load->model('patient_m');
			$p_data=$this->patient_m->get($patient_id);
			
			$this->data['patient_id']=$patient_id;
			$this->data['p_data']=$p_data;
			$this->data['t_plans']=$t_plans;
		  	$this->data['sub_view']='view_treatment_plans';
			$this->data['page_title']='Dashboard'; 
			$this->load->view('doctor_admin/layout',$this->data);
				
			}
		else {
			$this->session->set_flashdata('message','You can not view the plan. Only the owner doctor or the admin can view this plan');
			$this->session->set_flashdata('type','warning');
			redirect(bu('doctor/treatment_plans'));
			}
		
		}
	else {show_404();return;}
	
	
	
	}
	
public function get_all_treatment_plans_by_id($offset=0){
		if(isset($_POST['pid'])) $pid=sql_filter($_POST['pid']);
		$number_of_result=10;
		$offest_f=$offset*$number_of_result;
		$primary=$this->session->userdata('primary');
		if(empty($primary)){ echo '<p>Please select a clinic from top left to get the treatment plans</p>'; return;}
		$this->load->model('treat_m');
		$this->load->model('patient_m');
		$this->load->model('doctor_m'); 
		$this->db->order_by("date", "desc");
		if(isset($pid)){
			$t_data	=$this->db->get_where('treatment_plan', 
			array('clinic_id'=>$primary,'patient_id'=>$pid),$number_of_result,$offest_f)->result();		
			}
		else
		$t_data	=$this->db->get_where('treatment_plan', array('clinic_id'=>$primary),$number_of_result,$offest_f)->result();		
		
		
		foreach($t_data as $a=>$b):
		$p_data	=$this->patient_m->get($b->patient_id,true);
		$doctor_data=$this->doctor_m->get($b->doctor_id,true);
		?>
	
    	<h5><?php echo date('d-M-Y',strtotime($b->date));?></h5>
<div class="box box-primary tp p_parent">
	<div class="box-header">
    <div class="s-menu">
    
    <div class="btn-group np">
        <button class="btn btn-default btn-sm np printme" data-print_type="treatment_plans" data-pid="<?=@$b->patient_id?>"><i class="fa fa-wa fa-print"></i></button> 
        <button id="dLabel" class="btn btn-default btn-sm np" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-wa fa-bars"></i> </button>
          <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
           	<li role="presentation">
            	<a role="menuitem"  href="<?php echo bu('doctor/edit_treatment_plans/'.$b->id)?>"><i class="fa fa-wa fa-pencil"></i> Edit</a>
            </li>
            <li role="presentation">
            	<a role="menuitem" href="<?php echo bu('doctor/delete_t_plan/'.$b->id);?>">
                	<i class="fa fa-wa fa-trash-o"></i> Delete
                </a>
            </li>
            <hr />
            <li role="presentation">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-envelope"></i> Email</a>
            </li>
            <li role="presentation" class="printme" data-print_type="treatment_plans" data-pid="<?=@$b->patient_id?>">
            	<a role="menuitem"  href=""><i class="fa fa-wa fa-print"></i> Print</a>
            </li>
            <li role="presentation" class="printme_dot_matrix" data-print_type="treatment_plans" data-pid="<?=@$b->patient_id?>">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-print"></i> Dot Matrix Print</a>
            </li>
            <li role="presentation" class="save_me" data-print_type="treatment_plans" data-pid="<?=@$b->patient_id?>">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-save"></i> Save as PDF</a>
            </li>
            <li role="presentation">
            	<a role="menuitem"  href="<?php echo bu('doctor/printouts');?>"><i class="fa fa-wa fa-gear"></i> Print Settings</a>
            </li>
            <hr>
            <li role="presentation">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-tasks"></i> View Patient Timeline</a>
            </li>
          </ul> 
    </div>
                     
    </div> 
    	<a class="np" href="<?php echo bu('doctor/view_treatment_plans/'.$b->id);?>"><table class="detail_head">
        	
            	<tr class="np"> 
                    <td><img src="<?php echo get_dp($p_data)?>" class="sm_dp np" /></td>
                    <td class="np"><?php echo ucfirst($p_data->name)?></td>
                    <td class="np">
                    <?php if($p_data->gender=="M")
                    echo 'Male';
                    elseif($p_data->gender=="F")
                    echo 'Female';
                    $te=@date_diff(date_create(str_replace('/','-',$p_data->dob)), date_create('today'))->y;
                    if(isset($te) and !empty($te)) echo ','.$te.' Years';
                    ?> 
                    
                    </td>
                    <td class="np">ID:<?php $temp=(json_decode($p_data->optional_id,true));
                    if(isset($temp[$this->session->userdata('id')])){ echo $temp[$this->session->userdata('id')];}
                    ?> </td> 
           		</tr>
           
        </table> </a>
        <hr />
        
        <table class="table table-condensed">
        	<thead>
            	<th>PROCEDURE</th>
                <th>COST</th>
                <th>DISCOUNT</th>
                <th>TOTAL</th>
                <th>NOTE</th>
            </thead>
            <?php 
			$data=json_decode($b->json,true);
			$est_cost=0;
			foreach($data as $x=>$y):
			?>
        	<tr class="callout <?php if( $y['completed']) echo 'callout-success'; else echo 'callout-info' ?>">
            	<td>
				<?php if($y['completed']==1)
					echo '<input class="np" type="checkbox" checked="checked"  disabled="disabled" >';
					else echo '<input type="checkbox" class="checker np" data-index="'.$x.'" data-parent="'.$b->id.'">';
				?>
				<?php echo $y['treatment_plan_name'];?></td>
                <td><i class="fa fa-wa fa-inr"></i><?php echo $y['qty']*$y['price'];?></td>
                <td></i> <i class="fa fa-wa fa-inr"></i>
				<?php echo (($y['qty']*$y['price'])-$y['total_price'])?> 
                (
                <?php 
				if($y['qty']*$y['price']>0)
				echo 100-(($y['total_price']*100)/($y['qty']*$y['price'])); ?>
                %)</td>
                <td><i class="fa fa-wa fa-inr"><?php echo $y['total_price']; $est_cost+=$y['total_price'];?></td>
                <td class="hid_text" title="<?php echo @$y['vig']; ?>">
                <?php if(!empty($y['note_txt'])) echo $y['note_txt'].'<hr>';
				echo @$y['vig']; ?>
                
                </td>
            </tr>
           <?php endforeach;?>
            
        </table>
    	<table class="table table-condensed">
        	<tfoot>
            	<tr>
                	<th>Planned by <strong><?php echo $doctor_data->name; ?></strong></th>
                    <th><strong>Estimated amount:<i class="fa fa-wa fa-inr"> <?php echo $est_cost;?>	</strong></th>
                </tr>
            </tfoot>
        </table>
    	
    </div>
</div>
<div align="center" class="sm_btn">
	<button class="btn btn-info btn-info" onclick="append_result('<?php echo $offset+1;?>')">Show More</button>
</div>
<?php		endforeach;
		}
		
public function mark_t_plan(){
	if(!isset($_POST['str'])) {show_404(); return;}
	
	$str=sql_filter($_POST['str']);
	$str=array_filter(explode('-::-',$str));
	$this->load->model('treat_m');
	foreach($str as $a=>$b){
		$temp=explode(':',$b);
		$id=$temp[0];
		$index=$temp[1]; 
		$data=$this->treat_m->get($id,true);
		$json=json_decode($data->json,true);
		if(isset($json[$index])){
			$json[$index]['completed']=1;
			$json[$index]['completed'];
			$json=json_encode($json);
			$this->treat_m->save(array('json'=>$json),$id);
			}
		echo 1;
		//var_dump($json);
		} 
	
	}

public function edit_treatment_plans($t_id=NULL){
	
	
	if($t_id==NULL){ 
		show_404();
		return;
		 
			
		}
	else{
		//Get the treatment plan details
		$t_id=sql_filter($t_id);
		$this->load->model('treat_m');
		$t_data=$this->treat_m->get($t_id,true);
		
		if(empty($t_data)) {show_404();return;}
		
		//Get the patient details
		$this->load->model('patient_m');
		$patient_data=$this->patient_m->get($t_data->patient_id,true);
		
		
		//Extract patient data 
		
		$this->load->model('doctor_m');
		$session_id=$this->session->userdata('id');
		$doctor_data=$this->doctor_m->get($t_data->doctor_id,true); 
		//404 if the plan does not belong to the doctor admin
		if($doctor_data->id!=$session_id){show_404(); return;}
		
		
		$this->load->model('doc_m');
		$doc_data=$this->doc_m->get_by(array('doctor_id'=>$t_data->doctor_id),true);
		
		
	 	$primary=sql_filter($this->session->userdata('primary'));
		
		$sql="SELECT speciality,treatment_plans,id FROM clinic WHERE id=$primary";
		$clinic_data=$this->db->query($sql)->result();
		@$clinic_data=$clinic_data[0];
		$speciality=$clinic_data->speciality;
		
		$this->load->model('sbs_m');
		$sbs_data=$this->sbs_m->get_by(array('speciality'=>$speciality),true);
		 
		
		$this->data['clinic_data']	=$clinic_data;
		$this->data['t_data']		=$t_data;
		$this->data['sbs_data']		=$sbs_data;
		$this->data['patient_data']	=$patient_data;
		$this->data['doc_data']		=$doc_data; 	
		$this->data['page_title']	='Treatment Plans';	
		$this->data['sub_view']		='treatment_plan_edit';
		
		$this->load->view('doctor_admin/layout',$this->data);
		
		}
	
	
	
	}

public function printouts(){
	$this->data['page_title']	='Printing Settings';	
	$this->data['sub_view']		='printouts';
	
	$this->load->view('doctor_admin/layout',$this->data);
	}

public function ajax_load_tab_content(){
	$name		=sql_filter($this->input->post('name'));
	
	$primary	=$this->session->userdata('primary');
	$doc_id		=$this->session->userdata('id');
	
	$this->load->model('print_m');
	$data=$this->print_m->get_by(array('clinic_id'=>$primary),true);
	
	isset($data->$name)?$json=$data->$name:$json='';
	
	$this->data['json']=$json;
	$this->data['dummy_html']=generate_dummy_html_by_name($name);
	$this->load->view('doctor_admin/components/tab_content',$this->data);
	
	}

function ajax_save_print_settings(){
	$json		=json_decode($this->input->post('json'));
	$json		=json_encode($json);

	$save_all	=sql_filter($this->input->post('save_all'));
	$feild		=sql_filter($this->input->post('feild'));
	
	$primary	=$this->session->userdata('primary');
	$doc_id		=$this->session->userdata('id');
	
	$data['doctor_id']				=$doc_id;
	$data['clinic_id']				=$primary;
	$data['prescription']		    ='';
	$data['treatment_plans']		='';
	$data['case_sheet']		    	='';
	$data['medical_leave']		    ='';
	$data['invoice']		    	='';
	$data['recept']		   			='';
	$saved=0;
	
	
	$this->load->model('print_m');
	$raw=$this->print_m->get_by(array('clinic_id'=>$primary),true);
	
	if($save_all){
		$data['prescription']=$data['treatment_plans']=$data['case_sheet']=$data['medical_leave']=$data['invoice']=$data['recept']=$json;
		}
	else {
		if(isset($raw->prescription)) 		$data['prescription']		=$raw->prescription;
		if(isset($raw->treatment_plans)) 	$data['treatment_plans']	=$raw->treatment_plans;
		if(isset($raw->case_sheet)) 		$data['case_sheet']			=$raw->case_sheet;
		if(isset($raw->medical_leave)) 		$data['medical_leave']		=$raw->medical_leave;
		if(isset($raw->invoice)) 			$data['invoice']			=$raw->invoice;
		if(isset($raw->recept)) 			$data['recept']				=$raw->recept; 
		
		$data[$feild]=$json;
		}
	
	$saved=0;
	if(isset($raw->id)){
		$record_id=$raw->id;
		$saved=$this->print_m->save($data,$record_id);
		}
	else {
		 $sqved=$this->print_m->save($data); 
		}
	
	if($saved){
		echo 1;
		$this->session->set_flashdata('message','Successfully saved');
		$this->session->set_flashdata('type','success');
		}
	
	}

public function workdone($t_id=NULL){
		
	//Get the treatment id from session data which is stored by a ajax request from view_treatment_plans.php line:57
	//Controller: doctor/set_userdata
	
	//Data format:  index=>data
	//Retrive the data. If empty show 404
	// data contains treatment_id with json index of the particular treatment plan
	//Ex:19:1-::-67:5
	//19 is the treatment id and 1 is the index
	
	 $t_id=$this->session->userdata('index');
	 
	
	
	if($t_id==NULL or empty($t_id)){ 
		show_404();
		return;
		}
	else{
		
		$treatment_ids=array_filter(explode('-::-',$t_id)); 
		 
		 
		
		$id_array=array();
		foreach($treatment_ids as $a=>$b){
			$temp=array_filter(explode(':',$b)); 
			$id_array[]=@$temp[0];
			}
		$id_array=array_unique($id_array);
		//Check all the ids relates to same patient id
		$ids_str=implode(',',$id_array);
		$sql="SELECT distinct(`patient_id`),doctor_id FROM `treatment_plan` where id in($ids_str)";
		$num_rows=$this->db->query($sql)->num_rows();
		
		if($num_rows!=1){  show_404(); return; }
		
		$result=$this->db->query($sql)->result();
		$result=@$result[0]; 
		$p_id=$result->patient_id;
		//Till these point all the treatment ids are of same patient
		
		
		//Get the patient details
		$this->load->model('patient_m');
		$patient_data=$this->patient_m->get($p_id,true);
		//return;
		
		
		
		//Get the treatment plan details 
		$this->load->model('treat_m');
		
		$this->db->where_in('id', $id_array);
		$t_data=$this->db->get('treatment_plan')->result();
		
		//$t_data=$this->treat_m->get($t_id,true); 
		
		//Get the doctor id
		if(empty($t_data)) {show_404();return;}
		
		//var_dump($t_data);
		//die('This is the break point');
		
		
		
		//Extract doctor data 
		
		$this->load->model('doctor_m');
		$session_id=$this->session->userdata('id');
		$doctor_data=$this->doctor_m->get($t_data[0]->doctor_id,true); 
		
		//404 if the plan does not belong to the doctor admin
		if($doctor_data->id!=$session_id){show_404(); return;}
		
		
		$this->load->model('doc_m');
		$doc_data=$this->doc_m->get_by(array('doctor_id'=>$t_data[0]->doctor_id),true);
		
		
	 	$primary=sql_filter($this->session->userdata('primary'));
		
		$sql="SELECT speciality,treatment_plans,id FROM clinic WHERE id=$primary";
		$clinic_data=$this->db->query($sql)->result();
		@$clinic_data=$clinic_data[0];
		$speciality=$clinic_data->speciality;
		
		$this->load->model('sbs_m');
		$sbs_data=$this->sbs_m->get_by(array('speciality'=>$speciality),true);
		
		
		$this->data['treatment_ids']	=$treatment_ids;
		$this->data['clinic_data']		=$clinic_data;
		$this->data['t_data']			=$t_data;
		$this->data['sbs_data']			=$sbs_data;
		$this->data['patient_data']		=$patient_data;
		$this->data['doc_data']			=$doc_data; 	
		$this->data['page_title']		='Treatment Plans';	
		$this->data['sub_view']			='treatment_plan_workdone';
		
		$this->load->view('doctor_admin/layout',$this->data);
		
		} 
		}
	



	
public function ajax_edit_completed_procedure( ){
	
	$rule=array(
			't_id'			=>array('field'=>'t_id','label'=>'Id','rules'=>'trim|required|xss_clean|max_length[10]'),
			
			'doctor_id'			=>array('field'=>'doctor_id','label'=>'Doctor id','rules'=>'trim|required|xss_clean|max_length[10]'),
			'clinic_id'			=>array('field'=>'clinic_id','label'=>'Clinic id','rules'=>'trim|required|xss_clean|max_length[10]'),
			
			'patient_id'	=>array('field'=>'patient_id','label'=>'Patient id','rules'=>'trim|required|xss_clean|max_length[10]'),
			'json'			=>array('field'=>'patient_id','label'=>'Patient id','rules'=>'trim|required|xss_clean'),
			 
			);
			
		$this->form_validation->set_rules($rule);
		$this->load->library('form_validation');		
		if($this->form_validation->run()==TRUE){ 
		
			$doctor_id			=sql_filter($this->input->post('doctor_id'));
			$t_id				=sql_filter($this->input->post('t_id'));
			$clinic_id			=sql_filter($this->input->post('clinic_id'));
			$patient_id			=sql_filter($this->input->post('patient_id'));
			$json				=($this->input->post('json'));
			$json				=json_decode($json,true);
			  
			$this->load->model('completed_m');
			
			
				
			$filtered_json=array();
			
			foreach($json as $a=>$b){ 
				$filtered_json[$a]=array();
				foreach($b as $aa=>$bb){
					$filtered_json[$a][$aa]=sql_filter($bb); 
					}
				}
			$filtered_json=array_filter($filtered_json);
			if(empty($filtered_json)) {echo 2; return;}
			$filtered_json=json_encode($filtered_json);
			  
			
			
			$data_array['json']			=$filtered_json;
			$saved=0;
			$saved=$this->completed_m->save($data_array,$t_id);
			if($saved){
				$this->session->set_flashdata('message', 'Procedure Edited Successfully');
				$this->session->set_flashdata('type', 'success');			
				echo 1;
				return;
					
				}
		
		}
	}//End of funftion

public function prescription($pid=NULL){
		
	
	
	
	if($pid==NULL){
		//Show all the treatment plans available
		
		 
		$this->data['debug']=''; 	
		$this->data['page_title']='Prescription';	
		$this->data['sub_view']='prescription_home';
		
		$this->load->view('doctor_admin/layout',$this->data);
			
		}
	else{
		
		if(!valid_pid_for_completed_procedure($pid)){
			show_404(); return;
			}
		$this->load->model('patient_m');
		$p_data=$this->patient_m->get($pid);	
		$this->data['p_data']=$p_data; 	
		$this->data['pid']=$pid; 	
		$this->data['debug']=''; 	
		$this->data['page_title']='Prescription';	
		$this->data['sub_view']='prescription_home';
		
		$this->load->view('doctor_admin/layout',$this->data);
		}
	
	
	
		
		}

public function add_prescription($pid=NULL){
	if(!valid_pid_for_completed_procedure($pid)){ show_404(); return; }
	
	$this->load->model('patient_m');
	$patient_data=$this->patient_m->get($pid,true);
	
	$this->load->model('doc_m');
	$doctor_id=$this->session->userdata('id');
	$doctor_meta=$this->doc_m->get_by(array('doctor_id'=>$doctor_id),true);
	
	$this->data['doctor_meta']=$doctor_meta;	
	$this->data['patient_data']=$patient_data;	
	$this->data['page_title']='Add Prescription';	
	$this->data['sub_view']='add_prescription';	
	$this->load->view('doctor_admin/layout',$this->data);
	
	}

public function delete_drug($index=NULL){
	if($index==NULL) return;
	$index=urldecode($index);
	$this->load->model('doc_m');
	$doc_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true); 
	$drugs=(json_decode($doc_data->drug,true));
	if(isset($drugs[$index])) unset($drugs[$index]);
	$drugs=json_encode($drugs); 
	if($this->doc_m->save(array('drug'=>$drugs),$doc_data->id)){
		$this->session->set_flashdata('message', 'Successfully deleted');
		$this->session->set_flashdata('type', 'success');
		}
	redirect($_SERVER['HTTP_REFERER']);
	}

public function delete_prescription($id=NULL){
	if($id==NULL){show_404();return;} 
	$id=sql_filter($id);
	
	//Get the patient id
	$this->load->model('prescription_m');
	$data=$this->prescription_m->get($id);
	if(empty($data)) return;
	$pid=$data->patient_id;
	
	if(valid_pid_for_completed_procedure($pid)){
		
		//Delete from prescription if tp_id is available
		 
		$this->db->delete('prescription', array('id' => $id));
		$this->session->set_flashdata('message','Successfully deleted');
		$this->session->set_flashdata('type','success');
		redirect(bu('doctor/prescription/'.$pid));  
		}
	 
	else {
		$this->session->set_flashdata('message','You can not delete the plan. Either the owner doctor or the admin can delete');
		$this->session->set_flashdata('type','warning');
		redirect(r(bu('doctor/prescription/'.$pid)));  
		} 
	}

public function edit_prescription($t_id=NULL){
 
	//t_id is prescription id
	if($t_id==NULL){ 
		show_404();
		return;
		  
		}
	else{
		//Get the prescription  details
		$t_id=sql_filter($t_id);
		$this->load->model('prescription_m');
		$t_data=$this->prescription_m->get($t_id,true);
		//t_data is prescription data
		if(empty($t_data)) {show_404();return;
		}
		
		//Get the patient details
		$this->load->model('patient_m');
		$patient_data=$this->patient_m->get($t_data->patient_id,true);
		
		
		//Extract patient data 
		
		$this->load->model('doctor_m');
		$session_id=$this->session->userdata('id');
		$doctor_data=$this->doctor_m->get($t_data->doctor_id,true); 
		//404 if the plan does not belong to the doctor admin
		if(@$doctor_data->id!=$session_id){show_404(); return;}
		
		
		$this->load->model('doc_m');
		$doctor_meta=$this->doc_m->get_by(array('doctor_id'=>$t_data->doctor_id),true);
		
		
	 	$primary=sql_filter($this->session->userdata('primary'));
		
		
		 
		 		 
		 
		$this->data['t_data']		=$t_data; 
		$this->data['patient_data']	=$patient_data;
		$this->data['doctor_meta']	=$doctor_meta; 	
		$this->data['page_title']	='Edit prescription';	
		$this->data['sub_view']		='edit_prescription';
		
		$this->load->view('doctor_admin/layout',$this->data);
		
		}
	
	
	
	}
	
public function get_prescription($offset=0){
		if(isset($_POST['pid'])) {$pid=sql_filter($_POST['pid']);
		if(!valid_pid_for_completed_procedure($pid)){   show_404();return; }
		}
		
		
		$number_of_result=10;
		$offest_f=$offset*$number_of_result;
		$primary=$this->session->userdata('primary');
		if(empty($primary)){ echo '<p>Please select a clinic from top left to get the treatment plans</p>'; return;}
		$this->load->model('prescription_m');
		$this->load->model('patient_m');
		$this->load->model('doctor_m');
		$this->db->order_by('id','desc');
		if(isset($pid)){
			$t_data	=$this->db->get_where('prescription', 
			array('clinic_id'=>$primary,'patient_id'=>$pid),$number_of_result,$offest_f)->result();		
			}
		else
		$t_data	=$this->db->get_where('prescription', array('clinic_id'=>$primary),$number_of_result,$offest_f)->result();		 
		if(empty($t_data)) {
			echo '<div class="callout callout-info">
                                        <h4>No prescription found.</h4> 
                                    </div>';
			return;
			}
		
		foreach($t_data as $a=>$b):
		$p_data	=$this->patient_m->get($b->patient_id,true);
		$doctor_data=$this->doctor_m->get($b->doctor_id,true);
		?>

<h5><?php echo date('d-M-Y',strtotime($b->date));?></h5>
<div class="box box-primary tp p_parent">
	<div class="box-header">
    <div class="s-menu">
    
    <div class="btn-group np">
        <button class="btn btn-default btn-sm np printme" data-print_type="prescription" data-pid="<?=@$p_data->id?>"><i class="fa fa-wa fa-print"></i></button> 
        <button id="dLabel" class="btn btn-default btn-sm np" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-wa fa-bars"></i> </button>
          <ul class="dropdown-menu pull-right np" role="menu" aria-labelledby="dLabel">
           	<li role="presentation">
            	<a role="menuitem"  href="<?php echo bu('doctor/edit_prescription/'.$b->id)?>"><i class="fa fa-wa fa-pencil"></i> Edit</a>
            </li>
            <li role="presentation">
            	<a role="menuitem" href="<?php echo bu('doctor/delete_prescription/'.$b->id);?>">
                	<i class="fa fa-wa fa-trash-o"></i> Delete
                </a>
            </li>
            <hr />
            <li role="presentation" 
            data-toggle="modal" data-target="#email_dialog"
             class="email_me" data-print_type="treatment_plans" data-pid="<?=@$p_data->id?>">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-envelope"></i> Email</a>
            </li>
            <li role="presentation"  class="printme" data-print_type="prescription" data-pid="<?=@$p_data->id?>">
            	<a role="menuitem"  href=""><i class="fa fa-wa fa-print"></i> Print</a>
            </li>
            <li role="presentation " class="printme_dot_matrix" data-print_type="prescription" data-pid="<?=@$p_data->id?>">
            	<a role="menuitem"    href=""><i class="fa fa-wa fa-print"></i> Dot Matrix Print</a>
            </li>
            <li role="presentation" class="save_me" data-print_type="treatment_plans" data-pid="<?=@$p_data->id?>">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-print"></i> Save as PDF</a>
            </li>
            <li role="presentation">
            	<a role="menuitem"  href="<?php echo bu('doctor/printouts');?>"><i class="fa fa-wa fa-gear"></i> Print Settings</a>
            </li>
            <hr>
            <li role="presentation">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-tasks"></i> View Patient Timeline</a>
            </li>
          </ul> 
    </div>
                     
    </div> 
    	<a  class="np" href="<?php echo bu('doctor/prescription/'.$p_data->id);?>"><table class="detail_head">
        	
            	<tr class="np">
                    <td><img src="<?php echo get_dp($p_data)?>" class="sm_dp np" /></td>
                    <td>
					
					<?php echo ucfirst($p_data->name)?></td>
                    <td>
                    <?php if($p_data->gender=="M")
                    echo 'Male';
                    elseif($p_data->gender=="F")
                    echo 'Female';
                    $te=@date_diff(date_create(str_replace('/','-',$p_data->dob)), date_create('today'))->y;
                    if(isset($te) and !empty($te)) echo ','.$te.' Years';
                    ?> 
                    
                    </td>
                    <td>ID:<?php $temp=(json_decode($p_data->optional_id,true));
                    if(isset($temp[$this->session->userdata('id')])){ echo $temp[$this->session->userdata('id')];}
                    ?> </td> 
           		</tr>
           
        </table> </a>
        <hr />
        
        <table class="table table-condensed">
        	<thead>
            	<th>DRUG NAME</th>
                <th>STRENGTH</th>
                <th>DURATION</th>
                <th>Mrn - Noon - Ngt</th>
                <th>NOTE</th>
            </thead>
            <?php 
			$data=json_decode($b->json,true);
			$est_cost=0;
			foreach($data as $x=>$y):
			?>
        	<tr class="procedures ">
            	<td>
				<?php echo $y['drug_name'];?>
                </td>
                <td><?php echo $y['strength'].' '.@$y['units'];?></td>
                <td><?php echo $y['qty'].' '.@$y['duration'];?></td>
                <td>
				<span class="mms"><?php if($y['morning_dose']=='0') echo '-';else echo $y['morning_dose'];?></span>
                <span class="mms"><?php if($y['noon_dose']=='0') echo '-';else echo $y['noon_dose'];?></span>
                <span class="mms"><?php if($y['night_dose']=='0') echo '-';else echo $y['night_dose'];?></span> </td>
                <td><?php echo ucfirst(str_replace('_',' ',$y['after_before']));
				if(!empty($y['note_txt'])) echo '<br>'.@$y['note_txt'];
				echo '<br>'.@$y['cap_count'].'  Capsule(s)'; 
				?></td> 
                 
            </tr>
           <?php endforeach;?>
            
        </table>
    	
    	
    </div>
</div>
<div align="center" class="sm_btn">
	<button class="btn btn-info btn-info" onclick="append_result('<?php echo $offset+1;?>')">Show More</button>
</div>
<?php		endforeach;

		}

public function ajax_save_prescription(){
	$rule=array( 
			'doctor_id'			=>array('field'=>'doctor_id','label'=>'Doctor id','rules'=>'trim|required|xss_clean|max_length[10]'),
			'clinic_id'			=>array('field'=>'clinic_id','label'=>'Clinic id','rules'=>'trim|required|xss_clean|max_length[10]'),
			
			'patient_id'	=>array('field'=>'patient_id','label'=>'Patient id','rules'=>'trim|required|xss_clean|max_length[10]'),
			'json'			=>array('field'=>'patient_id','label'=>'Patient id','rules'=>'trim|required|xss_clean'),
			);
		$this->form_validation->set_rules($rule);
		$this->load->library('form_validation');		
		if($this->form_validation->run()==TRUE){ 
			$doctor_id			=sql_filter($this->input->post('doctor_id'));
			$clinic_id			=sql_filter($this->input->post('clinic_id'));
			$patient_id			=sql_filter($this->input->post('patient_id'));
			$json				=($this->input->post('json'));
			$json				=json_decode($json,true);
			
			$filtered_json=array();
			foreach($json as $a=>$b){ 
				$filtered_json[$a]=array();
				foreach($b as $aa=>$bb){
					$filtered_json[$a][$aa]=sql_filter($bb); 
					}
				}
			$filtered_json=array_filter($filtered_json);
			if(empty($filtered_json)) {echo 2; return;}
			$filtered_json=json_encode($filtered_json);
			 
			$this->load->model('prescription_m');
			
			$data_array=array();
			$data_array['doctor_id']	=$doctor_id;
			$data_array['clinic_id']	=$clinic_id;
			$data_array['patient_id']	=$patient_id;
			$data_array['json']			=$filtered_json;
			$saved=0;
			 
			if(isset($_POST['t_id'])){
				$t_id			=sql_filter($this->input->post('t_id'));
				$saved=$this->prescription_m->save($data_array,$t_id);
				if($saved){
				$this->session->set_flashdata('message', 'Prescription edited successfully');
				$this->session->set_flashdata('type', 'success');			
				echo 1;
				return;
				}
				}
			else $saved=$this->prescription_m->save($data_array);
			if($saved){
				$this->session->set_flashdata('message', 'Prescription added successfully');
				$this->session->set_flashdata('type', 'success');			
				echo 1;
				}
			else echo 2; 
			 
			
			}
		else {
			//echo $validation_errors();
			echo 2;
			} 
	}

public function add_drug(){
	$rule=array( 
			'name'			=>array('field'=>'name','label'=>'Name','rules'=>'trim|required|xss_clean|max_length[50]'),
			);
		$this->form_validation->set_rules($rule);
		$this->load->library('form_validation');		
		if($this->form_validation->run()==TRUE){ 
			$name		=sql_filter($this->input->post('name'));
			$strength	=sql_filter($this->input->post('strength'));
			$unit		=sql_filter($this->input->post('unit'));
			
			$name=str_replace("\\",'',$name);
			$name=str_replace("/",'',$name);
			
			$strength=str_replace("/",'',$strength);
			$strength=str_replace("\\",'',$strength);
			$strength=str_replace("'-::-",'',$strength);
			
			if(!is_numeric($strength)) return;
			$strength=abs($strength);
			
			$unit=str_replace("/",'',$unit);
			$unit=str_replace("\\",'',$unit);
			$unit=str_replace("'-::-",'',$unit);
			 
	 
			$this->load->model('doc_m');
			$doc_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true); 
			$drugs=(json_decode($doc_data->drug,true));
			if(empty($drugs)){
				echo 1;
				$drugs=array();
				$drugs[$name]=$strength.'-::-'.$unit;
				}
			else {
				echo 2;
				if(isset($drugs[$name])) {
					echo 3;
					$this->session->set_flashdata('message', 'You already have same drug in your list');
					$this->session->set_flashdata('type', 'warning');
					redirect($_SERVER['HTTP_REFERER']);
					}
				else $drugs[$name]=$strength.'-::-'.$unit;
				} 
			$drugs=json_encode($drugs); 
			if($this->doc_m->save(array('drug'=>$drugs),$doc_data->id)){
				$this->session->set_flashdata('message', 'Successfully added');
				$this->session->set_flashdata('type', 'success');
				}
			
			
			}
		else {
			$this->session->set_flashdata('message', validation_errors());
			$this->session->set_flashdata('type', 'danger');			
			}
		
		redirect($_SERVER['HTTP_REFERER']);
	
	
	}

public function completed_procedure($pid=NULL){
	
	
	
	if($pid==NULL){
		//Show all the treatment plans available
		
		 
		$this->data['debug']=''; 	
		$this->data['page_title']='Completed Procedure';	
		$this->data['sub_view']='completed_procedure_home';
		
		$this->load->view('doctor_admin/layout',$this->data);
			
		}
	else{
		
		if(!valid_pid_for_completed_procedure($pid)){
			show_404(); return;
			}
		$this->load->model('patient_m');
		$p_data=$this->patient_m->get($pid);	
		$this->data['p_data']=$p_data; 	
		$this->data['pid']=$pid; 	
		$this->data['debug']=''; 	
		$this->data['page_title']='Completed Procedure';	
		$this->data['sub_view']='completed_procedure_home';
		
		$this->load->view('doctor_admin/layout',$this->data);
		}
	
	
	}

public function get_completed_procedure($offset=0){
		if(isset($_POST['pid'])) {$pid=sql_filter($_POST['pid']);
		if(!valid_pid_for_completed_procedure($pid)){  return; }
		}
		
		
		$number_of_result=10;
		$offest_f=$offset*$number_of_result;
		$primary=$this->session->userdata('primary');
		if(empty($primary)){ echo '<p>Please select a clinic from top left to get the treatment plans</p>'; return;}
		$this->load->model('completed_m');
		$this->load->model('patient_m');
		$this->load->model('doctor_m');
		$this->db->order_by('date');
		if(isset($pid)){
			$t_data	=$this->db->get_where('completed_procedure', 
			array('clinic_id'=>$primary,'patient_id'=>$pid),$number_of_result,$offest_f)->result();		
			}
		else
		$t_data	=$this->db->get_where('completed_procedure', array('clinic_id'=>$primary),$number_of_result,$offest_f)->result();		 
		if(empty($t_data)) {
			echo '<div class="callout callout-info">
                                        <h4>No completed procedure found.</h4> 
                                    </div>';
			return;
			}
		
		foreach($t_data as $a=>$b):
		$p_data	=$this->patient_m->get($b->patient_id,true);
		$doctor_data=$this->doctor_m->get($b->doctor_id,true);
		?>

<h5><?php echo date('d-M-Y',strtotime($b->date));?></h5>
<div class="box box-primary tp p_parent">
	<div class="box-header">
    <div class="s-menu">
    
    <div class="btn-group np">
        <button class="btn btn-default btn-sm np printme" data-print_type="treatment_plans" data-pid="<?=@$p_data->id?>"><i class="fa fa-wa fa-print"></i></button> 
        <button id="dLabel" class="btn btn-default btn-sm np" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-wa fa-bars"></i> </button>
          <ul class="dropdown-menu pull-right np" role="menu" aria-labelledby="dLabel">
           	<li role="presentation">
            	<a role="menuitem"  href="<?php echo bu('doctor/edit_completed_procedure/'.$b->id)?>"><i class="fa fa-wa fa-pencil"></i> Edit</a>
            </li>
            <li role="presentation">
            	<a role="menuitem" href="<?php echo bu('doctor/delete_c_procedure/'.$b->id);?>">
                	<i class="fa fa-wa fa-trash-o"></i> Delete
                </a>
            </li>
            <hr />
            <li role="presentation" 
            data-toggle="modal" data-target="#email_dialog"
             class="email_me" data-print_type="treatment_plans" data-pid="<?=@$p_data->id?>">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-envelope"></i> Email</a>
            </li>
            <li role="presentation"  class="printme" data-print_type="treatment_plans" data-pid="<?=@$p_data->id?>">
            	<a role="menuitem"  href=""><i class="fa fa-wa fa-print"></i> Print</a>
            </li>
            <li role="presentation " class="printme_dot_matrix" data-print_type="treatment_plans" data-pid="<?=@$p_data->id?>">
            	<a role="menuitem"    href=""><i class="fa fa-wa fa-print"></i> Dot Matrix Print</a>
            </li>
            <li role="presentation" class="save_me" data-print_type="treatment_plans" data-pid="<?=@$p_data->id?>">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-print"></i> Save as PDF</a>
            </li>
            <li role="presentation">
            	<a role="menuitem"  href="<?php echo bu('doctor/printouts');?>"><i class="fa fa-wa fa-gear"></i> Print Settings</a>
            </li>
            <hr>
            <li role="presentation">
            	<a role="menuitem"   href=""><i class="fa fa-wa fa-tasks"></i> View Patient Timeline</a>
            </li>
          </ul> 
    </div>
                     
    </div> 
    	<a  class="np" href="<?php echo bu('doctor/completed_procedure/'.$p_data->id);?>"><table class="detail_head">
        	
            	<tr class="np">
                    <td><img src="<?php echo get_dp($p_data)?>" class="sm_dp np" /></td>
                    <td>
					
					<?php echo ucfirst($p_data->name)?></td>
                    <td>
                    <?php if($p_data->gender=="M")
                    echo 'Male';
                    elseif($p_data->gender=="F")
                    echo 'Female';
                    $te=@date_diff(date_create(str_replace('/','-',$p_data->dob)), date_create('today'))->y;
                    if(isset($te) and !empty($te)) echo ','.$te.' Years';
                    ?> 
                    
                    </td>
                    <td>ID:<?php $temp=(json_decode($p_data->optional_id,true));
                    if(isset($temp[$this->session->userdata('id')])){ echo $temp[$this->session->userdata('id')];}
                    ?> </td> 
           		</tr>
           
        </table> </a>
        <hr />
        
        <table class="table table-condensed">
        	<thead>
            	<th>PROCEDURE</th>
                <th>COST</th>
                <th>DISCOUNT</th>
                <th>TOTAL</th>
                <th>NOTE</th>
            </thead>
            <?php 
			$data=json_decode($b->json,true);
			$est_cost=0;
			foreach($data as $x=>$y):
			?>
        	<tr class="procedures callout <?php if( $y['completed']) echo 'callout-success'; else echo 'callout-info' ?>">
            	<td>
				<?php if($y['invoiced']==1)
					echo '<i class="fa fa-file-text" title="Invoice Created"></i>';
					else echo '<input  type="checkbox" class="checker np">';
				?>
                
                <input type="hidden" class="p_id" value="<?php echo $p_data->id?>"/>
                <input type="hidden" class="origin_id" value="<?php echo @$b->id.':'.$x;?>" />
				<span class="pro_name"><?php echo $y['treatment_plan_name'];?></span></td>
                <td><i class="fa fa-wa fa-inr"></i><span class="price"><?php echo $y['qty']*$y['price'];?></span></td>
                <td></i> <i class="fa fa-wa fa-inr"></i>
				<span class="discount"><?php echo (($y['qty']*$y['price'])-$y['total_price'])?> </span>
                (
                <?php 
				if($y['qty']*$y['price']>0)
				echo 100-(($y['total_price']*100)/($y['qty']*$y['price'])); ?>
                %)</td>
                <td><i class="fa fa-wa fa-inr"><?php echo $y['total_price']; $est_cost+=$y['total_price'];?></td>
                <td class="hid_text" title="<?php echo @$y['vig']; ?>">
                <?php if(!empty($y['note_txt'])) echo '<span class="note">'.$y['note_txt'].'</span><hr>';
				echo '<span class="vig">'.@$y['vig'].'</span>'; ?>
                
                </td>
            </tr>
           <?php endforeach;?>
            
        </table>
    	<table class="table table-condensed">
        	<tfoot>
            	<tr>
                	<th>Completed by <strong><?php echo $doctor_data->name; ?></strong></th>
                    <th><strong>Estimated amount:<i class="fa fa-wa fa-inr"> <?php echo $est_cost;?>	</strong></th>
                </tr>
            </tfoot>
        </table>
    	
    </div>
</div>
<div align="center" class="sm_btn">
	<button class="btn btn-info btn-info" onclick="append_result('<?php echo $offset+1;?>')">Show More</button>
</div>
<?php		endforeach;

		}


public function edit_completed_procedure($t_id=NULL){
 
	
	if($t_id==NULL){ 
		show_404();
		return;
		 
			
		}
	else{
		//Get the treatment plan details
		$t_id=sql_filter($t_id);
		$this->load->model('completed_m');
		$t_data=$this->completed_m->get($t_id,true);
		
		if(empty($t_data)) {show_404();return;
		}
		
		//Get the patient details
		$this->load->model('patient_m');
		$patient_data=$this->patient_m->get($t_data->patient_id,true);
		
		
		//Extract patient data 
		
		$this->load->model('doctor_m');
		$session_id=$this->session->userdata('id');
		$doctor_data=$this->doctor_m->get($t_data->doctor_id,true); 
		//404 if the plan does not belong to the doctor admin
		if($doctor_data->id!=$session_id){show_404(); return;}
		
		
		$this->load->model('doc_m');
		$doc_data=$this->doc_m->get_by(array('doctor_id'=>$t_data->doctor_id),true);
		
		
	 	$primary=sql_filter($this->session->userdata('primary'));
		
		$sql="SELECT speciality,treatment_plans,id FROM clinic WHERE id=$primary";
		$clinic_data=$this->db->query($sql)->result();
		@$clinic_data=$clinic_data[0];
		$speciality=$clinic_data->speciality;
		
		$this->load->model('sbs_m');
		$sbs_data=$this->sbs_m->get_by(array('speciality'=>$speciality),true);
		 
		
		$this->data['clinic_data']	=$clinic_data;
		$this->data['t_data']		=$t_data;
		$this->data['sbs_data']		=$sbs_data;
		$this->data['patient_data']	=$patient_data;
		$this->data['doc_data']		=$doc_data; 	
		$this->data['page_title']	='Completed Procedure';	
		$this->data['sub_view']		='completed_procedure_edit';
		
		$this->load->view('doctor_admin/layout',$this->data);
		
		}
	
	
	
	}
public function add_completed_procedure($pid=NULL){
	
	if($pid==NULL){
		//Show all the treatment plans available
		
		 
		$this->data['debug']=''; 	
		$this->data['page_title']='Treatment Plans';	
		$this->data['sub_view']='treatment_plan_home';
		
		$this->load->view('doctor_admin/layout',$this->data);
			
		}
	else{
		filter_pid($pid);
		
		
		//Extract patient data
		$this->load->model('patient_m');
		$patient_data=$this->patient_m->get($pid,true);
		$this->load->model('doc_m');
		$doc_data=$this->doc_m->get_by(array('doctor_id'=>$this->session->userdata('id')),true);
		
	 	$primary=sql_filter($this->session->userdata('primary'));
		
		$sql="SELECT speciality,treatment_plans,id FROM clinic WHERE id=$primary";
		$clinic_data=$this->db->query($sql)->result();
		@$clinic_data=$clinic_data[0];
		$speciality=$clinic_data->speciality;
		
		$this->load->model('sbs_m');
		$sbs_data=$this->sbs_m->get_by(array('speciality'=>$speciality),true);
		
		$this->data['clinic_data']	=$clinic_data;
		$this->data['sbs_data']		=$sbs_data;
		$this->data['patient_data']	=$patient_data;
		$this->data['doc_data']		=$doc_data; 	
		$this->data['page_title']	='Treatment Plans';	
		$this->data['sub_view']		='completed_prodedure_add';
		
		$this->load->view('doctor_admin/layout',$this->data);
		
		}
	
	
	}

public function ajax_save_completed_procedure($inv=0){
	
	$rule=array( 
			'doctor_id'			=>array('field'=>'doctor_id','label'=>'Doctor id','rules'=>'trim|required|xss_clean|max_length[10]'),
			'clinic_id'			=>array('field'=>'clinic_id','label'=>'Clinic id','rules'=>'trim|required|xss_clean|max_length[10]'),
			
			'patient_id'	=>array('field'=>'patient_id','label'=>'Patient id','rules'=>'trim|required|xss_clean|max_length[10]'),
			'json'			=>array('field'=>'patient_id','label'=>'Patient id','rules'=>'trim|required|xss_clean'),
			'treatment_ids'			=>array('field'=>'treatment_ids','label'=>'treatment ids','rules'=>'trim|required|xss_clean'),
			);
			
		$this->form_validation->set_rules($rule);
		$this->load->library('form_validation');		
		if($this->form_validation->run()==TRUE){ 
		
			$doctor_id			=sql_filter($this->input->post('doctor_id'));
			$clinic_id			=sql_filter($this->input->post('clinic_id'));
			$patient_id			=sql_filter($this->input->post('patient_id'));
			$treatment_ids		=sql_filter($this->input->post('treatment_ids'));
			$json				=($this->input->post('json'));
			$json				=json_decode($json,true);
			 
			//Make completed =1 in treatment plans by $treatment_ids and its indexes-
			$this->load->model('treat_m');
			$ids=explode('-::-',$treatment_ids);
			foreach($ids as $a=>$b){
				$temp=explode(':',$b);
				$id=$temp[0];
				$index=$temp[1];
				$data=$this->treat_m->get($id,true);
				$json_p=json_decode($data->json,true);
				$json_p[$index]['completed']=1;
				$json_p=json_encode($json_p);
				$this->treat_m->save(array('json'=>$json_p),$id);
				} 
				
			$filtered_json=array();
			
			foreach($json as $a=>$b){ 
				$filtered_json[$a]=array();
				foreach($b as $aa=>$bb){
					$filtered_json[$a][$aa]=sql_filter($bb); 
					}
				}
			$filtered_json=array_filter($filtered_json);
			if(empty($filtered_json)) {echo 2; return;}
			$filtered_json=json_encode($filtered_json);
			 
			$this->load->model('completed_m');
			$date=date('d-M-Y');
			$data=$this->completed_m->get_by(array('patient_id'=>$patient_id,'clinic_id'=>$clinic_id,'date'=>$date),true);
			
			
			
			$returned_inv_ids=array();
			//Check if a record exists with patient id,clinic id and date
			//If found then edit the json 
			
			if(!empty($data)){ 
				$c_id=$data->id;
				$pre_json=$data->json;
				$pre_json=json_decode($pre_json,true);
				$sub_json=json_decode($filtered_json,true);
				$all_json=json_encode(array_merge($pre_json,$sub_json));
				$data_array['json']			=$all_json;
				$saved=$this->completed_m->save($data_array,$c_id);
				if($saved){
					//Save invoice if inv=1
					$this->session->set_flashdata('message', 'Treatment plan completed successfully');
					$this->session->set_flashdata('type', 'success');		
					
					if($inv) {
						$returned_inv_ids=$this->single_invoice_selected($doctor_id,$clinic_id,$patient_id,$filtered_json);
						echo implode('-::-',$returned_inv_ids);
						return;
						}
						
					return;
					} 
				}
			
			//else save as it is
			else{
				$data_array=array();
				$data_array['doctor_id']	=$doctor_id;
				$data_array['clinic_id']	=$clinic_id;
				$data_array['patient_id']	=$patient_id;
				$data_array['json']			=$filtered_json;
				$data_array['date']			=$date;
				$saved=0;
				$saved=$this->completed_m->save($data_array);
				if($saved){
					//Save invoice if inv=1
					$this->session->set_flashdata('message', 'Treatment plan completed successfully');
					$this->session->set_flashdata('type', 'success');		
					if($inv) {
						$returned_inv_ids=$this->single_invoice_selected($doctor_id,$clinic_id,$patient_id,$filtered_json);
						echo implode('-::-',$returned_inv_ids);
						return;
						}
						
					echo 1;
					return;
					} 
				}
		
		}
	}//End of funftion

public function prepare_invoice_ids(){ 
	$json		=($this->input->post('json'));
	if(empty($json)) return;
	$json		=json_decode($json,true);
	$jstring	=implode('-::-',$json);
	$this->load->library('session');
	
	$newdata = array( 'inv_id_list'  => $jstring );
	$this->session->set_userdata($newdata);  
	echo 1; 
	}

function handle_post_redirect($pid=NULL){
	if(!valid_pid_for_completed_procedure($pid)){ show_404();return; }
	$data		=($this->input->post('data'));
	 
	$this->load->library('session');
	
	$newdata = array( 'inv_id_list'  => $data );
	$this->session->set_userdata($newdata);  
	redirect(bu('doctor/add_payment/'.$pid));
	}

function single_invoice_selected($doctor_id,$clinic_id,$patient_id,$filtered_json){ 
	$doctor_id		=sql_filter($doctor_id);
	$clinic_id		=sql_filter($clinic_id);
	$patient_id		=sql_filter($patient_id);
	$returned_inv_ids	=array();
	if(!valid_pid_for_completed_procedure($patient_id)){ show_404();return;}
	
	$json=json_decode($filtered_json,true); 
	$this->load->model('invoice_m');
	
	 
	foreach($json as $a=>$b){
		$temp_array=array();
		$temp_array['procedure_name']	=$b['treatment_plan_name'];
		$temp_array['doctor_id']		=$doctor_id;
		$temp_array['clinic_id']		=$clinic_id;
		$temp_array['patient_id']		=$patient_id;
		
		if($b['speciality']=='Dentist') $temp_array['json']='{"note":"'.$b['note_txt'].'","teeth":"'.$b['vig'].'"}';
		else $temp_array['json']='{"note":"'.$b['note_txt'].'"}';
		
		$temp_array['date']			=date('d-m-y');
		$total_price					=$b['price']*$b['qty'];
		$temp_array['price']			=$total_price;
		$temp_array['price_per_unit']	=$b['price'];
		$temp_array['qty']				=$b['qty']; 
		
		$discount=0;
		if($b['inr_or_per']=='inr') 	$discount=($b['discount']);
		else $discount=$total_price*$b['discount']*.01;  
		$temp_array['discount']			=$discount;
		$temp_array['tax']				=0;
		$temp_array['paid']				=0; 
		
		$invoice_id= $this->invoice_m->save(  $temp_array); 
		$returned_inv_ids[]=$invoice_id;
		
		$amount=$total_price-$discount;
		
		$this->update_balence($patient_id,$amount,$update_json=0,$operation='sub',$towards=$b['treatment_plan_name'],'Auto generated',$invoice_id);
		}
		return $returned_inv_ids;
	
	}

function invoice_selected(){
	$rules	=array( 'json'	=>array('field'=>'json','label'=>'Json','rules'=>'trim|required|xss_clean')  );
					
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run()==TRUE){
			$json		=($this->input->post('json'));
			$json		=json_decode($json,true);
			
			
			
			$filtered_json=array();
			foreach($json as $a=>$b){ 
				$filtered_json[$a]=array();
				foreach($b as $aa=>$bb){
					$filtered_json[$a][$aa]=sql_filter($bb); 
					}
				}
			$filtered_json=array_filter($filtered_json);
			
			$this->load->model('completed_m');
			$this->load->model('invoice_m');
			$saved=0;
			$p_id=NULL;
			$amount=0;
			$pros	=array();
			$invoice_id=NULL;
			foreach($filtered_json as $a=>$b){
				//1st step
				//Make the invoiced flag=1 in the origin(completed procedure)
				$origin=explode(':',$b['origin_id']);
				$origin_id		=@$origin[0];
				$origin_index	=@$origin[1];
				$data=$this->completed_m->get($origin_id,true);
				$pre_json=json_decode($data->json,true);
				$pre_json[$origin_index]['invoiced']=1;
				$pre_json=json_encode($pre_json);
				$this->completed_m->save(array('json'=>$pre_json),$origin_id);
				
				//2nd Step 
				//Save the data in invoice
				$data		=array();
				$date		=date('d-m-y');
				$data['procedure_name']	=@$b['pro_name'];
				$pros[]				=@$b['pro_name'];
				$data['price']		=@$b['price'];
				$data['discount']	=@$b['discount'];	
				$amount				+=($data['price']-$data['discount']);
				
				$data['patient_id']	=@$b['p_id'];
				$p_id				=@$b['p_id'];
				$data['date']		=$date; 
				$data['doctor_id']	=$this->session->userdata('id');
				$data['clinic_id']	=$this->session->userdata('primary');
				
				$note_json=array();
				$note_json['note']	=@$b['note'];
				$note_json['teeth']	=@$b['vig'];
				
				$note_json=json_encode($note_json); 
				$data['json']		=$note_json;  
				if($invoice_id=$this->invoice_m->save($data)){ $saved+=1; }
				
			
				}
			
			if($saved){
				$this->update_balence($p_id,$amount,$update_json=0,$operation='sub',$towards=implode(',',$pros),'Auto generated',$invoice_id); 
				$this->session->set_flashdata('message','Invoiced Successfully');
				$this->session->set_flashdata('type','success');
				echo 1;
				}
			
		}  
	}

public function update_balence($pid=NULL,$amount=0,$update_json=1,$operation='sub',$towards='',$note='',$invoice='',$mode='cash',$date=NULL,$recept_no=NULL){
	//pid is the patient id
	//amount is the amount that is to add or substract from/to the balence
	//update_json is the flag,if true then it will not update the json
	//operation (value:sub/add) to substruct or add the amount to the balence
	//towards is optional json option 
	//Note is optional json option
	//invoice is optional invoice id the payment is releted to
	//Mode is optional json option which denotes the mode of payment
	if($recept_no==NULL){$unique=uniqid (); $recept_no=strtoupper( substr($unique,-5));}
 
	if($pid==NULL) { show_404(); return; }
	if(!valid_pid_for_completed_procedure($pid)){ show_404(); return; }
	
	$this->load->model('payment_m');
	$clinic_id	=$this->session->userdata('primary');
	
	$data=$this->payment_m->get_by(array('patient_id'=>$pid,'clinic_id'=>$clinic_id),true);
	
	if($date==NULL) $date=date('d-m-y');
	else{  $date=date('d-m-y',strtotime (str_replace('/','-',$date)));}
	
	
	if(empty($data)){
		// Add a new record
		$dat=array();
		$dat['json']		='';
		$dat['patient_id']	=$pid;
		$dat['clinic_id']	=$clinic_id; 
		$record_id			=$this->payment_m->save($dat);
		$data				=$this->payment_m->get($record_id,true);
		}
	else{$record_id=$data->id;}
	$dat=array();
	switch($operation){
		case('add'): $new_balence=$data->balence+$amount;$amount_dummy='+'.$amount;
		break;
		case('sub'): $new_balence=$data->balence-$amount;$amount_dummy='-'.$amount;
		break;
		} 
	 
	$dat['balence']		=$new_balence;
	
	//Edit the json
	$json=json_decode($data->json,true);
	if(isset($json[$date])) $temp_array=$json[$date];
	else $temp_array=array();
	
	$temp_array[]=array(
		'invoice'	=>sql_filter($invoice),
		'timestamp'	=>time(),
		'towards'	=>sql_filter($towards),
		'note'		=>sql_filter($note),
		'amount'	=>sql_filter($amount_dummy),
		'balence'	=>sql_filter($new_balence),
		'mode'		=>sql_filter($mode), 
		'recept_no'	=>sql_filter($recept_no), 
		'flag'		=>'', 
		);
	$json[$date]=$temp_array;
	
	if($update_json) $dat['json']=json_encode($json); 
	$dat['last_payment_date']=date('d-m-y'); 
	return $this->payment_m->save($dat,$record_id); 

	}

public function invoice($pid=NULL){
	 
	if($pid==NULL){
		//Show all the Invoice available
		
		 
		$this->data['debug']=''; 	
		$this->data['page_title']='Invoice';	
		$this->data['sub_view']='invoice_home';
		
		$this->load->view('doctor_admin/layout',$this->data);
			
		}
	else{
		
		if(!valid_pid_for_completed_procedure($pid)){
			show_404(); return;
			}
		$this->load->model('patient_m');
		$p_data=$this->patient_m->get($pid);	
		$this->data['p_data']=$p_data; 	
		$this->data['pid']=$pid; 	
		$this->data['debug']=''; 	
		$this->data['page_title']='Invoice';	
		$this->data['sub_view']='invoice_home';
		
		$this->load->view('doctor_admin/layout',$this->data);
		} 
	}





public function get_invoice($offset=0){
		if(isset($_POST['pid'])) {$pid=sql_filter($_POST['pid']);
		if(!valid_pid_for_completed_procedure($pid)){  return; }
		}
		
		
		$number_of_result=10;
		$offest_f=$offset*$number_of_result;
		$primary=$this->session->userdata('primary');
		if(empty($primary)){ echo '<p>Please select a clinic from top left to get the treatment plans</p>'; return;}
		$this->load->model('invoice_m');
		$this->load->model('patient_m');
		$this->load->model('doctor_m');
		$this->db->order_by("id", "desc"); 
		if(isset($pid)){
			$t_data	=$this->db->get_where('invoice', 
			array('clinic_id'=>$primary,'patient_id'=>$pid),$number_of_result,$offest_f)->result();		
			
			 
			}
		else{ 
			$t_data	=$this->db->get_where('invoice', array('clinic_id'=>$primary),$number_of_result,$offest_f)->result();
			 
			}
		
				 
		if(empty($t_data)) {
			echo '<div class="callout callout-info">
                                        <h4>No Invoice found.</h4> 
                                    </div>';
			return;
			}
			 
		$tmp = array();

		foreach($t_data as $arg)
		{
			$tmp[$arg->date][$arg->patient_id][] = array(
				'id'				=>$arg->id,
				'procedure_name'	=>$arg->procedure_name,
				'doctor_id'			=>$arg->doctor_id,
				'clinic_id'			=>$arg->clinic_id,
				'patient_id'		=>$arg->patient_id,
				'json'				=>$arg->json,
				'date'				=>$arg->date,
				'price'				=>$arg->price,
				'price_per_unit'	=>$arg->price_per_unit,
				'qty'				=>$arg->qty,
				'discount'			=>$arg->discount,
				'tax'				=>$arg->tax,
				'paid'				=>$arg->paid
				);
		}
		
		 
		
		$t_data=$tmp;
		
	 
		
		foreach($t_data as $date=>$p_id):  
		echo "<strong>$date</strong>";
			foreach($p_id as $index=>$invoice_data):  
			
				$p_data		=$this->patient_m->get($index,true);?>
              <div class="box box-primary tp">
	<div class="box-header p_parent">
    <div class="s-menu">
    
       
                     
    </div> 
    	<a class="np" href="<?php echo bu('doctor/invoice/'.$p_data->id);?>"><table class="detail_head">
        	
            	<tr class="np">
                    <td><img src="<?php echo get_dp($p_data)?>" class="sm_dp" /></td>
                    <td>
					
					<?php echo ucfirst($p_data->name)?></td>
                    <td>
                    <?php if($p_data->gender=="M")
                    echo 'Male';
                    elseif($p_data->gender=="F")
                    echo 'Female';
                    $te=@date_diff(date_create(str_replace('/','-',$p_data->dob)), date_create('today'))->y;
                    if(isset($te) and !empty($te)) echo ','.$te.' Years';
                    ?> 
                    
                    </td>
                    <td>ID:<?php $temp=(json_decode($p_data->optional_id,true));
                    if(isset($temp[$this->session->userdata('id')])){ echo $temp[$this->session->userdata('id')];}
                    ?> </td> 
                    <td>
                    <button class="btn btn-flat btn-sm pull-right btn-success np printme" data-print_type="invoice" 
                    data-pid="<?php echo $p_data->id?>">
                    <i class="fa fa-print"></i></button></td>
           		</tr>
           
        </table> </a>
        <hr />
       
        	<?php foreach($invoice_data as $a=>$b):  
			
					  	$doctor_data=$this->doctor_m->get($b['doctor_id'],true);?>
                        <div class=" tp p_parent">
                         <table class="table table-condensed inv_t">
                            <thead >
                            <tr >
                             	<th>INVOICE_NUMBER</th>
                                <th>PRODUCTS/SERVICES</th>
                                <th>UNIT_COST </th>
                                <th>QTY </th>
                                <th>DISCOUNT </th> 
                                <th>TOTAL</th> 
                                <th class="np"></th> 
                            </tr>
                               
                            </thead>
                        
                        <tbody>
						<tr>
                        	<td class="mega_p" data-inv_id="<?=@$b['id'];?>">
                            <input class="checker np" type="checkbox"   
                            <?php 
							if(@$b['paid']<(@$b['price']+@$b['tax']-@$b['discount'])) echo ' value="'.@$b['id'].'"';
							else echo 'disabled="disabled"';
							?>
                            />
                            <a class="np" href="<?=bu('doctor/invoice/'.@$p_data->id);?>"><?=@$b['id'];?></a>
                            <span class="sp"><?=@$b['id'];?></span>
                            <p class="np">Status:
                            <?php if(@$b['paid']<(@$b['price']+@$b['tax']-@$b['discount'])) 
							echo '<small class="badge  bg-red" >Open</small>';
							else echo '<small class="badge  bg-green" >Closed</small>';
							?>
                            
                            </p>
                            <div class="col-xs-6">
                            	<p>Total:</p><?=@$b['price']+@$b['tax']-@$b['discount']; ?>
                            </div>
                            <div class="col-xs-6">
                            	<p>Paid:</p><?=@$b['paid'] ?> 
                            </div>
                            
                            </td>
                            
                        	<td><?=@$b['procedure_name'];?>
                            <hr class="np" />
                            <br class="sp" />
                            <?php
							$note_json=json_decode(@$b['json'],true); 
							if(!empty($note_json)){
								foreach($note_json as $as=>$bs){
									if(!empty($bs)) echo ucfirst($as).':'.ucfirst($bs).'<br>';
									  
									}
								}
							?>
                            Completed By:Dr. <strong><?= @$doctor_data->name;?></strong>
                            </td>
                            <td><?=@$b['price_per_unit'];?> <i class="fa fa-inr"></i><span class="spt">(INR)</span></td>
                            <td><?=@$b['qty'];?> </td>
                            <td><?=@$b['discount'];?> <i class="fa fa-inr"></i><span class="spt">(INR)</span></td>
                            <td><?=@$b['price']+@$b['tax']-@$b['discount'];?> <i class="fa fa-inr"></i><span class="spt">(INR)</span></td>
                            <td class="np">
                             <div class="btn-group bokka np">
            <button class="btn btn-default btn-sm np printme" data-print_type="invoice" data-pid="<?=@$p_data->id; ?>"><i class="fa fa-wa fa-print"></i></button> 
            <button id="dLabel" class="btn btn-default btn-sm np" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-wa fa-bars"></i> </button>
             <ul class="dropdown-menu pull-right np" role="menu" aria-labelledby="dLabel">
              <li role="presentation">	
			 <?php if(@$b['paid']<@$b['price']):?>
                 <form method="post" action="<?php echo bu('doctor/set_userdata/');?>" class="">
                            <input type="hidden" name="redirect_url" 
                            value="<?php echo bu('doctor/add_payment/'.@$p_data->id);?> "/>
                            <input type="hidden" name="var_name" value="inv_id" />
                            <input type="hidden" name="data" value="<?=@$b['id']?>" />
                            
                        </form> 
                        <a href="" onclick="event.preventDefault();$(this).prev().submit()"  role="menuitem"><i class="fa fa-wa fa-money"></i> Pay</a>
			 
             <?php else :?>
             		 <form method="post" action="<?php echo bu('doctor/set_userdata/');?>">
                    	<input type="hidden" name="redirect_url" 
                        value="<?php echo bu('doctor/refund_invoice/'.@$p_data->id);?> "/>
                        <input type="hidden" name="var_name" value="inv_id" />
                    	<input type="hidden" name="data" value="<?=@$b['id']?>" />
                        
                    </form> 
                    <a href="" onclick="event.preventDefault();$(this).prev().submit()"  role="menuitem"><i class="fa fa-wa fa-money"></i> Refund</a>
             <?php endif;?>
                   
                </li> 
                <hr /> 
                <li role="presentation" onclick="return(confirm(\"Are you sure?\"))">
                    <a role="menuitem" href="<?php echo bu('doctor/delete_invoice/'.@$b['id'].'/'.@$p_data->id);?>">
                        <i class="fa fa-wa fa-trash-o"></i> Delete
                    </a>
                </li>
                <hr />
                <li role="presentation">
                    <a role="menuitem"   href=""><i class="fa fa-wa fa-envelope"></i> Email</a>
                </li>
                <li role="presentation" class="printme" data-print_type="invoice" data-pid="<?=@$p_data->id; ?>">
                    <a role="menuitem"   href=""><i class="fa fa-wa fa-print"></i> Print</a>
                </li>
                <li role="presentation" class="printme_dot_matrix" data-print_type="invoice" data-pid="<?=@$p_data->id; ?>">
                    <a role="menuitem"   href=""><i class="fa fa-wa fa-print"></i> Dot Matrix Print</a>
                </li>
                <li role="presentation"  class="save_me" data-print_type="invoice" data-pid="47">
                    <a role="menuitem"   href=""><i class="fa fa-wa fa-save"></i> Save as PDF</a>
                </li>
                <li role="presentation">
                    <a role="menuitem"  href="<?php echo bu('doctor/printouts');?>"><i class="fa fa-wa fa-gear"></i> Print Settings</a>
                </li>
                <hr>
                <li role="presentation">
                    <a role="menuitem"   href=""><i class="fa fa-wa fa-tasks"></i> View Patient Timeline</a>
                </li>
              </ul>  
        </div>
                            
                            </td>
                        
                        </tr>
			</tbody>
        </table>
		</div>
				<?php endforeach;?>
        
	</div>
</div>
<div align="center" class="sm_btn">
	<button class="btn btn-info btn-info" onclick="append_result('<?php echo $offset+1;?>')">Show More</button>
</div>
			
<?php
			endforeach;
		endforeach;

		}
		

function payment($pid=NULL){ 
	if($pid==NULL){
		//Show all the Invoice available
		
		 
		$this->data['debug']=''; 	
		$this->data['page_title']='Payments';	
		$this->data['sub_view']='payment_home';
		
		$this->load->view('doctor_admin/layout',$this->data);
			
		}
	else{ 
		if(!valid_pid_for_completed_procedure($pid)){
			show_404(); return;
			}
		$this->load->model('patient_m');
		$p_data=$this->patient_m->get($pid);	
		$this->data['p_data']=$p_data; 	
		$this->data['pid']=$pid; 	
		$this->data['debug']=''; 	
		$this->data['page_title']='Payments';	
		$this->data['sub_view']='payment_home';
		
		$this->load->view('doctor_admin/layout',$this->data);
		} 
	
	}
public function get_payment($offset=0){
		if(isset($_POST['pid'])) {$pid=sql_filter($_POST['pid']);
		if(!valid_pid_for_completed_procedure($pid)){  return; }
		} 
		
		$number_of_result=10;
		$offest_f=$offset*$number_of_result;
		$primary=$this->session->userdata('primary');
		if(empty($primary)){ echo '<p>Please select a clinic from top left to get the treatment plans</p>'; return;}
		$this->load->model('payment_m');
		$this->load->model('patient_m');
		$this->load->model('doctor_m'); 
		if(isset($pid)){
			$this->db->order_by(("last_payment_date")); 
			$t_data	=$this->db->get_where('payment', 
			array('clinic_id'=>$primary,'patient_id'=>$pid),$number_of_result,$offest_f)->result();		
			
			 
			}
		else{
			$this->db->order_by(("last_payment_date")); 
			$t_data	=$this->db->get_where('payment', array('clinic_id'=>$primary),$number_of_result,$offest_f)->result();
			 
			}
		
				
		
		if(empty($t_data)) {
			echo '<div class="callout callout-info"> <h4>No Payment found.</h4>  </div>';
			return;
			}
			 
		$tmp = array();

		foreach($t_data as $arg)
		{ 
			$tmp[$arg->last_payment_date][$arg->patient_id] = array(
				'id'				=>$arg->id,
				'clinic_id'			=>@$arg->clinic_id, 
				'patient_id'		=>@$arg->patient_id,
				'json'				=>@$arg->json,
				'balence'			=>@$arg->balence,
				'last_payment_date'	=>@$arg->last_payment_date,
				 
				);
		}
		 
		 
		
		$t_data=$tmp; 
		foreach($t_data as $date=>$datta):  
		if(!isset($pid))
		echo "<strong>$date</strong>";
			foreach($datta as $p_id=>$payment_data):   
				$p_data		=$this->patient_m->get($p_id,true);?>
              <div class="box box-primary tp" style="height:68px">
	<div class="box-header">
    <div class="s-menu">
    
       <button  class="btn btn-flat btn-success btn-sm print_payment_history" data-print_type="recept" data-pid="<?php echo $p_data->id?>" ><i class="fa fa-print"></i></button>
                     
    </div> 
    	<a href="<?php echo bu('doctor/payment/'.$p_data->id);?>"><table class="detail_head">
        	
            	<tr>
                    <td><img src="<?php echo get_dp($p_data)?>" class="sm_dp" /></td>
                    <td>
					
					<?php echo ucfirst($p_data->name)?></td>
                    <td>
                    <?php if($p_data->gender=="M")
                    echo 'Male';
                    elseif($p_data->gender=="F")
                    echo 'Female';
                    $te=@date_diff(date_create(str_replace('/','-',$p_data->dob)), date_create('today'))->y;
                    if(isset($te) and !empty($te)) echo ','.$te.' Years';
                    ?> 
                    
                    </td>
                    <td>ID:<?php $temp=(json_decode($p_data->optional_id,true));
                    if(isset($temp[$this->session->userdata('id')])){ echo $temp[$this->session->userdata('id')];}
                    ?> </td> 
           		</tr>
           
        </table> </a>
        <hr />
       <table >
                        <thead > 
                            <th>RECEPT #</th>
                            <th>PAID</th>
                            <th>INVOICE</th>
                            <th>TOWARDS</th>
                            <th>MODE</th> 
                            <th>NOTE</th> 
                            <th>TIME</th>
                            <th></th>
                        </thead>
                    
                    <tbody></tbody>
                    </table>
        	<?php    
				$pay_json=json_decode(@$payment_data['json'],true);   
					if(sizeof($pay_json)):
					foreach($pay_json as $date_issued=>$main_json): 
						foreach($main_json as $aa=>$bb):  ?>
                    <?php if(@$bb[0]['amount']>0 or 1):?>
                    <div class="box box-primary tp p_parent">
                    <table >
                        <thead  class="spt"> 
                            <th>RECEPT #</th>
                            <th>PAID</th>
                            <th>INVOICE</th>
                            <th>TOWARDS</th>
                            <th>MODE</th> 
                            <th>NOTE</th> 
                            <th>TIME</th>
                            <th></th>
                        </thead>
                    
                    <tbody>
                    <tr> 
                    	<td ><?=(@$bb['recept_no']);?></td>
                    	<td >
                        <?php if(@$bb['amount']>0)echo '<i class="fa fa-fw fa-chevron-circle-down bg-green"></i>';
						else echo '<i class="fa fa-fw fa-chevron-circle-up bg-red"></i>';?>
                        <i class="fa fa-inr"></i><?=abs(@$bb['amount']);?>
                        
                        </td>
                    	<td>
                        <a href="<?=bu('doctor/invoice/'.$p_data->id);?>" class="np"><?=@$bb['invoice'];?></a>
                        <span class="sp"><?=@$bb['invoice'];?></span>
                        </td>	
                        
                        <td  style="max-width: 30px;"><?=@$bb['towards'];?></td>
                        <td><?=ucfirst(@$bb['mode']);?></td>
                        <td style="max-width: 100px;"><?=@$bb['note'];?></td>
                        <td><?=$date_issued.' '.date('h:ia',@$bb['timestamp']);?></td>
                        <td><div class="btn-group bokka">
            <button class="btn btn-default btn-sm printme np" data-print_type="recept" data-pid="<?=$p_data->id;?>"><i class="fa fa-wa fa-print"></i></button> 
            <button id="dLabel" class="btn btn-default btn-sm np" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-wa fa-bars"></i> </button>
             <ul class="dropdown-menu pull-right np" role="menu" aria-labelledby="dLabel">
               
                 
                <li role="presentation" onclick="return(confirm(\"Are you sure?\"))">
                    <a role="menuitem" href="<?php echo bu('doctor/delete_paymemnt/'.$aa.'/'.@$p_data->id.'/'.$date_issued);?>">
                        <i class="fa fa-wa fa-trash-o"></i> Delete
                    </a>
                </li>
                <hr />
                <li role="presentation">
                    <a role="menuitem"   href=""><i class="fa fa-wa fa-envelope"></i> Email</a>
                </li>
                <li role="presentation" class="printme" data-print_type="recept" data-pid="<?=$p_data->id;?>">
                    <a role="menuitem"  href=""><i class="fa fa-wa fa-print"></i> Print</a>
                </li>
                <li role="presentation" class="printme_dot_matrix" data-print_type="recept" data-pid="<?=$p_data->id;?>">
                    <a role="menuitem"   href=""><i class="fa fa-wa fa-print"></i> Dot Matrix Print</a>
                </li>
                <li role="presentation" class="save_me" data-print_type="recept" data-pid="<?=$p_data->id;?>">
                    <a role="menuitem"   href=""><i class="fa fa-wa fa-save"></i> Save as PDF</a>
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
                    </table >
                    </div>
                    <?php endif;?>
						
				 
					<?php endforeach;?>
				<?php endforeach;?>
                <?php 
				else:?>
                <div class="callout callout-info"> <h4>No Payment found.</h4>  </div>
				<?php endif;?>
       
	
</div>
<div align="center" class="sm_btn">
	<button class="btn btn-info btn-info" onclick="append_result('<?php echo $offset+1;?>')">Show More</button>
</div>
			
<?php
			endforeach;
		endforeach;

		}


public function add_payment($pid=NULL){
	if($pid==NULL) {show_404();return;}
	$pid=sql_filter($pid);
	if(!valid_pid_for_completed_procedure($pid)) {show_404();return;}
	$this->load->model('patient_m');
	$this->load->model('invoice_m');
	$this->load->model('clinic_m'); 
	 
	$p_data=$this->patient_m->get($pid);
	$clinic_data=$this->clinic_m->get($this->session->userdata('primary')); 
	$primary=$this->session->userdata('primary');
	$sql="SELECT * FROM invoice WHERE (clinic_id=$primary AND patient_id=$pid) AND `price`>`paid`";
	$invoice_data=$this->db->query($sql)->result();  
									 
	$this->data['patient_data']		=$p_data;
	$this->data['clinic_data']		=$clinic_data; 
	$this->data['invoice_data']		=$invoice_data; 	
	$this->data['page_title']		='Add payment';	
	$this->data['sub_view']			='add_payment';
	  
	$this->load->view('doctor_admin/layout',$this->data);
	}

public function ajax_add_advance($pid=NULL){
		$rules=array(  
			'patient_id'		=>array('field'=>'patient_id','label'=>'patient  id','rules'=>'trim|required|xss_clean|max_length[100]|numeric'), 
			'json'		=>array('field'=>'json','label'=>'json ','rules'=>'trim|required|xss_clean'),
			);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){ 
			$patient_id			=sql_filter($this->input->post('patient_id')); 
			$json				=($this->input->post('json')); 
			$json				=json_decode($json,true);
			
			$filtered_json=array();
			foreach($json as $a=>$b){  $filtered_json[sql_filter($a)]=sql_filter($b);  }
			if(@$filtered_json['amount']==0) {echo 2; return;}
			if($this->update_balence($pid=$patient_id	,$amount=@$filtered_json['amount'],$update_json=1,$operation='add',$towards='Advance',$note=@$filtered_json['note'],$invoice='',$mode=@$filtered_json['mode'],$date=@$filtered_json['date'],$recept_no=@$filtered_json['recept_no'])){
				$this->session->set_flashdata('message','Advance received successfully');
				echo 1;
				}
			}
	}

public function ajax_add_refund($pid=NULL){
		$rules=array(  
			'patient_id'		=>array('field'=>'patient_id','label'=>'patient  id','rules'=>'trim|required|xss_clean|max_length[100]|numeric'), 
			'json'		=>array('field'=>'json','label'=>'json ','rules'=>'trim|required|xss_clean'),
			);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){ 
			$patient_id			=sql_filter($this->input->post('patient_id')); 
			$json				=($this->input->post('json')); 
			$json				=json_decode($json,true);
			
			$filtered_json=array();
			foreach($json as $a=>$b){  $filtered_json[sql_filter($a)]=sql_filter($b);  }
			if(@$filtered_json['amount']==0) {echo 2; return;}
			if($this->update_balence($pid=$patient_id	,$amount=@$filtered_json['amount'],$update_json=1,$operation='sub',$towards='Refund',$note=@$filtered_json['note'],$invoice='',$mode=@$filtered_json['mode'],$date=@$filtered_json['date'],$recept_no=@$filtered_json['recept_no'])){
				$this->session->set_flashdata('message','Refunded successfully');
				echo 1;
				}
			}
	}

public function ajax_add_advance_by_invoice(){
		$rules=array(  
			'patient_id'		=>array('field'=>'patient_id','label'=>'patient  id','rules'=>'trim|required|xss_clean|max_length[100]|numeric'), 
			'clinic_id'		=>array('field'=>'clinic_id','label'=>'clinic  id','rules'=>'trim|required|xss_clean|max_length[100]|numeric'), 
			'json'		=>array('field'=>'json','label'=>'json ','rules'=>'trim|required|xss_clean'),
			);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){ 
			$patient_id			=sql_filter($this->input->post('patient_id')); 
			$clinic_id			=sql_filter($this->input->post('clinic_id')); 
			$note				=sql_filter($this->input->post('note')); 
			$mode				=sql_filter($this->input->post('mode')); 
			$recept_no			=sql_filter($this->input->post('recept_no')); 
			$p_date				=sql_filter($this->input->post('p_date'));  
			
			$json				=($this->input->post('json')); 
			$json				=json_decode($json,true);
			$this->load->model('invoice_m');
			$filtered_json=array();
			foreach($json as $a=>$b){ 
				foreach($b as $aa=>$bb)
				 $filtered_json[$a][sql_filter($aa)]=sql_filter($bb);  
				 } 
			$amount=0;
			$towards='';
			$invoice_a='<a href="'.bu('doctor/invoice/'.$patient_id).'">';
			
			foreach($filtered_json as $a=>$b){//First get the paid amount
				$data4=$this->invoice_m->get_by(array('patient_id'=>$patient_id,'clinic_id'=>$clinic_id,'id'=>$b['inv_id']));  
				$data4=@$data4[0];
				$ini_paid=$data4->paid;
				$temp=array();
				$temp['paid']=$ini_paid+$b['amount'];  
				$this->db->update('invoice', $temp, array('id' => $b['inv_id'],'clinic_id'=>$clinic_id));
				$amount+=$b['amount'];
				$towards.=$b['pro_name'].', ';
				$invoice_a.=$b['inv_id'].', ';
				}
				
			$invoice_a = rtrim($invoice_a, ',');
			$invoice_a='</a>';
			$towards = rtrim($towards, ',');
			
			
			if($this->update_balence($pid=$patient_id	,$amount=$amount,$update_json=1,$operation='add',
			$towards=$towards,$note=$note,$invoice=$invoice_a,$mode=$mode,$date=$p_date,$recept_no=$recept_no)){
				$this->session->set_flashdata('message','Payment  received successfully');
				echo 1;
				}
			}
	}

public function ajax_refund_by_invoice(){
		$rules=array(  
			'patient_id'		=>array('field'=>'patient_id','label'=>'patient  id','rules'=>'trim|required|xss_clean|max_length[100]|numeric'), 
			'clinic_id'		=>array('field'=>'clinic_id','label'=>'clinic  id','rules'=>'trim|required|xss_clean|max_length[100]|numeric'), 
			'json'		=>array('field'=>'json','label'=>'json ','rules'=>'trim|required|xss_clean'),
			);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){ 
			$patient_id			=sql_filter($this->input->post('patient_id')); 
			$clinic_id			=sql_filter($this->input->post('clinic_id')); 
			$note				=sql_filter($this->input->post('note')); 
			$mode				=sql_filter($this->input->post('mode')); 
			$recept_no			=sql_filter($this->input->post('recept_no')); 
			$p_date				=sql_filter($this->input->post('p_date')); 
			
			$json				=($this->input->post('json')); 
			$json				=json_decode($json,true);
			
			$this->load->model('invoice_m');
			
			$filtered_json=array();
			foreach($json as $a=>$b){ 
				foreach($b as $aa=>$bb)
				 $filtered_json[$a][sql_filter($aa)]=sql_filter($bb);  
				 } 
			$amount=0;
			$towards='';
			$invoice_a='<a href="'.bu('doctor/invoice/'.$patient_id).'">';
			foreach($filtered_json as $a=>$b){
				//First get the paid amount
				$data4=$this->invoice_m->get_by(array('patient_id'=>$patient_id,'clinic_id'=>$clinic_id,'id'=>$b['inv_id'])); 
				$data4=@$data4[0];
				$ini_paid=$data4->paid;
				$temp=array();
				$temp['paid']=$ini_paid-$b['amount'];
				$this->db->update('invoice', $temp, array('id' => $b['inv_id'],'clinic_id'=>$clinic_id));
				$amount+=$b['amount'];
				$towards.=$b['pro_name'].', ';
				$invoice_a.=$b['inv_id'].', ';
				}
				
			$invoice_a = rtrim($invoice_a, ',');
			$invoice_a='</a>';
			$towards = rtrim($towards, ',');
			
			
			if($this->update_balence($pid=$patient_id	,$amount=$amount,$update_json=1,$operation='sub',
			$towards=$towards,$note=$note,$invoice=$invoice_a,$mode=$mode,$date=$p_date,$recept_no=$recept_no)){
				$this->session->set_flashdata('message','Refunded successfully');
				echo 1;
				}
			}
	}
	
	
	




public function calender($did=NULL){ 
	$this->data['page_title']		='Calender';	
	$this->data['sub_view']			='calender';
	
	$primary=$this->session->userdata('primary');
	$this->load->model('clinic_m');
	$this->data['c_data']		=$this->clinic_m->get($primary,true);
	$this->data['app_data']		=get_clinic_appointment($did);
	$this->load->view('doctor_admin/layout',$this->data);
	}

public function ajax_save_consultation_time(){
	$time			=sql_filter($this->input->post('time'));
	$ckeck_array=array(3,5,7,10,15,20,30,45,60); 
	if(!in_array($time,$ckeck_array)) {echo 0; return;}
	$this->load->model('clinic_m');
	$primary=$this->session->userdata('primary');
	$temp=array('consultation_time'=>$time);
	$this->clinic_m->save($temp,$primary);
	echo 1;
	}

public function refund_invoice($pid=NULL){
	if($pid==NULL) {show_404();return;}
	$pid=sql_filter($pid);
	if(!valid_pid_for_completed_procedure($pid)) {show_404();return;}
	$this->load->model('patient_m');
	$this->load->model('invoice_m');
	$this->load->model('clinic_m'); 
	 
	$p_data=$this->patient_m->get($pid);
	$clinic_data=$this->clinic_m->get($this->session->userdata('primary')); 
	$primary=$this->session->userdata('primary');
	$sql="SELECT * FROM invoice WHERE (clinic_id=$primary AND patient_id=$pid) AND `paid`>0";
	$invoice_data=$this->db->query($sql)->result();  
	
	$primary=$this->session->userdata('primary');
	$sql="SELECT * FROM payment WHERE (clinic_id=$primary AND patient_id=$pid)";
	$payment_data=$this->db->query($sql)->result(); 
    $payment_data=@$payment_data[0];
									 
	$this->data['patient_data']		=$p_data;
	$this->data['clinic_data']		=$clinic_data; 
	$this->data['invoice_data']		=$invoice_data; 	
	$this->data['payment_data']		=$payment_data; 
	$this->data['page_title']		='Add payment';	
	$this->data['sub_view']			='refund_payment';
	  
	$this->load->view('doctor_admin/layout',$this->data);
	
	
	}

public function set_userdata(){
	$this->load->library('session');
	$var_name			=sql_filter($this->input->post('var_name'));
	$data				=sql_filter($this->input->post('data'));
	$redirect_url		=sql_filter($this->input->post('redirect_url'));
	
	$array=array("$var_name"=>$data);  
	$newdata = array( $var_name  => $data );
	
	$this->session->set_userdata($newdata);  
	if(!empty($redirect_url)) redirect($redirect_url);
	
	echo $this->session->userdata($var_name);
	}

public function printme(){
	 $data			=($this->input->post('data'));
	
	$print_type		=($this->input->post('print_type'));
	$pid			=($this->input->post('pid')); 
	if(!valid_pid_for_completed_procedure($pid)){show_404(); return;}
	
	$data= htmlspecialchars_decode( $data);
	
	$dot_matrix=0;
	if(isset($_POST['dot_matrix'])) $dot_matrix=1;
	
	$print_payment_history=0;
	if(isset($_POST['print_payment_history'])) $print_payment_history=1;
	
	
	$primary	=$this->session->userdata('primary');
	$doc_id		=$this->session->userdata('id');
	
	$this->load->model('patient_m');
	$patient_data=$this->patient_m->get($pid,true);
	
	$this->load->model('payment_m');
	$payment_data=$this->payment_m->get_by(array('patient_id'=>$pid),true); 
	$this->load->model('print_m');
	$printer_data=$this->print_m->get_by(array('doctor_id'=>$doc_id,'clinic_id'=>$primary),true);
	$printer_data=@$printer_data->$print_type;
	
	$this->data['data']				=$data;	 
	$this->data['pid']				=$pid;	 
	$this->data['dot_matrix']		=$dot_matrix;	 
	$this->data['print_payment_history']		=$print_payment_history;	 
	$this->data['patient_data']		=$patient_data;	
	$this->data['payment_data']		=$payment_data;	 
	$this->data['printer_data']		=$printer_data;	 
	$this->data['print_type']		=$print_type;	 
	$this->data['page_title']		='Print';	 
	$this->load->view('doctor_admin/printme',$this->data);
	}



public function saveme( ){
	$data			=($this->input->post('data'));
	$print_type		=($this->input->post('print_type'));
	$pid			=($this->input->post('pid')); 
	if(!valid_pid_for_completed_procedure($pid)){show_404(); return;}
	
	$dot_matrix=0;
	if(isset($_POST['dot_matrix'])) $dot_matrix=1;
	
	$primary	=$this->session->userdata('primary');
	$doc_id		=$this->session->userdata('id');
	
	$this->load->model('patient_m');
	$patient_data=$this->patient_m->get($pid,true);
	
	$this->load->model('print_m');
	$printer_data=$this->print_m->get_by(array('doctor_id'=>$doc_id,'clinic_id'=>$primary),true);
	$printer_data=$printer_data->$print_type;
	
	$this->data['data']				=$data;	 
	$this->data['dot_matrix']		=$dot_matrix;	 
	$this->data['patient_data']		=$patient_data;	 
	$this->data['printer_data']		=$printer_data;	 
	$this->data['print_type']		=$print_type;	 
	$this->data['page_title']		='Print';	
	$this->load->view('doctor_admin/save_me',$this->data);
	 
	}



public function make_pdf_from_html($pid=NULL){ 
	

	$html			=html_entity_decode($this->input->post('html'));
	$pid			=sql_filter($this->input->post('patient_id'));
	if(!valid_pid_for_completed_procedure($pid)){ return;}
	
	$doctor_id=$this->session->userdata('id');
	$primary=$this->session->userdata('primary');
	$time=time();
	$file_name=$doctor_id.'_'.$primary.'_'.$time.'.pdf';
	$parent_folder='patients';
	$path="$parent_folder/$pid";
	if(!file_exists($path)) mkdir("patients/$pid");
	$path="patients/$pid";
	
	$path_file=$path.'/'.$file_name;
	
	
	include(('mpdf/mpdf.php'));
	$mpdf=new mPDF( );  
	$mpdf->WriteHTML($html);
	
	$this->load->model('clinic_m');
	$data=$this->clinic_m->get($primary,true);
	$remaining_memory=($data->remaining_memory);
	
	if($remaining_memory>200000){
		//Qualify to save
		$mpdf->Output(($path_file));  
		echo '<div class="alert alert-success alert-dismissable">  <i class="fa fa-check"></i>  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <b>Success!</b> Your file has been successfully saved as '.$file_name.'.</div>';
		
		//Calcutale the size of saved file
		$size=filesize($path_file);
		$new_memory=$remaining_memory-$size; 
		$this->clinic_m->save(array('remaining_memory'=>$new_memory),$primary);
		
		//Register the saved file
		register_saved_file($pid,$path_file,$file_name,$parent_folder);
		
		}
	else{
		echo '<div class="alert alert-danger alert-dismissable">  <i class="fa fa-times"></i>  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <b>Error!</b>Not enough memory. Please delete some files.</div>';
		}
	
	exit;

	}

public function file_manager($pid=NULL){ 

	$total_used_memory=0;
	$primary=$this->session->userdata('primary');
	$sql="SELECT SUM(size) as size FROM files WHERE clinic_id=$primary;";
	$result=$this->db->query($sql)->result();
	$result=@$result[0];
	$total_used_memory=$result->size; 
	$this->data['total_used_memory']=$total_used_memory; 	
	
	if($pid==NULL){
		//Show all the Files available
		
		 
		$this->data['debug']=''; 	
		$this->data['page_title']='File Manager';	
		$this->data['sub_view']='file_manager';
		
		$this->load->view('doctor_admin/layout',$this->data);
			
		}
	else{
		
		if(!valid_pid_for_completed_procedure($pid)){
			show_404(); return;
			}
		$this->load->model('patient_m');
		$p_data=$this->patient_m->get($pid);	
		$this->data['p_data']=$p_data; 	
		$this->data['pid']=$pid; 	
		$this->data['debug']=''; 	
		$this->data['page_title']='File Manager';	
		$this->data['sub_view']='file_manager';
		
		$this->load->view('doctor_admin/layout',$this->data);
		} 
	
	}
public function get_files($offset=0){

		if(isset($_POST['pid'])) {$pid=sql_filter($_POST['pid']);
		if(!valid_pid_for_completed_procedure($pid)){  return; }
		}
		
		if(isset($_POST['type'])){$type=sql_filter($_POST['type']);}
		else $type='';
		
		if(isset($_POST['filter'])){$filter=sql_filter($_POST['filter']);}
		else $filter='';
		
		if(isset($_POST['search_key'])){$search_key=sql_filter($_POST['search_key']);}
		else $search_key='';
		
		
		$number_of_result=20;
		$offest_f=$offset*$number_of_result;
		$primary=$this->session->userdata('primary');
		if(empty($primary)){ echo '<p>Please select a clinic from top left to get the treatment plans</p>'; return;}
		$this->load->model('files_m');
		$this->load->model('patient_m');
		$this->load->model('doctor_m');
		
		if(($type=='type')){
			if(!empty($filter)){ 
				$this->db->where($type,$filter);
				}
			}
		if(($type=='date_created')){
			if(!empty($filter)){ 
				if($filter=='today'){
					$this->db->like('date_created', '2015-04-15');
					}
				if($filter=='last_seven'){
					$start_date=date('Y-m-d', strtotime('-7 days'));
					$end_date=date('Y-m-d');
					$this->db->where('date_created BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
					}
			}
			
			}
		
		if(!empty($search_key)) $this->db->like('name', $search_key);
		$this->db->order_by("date_created", "desc"); 
		if(isset($pid)){ 
			$t_data	=$this->db->get_where('files', 
			array('clinic_id'=>$primary,'patient_id'=>$pid),$number_of_result,$offest_f)->result();		
			
			 
			}
		else{ 
			$t_data	=$this->db->get_where('files', array('clinic_id'=>$primary),$number_of_result,$offest_f)->result();
			 
			}
		echo '<span class="mha">'.sizeof($t_data).' files found.</span>';
		//echo $this->db->last_query();
				 
		if(empty($t_data)) {
			echo '<div class="callout callout-info" style="clear: both;"> <h4>No Files found.</h4>  </div>';
			return;
			}
			 
		$tmp = array(); 
		
		foreach($t_data as $a=>$b):?>
      
		<div class="file"  data-src="<?php echo ($b->id);?>"> 
            <?php if($b->type=='pdf'):?> 
            <a target="_blank"   href="<?php echo bu($b->rel_path);?>">
            	<img src="<?php echo bu('images/pdf.jpg')?>" class="jp" /> 
            </a>
          	<?php else:?>
            <img src="<?php echo bu('images/jpeg.jpg')?>" class="jp img_preview" data-src="<?php echo bu($b->rel_path);?>"/>
            <?php endif;?><br clear="all" />
            <input type="checkbox" class="btn btn-xs btn-default checker simple" />
            <button title="Delete this file" class="btn btn-xs btn-default" onclick="if(confirm('Are you sure?')) delete_file($(this))"><i class="fa fa-trash-o"></i></button>  
            
            <button title="Email this file" onclick="prepare_attachment($(this))" 
            data-rel_path="<?=$b->rel_path;?>"
            data-toggle="modal" data-target="#email_dialog" data-pid="<?=$b->patient_id?>"
            class="btn btn-xs btn-default"><i class="fa fa-envelope-o"></i></button>
             
             
            
             
            <div class="file_n"><?=$b->name?></div>
        </div>
<?php endforeach;
	echo '<div  class="show_more"  align="center"; style="clear:both"><button onclick="append_result('.($offset+1).')" class="btn btn-success btn-sm btn-flat">Show More</button></div>';
		return;
		
	}

public function ajax_delete_file(){
	$id=sql_filter($this->input->post('src_id'));
	$this->load->model('files_m');
	//Validate the file if it belongs to the clinic
	$primary=$this->session->userdata('primary');
	$data=$this->files_m->get_by(array('id'=>$id,'clinic_id'=>$primary),true);
	$src='';
	$src=@$data->rel_path;
	if(!empty($src)){ 
		//Check if file exists
		if(file_exists(($src))){
			//Get the size of the file
			$size=filesize(($src));
			
			//First delete the file
			unlink(($src));
			
			//Delete record from db
			$this->files_m->delete($id);
			
			//Update the available space
			$this->load->model('clinic_m');
			$c_data=$this->clinic_m->get($primary,true);
			$remaining_memory=@$c_data->remaining_memory;
			$remaining_memory+=$size;
			$this->clinic_m->save(array('remaining_memory'=>$remaining_memory),$primary);
			
			echo 1;
			
			}
		}
	}

public function ajax_get_p_data_for_email(){
	if(isset($_POST['pid'])) {$patient_id=sql_filter($_POST['pid']);
	if(!valid_pid_for_completed_procedure($patient_id)){  show_404();return; }
		}
	  
	$sql="SELECT * FROM patient WHERE id=".$patient_id." LIMIT 1";
	$results=mysql_query($sql);
	$row = mysql_fetch_assoc($results);
	$p_data=$row; 

	$this->load->model('patient_m');
	$this->load->model('clinic_m');
	$primary=$this->session->userdata('primary');
	$c_data=$this->clinic_m->get($primary,true);
	$remaining_email=@$c_data->remaining_email;
	
	//$patient_data=$this->patient_m->get($pid,true);
		 
	  
	$html='';
	$html.=' <small class="pull-right" style=" padding: 0 40px;margin-top: 5px;">Todays Limit:'.$remaining_email.'</small>';
	$html.='<div class="form-group">  
	<label>Email Address</label> <input type="email" class="form-control" id="recept_email_id" placeholder="Enter email" value="'.$p_data['email'].'"></div>';
	
	if($remaining_email>0){
		$html.='<button class="btn btn-sm  btn-info btn-flat disabled mob">Please Wait <img src="'.bu('images/ajax_rt.gif').'"></button>';
		$html.='<button class="btn btn-sm  btn-success btn-flat mob" onclick="send_email($(this))" 
		data-pid='.$p_data['id'].' style="display:none">Send</button>';
		}
	
	else $html.='<button class="btn btn-sm btn-flat btn-warning disabled">Not enough Email credit</button>';
	
	echo $html;
	}
public function upload_file($pid=NULL){
	if(!valid_pid_for_completed_procedure($pid)){  show_404();return; }
	}

public function ajax_prepare_attachment(){
	//Attachment is in relative path only
	$attachment		=sql_filter($this->input->post('attachment'));
	
	$file_name		=array_reverse(explode('/',$attachment));
	$file_name		=@$file_name[0];
	
	
	$pid			=sql_filter($this->input->post('pid'));
	if(!valid_pid_for_completed_procedure($pid)){  show_404();return; }
	
	$newdata = array( 'attachment'  => $attachment ,'attach_filename'=>$file_name);
	$this->session->set_userdata($newdata);  
	echo 1;
	}

public function ajax_prepare_email(){
	$data			=($this->input->post('data'));  
	$pid			=sql_filter($this->input->post('pid')); 
	$print_type		=sql_filter($this->input->post('print_type'));
	if(!valid_pid_for_completed_procedure($pid)){show_404(); return;}
	
	$data= htmlspecialchars_decode( $data);
	 
	
	$primary	=$this->session->userdata('primary');
	$doc_id		=$this->session->userdata('id');
	
	$this->load->model('patient_m');
	$patient_data=$this->patient_m->get($pid,true);
	
	$this->load->model('print_m');
	$printer_data=$this->print_m->get_by(array('doctor_id'=>$doc_id,'clinic_id'=>$primary),true);
	$printer_data=$printer_data->$print_type; 
	 
	$newdata = array( 'primary'  => $primary ,'email_body'=>$data);
	$this->session->set_userdata($newdata);
 
	$this->data['data']				=$data;	 
	$this->data['dot_matrix']		=1;	 
	$this->data['patient_data']		=$patient_data;	 
	$this->data['printer_data']		=$printer_data;	  	 
	$this->data['page_title']		='Email';	
	$this->data['print_type']		=$print_type;	 
	$this->load->view('doctor_admin/emailme',$this->data); 
}

public function ledger(){
	//Only admin of the clinic can access this page
	if(!allow_only_admins()){ show_noaccess(); return;}
	
	$this->data['sub_view']='ledger';
	$this->load->view('doctor_admin/layout',$this->data);
	}

public function set_timing(){
	if(!allow_only_admins()){show_noaccess(); return;}
	
	$primary=$this->session->userdata('primary');
	$this->load->model('clinic_m');
	$clinic_data=$this->clinic_m->get($primary,true);
	$this->data['clinic_data']=$clinic_data;
	$this->data['sub_view']='set_timing';
	$this->load->view('doctor_admin/layout',$this->data);
	}

public function set_timing_ajax(){
	if(isset($_POST['json'])) $json=$this->input->post('json');
	else return;
	$json=json_decode($json,true); 
	$error_array=array();
	foreach($json as $day=>$timing){
		
		if(isset($timing[1]) and isset($timing[0])){
			
			$now_session	=($timing[0]['end']);
			$array			=explode(':',$now_session);
			$now_session	=strtotime(date("H:i", strtotime($array[0].':'.$array[1].' '.$array[2])));			
			
			$next_session	=($timing[1]['start']);
			$array			=explode(':',$next_session);
			$next_session	=strtotime(date("H:i", strtotime($array[0].':'.$array[1].' '.$array[2])));
			
			if($next_session<$now_session) {
				$error_array[]=$day.'_0';
				$error_array[]=$day.'_1';
				}
			}
		
		foreach($timing as $a=>$b){
			$start		=$b['start'];
			$array		=explode(':',$start);
			$start_24	=date("H:i", strtotime($array[0].':'.$array[1].' '.$array[2]));
			$end		=$b['end'];
			$array		=explode(':',$end);
			$end_24		=date("H:i", strtotime($array[0].':'.$array[1].' '.$array[2]));
			
			if($start_24>=$end_24) {$error_array[]=$day.'_'.$a;}
			}
		}
	if(sizeof($error_array)) {echo json_encode($error_array);return;}
	//Sanatize the json
	$sanatized_json=array();
	foreach($json as $day=>$timing){
		$temp=array();
		foreach($timing as $a=>$b){			
			$temp[$a]=array('start'=>sql_filter($b['start']),'end'=>sql_filter($b['end']));
			$sanatized_json[sql_filter($day)]=$temp;
			}
		}
	
	$json=json_encode($json);
	$sanatized_json=json_encode($sanatized_json);
	if(strcmp($json,$sanatized_json)) {echo 0;return;}
	//Input is safe and can be stored in the db
	 
	$this->load->model('clinic_m');
	$data_array=array('timing'=>$sanatized_json);
	if($this->clinic_m->save($data_array,$this->session->userdata('primary'))){
		echo 1;
		}
	else echo 0;
	
	}
	
 public function ajax_del_app(){	 
		$app_id		=sql_filter($this->input->post('id')); 
		$dummy_id=$app_id;
		$timestamp	=sql_filter($this->input->post('timestamp')); 
		$sql="SELECT id FROM appointment WHERE clinic_id=".$this->session->userdata('primary')." AND id=$app_id AND time='$timestamp'" ;   
		
		if(!$this->db->query($sql)->num_rows()){
			echo 0;
			return;
			}
		$sql="DELETE  FROM appointment WHERE clinic_id=".$this->session->userdata('primary')." AND id=$app_id AND time='$timestamp'" ;   
		
		if($this->db->query($sql)){
			echo $dummy_id;;
			return;
			} 
		
			
	 }
}
?>

