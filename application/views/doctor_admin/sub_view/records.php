<style>
.left_pane {
}
.no-pad {
	padding: 0
}
.smml{ margin:5px 0;border: 1px solid #C7C7C7; padding:0}
.h_h{height:100px}
</style>
<script>
$(document).ready(function(e) {
	get_patients(0);
	
});

$( document ).ajaxComplete(function() {
  q=$('#search_q').val();
  if(q.length){console.log(q);search_patient($('#search_q'))}
});

function get_patients(offset){
	$('#patient_h_body').html('<img src="<?php echo bu('images/ajax-fast-loader.gif');?>" style="display: block;height: 67px;margin: 100px auto;">');
	$.post('<?php echo bu('doctor/get_all_patient/')?>'+offset,function(data){
		 $('#patient_h_body').html(data);
		})
   
	}
function append_patients(offset){
	$('.mmoj').remove();
	$.post('<?php echo bu('doctor/get_all_patient/')?>'+offset,function(data){
		 $('#patient_h_body').append(data);
		})
	}

function get_patients_by_group(offset,g_name){
	$('#patient_h_body').html('<img src="<?php echo bu('images/ajax-fast-loader.gif');?>" style="display: block;height: 67px;margin: 100px auto;">');
	$.post('<?php echo bu('doctor/get_all_patient_from_group/')?>'+offset,{g_name:g_name},function(data){
		 $('#patient_h_body').html(data);
		})
	}
	
function append_patients_by_group(offset,g_name){
	$('.mmoj').remove();
	$.post('<?php echo bu('doctor/get_all_patient_from_group/')?>'+offset,{g_name:g_name},function(data){
		 $('#patient_h_body').append(data);
		})
	}

function get_recent_patients(offset){
	$('#patient_h_body').html('<img src="<?php echo bu('images/ajax-fast-loader.gif');?>" style="display: block;height: 67px;margin: 100px auto;">');
	$.post('<?php echo bu('doctor/get_recent_patient/')?>'+offset,function(data){
		 $('#patient_h_body').html(data);
		})
	}

function append_recent_patients(offset){
	$('.mmoj').remove();
	$.post('<?php echo bu('doctor/get_recent_patient/')?>'+offset,function(data){
		 $('#patient_h_body').append(data);
		})
	}


function search_patient(self){
	$('#patient_h_body').html('<img src="<?php echo bu('images/ajax-fast-loader.gif');?>" style="display: block;height: 67px;margin: 100px auto;">');
	$.post('<?php echo bu('doctor/search_patient')?>',{g_name:self.val()},function(data){
		 $('#patient_h_body').html(data);
		})
	}
</script>
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
<?php if($show_head):?>
    <div class="col-lg-12">
        <h1 class="page-header">Available patients <small>View and edit patient details</small> </h1>
      </div>
<?php endif;?>
  
  
  
  <?php $this->load->view('doctor_admin/components/record_body',$this->data);?>
  
</div>
