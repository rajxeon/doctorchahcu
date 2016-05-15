<style>
.dp{padding: 0 15px; max-height:150px}
.dl-horizontal dt{width:100px;}
.dl-horizontal dd {
margin-left: 110px;
}
hr{ margin:3px 0}

.dl-horizontal dt {
	float:left;
	margin-right:12px;
overflow: hidden;
clear: left;
text-align: right;
text-overflow: ellipsis;
white-space: nowrap;
}
.f_r{ float:right;}

.modal-lg {
width: auto ;
}
@media (min-width: 768px){
.modal-dialog {
margin: 30px 5%;
}
}
</style>
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
  <div class="col-lg-12">
    <h1 class="page-header">
    <a href="<?php echo bu('doctor/edit_patient/'.$p_data->id);?>" class="btn btn-primary btn-flat" style="float:right">
    	<i class="fa fa-fw fa-pencil"></i> Edit Patient Profile
    </a>
     <a data-toggle="modal" onclick="event.preventDefault();" class="btn btn-default" href="<?php echo bu('doctor/records/0/view_patient')?>" data-target=".bs-example-modal-lg">
     	 <i class="fa fa-fw fa-users"></i>
     </a>
    
    PATIENT PROFILE <small>View and edit patient details</small> 
    
    </h1>
    <?php display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));?>
  </div>
  

<div class="">
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" align="center">
    
    	<?php 
		$p_data=$p_data;
		$img_src='';
		if(file_exists('patients/'.$p_data->id.'/dp.jpg')) $img_src='patients/'.$p_data->id.'/dp.jpg';
		else{
			if($p_data->gender=='M') $img_src =bu('images/avatar5.png');
			else if($p_data->gender=='F') $img_src= bu('images/avatar_lady.jpg');
			else  $img_src =bu('images/user.png');
			}
		?>
    	<img class="dp" src="<?php echo $img_src;?>"/>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    	<dl class="dl-horizontal"> 
        	<?php if(!empty($p_data->optional_id)):?>
            
            <?php $lipli= array_filter(json_decode($p_data->optional_id,true));
			if(isset($lipli[$this->session->userdata('id')])){
				echo '<dt>ID</dt>';
				echo '<dd>'.$lipli[$this->session->userdata('id')].'</dd>';
				}
			?>
            <?php endif;?>
        
			<?php if(!empty($p_data->name)):?>
            <dt>Name</dt>
            <dd><?php echo ucfirst($p_data->name);?></dd>
            <?php endif;?>
            
              
            <?php if(!empty($p_data->aadhaar)):?>
            <dt>Aadhaar</dt>
            <dd><?php echo ($p_data->aadhaar);?></dd>
            <?php endif;?>
            
            <?php if(!empty($p_data->gender)):?>
            <dt>Gender</dt>
            <dd><?php echo ucfirst($p_data->gender);?></dd>
            <?php endif;?>
            
            <?php if(!empty($p_data->dob)):?>
            <dt>Age</dt>
            <dd><?php 
			echo @date_diff(date_create(str_replace('/','-',$p_data->dob)), date_create('today'))->y;?></dd>
            <?php endif;?>
                                        
            <?php if(!empty($p_data->occupation)):?>
            <dt>Occupation</dt>
            <dd><?php echo ucfirst($p_data->occupation);?></dd>
            <?php endif;?>   
            
            <?php if(!empty($p_data->blood_group)):?>
            <dt>Blood group</dt>
            <dd><?php echo ucfirst($p_data->blood_group);?></dd>
            <?php endif;?>       
            
            <?php if(!empty($p_data->family)):?>
            <?php $exp=array_filter(explode('-::-',$p_data->family));
			if(!empty($exp)):
			?>
            <dt>Relation</dt>
            <dd>
			
			<?php echo @ucfirst($exp[0]).' of <strong>'.ucfirst($exp[1]).'</strong>';
			?></dd>
            <?php endif;endif;?>     
            
            <h4>Contact Details</h4>     
            <hr />
            <?php if(!empty($p_data->email)):?>
            <dt>Email</dt>
            <dd><?php echo ($p_data->email);?></dd>
            <?php endif;?>   
           
            <?php if(!empty($p_data->phone)):?>
            <dt>Phone</dt>
            <dd><?php echo ucfirst($p_data->phone);?></dd>
            <?php endif;?>
            
            <?php if(!empty($p_data->street) or !empty($p_data->locality) or !empty($p_data->city)):?>
            <dt>Address</dt>
            <dd><?php 
			if(!empty($p_data->street)) echo ucfirst($p_data->street).'/';
			if(!empty($p_data->locality)) echo ucfirst($p_data->locality).'/';
			if(!empty($p_data->city)) echo ucfirst($p_data->city);		
			?></dd>
            <?php endif;?>
            
            <?php if(!empty($p_data->pin)):?>
            <dt>Pin code</dt>
            <dd><?php echo ucfirst($p_data->pin);?></dd>
            <?php endif;?>
                    
       </dl>
    </div>
    <?php $this->load->view('doctor_admin/components/patient_note.php');?>
   

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      </div>
    </div>
  </div>
</div>
</div>

</div>

