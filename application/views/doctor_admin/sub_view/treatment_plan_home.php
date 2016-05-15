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
.detail_head{ color:#39C}
.detail_head:hover{ color:#666}
</style>
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
<div class="col-lg-12">
<h1 class="page-header">
	<a data-toggle="modal" onclick="event.preventDefault();" class="btn btn-primary btn-sm btn-flat" style="margin: 6px;float: right;" href="<?php echo bu('doctor/records/0/treatment_plans')?>" data-target=".bs-example-modal-lg">
    + Add 
    </a>
	
    
    <a data-toggle="modal" onclick="event.preventDefault();" class="btn btn-default" href="<?php echo bu('doctor/records/0/treatment_plans')?>" data-target=".bs-example-modal-lg">
     	 <i class="fa fa-fw fa-users"></i>
     </a>
    All Patients Treatment Plans<small>Add or Edit treatment plans</small>
</h1>
<?php display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));?>

<script>
$(document).ready(function(e) { 
    $.post('<?php echo bu('doctor/get_treatment_plans/0');?>',function(data){ 
		$('#treatment_plan_tile_holder').html(data);
		});
});

function append_result(offset){
	$.post('<?php echo bu('doctor/get_treatment_plans/');?>'+offset,function(data){ 
		$('#treatment_plan_tile_holder').append(data);
		});
	}
</script>
<div id="treatment_plan_tile_holder">
	<img src="<?php echo bu('images/ajax-loader.gif')?>" style="display:block; margin:200px auto;"  />
</div> 

</div>
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
