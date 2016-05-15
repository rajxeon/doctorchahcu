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
	get_patients(0,'<?php echo $link;?>');
});

function get_patients(offset,links){
	$('#patient_h_body').html('<img src="<?php echo bu('images/ajax-fast-loader.gif');?>" style="display: block;height: 67px;margin: 100px auto;">');
	$.post('<?php echo bu('doctor/get_all_patient/')?>'+offset+'/'+links,function(data){
		 $('#patient_h_body').html(data);
		})
   
	}
function append_patients(offset,links){
	$('.mmoj').remove();
	$.post('<?php echo bu('doctor/get_all_patient/')?>'+offset+'/'+links,function(data){
		 $('#patient_h_body').append(data);
		})
	}

function get_patients_by_group(offset,g_name,links){
	$('#patient_h_body').html('<img src="<?php echo bu('images/ajax-fast-loader.gif');?>" style="display: block;height: 67px;margin: 100px auto;">');
	$.post('<?php echo bu('doctor/get_all_patient_from_group/')?>'+offset+'/'+links,{g_name:g_name},function(data){
		 $('#patient_h_body').html(data);
		})
	}
	
function append_patients_by_group(offset,g_name,links){
	$('.mmoj').remove();
	$.post('<?php echo bu('doctor/get_all_patient_from_group/')?>'+offset+'/'+links,{g_name:g_name},function(data){
		 $('#patient_h_body').append(data);
		})
	}

function get_recent_patients(offset,links){
	$('#patient_h_body').html('<img src="<?php echo bu('images/ajax-fast-loader.gif');?>" style="display: block;height: 67px;margin: 100px auto;">');
	$.post('<?php echo bu('doctor/get_recent_patient/')?>'+offset+'/'+links,function(data){
		 $('#patient_h_body').html(data);
		})
	}

function append_recent_patients(offset,links){
	$('.mmoj').remove();
	$.post('<?php echo bu('doctor/get_recent_patient/')?>'+offset+'/'+links,function(data){
		 $('#patient_h_body').append(data);
		})
	}

function search_patient(self,links){
	$('#patient_h_body').html('<img src="<?php echo bu('images/ajax-fast-loader.gif');?>" style="display: block;height: 67px;margin: 100px auto;">');
	$.post('<?php echo bu('doctor/search_patient')?>'+'/'+links,{g_name:self.val()},function(data){
		 $('#patient_h_body').html(data);
		})
	}
</script>
<div  style=" position:relative; margin:0"  class="right-side">

  
  
  
  <?php $this->load->view('doctor_admin/components/record_body',$this->data);?>
  
</div>
