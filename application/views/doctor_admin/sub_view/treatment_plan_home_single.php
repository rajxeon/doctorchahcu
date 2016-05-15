<style>
hr{ margin:3px 0}
.modal-lg {
width: auto ;
}
@media (min-width: 768px){
.modal-dialog {
margin: 30px 5%;
}
}
.tp{ padding:0 10px;}
.sm_dp{ height:40px;}
.detail_head{ width:100%}
.table{margin-bottom:5px}
.s-menu{ position:absolute; right:0}
.callout.callout-success {
background-color: #f0fdf0;
border-color: #d2f0d0;
}
.hid_text{text-overflow: ellipsis;max-width: 120px;overflow: hidden;}
.sm_btn{ display:none}
.sm_btn:last-child{display:block}
</style>
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
<h1 class="page-header" style="padding:5px">
	<a class="btn btn-primary btn-sm btn-flat" style="margin: 6px;float: right;"
     href="<?php echo bu('doctor/treatment_plans/'.$patient_data->id)?>"  >
    + Add New Treatment Plan
    </a>
	
    
    <a data-toggle="modal" onclick="event.preventDefault();" class="btn btn-default" href="<?php echo bu('doctor/records/0/treatment_plans')?>" data-target=".bs-example-modal-lg">
     	 <i class="fa fa-fw fa-users"></i>
     </a>
    Treatment Plans of <?php echo @ucfirst($patient_data->name);?>
    <a href="<?php echo bu('doctor/treatment_plans');?>">
    	<small><u>Show All Treatment Plans</u></small>
    </a>
</h1>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

<?php display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));?>

<script>
$(document).ready(function(e) { 
    $.post('<?php echo bu('doctor/get_treatment_plans/0');?>',{pid:'<?php echo $pid;?>'},function(data){ 
		$('#treatment_plan_tile_holder').html(data);
		});
});

function append_result(offset){
	$.post('<?php echo bu('doctor/get_treatment_plans/');?>'+offset,{pid:'<?php echo $pid;?>'},function(data){ 
		$('#treatment_plan_tile_holder').append(data);
		});
	}
</script>

<div id="treatment_plan_tile_holder">
	<img src="<?php echo bu('images/ajax-loader.gif')?>" style="display:block; margin:200px auto;"  />
</div> 

</div> 
<?php   $this->load->view('doctor_admin/components/patient_note');?>
</div>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      </div>
    </div>
  </div>
</div>
</div>

</div>
