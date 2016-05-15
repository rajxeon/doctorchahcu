<style>
.f_r {
float: right;
}
.p_name{ width:100px !important ; overflow:hidden;text-overflow: ellipsis;white-space: nowrap;padding: 10px 3px!important;font-size: 16px !important; cursor:pointer !important}
.dpm{ width:40px;padding: 3px 3px!important; float:left}
.link-header{ color:#FFF !important;  cursor:pointer }
.p_smal{ width:auto !important; }
</style>
<img src="<?php echo get_dp($p_data);?>" class="dpm" />
                <h3 class="box-title p_name " style="width:100px !important" title=" <?php echo ucfirst($p_data->name)?>"  >  
				<?php echo ucfirst($p_data->name)?></h3>
                <h3 class="box-title p_name p_smal"  >  <?php echo @$p_data->gender?></h3> 
                <h3 class="box-title p_name p_smal"  >  <?php echo get_dob($p_data)?></h3>
                <h3 class="box-title p_name p_smal"  >  &nbsp;&nbsp;&nbsp;
                ID:<?php echo get_optional_id($p_data)?></h3>
                 
               <small class="badge pull-right 
               
               <?php
			   $balence=0; 
			   $sql="SELECT * FROM payment WHERE patient_id=".@$p_data->id." AND clinic_id=".$this->session->userdata('primary');
			   $payment=$this->db->query($sql)->result();
			   if(isset($payment[0])) {
				   $payment=$payment[0];
			   	   $balence=$payment->balence;
			   }
			   ?>
               <?php 
			   $abs_balence=abs($balence);
			   if($balence<0)echo ' bg-red ';
			   else echo ' bg-green';
			   ?>
               " style="margin:11px 10px"><i class="fa fa-inr" ></i> <?php echo $abs_balence?>  
               </small> 