<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper extends Frontend_Controller {
	
	public function __construct(){
		parent::__construct();
		}
	public function _time_check($time){
		if($time<config_item('now_time')){
			$this->form_validation->set_message('_time_check', 'The %s does not match.');
			return FALSE;
			}
		else return TRUE;
		}
	
	public function set_appointment(){
			$html='';
						
			$rule=array(
			'name'		=>array('field'=>'name','label'=>'Name','rules'=>'trim|required|xss_clean|max_length[100]'),
			'email'		=>array('field'=>'email','label'=>'Email','rules'=>'trim|xss_clean|valid_email'),
			'phone'		=>array('field'=>'phone','label'=>'Phone number','rules'=>'trim|xss_clean|max_length[30]|numeric|required'),
			'clinic_id'	=>array('field'=>'clinic_id','label'=>'Clinic id','rules'=>'trim|xss_clean|numeric|required'),
			'doctor_id'	=>array('field'=>'doctor_id','label'=>'Doctor id','rules'=>'trim|xss_clean|numeric|required'),
			'time'		=>array('field'=>'time','label'=>'Time Slot','rules'=>'trim|xss_clean|max_length[20]|numeric|required| callback__time_check'),
			);
		$this->form_validation->set_rules($rule);
		$this->load->helper('security');
		
		if($this->form_validation->run()==TRUE){
			$manual=0;
			$errors=0;
			$name				=$this->input->post('name');
			$email				=$this->input->post('email');
			$phone				=$this->input->post('phone');
			$clinic_id			=$this->input->post('clinic_id');
			$doctor_id			=$this->input->post('doctor_id');
			$time				=$this->input->post('time');
			if(isset($_POST['manual'])) $manual=1;
			
			
			$data=array();
			$data['clinic_id']=$clinic_id;
			$data['doctor_id']=$doctor_id;
			$data['name']=$name;
			$data['email']=$email;
			$data['phone']=$phone;
			$data['time']=$time;
			if($manual){ $data['maunal']=1; }
			
			$present_day	=strtotime(date('m/d/Y',$time));
			$next_day		=$present_day+(24*60*60);
			$sql="SELECT id,time FROM appointment WHERE phone='$phone' AND doctor_id='$doctor_id' AND clinic_id=$clinic_id AND time BETWEEN $present_day AND $next_day";
			$results		=$this->db->query($sql)->result();
			$num_rows=sizeof($results);
			
			if($num_rows and !$manual){
				$results=$results[0];
				$html='<div class="alert alert-warning" role="alert" style="margin:0;margin-top:10px;">
				<strong><i class="glyphicon glyphicon-exclamation-sign"></i> Appointment exists</strong>';
				$html.='<p>You already have an appointment on this day at '.date('h:i a',$results->time).'</p>';
				$html.='</div>';
				echo $html;
				return;
				}
			
			$this->load->model('clinic_m');
			$appointments_count=$this->clinic_m->get($clinic_id,true);
			$appointments_count=$appointments_count->appointments;
			if($appointments_count<=0){
				  $html='<div class="alert alert-danger" role="alert" style="margin:0;margin-top:10px;">
				  <strong><i class="glyphicon glyphicon-warning-sign"></i> Error</strong>';
				  $html.='<p>Sorry but no appointments credit left. If you are the owner of this clinic please purchase more appointment credit from your admin panel.</p>';
				  $html.='</div>';
				  echo $html;
				  return;}
			
			$this->load->model('appointment_m');
			$app_id=$this->appointment_m->save($data);
			
			$appointments_count=$appointments_count-1;
			$this->clinic_m->save(array('appointments'=>$appointments_count),$clinic_id);
			
			
			//------------------------------------------------For front end-------------------------
			if(!$manual){
			  if($app_id){
				  $html='<div class="alert alert-success" role="alert" style="margin: 0;margin-top: 10px;">
				  <strong><i class="glyphicon glyphicon-ok-sign"></i> Appointment Booked</strong>';
			  $html.='<p>Congratulations your appointment has been successfully booked on '.date('d/m/y',$time).' at '. date('h:i a',$time).'. You will receive a confirmation SMS. <br> Appointment id:<strong>'.$app_id.' </strong>
			  <br><br> <button class="btn btn-success btn-xs" onclick="$(\'.inst_appoint_holder\').slideUp(400);destroy_shedule_form()">Dismiss</button> </p>';
			  $html.='</div>';
			  echo $html;
				  }
			  else {
				  $html='<div class="alert alert-danger" role="alert" style="margin:0;margin-top:10px;">
				  <strong><i class="glyphicon glyphicon-warning-sign"></i> Error</strong>';
				  $html.='<p>Something went wrong</p>';
				  $html.='</div>';
				  echo $html;
				  }
			}
			
			//------------------------------------------------For back end-------------------------
			if($num_rows and $manual){
				echo 'duplicate_'.$app_id;
				return;
				}
				
			if($manual){
			  if($app_id){echo $app_id;}
			  else {echo 0; }
			}
			
			}
		else {
			$html='<div class="alert alert-danger" role="alert" style="margin:0;margin-top:10px;">
			<strong><i class="glyphicon glyphicon-warning-sign"></i> Error</strong>';
			$html.=validation_errors();
			$html.='</div>';
			echo $html;
			}
		
		
			
		}
	
	public function ajax_appoint_sheduler_clinic(){
		if(isset($_POST['day']) and isset($_POST['clinic_id'])){ 
			$clinic_id	=mysql_real_escape_string($_POST['clinic_id']);
			$date		=mysql_real_escape_string($_POST['day']);
			$date		=explode('-',$date); 
			$day		=strtolower($date[0]);
			$date		=$date[1];
			$date 		= str_replace('/', '-', $date);
			 
			$this->load->model('clinic_m');
			$result		=$this->clinic_m->get($clinic_id,true);
			$time_doc	=$result->consultation_time;
			$timing		=$result->timing;
			$json		=json_decode($timing,true);			
			if(empty($json)) $json=array();
			if(!isset($json[$day])){
				echo '<h4><i class="glyphicon glyphicon-alert"></i> Sorry Clinic is closed on <u>'.ucfirst($day).'</u>.</h4>
				<div class="alert alert-warning" role="alert">Clinic is open on <strong>'; 
				$days='';
				foreach($json as $day=>$tim){
					$days.=ucfirst($day).',';					
					}
				echo rtrim($days,',');
				echo '</strong>. Please choose date from the mentioned days.</div>';
				return;
				} 
			$json=$json[$day];
			//var_dump($json); return; 
			
			
			$present_day	=strtotime($date);
			$next_day		=$present_day+(24*60*60);
			
			$sql="SELECT id,time FROM appointment WHERE clinic_id=$clinic_id  AND time BETWEEN $present_day AND $next_day";
			$app_result=$this->db->query($sql)->result();
			$temp_array=array(); 
			foreach($app_result as $x=>$y){ $temp_array[]=$y->time; }
			$number_of_app_on_time= array_count_values($temp_array);
			 
				
			
			echo '<form class="shedule_form">
			<input type="hidden" name="doctor_id" value="0">
			<input type="hidden" name="clinic_id" value="'.$clinic_id.'">
			<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding:0;">
			<h4><i class="glyphicon glyphicon-time"></i> Pick Time Slot</h4>';
			echo '<div class="fiver">';
			foreach($json as $a=>$b){
				echo '<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-6" style="padding:0;">';
				if($a) echo '<div class="hidden-xs"><br></div>';
				echo '<strong>'.addOrdinalNumberSuffix($a+1).' hour</strong><br>';
				
				$start_format	=explode(':',$b['start']);
				if($start_format[2]=='PM') $start_format[0]=$start_format[0]+12;
				$start_time=strtotime(($date.'-'.$start_format[0].':'.$start_format[1]));
				
				$end_format	=explode(':',$b['end']);
				if($end_format[2]=='PM') $end_format[0]=$end_format[0]+12;
				$end_time=strtotime(($date.'-'.$end_format[0].':'.$end_format[1]));
				
				if($start_time>$end_time){
					$temp=$end_time;
					$end_time=$start_time;
					$start_time=$temp;
					}
				
				 
				$increment=1800; //1800 for 30 minute
				if($time_doc>30) $increment=$time_doc*60;
				
				for($ii=$start_time; $ii<$end_time;$ii+=$increment){
					$upto=$ii+$increment;
					if($upto>$end_time) $upto=$end_time;
					
					$now_time=config_item('now_time');
									
					if($now_time>$ii) {
						echo '<div class="form-group" style="opacity: 0.4;margin: 0;background: rgb(243, 243, 243);">
							<input type="radio" disabled class="slot_picker" >
							<label class="slot_label">'.date('h:i a', $ii).'-'.date('h:i a', $upto).'</label>
						</div>';
						}
					
					else
					{
						$flag=0;
						if(isset($number_of_app_on_time[$ii])){
								$number_of_app_on_time[$ii];
								$sed= intval($increment/($time_doc*60)); //900 for 15 minute
								if($number_of_app_on_time[$ii]>=$sed) $flag=1;
								}
						echo '<div class="form-group" style="margin:0">';
							if($flag) 	echo '<input type="radio" disabled class="slot_picker" >
										<label style="opacity:1 ;margin: 0;background: rgb(255, 245, 197);"
										 class="slot_label">'.date('h:i a', $ii).'-'.date('h:i a', $upto);
							else 		echo '<input type="radio" class="slot_picker" value="'.$ii.'" name="ask_slot">
										<label class="slot_label">'.date('h:i a', $ii).'-'.date('h:i a', $upto);
							 
							if($flag){  echo '<div class="btn btn-xs btn-warning not_available">Not Available</div>'; }
							echo '</label>
						</div>';
						
						}
					
					}
				
				echo '</div>';
				}
			
			echo '</div></div>
<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding:0">
<h4><i class="glyphicon glyphicon-list-alt"></i> Enter Your details</h4>
  <div class="input-group" style="width: 100%;"> <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i> Phone</span>
    <input type="text" class="form-control" name="phone" placeholder="Phone number">
  </div> 
  <div class="input-group" style="width: 100%;"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> Name</span>
    <input type="text" class="form-control" name="name" placeholder="Your Name">
  </div> 
  <div class="input-group" style="width: 100%;"> <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i> Email</span>
    <input type="text" class="form-control" name="email" placeholder="Email address">
  </div>
  <div id="msg_holder">
  
  </div>
  <br>
  <button type="submit" class="btn btn-info btn-block"><i class="glyphicon glyphicon-flash"></i> Book Appointment 
  <i id="ajax_holder" style="height:18px"></i></button>
  <span style="font-size: 11px;">By clicking Book Appointment you agree our 
  <a style="color:#5555FD  !important; text-decoration:underline !important" href="">Privacy Policy</a></span>
</div>
</form>
';
			}
		}
	
	public function ajax_appoint_sheduler(){
		if(isset($_POST['day']) and isset($_POST['clinic_id']) and isset($_POST['doctor_id'])){
			$doctor_id	=mysql_real_escape_string($_POST['doctor_id']);
			$clinic_id	=mysql_real_escape_string($_POST['clinic_id']);
			$date		=mysql_real_escape_string($_POST['day']);
			$date		=explode('-',$date);
			$day		=strtolower($date[0]);
			$date		=$date[1];
			$date 		= str_replace('/', '-', $date);
			
			$sql		="SELECT $day,time FROM clinic WHERE id=$clinic_id AND (other_doctors LIKE '%,$doctor_id,%' OR doctor_id=$doctor_id)";
			$result=$this->db->query($sql)->result();
			$json=json_decode($result[0]->$day,true);
			$time_doc=json_decode($result[0]->time,true);
			
			$time_doc=@$time_doc[$doctor_id];
			if(!isset($json[$doctor_id])){
				echo '<h4><i class="glyphicon glyphicon-alert"></i> Error</h4>
				<div class="alert alert-warning" role="alert"><strong>Doctor is not available.</strong> Please try other dates. The doctor is not availabe in this clinic on this date.</div>';
				return;
				} 
			$shedule_id=$json[$doctor_id];
			
			$sql="SELECT * FROM shedule WHERE id=$shedule_id";
			$result=$this->db->query($sql)->result();
			if(empty($result)) {
				echo '<h4><i class="glyphicon glyphicon-alert"></i> Error</h4>
				<div class="alert alert-warning" role="alert"><strong>Doctor is not available.</strong> Please try other dates. The doctor is not availabe in this clinic on this date.</div>';
				return;
				};
			$result=$result[0];
			$json=json_decode($result->json,true);
			
			$present_day	=strtotime($date);
			$next_day		=$present_day+(24*60*60);
			
			$sql="SELECT id,time FROM appointment WHERE clinic_id=$clinic_id AND doctor_id=$doctor_id AND time BETWEEN $present_day AND $next_day";
			$app_result=$this->db->query($sql)->result();
			$temp_array=array(); 
			foreach($app_result as $x=>$y){ $temp_array[]=$y->time; }
			$number_of_app_on_time= array_count_values($temp_array);
			 
				
			
			echo '<form class="shedule_form">
			<input type="hidden" name="doctor_id" value="'.$doctor_id.'">
			<input type="hidden" name="clinic_id" value="'.$clinic_id.'">
			<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding:0;">
			<h4><i class="glyphicon glyphicon-time"></i> Pick Time Slot</h4>';
			echo '<div class="fiver">';
			foreach($json as $a=>$b){
				echo '<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-6" style="padding:0;">';
				if($a) echo '<div class="hidden-xs"><br></div>';
				echo '<strong>'.addOrdinalNumberSuffix($a+1).' hour</strong><br>';
				
				$start_format	=explode(':',$b['start']);
				if($start_format[2]=='PM') $start_format[0]=$start_format[0]+12;
				$start_time=strtotime(($date.'-'.$start_format[0].':'.$start_format[1]));
				
				$end_format	=explode(':',$b['end']);
				if($end_format[2]=='PM') $end_format[0]=$end_format[0]+12;
				$end_time=strtotime(($date.'-'.$end_format[0].':'.$end_format[1]));
				
				if($start_time>$end_time){
					$temp=$end_time;
					$end_time=$start_time;
					$start_time=$temp;
					}
				$increment=1800;
				if($time_doc>30) $increment=$time_doc*60;
				
				for($ii=$start_time; $ii<$end_time;$ii+=$increment){
					$upto=$ii+$increment;
					if($upto>$end_time) $upto=$end_time;
					
					$now_time=config_item('now_time');
									
					if($now_time>$ii) {
						echo '<div class="form-group" style="opacity: 0.4;margin: 0;background: rgb(243, 243, 243);">
							<input type="radio" disabled class="slot_picker" >
							<label class="slot_label">'.date('h:i a', $ii).'-'.date('h:i a', $upto).'</label>
						</div>';
						}
					
					else
					{
						$flag=0;
						if(isset($number_of_app_on_time[$ii])){
								$number_of_app_on_time[$ii];
								$sed= intval($increment/($time_doc*60));
								if($number_of_app_on_time[$ii]>=$sed) $flag=1;
								}
						echo '<div class="form-group" style="margin:0">';
							if($flag) 	echo '<input type="radio" disabled class="slot_picker" >
										<label style="opacity:1 ;margin: 0;background: rgb(255, 245, 197);"
										 class="slot_label">'.date('h:i a', $ii).'-'.date('h:i a', $upto);
							else 		echo '<input type="radio" class="slot_picker" value="'.$ii.'" name="ask_slot">
										<label class="slot_label">'.date('h:i a', $ii).'-'.date('h:i a', $upto);
							 
							if($flag){  echo '<div class="btn btn-xs btn-warning not_available">Not Available</div>'; }
							echo '</label>
						</div>';
						
						}
					
					}
				
				echo '</div>';
				}
			
			echo '</div></div>
<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding:0">
<h4><i class="glyphicon glyphicon-list-alt"></i> Enter Your details</h4>
  <div class="input-group" style="width: 100%;"> <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i> Phone</span>
    <input type="text" class="form-control" name="phone" placeholder="Phone number">
  </div> 
  <div class="input-group" style="width: 100%;"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> Name</span>
    <input type="text" class="form-control" name="name" placeholder="Your Name">
  </div> 
  <div class="input-group" style="width: 100%;"> <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i> Email</span>
    <input type="text" class="form-control" name="email" placeholder="Email address">
  </div>
  <div id="msg_holder">
  
  </div>
  <br>
  <button type="submit" class="btn btn-info btn-block"><i class="glyphicon glyphicon-flash"></i> Book Appointment 
  <i id="ajax_holder" style="height:18px"></i></button>
  <span style="font-size: 11px;">By clicking Book Appointment you agree our 
  <a style="color:#5555FD  !important; text-decoration:underline !important" href="">Privacy Policy</a></span>
</div>
</form>
';
			}
		}
		
		public function command($model='doctor_m'){
			$command=sql_filter($this->input->post('command'));
			$id=sql_filter($this->input->post('id'));
			$this->load->model($model);
			$doctor_data=$this->$model->get_by(array('id'=>$id),true);
			
			switch($command){
				case('like'):
					$like=$doctor_data->like;
					$like+=1;
					$this->$model->save(array('like'=>$like),$id);
					if($this->db->affected_rows()) echo 'liked';
					break;
				case('dislike'):
					$like=$doctor_data->like;
					$like-=1;
					if($like<0) $like=0;
					$this->$model->save(array('like'=>$like),$id);
					if($this->db->affected_rows()) echo 'disliked';
					break;
				}
			}

		public function rating($model='doctor_m'){
			$value=sql_filter($this->input->post('value'));
			$id=sql_filter($this->input->post('id'));
			$this->load->model($model);
			$doctor_data=$this->$model->get_by(array('id'=>$id),true);
			$total_rating=0.0;
			
			$rating=$doctor_data->rating;
			$rating_count=$doctor_data->rating_count;
			
			$total_rating+=($rating*$rating_count)+$value;
			$rating_count=$rating_count+1;
			
			
			$rating=$total_rating/$rating_count;
			if($rating<0) $rating=0;
			$this->$model->save(array('rating'=>$rating,'rating_count'=>$rating_count),$id);
			if($this->db->affected_rows()) echo 'rated';
			}
		
		public function submit_review($model='doctor_m'){
			$rule=array(
			'name'		=>array('field'=>'name_review','label'=>'Name','rules'=>'trim|required|xss_clean|max_length[20]'),
			'text'	=>array('field'=>'text','label'=>'Review','rules'=>'trim|required|xss_clean|max_length[100]')
			);
			$this->form_validation->set_rules($rule);
			
		
			if($this->form_validation->run()==TRUE){
				$name=sql_filter($this->input->post('name_review'));
				$review_cookie=sql_filter($this->input->post('review_cookie'));
				if($review_cookie) {
					echo '<div class="alert alert-warning" role="alert">
							You have recently reviewed. You can add review after 7 days
						</div>'; 
					return;}
				$text=sql_filter($this->input->post('text'));
				$id=sql_filter($this->input->post('id'));
				$this->load->model($model);
				$doctor_data=$this->$model->get_by(array('id'=>$id),true);
				$review=$doctor_data->review;
				$review_count=$doctor_data->review_count;
				$review_count+=1;
				$review=json_decode($review,true);
				$review[$name]=time().':-:'.$text;
				$review=array_reverse($review);
				$review=array_slice($review,0,10);
				$review=array_reverse($review);
				$review=json_encode($review);
				$this->$model->save(array('review'=>$review,'review_count'=>$review_count),$id);
				if($this->db->affected_rows()) echo '<div class="alert alert-success" role="alert">Thankyou for your review</div>'; 
				}
			else echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>';
			
			
			}
		
		public function generate_city_li($type='doctors'){
			$city=sql_filter($this->input->post('city'));
			$sql="SELECT distinct(city) FROM location WHERE city LIKE '%$city%' order by city LIMIT 10 ";
			$results=$this->db->query($sql)->result();
			$str='';
			foreach($results as $a=>$b){
				$str.='<li role="presentation">
						<a role="menuitem" tabindex="-1" href="'.bu('search/'.$type.'/'.$b->city).'">
							<span class="prefix">'.ucfirst(substr($b->city,0,1)).'</span>'.ucfirst($b->city).'
						</a>
					</li>';
				}
			echo $str;
			}
		public function get_all_services(){
			$doc_list=array();
			$id=sql_filter($this->input->post('id'));
			$sql="SELECT doctor_id,other_doctors FROM clinic WHERE id=$id LIMIT 1";
			$results=$this->db->query($sql)->result();
			$results=$results[0];
			$doc_list[]=$results->doctor_id;
			$other_doc=array_filter(explode(',',$results->other_doctors));
			$doc_list=array_merge($doc_list,$other_doc);
			//Check and get any special doctor
			$sql="SELECT id FROM doctors WHERE special_clinic=$id";
			$results=$this->db->query($sql)->result();
			foreach($results as $a=>$b){				$doc_list[]=$b->id;				}
			$doc_list=array_unique($doc_list);
			//doc_list contains all the doctors available to the clinic
			
			$sql="SELECT name,username,service FROM doctors WHERE id in (".implode(',',$doc_list).")";
			$service_data=$this->db->query($sql)->result();
			
			$output='<div class="row sr_holder"><h3> <i class="fa fa-fw fa-ambulance"></i> Available services group by doctors</h3><hr>';
			foreach($service_data as $a=>$b){
				$output.='<div class="row">
					<a class="link link_m" href="'.bu('doctors/'.$b->username).'"><h4><i class="fa fa-fw fa-user-md"></i> Dr '.$b->name.'</h4></a>';
				$service=array();
				$services=array_filter(explode(':-:',$b->service));
				if(!count($services)) $output.= '<p>No service found for this doctor</p>';
				foreach($services as $x=>$y) {$output.='<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6"><li>'.$y.'</li></div>';}
				$output.='<div class="col-lg-1"></div></div>';
				}
			
			$output.='</div>';
			echo $output;
			}
		
		public function city(){
			$val=sql_filter($_POST['query']);
			$sql="SELECT DISTINCT(city) FROM location WHERE city LIKE '%$val%' limit 10";
			$result=$this->db->query($sql)->result();
			$json='{"suggestions": [';
			foreach($result as $a=>$b){
				$json.='"'.$b->city.'",';
				}
			$json=rtrim($json,',');
			$json.=']}';
			echo $json;
			}
		 
		 public function search_autocomplete(){
			 
			$val=sql_filter($_POST['query']);
			 
			$sql="SELECT 'doctors' as type,name as name,username as slug,speciality_parent as helper FROM doctors WHERE doctors.name like '%$val%' LIMIT 5 UNION 
			 SELECT 'clinics',name as clinic_name,slug,city from clinic where clinic.name like '%$val%' LIMIT 5
			 UNION 
			 SELECT 'hospitals',name as hospital_name,slug,city from hospital where hospital.name like '%$val%' LIMIT 5
			 "
			 ;
			 $result=$this->db->query($sql)->result();
			 $json='{"suggestions": [';
			 foreach($result as $a=>$b){
				 $json.='{"value":"'.$b->name.'","data":{"catagory":"In '.ucfirst($b->type).'",
				 "link":"'.bu($b->type.'/'.$b->slug).'",
				 "helper":"'.rtrim(ltrim($b->helper,','),',').'"
				 
				 }},';
				 }
			$json=rtrim($json,',');
			$json.=']}';
			$json=json_encode(array_filter(json_decode($json,true)));
			echo $json; 
			 
			
			 }
}

