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
.detail_head{ width:90%}
.table{margin-bottom:5px}
.s-menu{ position:absolute; right:0}
.callout.callout-success {
background-color: #f0fdf0;
border-color: #d2f0d0;
}
.hid_text{text-overflow: ellipsis;max-width: 120px;overflow: hidden;}
.sm_btn{ display:none}
.sm_btn:last-child{display:block}
.sm_mar{ margin:5px}
</style>
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
  <div class="col-xs-12 no-pad" >
  <a class="btn btn-primary btn-flat btn-sm pull-right sm_mar" href="<?php echo bu('doctor/treatment_plans/'.$p_data->id);?>"> + Add</a>
  <button class="btn btn-success btn-flat btn-sm pull-right sm_mar disabled" id="markcomplete">Mark as Complete</button>
  
    <h1 class="page-header"> &nbsp;&nbsp;TREATMENT PLANS </h1>
  		
    
    
    <div class="col-sm-8 col-xs-12 ">
    <?php display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));?>
<script>
$(document).on('click','.checker',function(){
	length=$('.checker:checked').length;
	if(length){
		$('#markcomplete').removeClass('disabled');
		}
	else {$('#markcomplete').addClass('disabled');}
	});
	
$(document).ready(function(e) { 
    $.post('<?php echo bu('doctor/get_all_treatment_plans_by_id/0');?>',{pid:'<?php echo $p_data->id;?>'},function(data){ 
		$('#treatment_plan_tile_holder').html(data);
		});
	
	$('#markcomplete').click(function(e) {
	   str='';
       $('.checker:checked').each(function(index, element) {
		   str+=$(this).attr('data-parent')+':'+$(this).attr('data-index')+'-::-';
   		}); 
		 
		
		$.post('<?php echo bu('doctor/set_userdata');?>',{var_name:'index',data:str},function(data){
			if(data.localeCompare(str)){
				
				}window.location.href="<?php echo bu('doctor/workdone');?>";
			
			})
		
		//$.post('<?php echo bu('doctor/mark_t_plan');?>',{str:str},function(data){
//			if(data==1) window.location.reload();
//			
//			})
    });
});

function append_result(offset){
	$.post('<?php echo bu('doctor/get_all_treatment_plans_by_id/');?>'+offset,{pid:'<?php echo $p_data->id;?>'},function(data){ 
		$('#treatment_plan_tile_holder').append(data);
		});
	}
</script>

	<div id="treatment_plan_tile_holder">
        <img src="<?php echo bu('images/ajax-loader.gif')?>" style="display:block; margin:200px auto;"  />
    </div> 
    
    </div>
    
    <?php $this->load->view('doctor_admin/components/patient_note');?>
    
    
  </div>
</div>
 