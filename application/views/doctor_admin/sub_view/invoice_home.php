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
.tp{ padding:0 10px; }
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
.badge{ margin:0 10px}
.mega_p p{ margin:0}
.bokka{float: right;}
.mega_p a{ color:#33B2E2 !important}
</style>
<script>
$(document).on('click','.checker',function(){
	length=$('.checker:checked').length;
	if(length){
		$('#markcomplete').removeClass('disabled');
		}
	else {$('#markcomplete').addClass('disabled');}
	});

$(document).ready(function(e) { 
    $.post('<?php echo bu('doctor/get_invoice/0');?>',{<?php if(isset($pid)) echo 'pid:'.$pid?>},function(data){ 
		$('#treatment_plan_tile_holder').html(data);
		});
});

function append_result(offset){
	$.post('<?php echo bu('doctor/get_invoice/');?>'+offset,{<?php if(isset($pid))  echo 'pid:'.$pid?>},function(data){ 
		$('#treatment_plan_tile_holder').append(data);
		});
	}

function prepare_invoice_ids(){
	$('.ajax-marker').show(0);
	delta_array=[];
	$('.checker:checked').each(function(index, element) {
		delta_array.push($(this).val());
		});
	var myJsonString = JSON.stringify(delta_array); 
 	
 	$.post('<?php echo bu('doctor/prepare_invoice_ids');?>',{json:myJsonString},function(data){
		console.log(data);
		if(data==1){
			$('.ajax-marker').hide(0);
			$('.chk-marker').show(0);
			
			window.location.href="<?php  echo bu('doctor/add_payment/'.@$pid);?>";
			}
		});	
	}

</script>
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
 

<h1 class="page-header" style="padding: 10px;">
	  <button class="btn btn-success btn-flat btn-sm pull-right sm_mar disabled" id="markcomplete" onclick="prepare_invoice_ids($(this))">
      <i class="fa fa-check chk-marker" style="display:none"></i>
      <img src="<?php echo bu('images/ajax_rt.gif');?>"  style="display:none" class="ajax-marker" style="display:none"/>
      Pay Selected Invoice</button>
     
    <a data-toggle="modal" onclick="event.preventDefault();" class="btn btn-default" href="<?php echo bu('doctor/records/0/invoice')?>" data-target=".bs-example-modal-lg">
     	 <i class="fa fa-fw fa-users"></i>
     </a>
     <?php if(isset($pid)):?>
      <a style="margin:0 5px" href="<?php echo bu('doctor/add_completed_procedure/'.$pid);?>" class="btn btn-primary btn-flat btn-sm pull-right">+ Add</a>
      <?php endif;?>
    INVOICES  
</h1>
<?php display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));?>


<div class="<?php if(isset($p_data)) echo 'col-sm-8'; else echo 'col-sm-12';?> col-xs-12 ">
    <div id="treatment_plan_tile_holder">
        <img src="<?php echo bu('images/ajax-loader.gif')?>" style="display:block; margin:200px auto;"  />
    </div> 
</div>
 
<?php if(isset($p_data))$this->load->view('doctor_admin/components/patient_note',array('p_data'=>$p_data));?>
 


 
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
