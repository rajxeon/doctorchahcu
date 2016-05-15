 <style>
 .sm_btn{ display:none}
.sm_btn:last-child{display:block}
hr{ margin:0 !important}
 </style>
 <script>
$(document).ready(function(e) { 
    $.post('<?php echo bu('agent/get_doctor_list/0');?>',{'q':'<?php echo $q;?>'},function(data){ 
		$('#doctor_holder').html(data);
		$('#sacrifiser').hide(0);
		});
});

function append_result(){
	offset=$('#offset').val();
	$.post('<?php echo bu('agent/get_doctor_list/');?>'+offset,{'q':'<?php echo $q;?>'},function(data){ 
		$('#doctor_holder').append(data);$('#sacrifiser').hide(0);
		$('#offset').val(offset+1);
		});
	}
</script>
<input type="hidden" id="offset" value="1">
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
  <div class="col-lg-12">
     
    <ol class="breadcrumb">
      <li class="active"> <i class="fa fa-dashboard"></i> Dashboard </li>
      <li class="active"> <i class="fa fa-plus"></i> Doctors</li>
      
      	 
       
      <a  href="<?php echo bu('agent/add_new_doctor');?>" style="float: right; margin:-4px 10px" class="btn btn-primary btn-flat btn-sm" ><i class="fa fa-plus"></i> Add new doctor </a>
     
    </ol>
  </div>
    <div class="container-fluid">
    <?php display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));?>
        <div class="box box-primary tp p_parent">
            <div class="box-header">
            <table class="table table-condensed">
                <thead>
                    <th>NAME</th>
                    <th>PHONE</th>
                    <th>EMAIL</th>
                    <th>PLAN</th>
                    <th>JOINED</th>
                    <th>DCV</th> 
                    <th></th>
                </thead>
                <tbody id="doctor_holder">
                <img src="<?php echo bu('images/ajax-loader.gif')?>" style="display:block; margin:200px auto;" id="sacrifiser"  />
                </tbody>
            
            </table>
            
            
            
            </div>
        </div>
         <div align="center" class="sm_btn">
            <button class="btn btn-xs btn-info sm_btn" onclick="append_result()">Show More</button>
            </div>
    </div>
</div>

