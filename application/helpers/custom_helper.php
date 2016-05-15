<?php 

function display_msg($messages,$type='success'){
	if(empty($messages)) return;
	
	switch($type){
		case('success')	:echo '<div class="alert alert-dismissable alert-success" role="alert">	<i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';break;
		case('info')	:echo '<div class="alert alert-dismissable alert-info" role="alert">	<i class="fa fa-info"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';break;
		case('warning')	:echo '<div class="alert alert-dismissable alert-warning" role="alert">	<i class="fa fa-warning"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';break;
		case('danger')	:echo '<div class="alert alert-dismissable alert-danger" role="alert">	<i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';break;
		default		:echo '<div class="alert alert-dismissable alert-success" role="alert">	<i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
		}
	
	if(is_array($messages)){
		foreach($messages as $message){
			echo '<p>'.$message.'</p>';
			}
		}
	else echo $messages;
	echo '</div>';
	}

function hash_it($str=''){
	return hash('sha512',$str.config_item('encryption_key'));
	}

function gen_unique_id($id){
	return $id.'_'.time();
	}
function bu($path){
	return base_url().$path;
	}
function man_sp(){
	
	}

function get_speciality($selected=NULL)		{
	$ci = get_instance();
	$ci->load->helper('security');
	if($selected==NULL)$templ='';
	else 			 $templ='value="'.xss_clean($selected).'"';
	
	$str='<tr><td><div class="speciality_class"><table><tr><td>
	<div class="input-group">
	<span class="input-group-addon">Speciality</span>
	<input autocomplete="off" name="speciality[]" type="text" class="combo_filter" style="height:34px; width:280px" onkeyup="hanle_change(this)" placeholder="Enter  your Speciality" '.$templ.' />
	</div>
	</td><td><div class="dd_btn"></div></td></tr></table><div class="listme">';
    
	$result = $ci->db->query('select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME=\'speciality\' and COLUMN_NAME!=\'id\'')->result();
	if($selected==NULL)
	$str.='<option disabled="disabled" selected="selected">Select speciality</option>';
	foreach($result as $a=>$b){
		$str.='<optgroup label="'.$b->COLUMN_NAME.'">';
		$sql="select `$b->COLUMN_NAME` from speciality";
		
		$results = $ci->db->query($sql)->result();
		$temp=$b->COLUMN_NAME;
		foreach($results as $x=>$y){
			
			if(!empty($y->$temp)){
					$str.="<option class=\"p5\">".$y->$temp."</option>";
				}
			}
		$str.='</optgroup>';
		}
	$str = str_replace("\n", "", $str);
	$str = str_replace("\r", "", $str);
	echo $str;
		
	echo '</div></div></td><td class="reduce_speciality" style=" color:#FF5D5D; cursor:pointer;vertical-align: middle;"><i class="fa fa-fw fa-times-circle"></i> Delete</td></tr>';
	}

function get_education($selected=NULL)		{
	$ci = get_instance();
	$ci->load->helper('security');
	
	if($selected!=NULL){
		$array=explode('<::>',$selected);
		
		$education			=htmlentities($array[0]);
		$institution		=htmlentities($array[1]);
		$year				=htmlentities($array[2]);
		}
	else{
		$education				='';
		$institution			='';
		$year					='';
		}
		
	//education
	$str='<tr><td class="my_td"><div class="speciality_class"><table><tr><td>
	<div class="input-group">
		<span class="input-group-addon">Degree</span>
		<input autocomplete="off" name="education[]" type="text" class="combo_filter" style="height:34px; width:100%" onkeyup="hanle_change(this)" placeholder="Enter  your degree" value="'.$education.'" />
	</div>
	</td>
	<td style="display:table-cell;width: 3%;"><div class="dd_btn" ></div>
	</td></tr></table><div class="listme" style="width:276px">';
    
	$result = $ci->db->query('select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME=\'degree\' and COLUMN_NAME!=\'id\'')->result();
	if($selected==NULL)
	foreach($result as $a=>$b){
		$str.='<optgroup label="'.ucfirst($b->COLUMN_NAME).'">';
		$str.'<option selected="selected" disabled="disabled">Year</option>';
		$sql="select `$b->COLUMN_NAME` from degree";
		
		$results = $ci->db->query($sql)->result();
		$temp=$b->COLUMN_NAME;
		foreach($results as $x=>$y){
			
			if(!empty($y->$temp)){
					$str.="<option class=\"p5\">".stripslashes($y->$temp)."</option>";
				}
			}
		$str.='</optgroup>';
		}
	
	//College/Institution
	$str.='<td  class="my_td"><div class="speciality_class"><table><tr><td>
	<div class="input-group">
		<span class="input-group-addon">Institution</span>
		<input autocomplete="off" name="education[]" type="text" class="combo_filter" style="height:34px; width:100%" onkeyup="hanle_change_ajax(this)" placeholder="Enter  your Institution" value="'.$institution.'" />
	</div>
		</td></tr></table><div class="listme" style="width:260px"></div></td>';
	
	
	
	//Year
	$str.='<td  class="my_td">';
	$str.='
	<select name="education[]" class="form-control">';
	for($i=date('Y');$i>=(date('Y')-70);$i-=1){
		if($i==$year)	$str.='<option selected="selected">'.$i.'</option>';
		else 			$str.='<option>'.$i.'</option>';
		}
	
	$str. '</select>';
	$str.='</td>';
	
	$str = str_replace("\n", "", $str);
	$str = str_replace("\r", "", $str);
	echo $str;
		
	echo '</div></div></td><td class="reduce_speciality my_td" style=" color:#FF5D5D; cursor:pointer;vertical-align: middle;"><i class="fa fa-fw fa-times-circle"></i> Delete</td></tr>';
	}

function get_now()					{
	$time_now=date('H');
	if($time_now>12){
		$maridian='PM';
		}
	else $maridian='AM';
	$hour		=$time_now%12;
	$minute	=date('i')-date('i')%15;
	return $hour.':'.$minute.':'.$maridian;
	}

function generate_shedule_form($this,$id=NULL)	{
	include(bu('doctor_admin/components/sheduleform'));
	}
	
function addOrdinalNumberSuffix($num) 		{
    if (!in_array(($num % 100),array(11,12,13))){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
      }
    }
    return $num.'th';
  }
 
function ghash($time_stamp)				{
	$key=config_item('encryption_key');
	return md5($key.$time_stamp);
	}

function chash($time_stamp,$hash)			{
	$key=config_item('encryption_key');
	if($hash==md5($key.$time_stamp)){
		return true;
		}
	else return false;
	}

function get_experience($selected=NULL)		{
	
	
	if($selected!=NULL){
		$array=explode('<::>',$selected);
		$from				=htmlentities($array[0]);
		$to				=htmlentities($array[1]);
		$role				=htmlentities($array[2]);
		$organization		=htmlentities($array[3]);
		$city				=htmlentities($array[4]);
		}
	else{
		$from				='';
		$to				='';
		$role				='';
		$organization		='';
		$city				='';
		}
	$str='<div class="zebra">';
	
	if($selected==NULL){
		echo '<label class="btn btn-md btn-primary  btn-block firaz">+Add new experience</label>';
		}
	else echo '<label  class="btn btn-md btn-primary btn-block firaz">'.$role.' at '.$organization.'</label>'; 
	
	$str.='<!--Year from -->
		<div class="col-xs-6 col-sm-4 col-md-4">';
	
	$str.='
	<label>Year (From)</label>
	<select name="experience[]" class="form-control">
	<optgroup label="(Year)">
	<option disabled="disabled" selected="selected">Year (From)</option>
	';
	for($i=date('Y');$i>=(date('Y')-70);$i-=1){
		if($i==$from) $str.='<option selected="selected">'.$i.'</option>';
		else $str.='<option>'.$i.'</option>';
		}
	
	$str.='</optgroup></select>';
		
	$str.='</div>
		
		<!--Year to -->
		<div class="col-xs-6 col-sm-4 col-md-4">';
	$str.='
	<label>Year (To)</label>
	<select name="experience[]" class="form-control">
	<optgroup label="(Year)">
	<option disabled="disabled" selected="selected">Year (To)</option>
	';
	for($i=date('Y');$i>=(date('Y')-70);$i-=1){
		if($i==$to) $str.='<option selected="selected">'.$i.'</option>';
		else $str.='<option>'.$i.'</option>';
		}
	
	$str.='</optgroup></select>';	
	$str.='</div>
		
		<!--Role -->
		<div class="col-xs-6 col-sm-4 col-md-4">
		<label>Role</label>
		<input type="text" name="experience[]" class="form-control" placeholder="Enter your role" value="'.$role.'">
		</div>
		
		<!--Organization -->
		<div class="col-xs-6 col-sm-4 col-md-4">
		<label>Organization</label>
		<input type="text" name="experience[]" class="form-control" placeholder="Your Organization" value="'.$organization.'"> 
		</div>
		
		<!--City -->
		<div class="col-xs-6 col-sm-4 col-md-4">
		<label>City</label>
		<input type="text" name="experience[]" class="form-control" placeholder="Enter City" value="'.$city.'">
		</div>
		
		<!--Delete -->
		<div class="col-xs-6 col-sm-4 col-md-4">
			<i class="fa fa-fw fa-times-circle" style=" color:#FF5D5D; cursor:pointer;margin-top: 35px;width: 100%;text-align: left;"
			 onclick="$(this).parent().parent().prev().remove();$(this).parent().parent().remove();">&nbsp;&nbsp;&nbsp;Delete this experience</i> 
		</div>
		<br>
		
		</div>
		
		';
	$str = str_replace("\n", "", $str);
	$str = str_replace("\r", "", $str);
	echo $str;
	}

function get_achivements($selected=NULL)		{
	
	if($selected!=NULL){
		$array=explode('<::>',$selected);
		$awards			=htmlentities($array[0]);
		$year				=htmlentities($array[1]);
		}
	else{
		$awards			='';
		$year				='';
		}
		
	$str='<div>';
	$str.=' <div class="col-sm-5">
			<div class="input-group">
			<span class="input-group-addon">Achivement</span>
		  		<input type="text" name="achivements[]" class="form-control" placeholder="Any awards or achivements" value="'.$awards.'">
			</div>
		  </div>
		  <div class="col-sm-4">
		  <div class="input-group">
		  <span class="input-group-addon">Year</span>
		  <select name="achivements[]" class="form-control">
			<optgroup label="Year">
			<option selected="selected" disabled="disabled">Year</option>
			';
			for($i=date('Y');$i>=(date('Y')-70);$i-=1){
				if($i==$year) $str.='<option selected="selected">'.$i.'</option>';
				else $str.='<option>'.$i.'</option>';
				}
	
	$str.='</optgroup></select>
	</div>
	';
		  
	$str.='</div>
		  <div class="col-sm-3">
		  <i class="fa fa-fw fa-times-circle" style=" color:#FF5D5D; cursor:pointer;margin-top: 10px;width: 100%;text-align: left;"
			 onclick="$(this).parent().parent().remove();">&nbsp;&nbsp;&nbsp;Delete</i> 
		  </div>
	<br  clear="all"></div>';
		  
		  
	$str = str_replace("\n", "", $str);
	$str = str_replace("\r", "", $str);
	echo $str;
	}
	
function get_registration($selected=NULL)		{
	if($selected!=NULL){
		$array=explode('<::>',$selected);
		
		$registration		=htmlentities($array[0]);
		$year				=htmlentities($array[1]);
		$council			=htmlentities($array[2]);
		}
	else{
		$registration			='';
		$year					='';
		$council				='';
		}
	$str='<div style="margin-bottom:10px">';
	$str.='
		<div class="col-sm-6">
		<div class="input-group">
			<span class="input-group-addon">Reg Number</span>
			<input type="text" name="registration[]" class="form-control" placeholder="Registration number" value="'.$registration.'">
		</div>
		</div>
		<div class="col-sm-6">
		<div class="input-group">
			<span class="input-group-addon">Year</span>
			<select name="registration[]" class="form-control">
			<optgroup label="Year">
			<option selected="selected" disabled="disabled">Year</option>
			';
			for($i=date('Y');$i>=(date('Y')-70);$i-=1){
				if($i==$year) $str.='<option selected="selected">'.$i.'</option>';
				else $str.='<option>'.$i.'</option>';
				}
	
	$str.='</optgroup></select>
	</div>
	</div>
		<div class="col-sm-6">
		
		<table style="width:100%">
		<tr>
			<td>
			<div class="input-group">
				<span class="input-group-addon">Reg council &nbsp;</span>
				<input autocomplete="off" name="registration[]" type="text" class="combo_filter form-control" onkeyup="hanle_change_ajax_registration(this)" placeholder="Registration council" value="'.$council.'" />
			<div>
			</td>
		</tr>
		</table>
		<div class="listme"></div>
		
		</div>
		<div class="col-sm-3"></div>
		<div class="col-sm-3">
			<i class="fa fa-fw fa-times-circle" style=" color:#FF5D5D; cursor:pointer;margin-top: 10px;width: 100%;text-align: left;"
			 onclick="$(this).parent().parent().remove();">&nbsp;&nbsp;&nbsp;Delete</i> 
		</div>';
	$str.='<br clear="all"></div>';
	$str = str_replace("\n", "", $str);
	$str = str_replace("\r", "", $str);
	echo $str;
	}

function get_membership($membership=NULL)		{
	$membership=htmlentities($membership);
	$str='<div>';
	$str.='<div class="col-sm-9">
		
		<table style="width: 100%;"><tr><td>
		<div class="input-group">
			<span class="input-group-addon">Membership</span>
			<input autocomplete="off" name="membership[]" type="text" class="combo_filter form-control" onkeyup="hanle_change_ajax_membership(this)" placeholder="Membership" value="'.$membership.'" />
		</div>
		
		</td>
		</tr></table>
		<div class="listme" style="width:100%"></div>
		
		</div>
		
		<div class="col-sm-3">
			<i class="fa fa-fw fa-times-circle" style=" color:#FF5D5D; cursor:pointer;margin-top: 10px;width: 100%;text-align: left;"
			 onclick="$(this).parent().parent().remove();">&nbsp;&nbsp;&nbsp;Delete</i> 
		</div>';
	$str.='<br clear="all"></div>';
	$str = str_replace("\n", "", $str);
	$str = str_replace("\r", "", $str);
	echo $str;
	
	}
	
function get_service($service=NULL)			{
	$service=htmlentities($service);
	$str='<div>';
	$str.='<div class="col-sm-5">
		
		<table style="width: 100%;"><tr><td>
		<div class="input-group">
			<span class="input-group-addon">Service</span>
			<input autocomplete="off" name="service[]" type="text" class="combo_filter form-control" onkeyup="hanle_change_ajax_service(this)" placeholder="Service" value="'.$service.'" />
		</div>
		
		</td>
		</tr></table>
		<div class="listme" style="width:100%"></div>
		
		</div>
		
		<div class="col-sm-1">
			<i class="fa fa-fw fa-times-circle" style=" color:#FF5D5D;margin-left: -25px; cursor:pointer;margin-top: 10px;width: 100%;text-align: left;"
			 onclick="$(this).parent().parent().remove();">&nbsp;&nbsp;&nbsp;Delete</i> 
		</div>';
	$str.='</div>';
	$str = str_replace("\n", "", $str);
	$str = str_replace("\r", "", $str);
	echo $str;
	
	}

function get_clinic_address($id=NULL)		{
	$id=mysql_real_escape_string($id);
	$ci = get_instance();
	$result=$ci->db->query("SELECT * FROM clinic WHERE id='$id' LIMIT 1")->result();
	$row=$result[0];
	$address='';
	
	$address.='<strong><a href="'.bu('clinics/'.$row->slug).'"><h4><i class="fa fa-fw fa-hospital-o color_th"></i>'.$row->name.'</h4></a></strong>';
	if(!empty($row->landmark)) 	$address.=$row->landmark.',<br>';
	if(!empty($row->street)) 	$address.=$row->street.',';
	if(!empty($row->locality)) 	$address.=$row->locality.',';
	if(!empty($row->city)) 		$address.=$row->city.',<br>';
	if(!empty($row->district)) 	$address.=$row->district.',';
	if(!empty($row->state)) 	$address.=$row->state.',<br>';
	if(!empty($row->pin)) 		$address.=$row->pin;
	if(!empty($row->longitude) and !empty($row->latitude)) 		{
		$address.='<br>';
		$address.='<button class="btn btn-success btn-sm btn-flat" data-toggle="modal" data-clinic_name='.$row->name.' data-target="#myMapModal" data-longitude="'.$row->longitude.'" data-latitude="'.$row->latitude.'" onclick="open_map($(this))">
		<i class="fa fa-fw fa-map-marker"></i> View on map</button>';
		}
	
	return $address;
	
	}

function get_clinic_timing_for_clinic($id=NULL)		{
	if($id==NULL) return;
	$ci = get_instance();
	$ci->load->model('clinic_m');
	$result=$ci->clinic_m->get($id,true);
	$json=json_decode($result->timing,true);
	if(empty($json)) $json=array();
	//Get the unique timing
	$trial_array=array();
	foreach($json as $a=>$b){
		$trial_array[$a]=json_encode($b);
		}
	$parent_days=array_unique($trial_array);
	$same_days=array();
	
	$days_array=array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
	
	$days_cumulative_array=array();
	
	foreach($parent_days as $a=>$b){
		$temp_holder=array();
		foreach($trial_array as $x=>$y){
			if($b==$y){
				$temp_holder[]=$x; 
				}
			}
		$days_cumulative_array[]=$temp_holder;
		}
	$m_str='<div class="row" >'; 
	foreach($days_cumulative_array as $index=>$days){ 
		$str='<div class="col-lg-12  no-pad sm-pad" style="font-size:10px">';
		$str.='<div class="btn-group" style="margin-top: 10px;">';
		foreach($days as $a=>$b){
			if($b=='thursday')
				$str.='<button type="button" class="btn btn-info bg-purple  less_pad">'.substr($b,0,4).'</button>'; 
				else $str.='<button type="button" class="btn btn-info bg-purple less_pad">'.substr($b,0,3).'</button>'; 
			}
		$str.='</div>';		
		$str.='<br>';
		$str.=$json[$days[0]][0]['start'].' to '.$json[$days[0]][0]['end'];
		if(isset($json[$days[0]][1]['start'])) $str.='<br>'.$json[$days[0]][1]['start'].' to '.$json[$days[0]][1]['end'];
		
		//var_dump($json);
		'<span class="sm_text">11:00:AM - 01:00:PM</span>';
		$str.='</div>';
		$m_str.=$str;
		}
	$m_str.='</div>';
	echo $m_str;
	return;
	$unique_id=array_unique($array);
	$shedule=array();
	foreach($unique_id as $a=>$b){
		$shedule[]=$b;
		}
	$m_str='<div class="row" >';
	foreach($shedule as $a=>$b){
		if($b!=0){
		//$str='<div class="col-lg-12 col-md-4 col-sm-4 col-xs-6 no-pad">';
		$str='<div class="col-lg-12  no-pad sm-pad">';
		$str.='<div class="btn-group" style="margin-top: 10px;">';
		foreach($array as $i=>$j){
			if($j==$b and $j!=0){
				if($i=='thursday')
				$str.='<button type="button" class="btn btn-info bg-purple  less_pad">'.substr($i,0,4).'</button>'; 
				else $str.='<button type="button" class="btn btn-info bg-purple less_pad">'.substr($i,0,3).'</button>'; 
				}
				
			}
		$m_str.=$str.'</div>'; 
		$result_s	=$ci->db->query('SELECT * FROM shedule WHERE id='.$b)->result();
		if(isset($result_s[0])){
		$row_s	=$result_s[0];
			}
		
		$json=json_decode($row_s->json,true);
		foreach($json as $y=>$z){
			$m_str.='<br><span class="sm_text">'.$z['start'].' - '.$z['end'].'</span>';;
			}
		$m_str.='</div>';
		}	
		}
		
	echo $m_str.'</div>';
	
	
	}
	
function get_clinic_timing($id=NULL,$doctor_id=NULL)		{
	$ci = get_instance();
	$result=$ci->db->query("SELECT sunday,monday,tuesday,wednesday,thursday,friday,saturday FROM clinic WHERE id='$id' LIMIT 1")->result();
	$row=$result[0];
	$array =  (array) $row;
	
	foreach($array as $a=>$b){
		$json=json_decode($b,true);
		if(isset($json[$doctor_id])){
			$array[$a]=$json[$doctor_id];
			}
		}
		
	
	$unique_id=array_unique($array);
	$shedule=array();
	foreach($unique_id as $a=>$b){
		$shedule[]=$b;
		}
	$m_str='<div class="row" >';
	foreach($shedule as $a=>$b){
		if($b!=0){
		//$str='<div class="col-lg-12 col-md-4 col-sm-4 col-xs-6 no-pad">';
		$str='<div class="col-lg-12  no-pad sm-pad">';
		$str.='<div class="btn-group" style="margin-top: 10px;">';
		foreach($array as $i=>$j){
			if($j==$b and $j!=0){
				if($i=='thursday')
				$str.='<button type="button" class="btn btn-info bg-purple  less_pad">'.substr($i,0,4).'</button>'; 
				else $str.='<button type="button" class="btn btn-info bg-purple less_pad">'.substr($i,0,3).'</button>'; 
				}
				
			}
		$m_str.=$str.'</div>'; 
		$result_s	=$ci->db->query('SELECT * FROM shedule WHERE id='.$b)->result();
		if(isset($result_s[0])){
		$row_s	=$result_s[0];
			}
		
		$json=json_decode($row_s->json,true);
		foreach($json as $y=>$z){
			$m_str.='<br><span class="sm_text">'.$z['start'].' - '.$z['end'].'</span>';;
			}
		$m_str.='</div>';
		}	
		}
		
	echo $m_str.'</div>';
	
	
	}
	
	function get_day($json,$id){
		$json=json_decode($json,true);
		if(isset($json[$id]))
		return $json[$id];
		}
	
	function generate_appointment_sheet($date=NULL,$clinic_id=NULL,$blue=NULL){ 
		$ci = get_instance();
		if($date==NULL){$date=date('m/d/y');}
		if($clinic_id==NULL) return;
		$doctor_id=$ci->session->userdata('id');
		$day=$date;
		$day_name=strtolower(date('l',strtotime($day)));
		$next_day=date('m/d/y',strtotime($day)+(24*3600));
		$next_2_day=date('m/d/y',strtotime($day)+(48*3600));
		$sql="SELECT * FROM appointment WHERE (time BETWEEN ".strtotime($day)." AND  ".strtotime($next_day).") AND doctor_id=".$ci->session->userdata('id').' AND clinic_id='.$clinic_id.' ORDER BY booking_time';
		$appointments=$ci->db->query($sql)->result();
		
		
		$sql="SELECT $day_name,time FROM clinic WHERE id=$clinic_id";
		$clinic_details=$ci->db->query($sql)->result();
		$clinic_details=$clinic_details[0];
		$time_doc=json_decode($clinic_details->time,true);
		if(isset($time_doc[$ci->session->userdata('id')])){
			$time_doc=$time_doc[$ci->session->userdata('id')];
			}
		else $time_doc=5;
		 
		//-------------------------------------------------------------------------------------
		$html='<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    	<!-- 1st appointment holder -->';
		if($blue) $html.='<div class="box box box-solid bg-blue-gradient">';
		else 	  $html.='<div class="box box box-solid bg-green-gradient">';
        
            $html.='<div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-calendar"></i> '.date('d/m/y',strtotime($day)).'
                <small style="color:#fff"> &nbsp;&nbsp;&nbsp; <i class="fa fa-fw fa-table"></i> '.sizeof($appointments).' Appointments</small>
                </h3>
            </div>
            <div class="box-body aqua_li">
            <ol>
            	';
			
		$shedule_id=json_decode($clinic_details->$day_name,true);
		
		if(isset($shedule_id[$ci->session->userdata('id')])){
			$shedule_id=$shedule_id[$ci->session->userdata('id')];
			}
		else $html.= '<h4>Clinic is closed on this day</h4>';
		
		$sql="SELECT * FROM shedule WHERE id=$shedule_id LIMIT 1";
		$shedule=$ci->db->query($sql)->result();
		if(sizeof($shedule)){
			$shedule=$shedule[0];
			$shedule_json=json_decode($shedule->json,true);
			foreach($shedule_json as $a=>$b){
				$start_time=$b['start'];
				
				$end_time=$b['end'];
				
				
				$html.='<h4>From '.$start_time.' to '.$end_time.'</h4>';
				
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
				
				$counter=0;
				
				$number_of_visit=strval($increment/($time_doc*60));
				
				for($ii=$start_time; $ii<$end_time;$ii+=$increment){
					$html.= '<td><u>'.date('h:i a',$ii).'</u></td>';
					$html.=generate_li_items($number_of_visit,$ii,$increment,$appointments,$ii);
					for($j=0;$j<$number_of_visit;$j++){}
					$counter+=1;
					} 
				}
			}
		echo $html.=' 
            </ol>
            </div><!-- /.box-body -->
        </div>
    </div> 
    '; 
	
	//-------------------------------------------------------------------------------------
	
	}
	
	function generate_li_items($number_of_visit,$ii,$increment,$appointments,$timestamp){
		//$number_of_visit=$number_of_visit+3;
		$html='';
		$r_1=$ii;
		$r_2=$ii+$increment;
		$temp_array=array();
		foreach($appointments as $a=>$b){
			if($b->time>=$r_1 and $b->time<$r_2){
				$temp_array[]=$b;
				}
			} 
		$difference_in_size=($number_of_visit-sizeof($temp_array));
		if($difference_in_size<0) $difference_in_size=0;
		if($difference_in_size){
			for($x=0;$x<$difference_in_size;$x++){
				$temp_array['empty_'.$x]='';
				}
			}
		foreach($temp_array as $a=>$b){
			if(is_numeric($a)){
				$html.='<li><table class="sheet_table" >';
				$html.='<td><strong>'.$b->name.'</strong></td>';
				$html.='<td>'.$b->phone.'</td>';
				$html.='<td>';
				$html.='<span class="complete_btn">
				<i class="glyphicon glyphicon-step-forward btn btn-xs" title="Complete this Appointment" data-app_id="'.$b->id.'"
				onclick="complete_appointment($(this))"></i></span>';
				$html.='<i class="glyphicon glyphicon-trash btn btn-xs" title="Delete this appointment" data-app_id="'.$b->id.'"
				onclick="if(confirm(\'Are you sure?\')) delete_appointment($(this))"></i>';
				$html.='<i class="glyphicon glyphicon-open btn btn-xs" 
				data-toggle="modal" data-target=".bs-example-modal-lg" title="See patient past records" 
				onclick="patient_details($(this))" data-phone="'.$b->phone.'" 
				data-name="'.$b->name.'" data-email="'.$b->email.'"></i>';
					
				$html.='</td>';
				$html.='</table></li>';
				}
			else {
				$html.='<li><table class="sheet_table" >';
				$html.='<td></td>';
				$html.='<td></td>';
				$html.='<td><i data-timestamp="'.$timestamp.'" class="glyphicon glyphicon-plus btn btn-xs btn-default btn-block" 
				onclick="add_adder($(this))">Add</i></td>';
				$html.='</table><div class="msg_content"></div></li>';
				}
			}
		
		return $html;
		}
		
		function sql_filter($str){
			return mysql_real_escape_string($str);
			}
		function url_exists($url) {
			if (!$fp = curl_init($url)) return false;
			return true;
		}
	function get_doctor_speciality($doctor_data){
		$speciality=array_filter(explode(',',$doctor_data->speciality_parent));
		$str='';
		foreach($speciality as $a=>$b){
			$str.='<a href="'.bu('search/doctors/Select City/'.$b.'/NULL/NULL/0').'"><li>'.$b.'</li></a>';
			}
		$str.="<div class='review_zone'>";
		$str.='<div>
				<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
				<span id="recomendation">'.$doctor_data->like.'</span>
				<small> Recomendations</small>
			</div>';
		$str.='<div>
			<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
			<span id="recomendation">'.$doctor_data->review_count.'</span>
			<small> Rewiews</small>
		</div>';
		$str.='<div class="star_holder" data-container="body" data-toggle="popover" data-placement="bottom" 
        data-content="'.$doctor_data->rating.'Star" data-trigger="hover">
            <div class="disabled_stars"></div>
            <div class="stars" style=" width:'.(($doctor_data->rating/5)*100).'%"></div>
        </div>';
		$str.='</div>';
		echo $str;
		}
	
	function filter_pid($pid){ 
		$ci = get_instance();
		$pid=sql_filter($pid);
	
		$id=$ci->session->userdata('id');
		//Check if the patient belongs to the doctor
		$sql="SELECT id FROM patient WHERE doctors like '%,$id,%' and id='$pid'";
		$num_rows=$ci->db->query($sql)->num_rows();
		
		if(!$num_rows) {show_404();return;}
		
		}
		
	
		
	function counter_show_teeth(){
		$html='<input type="hidden" class="special_note">';
		$html.='
		<div class="col-xs-12 no-pad" align="left">
			<input type="checkbox" class="multiply" > Multiply Cost &nbsp;&nbsp;&nbsp;&nbsp;
			
			<input type="checkbox" class="select_all_teeth"> Full Mouth
			<button class="btn btn-xs btn-success pull-right" onclick="close_holder()">Done</button>
			<hr>
			<div  style="margin:10px 0"></div>
			<div class="col-xs-6" align="right">
				<div class="btn-group">';
				for($i=18;$i>=11;$i--){
					$html.='<button type="button" data-id="'.$i.'" class="btn btn-default btn-sm tooth_numbers">'.$i.'</button>';
					}
					
					
		$html.='</div>
			</div>
			<div class="col-xs-6" align="left">';
			for($i=21;$i<=28;$i++){
					$html.='<button type="button" data-id="'.$i.'" class="btn btn-default btn-sm tooth_numbers">'.$i.'</button>';
					}
		$html.='</div>
		<br clear="all">
		<div class="col-xs-6" align="right">
				<div class="btn-group" style="margin-bottom:7px">';
				for($i=48;$i>=41;$i--){
					$html.='<button type="button" data-id="'.$i.'" class="btn btn-default btn-sm tooth_numbers">'.$i.'</button>';
					}
					
					
		$html.='</div>
			</div>
			<div class="col-xs-6" align="left">';
			for($i=31;$i<=38;$i++){
					$html.='<button type="button" data-id="'.$i.'" class="btn btn-default btn-sm tooth_numbers">'.$i.'</button>';
					}
		$html.='</div>
		<br clear="all">
		<div align="center"><a href="" onclick="event.preventDefault();$(this).next().slideToggle(200)">Show Child Teeth</a>
			<div class="col-xs-12 no-pad" style="display:none">
				<div class="col-xs-6" align="right">';
				for($i=55;$i>=51;$i--){
						$html.='<button type="button" data-id="'.$i.'" class="btn btn-default btn-sm tooth_numbers">'.$i.'</button>';
						}
				$html.='
				</div>
				<div class="col-xs-6" align="left">';
				for($i=61;$i<=65;$i++){
						$html.='<button type="button" data-id="'.$i.'" class="btn btn-default btn-sm tooth_numbers">'.$i.'</button>';
						}
				$html.='
				</div>
				<br clear="all">
				<div class="col-xs-6" align="right">';
				for($i=85;$i>=81;$i--){
						$html.='<button type="button" data-id="'.$i.'" class="btn btn-default btn-sm tooth_numbers">'.$i.'</button>';
						}
				$html.='
				</div>
				<div class="col-xs-6" align="left">';
				for($i=71;$i<=75;$i++){
						$html.='<button type="button" data-id="'.$i.'" class="btn btn-default btn-sm tooth_numbers">'.$i.'</button>';
						}
				$html.='
				</div>
			</div>
		
		</div>
		
		
		</div>
		<br><br> ';
		
		echo  preg_replace('/^\s+|\n|\r|\s+$/m', '',$html); 
		
		}
	
	function get_dp($p_data){ 
		$img_src='';
		if(file_exists('patients/'.$p_data->id.'/dp.jpg')) $img_src='patients/'.$p_data->id.'/dp.jpg';
		else{
			if($p_data->gender=='M') $img_src =bu('images/avatar5.png');
			else if($p_data->gender=='F') $img_src= bu('images/avatar_lady.jpg');
			else  $img_src =bu('images/user.png');
			} 
    	return $img_src;
		}
	
	function get_dob($p_data){ 
		return @date_diff(date_create(str_replace('/','-',$p_data->dob)), date_create('today'))->y; 
		}
	
	function get_optional_id($p_data){ 
		$ci = get_instance();
		@$json=json_decode($p_data->optional_id,true);  
		return @$json[$ci->session->userdata('id')];
	}
	
	function generate_dummy_html_by_name($name='prescription'){
		switch($name){
			case('prescription'):
				return '<div class="dummy_data"> <div><strong>Prescription</strong> 
				<span style="float: right;">Date:'.date('d-M-Y').'</span>
				 <br/>
</div>
<div>
  <div> </div>
  <br/>
  <div>
    <table width="100%" class="table table-bordered">
      <thead>
        <tr>
          <th> </th>
          <th> Drug Name </th>
          <th> Strength </th>
          <th> Frequency </th>
          <th> Instructions </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td width="2%"> 1. </td>
          <td width="25%"> Tablet <strong>Crocin</strong> <br/>
            6 tablets </td>
          <td> 100 mg </td>
          <td><table>
              <tbody>
                <tr>
                  <td> 2 </td>
                  <td> - </td>
                  <td> 0 </td>
                  <td> - </td>
                  <td> 1 </td>
                </tr>
                <tr>
                  <td> Morning </td>
                  <td></td>
                  <td> Afternoon </td>
                  <td></td>
                  <td> Night </td>
                </tr>
              </tbody>
            </table></td>
          <td> 2 day(s) <br/>
            Before Food <br/>
            <pre>Need to take 3 units a day</pre></td>
        </tr>
        <tr>
          <td width="2%"> 2. </td>
          <td width="25%"> Tablet <strong>Nisep</strong> <br/>
            30 tablets </td>
          <td> 200 ml </td>
          <td><table>
              <tbody>
                <tr>
                  <td> 1 </td>
                  <td> - </td>
                  <td> 1 </td>
                  <td> - </td>
                  <td> 3 </td>
                </tr>
                <tr>
                  <td> Morning </td>
                  <td></td>
                  <td> Afternoon </td>
                  <td></td>
                  <td> Night </td>
                </tr>
              </tbody>
            </table></td>
          <td> 6 day(s) <br/>
            After Food <br/>
            <pre></pre></td>
        </tr>
      </tbody>
    </table>
    <br/>
    <pre> <strong>General Instructions : </strong> Sample Instruction for Prescription </pre>
  </div>
</div></div>
';
				break;
			case('treatment_plans'):
			return '<div>
    <strong>Treatment Plan</strong>
    <div style="float:right">
        Date: '.date('d-M-Y').'
    </div>
    <br/>
</div>
<div>
    <div>
        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            Treatment
                        </th>
                        <th>
                            Notes
                        </th>
                        <th>
                            Cost
                            <br/>
                            INR
                        </th>
                        <th>
                            Discount
                            <br/>
                            INR
                        </th>
                        <th>
                            After discount
                            <br/>
                            INR
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Sample Treatment Category
                        </td>
                        <td>
                            Sample Treatment Plan Description
                            <br/>
                            Teeth: 13|11|10
                        </td>
                        <td>
                            600.00
                        </td>
                        <td>
                            180.00
                        </td>
                        <td>
                            420.00
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Sample Treatment Category
                        </td>
                        <td>
                            Sample Treatment Plan Description
                            <br/>
                            Teeth: 23|22
                        </td>
                        <td>
                            1,500.00
                        </td>
                        <td>
                            300.00
                        </td>
                        <td>
                            1,200.00
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody style="text-align: right;">
                    <tr>
                        <td>
                            Estimated Amount:
                        </td>
                        <td>
                            2,100.00 INR
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Total Discount:
                        </td>
                        <td>
                            480.00 INR
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Grand Total:
                        </td>
                        <td>
                            1,620.00 INR
                        </td>
                    </tr>
                </tbody>
            </table>
            <div>
                *Taxes as applicable
            </div>
        </div>
    </div>
</div>';

			case('case_sheet'):
			return '<div class="datewise-container">
  <div class="entity-contianer">
    <div><span class="header-text  green-text">Receipt</span>
      <div class="entity-date date typename"><span class="text">Date:</span> <span class="name">28 Mar, 2015</span></div>
    </div>
    <div class="payment typename">
      <div class="payment-info">
        <div class="entity-info"><span class="text">Receipt Number:</span> <span class="name">REC101</span></div>
        <p class="topbottompadding_1em">Received with thanks, amount of 1,300.00 INR towards the following :</p>
        <div class="entity-contianer">
          <div>
            <div class="entity-info"><span class="text">Date:</span> <span class="name">28 Mar, 2015</span></div>
          </div>
          <div class="typename">
            <div class="details">
              <div class="payment-info">
                <div class="entity-info"><span class="text">Invoice Number:</span> <span class="name">INV006</span></div>
                <table class="pr_table clearboth table table-bordered">
                  <thead>
                    <tr>
                      <th class="text-left " width="5%">#</th>
                      <th class="text-left " width="40%">Treatments &amp; Products</th>
                      <th class="text-right cost-width cost">Unit Cost INR</th>
                      <th class="text-right" width="30">Qty</th>
                      <th class="text-right cost-width discount">Discount INR</th>
                      <th class="text-right cost-width tax">Tax INR</th>
                      <th class="text-right cost-width totalcost">Total Cost INR</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="topborder">
                      <td class=" text-left">1.</td>
                      <td class=" text-left ">Treatment Category Example</td>
                      <td class="text-right cost">200.00</td>
                      <td class="text-right">2</td>
                      <td class="text-right discount">80.00</td>
                      <td class="text-right tax">55.94</td>
                      <td class="text-right totalcost">375.94</td>
                    </tr>
                    <tr class="nopadding">
                      <td>&nbsp;</td>
                      <td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label>
                        Treatment Plan Item Note</td>
                    </tr>
                    <tr class="topborder">
                      <td class=" text-left">2.</td>
                      <td class=" text-left ">Consultation</td>
                      <td class="text-right cost">500.00</td>
                      <td class="text-right">5</td>
                      <td class="text-right discount">750.00</td>
                      <td class="text-right tax">216.30</td>
                      <td class="text-right totalcost">1,966.30</td>
                    </tr>
                    <tr class="nopadding">
                      <td>&nbsp;</td>
                      <td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label>
                        Invoice Detail Item Note</td>
                    </tr>
                    <tr>
                      <td colspan="1">&nbsp;</td>
                      <td colspan="6"><table class="total_summary">
                          <tbody>
                            <tr>
                              <td class="text-right padding2 topborder">Total Cost:</td>
                              <td class="text-right bold padding2 topborder">2,900.00 INR</td>
                            </tr>
                            <tr>
                              <td class="text-right padding2">Total Discount:</td>
                              <td class="text-right bold padding2">830.00 INR</td>
                            </tr>
                            <tr>
                              <td class="text-right padding2">Total Tax:</td>
                              <td class="text-right bold padding2">272.24 INR</td>
                            </tr>
                            <tr>
                              <td class="text-right padding2">Grand Total:</td>
                              <td class="text-right bold padding2">2,342.24 INR</td>
                            </tr>
                            <tr>
                              <td class="text-right padding2">Amount Received on 28 Mar, 2015:</td>
                              <td class="text-right bold padding2">200.00 INR</td>
                            </tr>
                            <tr>
                              <td class="text-right padding2">Balance Amount:</td>
                              <td class="text-right bold padding2">2,342.24 INR</td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <br class="clearboth" />
        <div>
          <div>Mode of Payment :</div>
        </div>
      </div>
    </div>
  </div>
  <div class="entity-contianer">
    <div><span class="header-text  green-text">Treatment Plan</span>
      <div class="entity-date date typename"><span class="text">Date:</span> <span class="name">28 Mar, 2015</span></div>
    </div>
    <div class="treatmentplan typename">
      <div class="details">
        <div class="treatment-info">
          <table class="table pr_table table table-bordered">
            <thead class="">
              <tr>
                <th class="treatment text-left">Treatment</th>
                <th class="notes text-left">Notes</th>
                <th class="cost-width text-right">Cost <br />
                  INR</th>
                <th class="cost-width text-right">Discount <br />
                  INR</th>
                <th class="cost-width text-right">After discount<br />
                  INR</th>
              </tr>
            </thead>
            <tbody>
              <tr class="">
                <td class="bottomborder">Sample Treatment Category</td>
                <td class="bottomborder">Sample Treatment Plan Description <br />
                  Teeth: 13|11|10</td>
                <td class="text-right bottomborder">600.00</td>
                <td class=" text-right bottomborder">180.00</td>
                <td class=" text-right bottomborder">420.00</td>
              </tr>
              <tr class="">
                <td class="bottomborder">Sample Treatment Category</td>
                <td class="bottomborder">Sample Treatment Plan Description <br />
                  Teeth: 23|22</td>
                <td class="text-right bottomborder">1,500.00</td>
                <td class=" text-right bottomborder">300.00</td>
                <td class=" text-right bottomborder">1,200.00</td>
              </tr>
            </tbody>
          </table>
          <table class="total_summary">
            <tbody>
              <tr>
                <td class=" text-right">Estimated Amount:</td>
                <td class="text-right bold">2,100.00 INR</td>
              </tr>
              <tr>
                <td class=" text-right bottomborder">Total Discount:</td>
                <td class=" text-right bottomborder bold">480.00 INR</td>
              </tr>
              <tr>
                <td class=" text-right">Grand Total:</td>
                <td class=" text-right bold">1,620.00 INR</td>
              </tr>
            </tbody>
          </table>
          <div class="clearboth">*Taxes as applicable</div>
        </div>
      </div>
    </div>
  </div>
  <div class="entity-contianer">
    <div>
      <div class="entity-date date typename"><span class="text">Date:</span> <span class="name">28 Mar, 2015</span></div>
    </div>
    <div class="typename">
      <div class="payment-info">
        <table class="pr_table soap_table">
          <tbody>
            <tr class="nopadding">
              <td class="borderbottom" width="10%">Complaint</td>
              <td class="borderbottom" width="90%"><ul>
                  <li>
                    <pre>This is a sample complaint</pre>
                  </li>
                </ul></td>
            </tr>
            <tr class="nopadding">
              <td class="borderbottom" width="10%">Observation</td>
              <td class="borderbottom" width="90%"><ul>
                  <li>
                    <pre>This is a sample observation</pre>
                  </li>
                </ul></td>
            </tr>
            <tr class="nopadding">
              <td class="borderbottom" width="10%">Investigation</td>
              <td class="borderbottom" width="90%"><ul>
                  <li>
                    <pre>This is a sample investigation</pre>
                  </li>
                </ul></td>
            </tr>
            <tr class="nopadding">
              <td class="borderbottom" width="10%">Diagnosis</td>
              <td class="borderbottom" width="90%"><ul>
                  <li>
                    <pre>This is a sample diagnosis</pre>
                  </li>
                </ul></td>
            </tr>
            <tr class="nopadding">
              <td class="borderbottom" width="10%">Note</td>
              <td class="borderbottom" width="90%"><ul>
                  <li>
                    <pre>This is a sample treatmentnote</pre>
                  </li>
                </ul></td>
            </tr>
          </tbody>
        </table>
      </div> 
    </div>
  </div>
  <div class="entity-contianer">
    <div><span class="entity-date date typename"><span class="text">Date:</span> <span class="name">28 Mar, 2015</span></span><span class="header-text  green-text">Prescription (℞)</span></div>
    <div class="typename">
      <div class="entity-info">&nbsp;</div>
      <br />
      <div>
        <table width="100%" class="table table-bordered">
          <thead>
            <tr>
              <th>&nbsp;</th>
              <th>Drug Name</th>
              <th>Strength</th>
              <th>Frequency</th>
              <th>Instructions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td width="2%">1.</td>
              <td width="25%">Tablet <strong>Crocin</strong> <br />
                6 tablets</td>
              <td>100 mg</td>
              <td><table>
                  <tbody>
                    <tr>
                      <td>2</td>
                      <td>-</td>
                      <td>0</td>
                      <td>-</td>
                      <td>1</td>
                    </tr>
                    <tr>
                      <td>Morning</td>
                      <td>&nbsp;</td>
                      <td>Afternoon</td>
                      <td>&nbsp;</td>
                      <td>Night</td>
                    </tr>
                  </tbody>
                </table></td>
              <td>2 day(s) <br />
                Before Food <br />
                <pre>Need to take 3 units a day</pre></td>
            </tr>
            <tr>
              <td width="2%">2.</td>
              <td width="25%">Tablet <strong>Nisep</strong> <br />
                30 tablets</td>
              <td>200 ml</td>
              <td><table>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>-</td>
                      <td>1</td>
                      <td>-</td>
                      <td>3</td>
                    </tr>
                    <tr>
                      <td>Morning</td>
                      <td>&nbsp;</td>
                      <td>Afternoon</td>
                      <td>&nbsp;</td>
                      <td>Night</td>
                    </tr>
                  </tbody>
                </table></td>
              <td>6 day(s) <br />
                After Food <br />
                <pre>Should be taken just After Food</pre></td>
            </tr>
          </tbody>
        </table>
        <br />
        <p>&nbsp;</p>
        <pre> <strong>General Instructions : </strong> Sample Instruction for Prescription </pre>
        <p>&nbsp;</p>
      </div>
    </div>
  </div>
</div>
<div class="datewise-container">
  <div class="entity-contianer">
    <div><span class="header-text  green-text">Invoice</span>
      <div class="entity-date date typename"><span class="text">Date:</span> <span class="name">29 Mar, 2015</span></div>
    </div>
    <div class="typename">
      <div class="details">
        <div class="payment-info">
          <div class="entity-info"><span class="text">Invoice Number:</span> <span class="name">INV006</span></div>
          <table class="pr_table clearboth table table-bordered">
            <thead>
              <tr>
                <th class="text-left " width="5%">#</th>
                <th class="text-left " width="40%">Treatments &amp; Products</th>
                <th class="text-right cost-width cost">Unit Cost INR</th>
                <th class="text-right" width="30">Qty</th>
                <th class="text-right cost-width discount">Discount INR</th>
                <th class="text-right cost-width tax">Tax INR</th>
                <th class="text-right cost-width totalcost">Total Cost INR</th>
              </tr>
            </thead>
            <tbody>
              <tr class="topborder">
                <td class=" text-left">1.</td>
                <td class=" text-left ">Treatment Category Example</td>
                <td class="text-right cost">200.00</td>
                <td class="text-right">2</td>
                <td class="text-right discount">80.00</td>
                <td class="text-right tax">55.94</td>
                <td class="text-right totalcost">375.94</td>
              </tr>
              <tr class="nopadding">
                <td>&nbsp;</td>
                <td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label>
                  Treatment Plan Item Note</td>
              </tr>
              <tr class="topborder">
                <td class=" text-left">2.</td>
                <td class=" text-left ">Treatment Category Example</td>
                <td class="text-right cost">500.00</td>
                <td class="text-right">4</td>
                <td class="text-right discount">1,000.00</td>
                <td class="text-right tax">123.60</td>
                <td class="text-right totalcost">1,123.60</td>
              </tr>
              <tr class="nopadding">
                <td>&nbsp;</td>
                <td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label>
                  Need to perform this treatment plan in parts</td>
              </tr>
              <tr>
                <td class="text-left notes " colspan="5"><strong>Invoice Notes </strong>Invoice Sample Note</td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
                <td colspan="4"><table class="total_summary">
                    <tbody>
                      <tr>
                        <td class="text-right padding2 topborder">Total Cost:</td>
                        <td class="text-right bold padding2 topborder">2,400.00 INR</td>
                      </tr>
                      <tr>
                        <td class="text-right padding2">Total Discount:</td>
                        <td class="text-right bold padding2">1,080.00 INR</td>
                      </tr>
                      <tr>
                        <td class="text-right padding2">Total Tax:</td>
                        <td class="text-right bold padding2">179.54 INR</td>
                      </tr>
                      <tr>
                        <td class="text-right padding2">Grand Total:</td>
                        <td class="text-right bold padding2">1,499.54 INR</td>
                      </tr>
                      <tr>
                        <td class="text-right padding2">Amount Received:</td>
                        <td class="text-right bold padding2">0.00 INR</td>
                      </tr>
                      <tr>
                        <td class="text-right padding2">Balance Amount:</td>
                        <td class="text-right bold padding2">1,499.54 INR</td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
';
			
			case('medical_leave'):
			return '<div class="datewise-container">
<div class="entity-contianer">
<div><strong><span class="header-text  green-text">Medical Leave Certificate</span></strong>
<div class="entity-date date typename pull-right"><span class="text">Date:</span> <span class="name">'.date('d-M-Y').'</span></div>
</div>
<br />
<div>Medical Leave Number : 20150328182639</div>
<br />
<div>This is to certify that the above named is unfit for duty for a period of <span class="underline">4.5</span> (Four and half) day(s) from <span class="underline">29 Mar, 2015</span> to <span class="underline">02 Apr, 2015</span> inclusive.</div>
<br />
<div class="extralineheight"><span class="labelname">Excused from:</span> <span class="underline">29 Mar, 2015</span> to <span class="underline">02 Apr, 2015</span></div>
<br />
<div class="extralineheight"><span class="labelname">Fit for light duty from:</span> <span class="underline">03 Apr, 2015</span> to <span class="underline">05 Apr, 2015</span></div>
<br />
<div>The above named patient attended my clinic at <span class="underline">28 Mar, 2015 06:06 PM</span> and left at <span class="underline">28 Mar, 2015 06:26 PM</span></div>
<br />
<div>Sample notes for Medical leave certificate</div>
<br />
<div>Issued on: <span class="underline">28 Mar, 2015</span></div>
<br /><br />
<div>Signature :</div>
<br />
<div>Doctor : Dr. Rohit Kumar</div>
</div>
</div>
<div class="datewise-container">&nbsp;</div>';
			
			
			case('invoice'):
			return '<div class="datewise-container">
<div class="entity-contianer">
<div><strong><span class="header-text  green-text">Invoice</span></strong>
<div class="entity-date date typename pull-right"><span class="text">Date:</span> <span class="name">'.date('d-M-Y').'</span></div>
</div>
<div class="typename">
<div class="details">
<div class="payment-info">
<div class="entity-info"><span class="text">Invoice Number:</span> <span class="name">INV006</span></div>
<table class="pr_table clearboth table table-bordered">
<thead>
<tr><th class="text-left " width="5%">#</th><th class="text-left " width="40%">Treatments &amp; Products</th><th class="text-right cost-width cost">Unit Cost INR</th><th class="text-right" width="30">Qty</th><th class="text-right cost-width discount">Discount INR</th><th class="text-right cost-width tax">Tax INR</th><th class="text-right cost-width totalcost">Total Cost INR</th></tr>
</thead>
<tbody>
<tr class="topborder">
<td class=" text-left">1.</td>
<td class=" text-left ">Treatment Category Example <br /><label class="width_10em">Date</label> 28 Mar, 2015</td>
<td class="text-right cost">200.00</td>
<td class="text-right">2</td>
<td class="text-right discount">80.00</td>
<td class="text-right tax">55.94</td>
<td class="text-right totalcost">375.94</td>
</tr>
<tr class="nopadding">
<td>&nbsp;</td>
<td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label> Treatment Plan Item Note</td>
</tr>
<tr class="topborder">
<td class=" text-left">2.</td>
<td class=" text-left ">Treatment Category Example <br /><label class="width_10em">Date</label> 28 Mar, 2015</td>
<td class="text-right cost">500.00</td>
<td class="text-right">4</td>
<td class="text-right discount">1,000.00</td>
<td class="text-right tax">123.60</td>
<td class="text-right totalcost">1,123.60</td>
</tr>
<tr class="nopadding">
<td>&nbsp;</td>
<td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label> Need to perform this treatment plan in parts</td>
</tr>
<tr>
<td class="text-left notes " colspan="5"><strong>Invoice Notes </strong>Invoice Sample Note</td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
<td colspan="4">
<table class="total_summary " style="height: 116px;" width="343">
<tbody>
<tr>
<td class="text-right padding2 topborder">Total Cost:</td>
<td class="text-right bold padding2 topborder">2,400.00 INR</td>
</tr>
<tr>
<td class="text-right padding2">Total Discount:</td>
<td class="text-right bold padding2">1,080.00 INR</td>
</tr>
<tr>
<td class="text-right padding2">Total Tax:</td>
<td class="text-right bold padding2">179.54 INR</td>
</tr>
<tr>
<td class="text-right padding2">Grand Total:</td>
<td class="text-right bold padding2">1,499.54 INR</td>
</tr>
<tr>
<td class="text-right padding2">Amount Received:</td>
<td class="text-right bold padding2">0.00 INR</td>
</tr>
<tr>
<td class="text-right padding2">Balance Amount:</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<div class="datewise-container">&nbsp;</div>';
			
			case('recept'):
			return '<div class="datewise-container">
<div class="entity-contianer">
<div>
<div><strong><span class="header-text  green-text">Receipt</span></strong>
<div class="entity-date date typename pull-right"><span class="text">Date:</span> <span class="name">'.date('d-M-Y').'</span></div>
</div>
<div class="payment typename">
<div class="payment-info">
<div class="entity-info"><span class="text">Receipt Number:</span> <span class="name">REC101</span></div>
<p class="topbottompadding_1em">Received with thanks, amount of 1,300.00 INR towards the following :</p>
<div class="entity-contianer">
<div>
<div class="entity-info"><span class="text">Date:</span> <span class="name">28 Mar, 2015</span></div>
</div>
<div class="typename">
<div class="details">
<div class="payment-info">
<div class="entity-info"><span class="text">Invoice Number:</span> <span class="name">INV006</span></div>
<table class="pr_table clearboth table table-bordered">
<thead>
<tr><th class="text-left " width="5%">#</th><th class="text-left " width="40%">Treatments &amp; Products</th><th class="text-right cost-width cost">Unit Cost INR</th><th class="text-right" width="30">Qty</th><th class="text-right cost-width discount">Discount INR</th><th class="text-right cost-width tax">Tax INR</th><th class="text-right cost-width totalcost">Total Cost INR</th></tr>
</thead>
<tbody>
<tr class="topborder">
<td class=" text-left">1.</td>
<td class=" text-left ">Treatment Category Example</td>
<td class="text-right cost">200.00</td>
<td class="text-right">2</td>
<td class="text-right discount">80.00</td>
<td class="text-right tax">55.94</td>
<td class="text-right totalcost">375.94</td>
</tr>
<tr class="nopadding">
<td>&nbsp;</td>
<td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label> Treatment Plan Item Note</td>
</tr>
<tr class="topborder">
<td class=" text-left">2.</td>
<td class=" text-left ">Consultation</td>
<td class="text-right cost">500.00</td>
<td class="text-right">5</td>
<td class="text-right discount">750.00</td>
<td class="text-right tax">216.30</td>
<td class="text-right totalcost">1,966.30</td>
</tr>
<tr class="nopadding">
<td>&nbsp;</td>
<td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label> Invoice Detail Item Note</td>
</tr>
<tr>
<td colspan="1">&nbsp;</td>
<td colspan="6">
<table class="total_summary" style="height: 162px;" width="331">
<tbody>
<tr>
<td class="text-right padding2 topborder">Total Cost:</td>
<td class="text-right bold padding2 topborder">2,900.00 INR</td>
</tr>
<tr>
<td class="text-right padding2">Total Discount:</td>
<td class="text-right bold padding2">830.00 INR</td>
</tr>
<tr>
<td class="text-right padding2">Total Tax:</td>
<td class="text-right bold padding2">272.24 INR</td>
</tr>
<tr>
<td class="text-right padding2">Grand Total:</td>
<td class="text-right bold padding2">2,342.24 INR</td>
</tr>
<tr>
<td class="text-right padding2">Amount Received on 28 Mar, 2015:</td>
<td class="text-right bold padding2">800.00 INR</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
<br class="clearboth" />
<div>
<div>Mode of Payment :</div>
</div>
</div>
</div>
</div>
<div class="typename">&nbsp;</div>
</div>
</div>
<div class="datewise-container">&nbsp;</div>';
			
			default:
				return '<p>No data received</p>';
			}
		}
	function valid_pid_for_completed_procedure($pid=NULL){ 
		$ci = get_instance();
		//Check if pid belongs to the clinic
		//1st step
		//Get all the doctors of the patient
		
		$ci->load->model('patient_m');
		$data=$ci->patient_m->get($pid,true);
		$doctors=(@$data->doctors);
		$doctors=array_filter(explode(',',$doctors)); 
		$primary=$ci->session->userdata('primary');
		//If any of the doctors exists in the clinic with id $primary then pid is valid
		
		//Step 2,Get all the doctor available in the clinic
		
		$sql="SELECT doctor_id,other_doctors FROM clinic where id=$primary union select 'a' as bal,id as other_doctors from doctors where special_clinic=$primary order by doctor_id";
		$data=$ci->db->query($sql)->result();
		$available_doctors=array();
		foreach($data as $a=>$b){
			$other_doc=array_filter(explode(',',$b->other_doctors));
			$available_doctors=array_merge($available_doctors,$other_doc);
			}
		$available_doctors[]=$data[0]->doctor_id;
		
		
		//var_dump($available_doctors,$doctors);
		$marged=array_unique(array_merge($available_doctors,$doctors));
		$original_size=sizeof($available_doctors)+sizeof($doctors) ;
		$generated_size=sizeof($marged); 
		//var_dump($available_doctors,$doctors);
		if($original_size==$generated_size){
			return 0; 
			} 
		else return 1;
		}

function refferer($exp=''){ 
	if(isset($_SERVER['HTTP_REFERER']) and !empty($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER'];
	else $exp;
	}
function r($exp=''){ refferer($exp='');}

function generate_print_html_by_name($name='prescription'){
		switch($name){
			case('prescription'):
				return '<div class="dummy_data"> <div><strong>Prescription</strong> 
				<span style="float: right;">Date:'.date('d-M-Y').'</span>
				 <br/>
</div>
<div>
  <div> </div>
  <br/>
  <div>
    <table width="100%" class="table table-bordered">
      <thead>
        <tr>
          <th> </th>
          <th> Drug Name </th>
          <th> Strength </th>
          <th> Frequency </th>
          <th> Instructions </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td width="2%"> 1. </td>
          <td width="25%"> Tablet <strong>Crocin</strong> <br/>
            6 tablets </td>
          <td> 100 mg </td>
          <td><table>
              <tbody>
                <tr>
                  <td> 2 </td>
                  <td> - </td>
                  <td> 0 </td>
                  <td> - </td>
                  <td> 1 </td>
                </tr>
                <tr>
                  <td> Morning </td>
                  <td></td>
                  <td> Afternoon </td>
                  <td></td>
                  <td> Night </td>
                </tr>
              </tbody>
            </table></td>
          <td> 2 day(s) <br/>
            Before Food <br/>
            <pre>Need to take 3 units a day</pre></td>
        </tr>
        <tr>
          <td width="2%"> 2. </td>
          <td width="25%"> Tablet <strong>Nisep</strong> <br/>
            30 tablets </td>
          <td> 200 ml </td>
          <td><table>
              <tbody>
                <tr>
                  <td> 1 </td>
                  <td> - </td>
                  <td> 1 </td>
                  <td> - </td>
                  <td> 3 </td>
                </tr>
                <tr>
                  <td> Morning </td>
                  <td></td>
                  <td> Afternoon </td>
                  <td></td>
                  <td> Night </td>
                </tr>
              </tbody>
            </table></td>
          <td> 6 day(s) <br/>
            After Food <br/>
            <pre></pre></td>
        </tr>
      </tbody>
    </table>
    <br/>
    <pre> <strong>General Instructions : </strong> Sample Instruction for Prescription </pre>
  </div>
</div></div>
';
				break;
			case('treatment_plans'):
			return '<div>
    <strong>Treatment Plan</strong>
    <div style="float:right">
        Date: '.date('d-M-Y').'
    </div>
    <br/>
</div>
<div>
    <div>
        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            Treatment
                        </th>
                        <th>
                            Notes
                        </th>
                        <th>
                            Cost
                            <br/>
                            INR
                        </th>
                        <th>
                            Discount
                            <br/>
                            INR
                        </th>
                        <th>
                            After discount
                            <br/>
                            INR
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Sample Treatment Category
                        </td>
                        <td>
                            Sample Treatment Plan Description
                            <br/>
                            Teeth: 13|11|10
                        </td>
                        <td>
                            600.00
                        </td>
                        <td>
                            180.00
                        </td>
                        <td>
                            420.00
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Sample Treatment Category
                        </td>
                        <td>
                            Sample Treatment Plan Description
                            <br/>
                            Teeth: 23|22
                        </td>
                        <td>
                            1,500.00
                        </td>
                        <td>
                            300.00
                        </td>
                        <td>
                            1,200.00
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody style="text-align: right;">
                    <tr>
                        <td>
                            Estimated Amount:
                        </td>
                        <td>
                            2,100.00 INR
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Total Discount:
                        </td>
                        <td>
                            480.00 INR
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Grand Total:
                        </td>
                        <td>
                            1,620.00 INR
                        </td>
                    </tr>
                </tbody>
            </table>
            <div>
                *Taxes as applicable
            </div>
        </div>
    </div>
</div>';

			case('case_sheet'):
			return '<div class="datewise-container">
  <div class="entity-contianer">
    <div><span class="header-text  green-text">Receipt</span>
      <div class="entity-date date typename"><span class="text">Date:</span> <span class="name">28 Mar, 2015</span></div>
    </div>
    <div class="payment typename">
      <div class="payment-info">
        <div class="entity-info"><span class="text">Receipt Number:</span> <span class="name">REC101</span></div>
        <p class="topbottompadding_1em">Received with thanks, amount of 1,300.00 INR towards the following :</p>
        <div class="entity-contianer">
          <div>
            <div class="entity-info"><span class="text">Date:</span> <span class="name">28 Mar, 2015</span></div>
          </div>
          <div class="typename">
            <div class="details">
              <div class="payment-info">
                <div class="entity-info"><span class="text">Invoice Number:</span> <span class="name">INV006</span></div>
                <table class="pr_table clearboth table table-bordered">
                  <thead>
                    <tr>
                      <th class="text-left " width="5%">#</th>
                      <th class="text-left " width="40%">Treatments &amp; Products</th>
                      <th class="text-right cost-width cost">Unit Cost INR</th>
                      <th class="text-right" width="30">Qty</th>
                      <th class="text-right cost-width discount">Discount INR</th>
                      <th class="text-right cost-width tax">Tax INR</th>
                      <th class="text-right cost-width totalcost">Total Cost INR</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="topborder">
                      <td class=" text-left">1.</td>
                      <td class=" text-left ">Treatment Category Example</td>
                      <td class="text-right cost">200.00</td>
                      <td class="text-right">2</td>
                      <td class="text-right discount">80.00</td>
                      <td class="text-right tax">55.94</td>
                      <td class="text-right totalcost">375.94</td>
                    </tr>
                    <tr class="nopadding">
                      <td>&nbsp;</td>
                      <td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label>
                        Treatment Plan Item Note</td>
                    </tr>
                    <tr class="topborder">
                      <td class=" text-left">2.</td>
                      <td class=" text-left ">Consultation</td>
                      <td class="text-right cost">500.00</td>
                      <td class="text-right">5</td>
                      <td class="text-right discount">750.00</td>
                      <td class="text-right tax">216.30</td>
                      <td class="text-right totalcost">1,966.30</td>
                    </tr>
                    <tr class="nopadding">
                      <td>&nbsp;</td>
                      <td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label>
                        Invoice Detail Item Note</td>
                    </tr>
                    <tr>
                      <td colspan="1">&nbsp;</td>
                      <td colspan="6"><table class="total_summary">
                          <tbody>
                            <tr>
                              <td class="text-right padding2 topborder">Total Cost:</td>
                              <td class="text-right bold padding2 topborder">2,900.00 INR</td>
                            </tr>
                            <tr>
                              <td class="text-right padding2">Total Discount:</td>
                              <td class="text-right bold padding2">830.00 INR</td>
                            </tr>
                            <tr>
                              <td class="text-right padding2">Total Tax:</td>
                              <td class="text-right bold padding2">272.24 INR</td>
                            </tr>
                            <tr>
                              <td class="text-right padding2">Grand Total:</td>
                              <td class="text-right bold padding2">2,342.24 INR</td>
                            </tr>
                            <tr>
                              <td class="text-right padding2">Amount Received on 28 Mar, 2015:</td>
                              <td class="text-right bold padding2">200.00 INR</td>
                            </tr>
                            <tr>
                              <td class="text-right padding2">Balance Amount:</td>
                              <td class="text-right bold padding2">2,342.24 INR</td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <br class="clearboth" />
        <div>
          <div>Mode of Payment :</div>
        </div>
      </div>
    </div>
  </div>
  <div class="entity-contianer">
    <div><span class="header-text  green-text">Treatment Plan</span>
      <div class="entity-date date typename"><span class="text">Date:</span> <span class="name">28 Mar, 2015</span></div>
    </div>
    <div class="treatmentplan typename">
      <div class="details">
        <div class="treatment-info">
          <table class="table pr_table table table-bordered">
            <thead class="">
              <tr>
                <th class="treatment text-left">Treatment</th>
                <th class="notes text-left">Notes</th>
                <th class="cost-width text-right">Cost <br />
                  INR</th>
                <th class="cost-width text-right">Discount <br />
                  INR</th>
                <th class="cost-width text-right">After discount<br />
                  INR</th>
              </tr>
            </thead>
            <tbody>
              <tr class="">
                <td class="bottomborder">Sample Treatment Category</td>
                <td class="bottomborder">Sample Treatment Plan Description <br />
                  Teeth: 13|11|10</td>
                <td class="text-right bottomborder">600.00</td>
                <td class=" text-right bottomborder">180.00</td>
                <td class=" text-right bottomborder">420.00</td>
              </tr>
              <tr class="">
                <td class="bottomborder">Sample Treatment Category</td>
                <td class="bottomborder">Sample Treatment Plan Description <br />
                  Teeth: 23|22</td>
                <td class="text-right bottomborder">1,500.00</td>
                <td class=" text-right bottomborder">300.00</td>
                <td class=" text-right bottomborder">1,200.00</td>
              </tr>
            </tbody>
          </table>
          <table class="total_summary">
            <tbody>
              <tr>
                <td class=" text-right">Estimated Amount:</td>
                <td class="text-right bold">2,100.00 INR</td>
              </tr>
              <tr>
                <td class=" text-right bottomborder">Total Discount:</td>
                <td class=" text-right bottomborder bold">480.00 INR</td>
              </tr>
              <tr>
                <td class=" text-right">Grand Total:</td>
                <td class=" text-right bold">1,620.00 INR</td>
              </tr>
            </tbody>
          </table>
          <div class="clearboth">*Taxes as applicable</div>
        </div>
      </div>
    </div>
  </div>
  <div class="entity-contianer">
    <div>
      <div class="entity-date date typename"><span class="text">Date:</span> <span class="name">28 Mar, 2015</span></div>
    </div>
    <div class="typename">
      <div class="payment-info">
        <table class="pr_table soap_table">
          <tbody>
            <tr class="nopadding">
              <td class="borderbottom" width="10%">Complaint</td>
              <td class="borderbottom" width="90%"><ul>
                  <li>
                    <pre>This is a sample complaint</pre>
                  </li>
                </ul></td>
            </tr>
            <tr class="nopadding">
              <td class="borderbottom" width="10%">Observation</td>
              <td class="borderbottom" width="90%"><ul>
                  <li>
                    <pre>This is a sample observation</pre>
                  </li>
                </ul></td>
            </tr>
            <tr class="nopadding">
              <td class="borderbottom" width="10%">Investigation</td>
              <td class="borderbottom" width="90%"><ul>
                  <li>
                    <pre>This is a sample investigation</pre>
                  </li>
                </ul></td>
            </tr>
            <tr class="nopadding">
              <td class="borderbottom" width="10%">Diagnosis</td>
              <td class="borderbottom" width="90%"><ul>
                  <li>
                    <pre>This is a sample diagnosis</pre>
                  </li>
                </ul></td>
            </tr>
            <tr class="nopadding">
              <td class="borderbottom" width="10%">Note</td>
              <td class="borderbottom" width="90%"><ul>
                  <li>
                    <pre>This is a sample treatmentnote</pre>
                  </li>
                </ul></td>
            </tr>
          </tbody>
        </table>
      </div> 
    </div>
  </div>
  <div class="entity-contianer">
    <div><span class="entity-date date typename"><span class="text">Date:</span> <span class="name">28 Mar, 2015</span></span><span class="header-text  green-text">Prescription (℞)</span></div>
    <div class="typename">
      <div class="entity-info">&nbsp;</div>
      <br />
      <div>
        <table width="100%" class="table table-bordered">
          <thead>
            <tr>
              <th>&nbsp;</th>
              <th>Drug Name</th>
              <th>Strength</th>
              <th>Frequency</th>
              <th>Instructions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td width="2%">1.</td>
              <td width="25%">Tablet <strong>Crocin</strong> <br />
                6 tablets</td>
              <td>100 mg</td>
              <td><table>
                  <tbody>
                    <tr>
                      <td>2</td>
                      <td>-</td>
                      <td>0</td>
                      <td>-</td>
                      <td>1</td>
                    </tr>
                    <tr>
                      <td>Morning</td>
                      <td>&nbsp;</td>
                      <td>Afternoon</td>
                      <td>&nbsp;</td>
                      <td>Night</td>
                    </tr>
                  </tbody>
                </table></td>
              <td>2 day(s) <br />
                Before Food <br />
                <pre>Need to take 3 units a day</pre></td>
            </tr>
            <tr>
              <td width="2%">2.</td>
              <td width="25%">Tablet <strong>Nisep</strong> <br />
                30 tablets</td>
              <td>200 ml</td>
              <td><table>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>-</td>
                      <td>1</td>
                      <td>-</td>
                      <td>3</td>
                    </tr>
                    <tr>
                      <td>Morning</td>
                      <td>&nbsp;</td>
                      <td>Afternoon</td>
                      <td>&nbsp;</td>
                      <td>Night</td>
                    </tr>
                  </tbody>
                </table></td>
              <td>6 day(s) <br />
                After Food <br />
                <pre>Should be taken just After Food</pre></td>
            </tr>
          </tbody>
        </table>
        <br />
        <p>&nbsp;</p>
        <pre> <strong>General Instructions : </strong> Sample Instruction for Prescription </pre>
        <p>&nbsp;</p>
      </div>
    </div>
  </div>
</div>
<div class="datewise-container">
  <div class="entity-contianer">
    <div><span class="header-text  green-text">Invoice</span>
      <div class="entity-date date typename"><span class="text">Date:</span> <span class="name">29 Mar, 2015</span></div>
    </div>
    <div class="typename">
      <div class="details">
        <div class="payment-info">
          <div class="entity-info"><span class="text">Invoice Number:</span> <span class="name">INV006</span></div>
          <table class="pr_table clearboth table table-bordered">
            <thead>
              <tr>
                <th class="text-left " width="5%">#</th>
                <th class="text-left " width="40%">Treatments &amp; Products</th>
                <th class="text-right cost-width cost">Unit Cost INR</th>
                <th class="text-right" width="30">Qty</th>
                <th class="text-right cost-width discount">Discount INR</th>
                <th class="text-right cost-width tax">Tax INR</th>
                <th class="text-right cost-width totalcost">Total Cost INR</th>
              </tr>
            </thead>
            <tbody>
              <tr class="topborder">
                <td class=" text-left">1.</td>
                <td class=" text-left ">Treatment Category Example</td>
                <td class="text-right cost">200.00</td>
                <td class="text-right">2</td>
                <td class="text-right discount">80.00</td>
                <td class="text-right tax">55.94</td>
                <td class="text-right totalcost">375.94</td>
              </tr>
              <tr class="nopadding">
                <td>&nbsp;</td>
                <td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label>
                  Treatment Plan Item Note</td>
              </tr>
              <tr class="topborder">
                <td class=" text-left">2.</td>
                <td class=" text-left ">Treatment Category Example</td>
                <td class="text-right cost">500.00</td>
                <td class="text-right">4</td>
                <td class="text-right discount">1,000.00</td>
                <td class="text-right tax">123.60</td>
                <td class="text-right totalcost">1,123.60</td>
              </tr>
              <tr class="nopadding">
                <td>&nbsp;</td>
                <td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label>
                  Need to perform this treatment plan in parts</td>
              </tr>
              <tr>
                <td class="text-left notes " colspan="5"><strong>Invoice Notes </strong>Invoice Sample Note</td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
                <td colspan="4"><table class="total_summary">
                    <tbody>
                      <tr>
                        <td class="text-right padding2 topborder">Total Cost:</td>
                        <td class="text-right bold padding2 topborder">2,400.00 INR</td>
                      </tr>
                      <tr>
                        <td class="text-right padding2">Total Discount:</td>
                        <td class="text-right bold padding2">1,080.00 INR</td>
                      </tr>
                      <tr>
                        <td class="text-right padding2">Total Tax:</td>
                        <td class="text-right bold padding2">179.54 INR</td>
                      </tr>
                      <tr>
                        <td class="text-right padding2">Grand Total:</td>
                        <td class="text-right bold padding2">1,499.54 INR</td>
                      </tr>
                      <tr>
                        <td class="text-right padding2">Amount Received:</td>
                        <td class="text-right bold padding2">0.00 INR</td>
                      </tr>
                      <tr>
                        <td class="text-right padding2">Balance Amount:</td>
                        <td class="text-right bold padding2">1,499.54 INR</td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
';
			
			case('medical_leave'):
			return '<div class="datewise-container">
<div class="entity-contianer">
<div><strong><span class="header-text  green-text">Medical Leave Certificate</span></strong>
<div class="entity-date date typename pull-right"><span class="text">Date:</span> <span class="name">'.date('d-M-Y').'</span></div>
</div>
<br />
<div>Medical Leave Number : 20150328182639</div>
<br />
<div>This is to certify that the above named is unfit for duty for a period of <span class="underline">4.5</span> (Four and half) day(s) from <span class="underline">29 Mar, 2015</span> to <span class="underline">02 Apr, 2015</span> inclusive.</div>
<br />
<div class="extralineheight"><span class="labelname">Excused from:</span> <span class="underline">29 Mar, 2015</span> to <span class="underline">02 Apr, 2015</span></div>
<br />
<div class="extralineheight"><span class="labelname">Fit for light duty from:</span> <span class="underline">03 Apr, 2015</span> to <span class="underline">05 Apr, 2015</span></div>
<br />
<div>The above named patient attended my clinic at <span class="underline">28 Mar, 2015 06:06 PM</span> and left at <span class="underline">28 Mar, 2015 06:26 PM</span></div>
<br />
<div>Sample notes for Medical leave certificate</div>
<br />
<div>Issued on: <span class="underline">28 Mar, 2015</span></div>
<br /><br />
<div>Signature :</div>
<br />
<div>Doctor : Dr. Rohit Kumar</div>
</div>
</div>
<div class="datewise-container">&nbsp;</div>';
			
			
			case('invoice'):
			return '<div class="datewise-container">
<div class="entity-contianer">
<div><strong><span class="header-text  green-text">Invoice</span></strong>
<div class="entity-date date typename pull-right"><span class="text">Date:</span> <span class="name">'.date('d-M-Y').'</span></div>
</div>
<div class="typename">
<div class="details">
<div class="payment-info">
<div class="entity-info"><span class="text">Invoice Number:</span> <span class="name">INV006</span></div>
<table class="pr_table clearboth table table-bordered">
<thead>
<tr><th class="text-left " width="5%">#</th><th class="text-left " width="40%">Treatments &amp; Products</th><th class="text-right cost-width cost">Unit Cost INR</th><th class="text-right" width="30">Qty</th><th class="text-right cost-width discount">Discount INR</th><th class="text-right cost-width tax">Tax INR</th><th class="text-right cost-width totalcost">Total Cost INR</th></tr>
</thead>
<tbody>
<tr class="topborder">
<td class=" text-left">1.</td>
<td class=" text-left ">Treatment Category Example <br /><label class="width_10em">Date</label> 28 Mar, 2015</td>
<td class="text-right cost">200.00</td>
<td class="text-right">2</td>
<td class="text-right discount">80.00</td>
<td class="text-right tax">55.94</td>
<td class="text-right totalcost">375.94</td>
</tr>
<tr class="nopadding">
<td>&nbsp;</td>
<td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label> Treatment Plan Item Note</td>
</tr>
<tr class="topborder">
<td class=" text-left">2.</td>
<td class=" text-left ">Treatment Category Example <br /><label class="width_10em">Date</label> 28 Mar, 2015</td>
<td class="text-right cost">500.00</td>
<td class="text-right">4</td>
<td class="text-right discount">1,000.00</td>
<td class="text-right tax">123.60</td>
<td class="text-right totalcost">1,123.60</td>
</tr>
<tr class="nopadding">
<td>&nbsp;</td>
<td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label> Need to perform this treatment plan in parts</td>
</tr>
<tr>
<td class="text-left notes " colspan="5"><strong>Invoice Notes </strong>Invoice Sample Note</td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
<td colspan="4">
<table class="total_summary " style="height: 116px;" width="343">
<tbody>
<tr>
<td class="text-right padding2 topborder">Total Cost:</td>
<td class="text-right bold padding2 topborder">2,400.00 INR</td>
</tr>
<tr>
<td class="text-right padding2">Total Discount:</td>
<td class="text-right bold padding2">1,080.00 INR</td>
</tr>
<tr>
<td class="text-right padding2">Total Tax:</td>
<td class="text-right bold padding2">179.54 INR</td>
</tr>
<tr>
<td class="text-right padding2">Grand Total:</td>
<td class="text-right bold padding2">1,499.54 INR</td>
</tr>
<tr>
<td class="text-right padding2">Amount Received:</td>
<td class="text-right bold padding2">0.00 INR</td>
</tr>
<tr>
<td class="text-right padding2">Balance Amount:</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<div class="datewise-container">&nbsp;</div>';
			
			case('recept'):
			return '<div class="datewise-container">
<div class="entity-contianer">
<div>
<div><strong><span class="header-text  green-text">Receipt</span></strong>
<div class="entity-date date typename pull-right"><span class="text">Date:</span> <span class="name">'.date('d-M-Y').'</span></div>
</div>
<div class="payment typename">
<div class="payment-info">
<div class="entity-info"><span class="text">Receipt Number:</span> <span class="name">REC101</span></div>
<p class="topbottompadding_1em">Received with thanks, amount of 1,300.00 INR towards the following :</p>
<div class="entity-contianer">
<div>
<div class="entity-info"><span class="text">Date:</span> <span class="name">28 Mar, 2015</span></div>
</div>
<div class="typename">
<div class="details">
<div class="payment-info">
<div class="entity-info"><span class="text">Invoice Number:</span> <span class="name">INV006</span></div>
<table class="pr_table clearboth table table-bordered">
<thead>
<tr><th class="text-left " width="5%">#</th><th class="text-left " width="40%">Treatments &amp; Products</th><th class="text-right cost-width cost">Unit Cost INR</th><th class="text-right" width="30">Qty</th><th class="text-right cost-width discount">Discount INR</th><th class="text-right cost-width tax">Tax INR</th><th class="text-right cost-width totalcost">Total Cost INR</th></tr>
</thead>
<tbody>
<tr class="topborder">
<td class=" text-left">1.</td>
<td class=" text-left ">Treatment Category Example</td>
<td class="text-right cost">200.00</td>
<td class="text-right">2</td>
<td class="text-right discount">80.00</td>
<td class="text-right tax">55.94</td>
<td class="text-right totalcost">375.94</td>
</tr>
<tr class="nopadding">
<td>&nbsp;</td>
<td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label> Treatment Plan Item Note</td>
</tr>
<tr class="topborder">
<td class=" text-left">2.</td>
<td class=" text-left ">Consultation</td>
<td class="text-right cost">500.00</td>
<td class="text-right">5</td>
<td class="text-right discount">750.00</td>
<td class="text-right tax">216.30</td>
<td class="text-right totalcost">1,966.30</td>
</tr>
<tr class="nopadding">
<td>&nbsp;</td>
<td class="text-left notes " colspan="6"><label class="width_10em">Notes:</label> Invoice Detail Item Note</td>
</tr>
<tr>
<td colspan="1">&nbsp;</td>
<td colspan="6">
<table class="total_summary" style="height: 162px;" width="331">
<tbody>
<tr>
<td class="text-right padding2 topborder">Total Cost:</td>
<td class="text-right bold padding2 topborder">2,900.00 INR</td>
</tr>
<tr>
<td class="text-right padding2">Total Discount:</td>
<td class="text-right bold padding2">830.00 INR</td>
</tr>
<tr>
<td class="text-right padding2">Total Tax:</td>
<td class="text-right bold padding2">272.24 INR</td>
</tr>
<tr>
<td class="text-right padding2">Grand Total:</td>
<td class="text-right bold padding2">2,342.24 INR</td>
</tr>
<tr>
<td class="text-right padding2">Amount Received on 28 Mar, 2015:</td>
<td class="text-right bold padding2">800.00 INR</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
<br class="clearboth" />
<div>
<div>Mode of Payment :</div>
</div>
</div>
</div>
</div>
<div class="typename">&nbsp;</div>
</div>
</div>
<div class="datewise-container">&nbsp;</div>';
			
			default:
				return '<p>No data received</p>';
			}
		}
	
function register_saved_file($pid,$path_file='',$file_name='',$parent_folder=''){
	$ci = get_instance();
	$doctor_id=$ci->session->userdata('id');
	$primary=$ci->session->userdata('primary');
	if(!valid_pid_for_completed_procedure($pid)) return;
	
	$size=filesize(($path_file));
	$type=array_reverse(explode('.',$file_name));
	$type=@$type[0];
	$date_created=date('Y-m-d');
	
	$data_array=array(
		'name'=>$file_name,
		'doctor_id'=>$doctor_id,
		'patient_id'=>$pid,
		'clinic_id'=>$primary,
		'type'=>$type,
		'parent_folder'=>$parent_folder,
		'rel_path'=>$path_file,
		'size'=>$size,
		'date_created'=>$date_created
		); 
	$ci->load->model('files_m');
	return $ci->files_m->save($data_array);
	 
	}

function get_all_admin(){
	$ci = get_instance();
	$primary=$ci->session->userdata('primary');
	$ci->load->model('clinic_m');
	$result=$ci->clinic_m->get($primary,true);
	$admins=array();
	$admins[]=$result->doctor_id;
	return  ( $admins); 
	}
function allow_only_admins(){
	$ci = get_instance();
	$id=$ci->session->userdata('id');
	return in_array($id,get_all_admin()); 
	}
function show_noaccess(){
	$ci = get_instance();
	$data=array();
	$data['heading']='Unauthorized User';
	$data['message']='<p>Only admin of this clinic can view this page</p>';
	
	$data['sub_view']='error_admin';
	$ci->load->view('doctor_admin/layout',$data);
	 
	}
function check_allowed_role($allowed_role){
	$ci = get_instance();
	$a_role=$ci->session->userdata('a_role');
	if(in_array($a_role,$allowed_role)) return 1;
	else return 0;
	}

function check_valid_doctor_for_agent($did){
	$ci		= get_instance();
	$a_id	=$ci->session->userdata('a_id');
	$ci->load->model('doctor_m');
	$data=$ci->doctor_m->get_by(array('id'=>$did,'agent'=>$a_id),true);
	if(count($data)) return 1;
	else return 0;
	}

function get_all_doctor_by_clinic($cid=NULL){
	$cid	=sql_filter($cid);
	if($cid==NULL) return;
	$ci		= get_instance();
	
	$all_doctors=array();
	$doctors=array();
	
	$ci->load->model('doctor_m');
	$doctor_data=$ci->doctor_m->get_by(array('special_clinic'=>$cid),true);	
	if(!empty($doctor_data)) $doctors[]=$doctor_data->id;
	
	$ci->load->model('clinic_m');
	$clinic_data=$ci->clinic_m->get($cid,true);	
	$other_doctors=$clinic_data->other_doctors;
	$other_doctors=explode(',',$other_doctors);
	
	$all_doctors=array_merge($other_doctors,$doctors);
	$all_doctors[]=$clinic_data->doctor_id;
	
	$all_doctors=(array_filter($all_doctors));
	sort($all_doctors); 
	return $all_doctors;
	
	}

function get_doctor_name_by_id($did=NULL){
	$did	=sql_filter($did);
	if($did==NULL) return;
	$ci		= get_instance();
	
	$ci->load->model('doctor_m');
	$doctor_data=$ci->doctor_m->get($did,true);	
	return @$doctor_data->name;
	}

function get_all_clinics_by_doctor($did=NULL){
	$did=sql_filter($did);
	if($did==NULL) return;
	$ci		= get_instance();
	
	$ci->load->model('doctor_m');
	$doctor_data=$ci->doctor_m->get_by(array('id'=>$did),true);	
	$clinics=array();
	
	$special_clinic=$doctor_data->special_clinic;
	if($special_clinic!=0)
	$clinics[]=$special_clinic;
	
	$ci->load->model('clinic_m');
	$clinic_data=$ci->clinic_m->get_by(array('doctor_id'=>$did));
	foreach($clinic_data as $a=>$b){
		$clinics[]=@$b->id;
		}
	
	
	$sql="SELECT id FROM clinic  where other_doctors like '%,$did,%'"; 
	$clinic_data=$ci->db->query($sql)->result();
	$clinic_data=@$clinic_data[0];
	$clinics[]=@$clinic_data->id;
	$clinics=array_filter($clinics); 
	return $clinics; 
	}

function gen_timing($hour_or_min='hour',$mag=NULL){
	
	if(!empty($mag)) $mag=explode(':',$mag);
	$str='';
	if($hour_or_min=='hour'){ 
		for($i=1;$i<=12;$i++)
		if(@$mag[0]==$i) $str.='<option selected="selected">'.sprintf("%02d", $i).'</option>'; 
		else $str.='<option>'.sprintf("%02d", $i).'</option>';
		}
		
	if($hour_or_min=='min'){
		for($i=0;$i<60;$i=$i+15)
		if(@$mag[1]==$i) $str.='<option selected="selected">'.sprintf("%02d", $i).'</option>'; 
		else $str.='<option>'.sprintf("%02d", $i).'</option>';
		}
	return $str;
	}

function from_to($day){
	$ci = get_instance();
	$ci->load->model('clinic_m');
	$primary=$ci->session->userdata('primary');
	$timing=$ci->clinic_m->get($primary,true);
	$timing=$timing->timing;
	if(!empty($timing)) $timing=json_decode($timing,true);
	//var_dump($timing);
	echo '<tr>
	<td > <input class="simple check_unchecker" data-day="'.trim(strtolower($day)).'" type="checkbox"';
	if(isset($timing[$day])) echo 'checked';
	echo '> '.ucfirst($day).'<small class="smss cp2a">Copy to all days</small> </td>
	<td id="'.$day.'_0">
					<select class="form-control smc s1fh" disabled="disabled">
                    	'.gen_timing('hour',@$timing[$day][0]['start']).'
                    </select> 
					<select class="form-control smc s1fm" disabled="disabled">
                    	'.gen_timing('min',@$timing[$day][0]['start']).'
                    </select>';
					$tempa=explode(':',@$timing[$day][0]['start']);
					$meridian=@$tempa[2];
                    echo '<select class="form-control smc s1fap" disabled="disabled">
                    	<option '.($meridian =='AM' ? 'selected="selected"' : '').'>AM</option>
                        <option '.($meridian =='PM' ? 'selected="selected"' : '').'>PM</option>
                    </select>
                    <label style="margin:0 7px 0px 3px">To</label>
                    <select class="form-control smc s1th " disabled="disabled">
                    	'.gen_timing('hour',@$timing[$day][0]['end']).'
                    </select>
                    <select class="form-control smc s1tm" disabled="disabled">
                    	'.gen_timing('min',@$timing[$day][0]['end']).'
                    </select>';
					$tempa=explode(':',@$timing[$day][0]['end']);
					$meridian=@$tempa[2];
                    echo '<select class="form-control smc s1tap" disabled="disabled">
                    	<option '.($meridian =='AM' ? 'selected="selected"' : '').'>AM</option>
                        <option '.($meridian =='PM' ? 'selected="selected"' : '').'>PM</option>
                    </select>
					</td>
	<td> <input class="simple smc s2checked" type="checkbox"  disabled="disabled" ';
	if(isset($timing[$day][1])) echo 'checked';
	echo '></td>
	<td id="'.$day.'_1">
					<select class="form-control smc s2fh s2" disabled="disabled">
                    	'.gen_timing('hour',@$timing[$day][1]['start']).'
                    </select>
                    <select class="form-control smc s2fm s2" disabled="disabled">
                    	'.gen_timing('min',@$timing[$day][1]['start']).'
                    </select>';
					$tempa=explode(':',@$timing[$day][1]['start']);
					$meridian=@$tempa[2];
                    echo '<select class="form-control smc s2fap s2" disabled="disabled">
                    	<option '.($meridian =='AM' ? 'selected="selected"' : '').'>AM</option>
                        <option '.($meridian =='PM' ? 'selected="selected"' : '').'>PM</option>
                    </select>
                    <label style="margin:0 7px 0px 3px">To</label>
                    <select class="form-control smc s2th s2" disabled="disabled">
                    	'.gen_timing('hour',@$timing[$day][1]['end']).'
                    </select>
                    <select class="form-control smc s2tm s2" disabled="disabled">
                    	'.gen_timing('min',@$timing[$day][1]['end']).'
                    </select>';
					$tempa=explode(':',@$timing[$day][1]['end']);
					$meridian=@$tempa[2];
                    echo '<select class="form-control smc s2tap s2" disabled="disabled">
                    	<option '.($meridian =='AM' ? 'selected="selected"' : '').'>AM</option>
                        <option '.($meridian =='PM' ? 'selected="selected"' : '').'>PM</option>
                    </select>
					</td></tr>';
	}

function get_clinic_appointment($did=NULL){
	$did	=sql_filter($did); 
	$ci		= get_instance();
	$primary=$ci->session->userdata('primary');
	if($did==NULL)
	$filter_array=array('clinic_id'=>$primary);
	else $filter_array=array('clinic_id'=>$primary,'doctor_id'=>$did);
	
	// Get all the appointment for the clinic
	$ci->load->model('appointment_m');
	$app_data=$ci->appointment_m->get_by($filter_array);
	
	$ci->load->model('clinic_m');
	$clinic_data=$ci->clinic_m->get($primary);
	$consultation_time=$clinic_data->consultation_time*60;
	
	$app_array=array();
	
	foreach($app_data as $a=>$b){ 
		$temp=array();
		$temp['id']			=$b->id;
		$temp['title']		=$b->name;
		$temp['email']		=$b->email;
		$temp['completed']	=$b->completed;
		$temp['phone']		=$b->phone;
		$temp['timestamp']	=$b->time;
		$temp['start']		=date('Y-m-d',$b->time).'T'.date('H:i',$b->time);
		$temp['end']		=date('Y-m-d',$b->time+$consultation_time).'T'.date('H:i',$b->time+$consultation_time);
		$temp['color']		=random_color($b->doctor_id); 
		
		
		$app_array[]=$temp;
		}
		
		
	return json_encode($app_array);
	//$ci->load->model('doctor_m');
	
	}


function random_color($index=NULL) { 
	$color=array('#2AD4FF','#8DB838','#A5CF25','#B86338','#FFAAFF','#FF7FAA','#FF2AAA','#FFAA55','#25CF50','#3863B8','#1392E7' ,'#AA7FFF','#FF552A','#FFAA55','#FFAA55','#CF25A5','#8D38B8','#707070');
	
	
	if(!is_null($index)) {
		$size=sizeof($color);
		if($index>=$size) $index=$index%$size-1; 
		return $color[$index];
		
		}
	else{
    return $color[array_rand($color)];;
		}
}

?>