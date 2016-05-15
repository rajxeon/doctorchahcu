<style>
.f_r {
float: right;
}
.p_name{ width:100px; overflow:hidden;text-overflow: ellipsis;white-space: nowrap;padding: 10px 3px!important;font-size: 16px !important; cursor:pointer !important}
.dpm{ width:40px;padding: 3px 3px!important; float:left}
.link-header{ color:#FFF !important;  cursor:pointer }
.p_smal{ width:auto !important}
.floater{ position:absolute;}
.ferer{max-height: 100vh;overflow: auto;}
 

.ferer::-webkit-scrollbar {  
    width: 6px;  
}  
.ferer::-webkit-scrollbar-track {  
    background-color: #eaeaea;  
    border-left: 1px solid #ccc;  
}  
.ferer::-webkit-scrollbar-thumb {  
    background-color: #050505;  
}  
.ferer::-webkit-scrollbar-thumb:hover {  
    background-color: #aaa;  
}   
</style>
<script>
	$(document).ready(function(e) {
        initial_top=$('.floater').offset().top;
		$('#initial_top').val(initial_top);
		
    });
	$(document).scroll(function(e) {
		if($(document).width()<768) return;
		initial_top=$('#initial_top').val(); 
        var top = $('.floater').offset().top;
		var screenTop = $(document).scrollTop();
		nav_height=$('.navbar.navbar-static-top').height();
		top=top-nav_height; 
		parent_width=$('.floater').parent().width();
		
		
		if(screenTop>=top){$('.floater').css({'position':'fixed','top':nav_height+'px','width':parent_width+'px'});}
		if(screenTop<initial_top-nav_height){$('.floater').css({'position':'absolute','top':'initial','width':'100%'});} 
    });
</script>
<input  id="initial_top" value="0" type="hidden" />
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 no-pad">
    	<div class="box box-solid box-primary floater">
            <a href="<?php echo bu('doctor/view_patient/'.$p_data->id);?>" class="link-header" >
            <div class="box-header bg-primary" style="color: #fff;" > 
            <?php $this->load->view('doctor_admin/components/patient_note_head');?>
            </div>
            </a>
            
            <!-- /.box-header -->
            <div class="box-body ferer">
            
            <h4>Referred by  <a href="<?php echo bu('doctor/edit_patient/'.$p_data->id);?>" class="f_r">Edit</a></h4>
            <?php 
			$refered_by=json_decode($p_data->refered_by,true);
			echo @$refered_by[$this->session->userdata('id')];
			?>
            <hr />
            <h4>Medical History  <a href="<?php echo bu('doctor/edit_patient/'.$p_data->id);?>" class="f_r">Edit</a></h4>
            <?php 
			$medical_history=json_decode($p_data->medical_history,true);
			$medical_history=@$medical_history[$this->session->userdata('id')];
			if(!empty($medical_history))
			foreach($medical_history as $a=>$b){
				echo '<li>'.$b.'</li>';
				}
			
			?>
            
            <hr />
            <h4>Groups  <a href="<?php echo bu('doctor/edit_patient/'.$p_data->id);?>" class="f_r">Edit</a></h4>
            <?php  
			 
			$group=explode('-::-',$p_data->group);
			
			foreach($group as $a=>$b){
				$temp=explode('_',$b); 
				if(isset($temp[1]))
				echo '<li>'.$temp[1].'</li>';
				}
			
			?>
            
            <h4>Virtual Nurse</h4>
            <hr />
            
            <h4>
            <?php 
			//Get the first treatment_plan id of the patient
			$primary=$this->session->userdata('primary');
			$sql="SELECT id FROM treatment_plan WHERE patient_id=$p_data->id and clinic_id=$primary";
			$result=$this->db->query($sql)->result();
			$num_rows=0;
			$num_rows=$this->db->query($sql)->num_rows();
			$result=@$result[0];
			 
			?>
            
            <?php 			if(isset($result->id)):			?>
            <a href="<?php echo bu('doctor/view_treatment_plans/'.@$result->id);?>">
            	Treatment plans 
            </a> 
            
            <?php 			else:			?>
            
            <a href="<?php echo bu('doctor/treatment_plans/'.@$p_data->id);?>">
            	+ Add Treatment plans 
            </a>
            <?php endif;?>
            <small class="badge pull-right bg-red"><?php echo $num_rows?></small>
            
           
            </h4>
            
            <h4>
            <?php 
			//Get the first treatment_plan id of the patient
			$primary=$this->session->userdata('primary');
			$sql="SELECT id FROM completed_procedure WHERE patient_id=$p_data->id and clinic_id=$primary";
			$result=$this->db->query($sql)->result();
			$num_rows=0;
			$num_rows=$this->db->query($sql)->num_rows();
			$result=@$result[0];
			 
			?>
            
           <a href="<?php echo bu('doctor/completed_procedure/'.@$p_data->id);?>">
            	Completed Procedure
            </a> 
            <small class="badge pull-right bg-red"><?php echo $num_rows?></small>
            
           
            </h4>
            <h4>
            <?php 
			//Get the number of files
			$sql="SELECT id FROM files WHERE patient_id=$p_data->id and clinic_id=$primary";
			$result=$this->db->query($sql)->result();
			$num_rows=0;
			$num_rows=$this->db->query($sql)->num_rows();
			$result=@$result[0];
			
			?>
             <a href="<?php echo bu('doctor/file_manager/'.@$p_data->id);?>">
            	Files
            </a> 
            <small class="badge pull-right bg-red"><?php echo $num_rows?></small>
            </h4>
            <h4>
            <?php 
			//Get the number of files
			$sql="SELECT id FROM prescription WHERE patient_id=$p_data->id and clinic_id=$primary";
			$result=$this->db->query($sql)->result();
			$num_rows=0;
			$num_rows=$this->db->query($sql)->num_rows();
			$result=@$result[0];
			
			?>
             <a href="<?php echo bu('doctor/prescription/'.@$p_data->id);?>">
            	Prescription
            </a> 
            <small class="badge pull-right bg-red"><?php echo $num_rows?></small>
            </h4>
            <hr />
            
            <h4>
            <?php 
			//Get the first treatment_plan id of the patient
			$primary=$this->session->userdata('primary');
			$sql="SELECT id FROM invoice WHERE patient_id=$p_data->id and clinic_id=$primary";
			$result=$this->db->query($sql)->result();
			$num_rows=0;
			$num_rows=$this->db->query($sql)->num_rows();
			$result=@$result[0];
			 
			?>
            
            <?php 			if(isset($result->id)):			?>
            <a href="<?php echo bu('doctor/invoice/'.@$p_data->id);?>">
            	Invoice
            </a> 
            
            <?php 			else:			?>
            
            Invoice
            <?php endif;?>
            <small class="badge pull-right bg-red"><?php echo $num_rows?></small>
            
           
            </h4>
            
            <h4>
            <?php  
			$primary=$this->session->userdata('primary');
			$sql="SELECT id FROM payment WHERE patient_id=$p_data->id and clinic_id=$primary";
			$result=$this->db->query($sql)->result();
			$num_rows=0;
			$num_rows=$this->db->query($sql)->num_rows();
			$result=@$result[0];
			 
			?>
            
             
            <a href="<?php echo bu('doctor/payment/'.@$p_data->id);?>">
            	Payments
            </a> 
            
            <small class="badge pull-right bg-red"><?php echo $num_rows?></small>
            
           
            </h4>
             
            </div>
            
            
            <!-- /.box-body -->
        </div>
    </div>