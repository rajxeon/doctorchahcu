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
<script>
$(document).on('click','.checker',function(){
	length=$('.checker:checked').length;
	if(length){
		$('#markcomplete').removeClass('disabled');
		}
	else {$('#markcomplete').addClass('disabled');}
	});

$(document).ready(function(e) { 
    $.post('<?php echo bu('doctor/get_completed_procedure/0');?>',{<?php if(isset($pid)) echo 'pid:'.$pid?>},function(data){ 
		$('#treatment_plan_tile_holder').html(data);
		});
});

function append_result(offset){
	$.post('<?php echo bu('doctor/get_completed_procedure/');?>'+offset,{<?php if(isset($pid))  echo 'pid:'.$pid?>},function(data){ 
		$('#treatment_plan_tile_holder').append(data);
		});
	}

function prepare_invoice(){
	$('.ajax-marker').show(0); 
	delta_array={};
	$('.checker:checked').each(function(index, element) {
        parent			=$(this).closest('.procedures ');
		
		pro_name		=parent.find('.pro_name').text();
		price			=parent.find('.price').text();
		discount		=parent.find('.discount').text();
		note			=parent.find('.note').text();
		vig				=parent.find('.vig').text(); 
		origin_id		=parent.find('.origin_id').val(); 
		p_id			=parent.find('.p_id').val();  
		json_array={};
		
		json_array['pro_name']	=pro_name;
		json_array['price']		=price;
		json_array['discount']	=discount;
		json_array['note']		=note;
		json_array['vig']		=vig; 
		json_array['origin_id']	=origin_id;
		json_array['p_id']		=p_id;
		
		
		delta_array[index]=json_array;
    });
	var myJsonString = JSON.stringify(delta_array); 
 	
 	$.post('<?php echo bu('doctor/invoice_selected');?>',{json:myJsonString},function(data){
		console.log(data);
		if(data==1){
			$('.ajax-marker').hide(0);
			$('.chk-marker').show(0);
			window.location.href="<?php echo bu('doctor/completed_procedure/'.@$pid);?>";
			}
		});	
	}

</script>
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
 

<h1 class="page-header" style="padding: 10px;">
	  <button class="btn btn-success btn-flat btn-sm pull-right sm_mar disabled" id="markcomplete" onclick="prepare_invoice($(this))">
      <i class="fa fa-check chk-marker" style="display:none"></i>
      <img src="<?php echo bu('images/ajax_rt.gif');?>"  style="display:none" class="ajax-marker" style="display:none"/>
      Invoice Selected Procedure</button>
     
    <a data-toggle="modal" onclick="event.preventDefault();" class="btn btn-default" href="<?php echo bu('doctor/records/0/completed_procedure')?>" data-target=".bs-example-modal-lg">
     	 <i class="fa fa-fw fa-users"></i>
     </a>
     <?php if(isset($pid)):?>
      <a style="margin:0 5px" href="<?php echo bu('doctor/add_completed_procedure/'.$pid);?>" class="btn btn-primary btn-flat btn-sm pull-right">+ Add</a>
      <?php endif;?>
    Completed Procedures
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
