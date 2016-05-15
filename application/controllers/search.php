<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends Frontend_Controller {
	
	public function __construct(){
		parent::__construct();
		}
		
	
	public function hospitals($city=NULL,$pin=NULL,$offset=0){
		
		$this->load->helper('security');
		$city=xss_clean($city);
		$pin=xss_clean($pin);
		$offset=xss_clean($offset);
		
		$this->data['number_of_results']=10;
		$nor=$this->data['number_of_results'];
		$lower_limit=$offset*$nor;
		$count_limit=$nor*8;
		
		$this->data['current_page']=$offset+1;
		
		$city			=sql_filter(($city));
		$pin			=urldecode(str_replace('_or_','/',sql_filter($pin)));
		
		
		if($pin==NULL or $pin=='NULL') 		$pin=NULL;
		if($city==NULL or $city=='NULL') 				$city='%%';
		
		
		$pin=array_filter(explode('-',$pin));
		$this->data['pin']=$pin;
		
		
		//if(!$this->db->query("SELECT id FROM location where city='$city' limit 1")->num_rows()){$city='%%';}
		if($city=='Select Your City') $city='%%';
		
		$filter_str=" (city like '$city' AND ";
		
		if(!empty($pin)) 	{
			foreach($pin as $a=>$b){
				$filter_str.=" hospital.pin = $b OR " ;
				}
			}
		
		
		$filter_str=rtrim($filter_str, "OR ");
		$filter_str=rtrim($filter_str, "AND ");
		
		$filter_str.=') ';
		
		$sql="SELECT * FROM hospital 	where $filter_str AND  visibility=1 	order by rank desc,name asc limit $lower_limit,$nor" ;
		
		$sql_count="SELECT * FROM hospital 	where $filter_str AND visibility=1 " ;
		
		$hospital_list=$this->db->query($sql)->result();
		
		
		$this->data['hospital_list']= $hospital_list;
		$this->data['hospital_count']= $this->db->query($sql_count)->num_rows();
		$this->data['doc_count']= $this->data['hospital_count'];
		if($this->data['doc_count']>$count_limit) $this->data['doc_count']=$count_limit;
		$this->data['city']=$city;
		$this->load->view('search_hospital',$this->data);
		
		
		
		}
	
	public function clinics($city=NULL,$speciality=NULL,$pin=NULL,$instant=NULL,$offset=0){
		$this->load->helper('security');
		$city=xss_clean($city);
		$speciality=xss_clean($speciality);
		$pin=xss_clean($pin);
		$instant=xss_clean($instant);
		$offset=xss_clean($offset);
		
		$this->data['instant']=$instant;
		$this->data['number_of_results']=10;
		$nor=$this->data['number_of_results'];
		$lower_limit=$offset*$nor;
		
		$this->data['current_page']=$offset+1;
		
		$city			=sql_filter(($city));
		$speciality		=urldecode(str_replace('_or_','/',sql_filter($speciality)));
		$pin			=urldecode(str_replace('_or_','/',sql_filter($pin)));
		
		
		if($speciality==NULL or $speciality=='NULL') 	$speciality=NULL;
		if($pin==NULL or $pin=='NULL') 					$pin=NULL;
		if($city==NULL or $city=='NULL') 				$city='%%';
		
		
		$speciality=array_filter(explode('-',$speciality));
		$this->data['speciality']=$speciality;
		
		$pin=array_filter(explode('-',$pin));
		$this->data['pin']=$pin;
		
		if(!$this->db->query("SELECT id FROM location where city='$city' limit 1")->num_rows()){$city='%%';}
		
		$filter_str=" (city like '$city' AND ";
		
		if(!empty($speciality)) 	{
			foreach($speciality as $a=>$b){
				$filter_str.=" doctors.speciality_parent like ('%,$b,%') OR " ;
				}
			}
		$filter_str=rtrim($filter_str, "OR ");
		$filter_str=rtrim($filter_str, "AND ");
		if(count($pin)) $filter_str.=" AND pin in ('".implode('\',\'',$pin)."') OR " ;
		
		
		if($instant==1) {
			$filter_str=rtrim($filter_str, "OR ");
			$filter_str=rtrim($filter_str, "AND ");
			$filter_str.=" AND  appointments>0 ";
			}
		
		$filter_str=rtrim($filter_str, "OR ");
		$filter_str=rtrim($filter_str, "AND ");
		
		$filter_str.=') AND ';
		//echo $filter_str;
		$sql="select 
		clinic.id,
		clinic.name as name,
		clinic.doctor_id as doctor_id ,
		doctors.name as doctor_name,
		clinic.rating as rating,
		clinic.phone as phone,
		doctors.speciality_parent,username,
		other_doctors,slug,landmark,street,locality,city,pin,longitude,latitude,appointments,fee
		from clinic
		join doctors on  
		doctors.special_clinic=clinic.id or
		doctor_id=doctors.id
		where $filter_str clinic.visibility=1 
		order by clinic.rank  desc limit $lower_limit,$nor" ;
		
		$sql_count="select 
		clinic.id,  
		doctors.name as doctor_name 
		from clinic join doctors on  doctors.special_clinic=clinic.id or
		doctor_id=doctors.id
		where $filter_str clinic.visibility=1 
		order by clinic.rank  desc limit $lower_limit,$nor" ;
		
		$doctor_list=$this->db->query($sql)->result();
		
		
		$this->data['doctor_list']= $doctor_list;
		$this->data['doc_count']= $this->db->query($sql_count)->num_rows();
		$this->data['city']=$city;
		$this->load->view('search_clinic',$this->data);
		
		
		}
	
	public function doctors($city=NULL,$speciality=NULL,$pin=NULL,$instant=NULL,$offset=0){
		$this->load->helper('security');
		$city=xss_clean($city);
		$speciality=xss_clean($speciality);
		$pin=xss_clean($pin);
		$instant=xss_clean($instant);
		$offset=xss_clean($offset);
		
		$this->data['instant']=$instant;
		$this->data['number_of_results']=10;
		$nor=$this->data['number_of_results'];
		$lower_limit=$offset*$nor;
		
		$this->data['current_page']=$offset+1;
		
		$city			=sql_filter(($city));
		$speciality		=urldecode(str_replace('_or_','/',sql_filter($speciality)));
		$pin			=urldecode(str_replace('_or_','/',sql_filter($pin)));
		
		
		if($speciality==NULL or $speciality=='NULL') 	$speciality=NULL;
		if($pin==NULL or $pin=='NULL') 					$pin=NULL;
		if($city==NULL or $city=='NULL') 				$city='%%';
		
		
		$speciality=array_filter(explode('-',$speciality));
		$this->data['speciality']=$speciality;
		
		$pin=array_filter(explode('-',$pin));
		$this->data['pin']=$pin;
		
		if(!$this->db->query("SELECT id FROM location where city='$city' limit 1")->num_rows()){$city='%%';}
		
		$filter_str=" (city like '$city' AND ";
		
		if(!empty($speciality)) 	{
			foreach($speciality as $a=>$b){
				$filter_str.=" speciality_parent like ('%,$b,%') OR " ;
				}
			}
		$filter_str=rtrim($filter_str, "OR ");
		$filter_str=rtrim($filter_str, "AND ");
		if(count($pin)) $filter_str.=" AND pin in ('".implode('\',\'',$pin)."') OR " ;
		
		
		if($instant==1) {
			$filter_str=rtrim($filter_str, "OR ");
			$filter_str=rtrim($filter_str, "AND ");
			$filter_str.=" AND  appointments>0 ";
			}
		
		$filter_str=rtrim($filter_str, "OR ");
		$filter_str=rtrim($filter_str, "AND ");
		
		$filter_str.=') AND ';
		//echo $filter_str;
		$sql="select doctors.id as doctor_id,view_contact,email,doctors.name as doctor_name,  username,gender,joined,doctors.phone as doctor_phone,unique_id,address_1,address_2,facebook,twitter,  google_plus,website,doctors.speciality,speciality_parent,doctors.like,doctors.rating,doctors.review_count, clinic.id, doctor_id,clinic.name, clinic.phone, clinic.visibility,fee,pin,street,latitude,longitude,appointments, locality,city,landmark, sunday,monday,tuesday,wednesday,thursday,friday, saturday ,slug,dc_verified
		from doctors 
		join clinic on doctors.id=clinic.doctor_id or doctors.special_clinic=clinic.id 
		where $filter_str (clinic.visibility=1 or 1) 
		order by doctors.rank desc,clinic.rank desc limit $lower_limit,$nor";
		
		$sql_count="select doctors.id from doctors join clinic on doctors.id=clinic.doctor_id or doctors.special_clinic=clinic.id  where $filter_str (clinic.visibility=1 or 1) order by doctors.rank desc,clinic.rank desc";
		
		$doctor_list=$this->db->query($sql)->result();
		$this->data['doctor_list']= $doctor_list;
		$this->data['doc_count']= $this->db->query($sql_count)->num_rows();
		$this->data['city']=$city;
		$this->load->view('search',$this->data);
		
		
		}
		
}

