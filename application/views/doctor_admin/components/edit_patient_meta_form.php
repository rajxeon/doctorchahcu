<style>
.mofet{ margin:0 8px}
#leeo,#meeo_c{ font-weight:bold; color:#09C; cursor:pointer}
.mafil,.mafil_g{display:none}
label{width:90%}
i{ cursor:pointer;}
</style>
<script>
	$(document).ready(function(e) {
       //get_medical_history();
	   //get_group_history();
	   //Above functions are invoked in edit_patient_form.php filr
    });
function get_medical_history(){
	 $.post('<?php echo bu('doctor/ajax_load_medical_history_from_meta')?>',function(data){
			$('#geo_guru').html(data);
			return true;
			});
	}
	
function get_group_history(){
	 $.post('<?php echo bu('doctor/ajax_get_group_history')?>',function(data){
			$('#geo_guru_2').html(data);
			return true;
			});

	}
function save_history(self){
	self.html('<img src="<?php echo bu('images/ajax_rt.gif')?>"> Please Wait');
	text=self.parent().find('input').val();
	if(text.length){
		$.post('<?php echo bu('doctor/ajax_save_history')?>',{text:text},function(data){ 
			if(data==1) {get_medical_history();self.html('<i class="fa fa-fw fa-check-square"></i> Saved');}
			})
		} 
	}
function save_group(self){
	self.html('<img src="<?php echo bu('images/ajax_rt.gif')?>"> Please Wait');
	text=self.parent().find('input').val();
	if(text.length){
		$.post('<?php echo bu('doctor/ajax_save_group')?>',{text:text},function(data){ 
			if(data==1){ get_group_history();self.html('<i class="fa fa-fw fa-check-square"></i> Saved');}
			
			})
		} 
	}
function delete_medical_history(index){
	$.post('<?php echo bu('doctor/delete_medical_history')?>',{index:index},function(data){ 
			if(data==1) get_medical_history();
			})
	}
function delete_group(index){
	$.post('<?php echo bu('doctor/delete_group')?>',{index:index},function(data){ 
			if(data==1) get_group_history();
			})
	}
</script>
<div class="box box-primary">
  <div class="box-header" data-toggle="tooltip" title="" data-original-title="Header tooltip">
    <h3 class="box-title">Medical History</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button class="btn btn-primary btn-xs" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
<div class="box-body">
<p align="right" id="leeo" onClick="$(this).next().show(200);">Add new</p>
<div class="mafil">
    <div col-lg-8>
     <input type="text" placeholder="Type New Medical History Here" class="form-control"></div>
     <button style="margin-top: 5px;" class="btn btn-success btn-flat" onClick="save_history($(this))">Save</button> 
     <button style="margin-top: 5px;" class="btn btn-primary btn-flat" onClick="$(this).parent().hide(200);">Close</button> 
</div>
<hr>
<div  id="geo_guru">
<img src="<?php echo bu('images/ajax-loader.gif')?>" style="display:block; margin:0 auto">
</div>

  </div>
</div>

<div class="box box-primary">
  <div class="box-header" data-toggle="tooltip" title="" data-original-title="Header tooltip">
    <h3 class="box-title">Groups</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button class="btn btn-primary btn-xs" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
<div class="box-body">
<p align="right" id="leeo" onClick="$(this).next().show(200);">Add new Group</p>

<div class="mafil_g">
    <div col-lg-8>
     <input type="text" placeholder="Type New Group Name Here" class="form-control"></div>
     <button style="margin-top: 5px;" class="btn btn-success btn-flat" onClick="save_group($(this))">Save</button> 
     <button style="margin-top: 5px;" class="btn btn-primary btn-flat" onClick="$(this).parent().hide(200);">Close</button> 
</div>
<hr>
<div  id="geo_guru_2">
<img src="<?php echo bu('images/ajax-loader.gif')?>" style="display:block; margin:0 auto">
</div>

  </div>
</div>
