<style>
.aqua_li li{min-height: 25px;border-bottom: 1px solid #41FF81;}
.bg-blue-gradient li{min-height: 25px;border-bottom: 1px solid #41BAFF;} 
.sheet_table td{ padding-right:15px; line-height:15px; }
.sheet_table td:nth-child(1){min-width:50%; max-width:50%; width:50%}
.sheet_table td:nth-child(2){min-width:30%; max-width:30%; width:30%}
.sheet_table td:nth-child(3){min-width:20%; max-width:20%; width:20%}
.sheet_table{ margin-top:-17px;width: 100%;}
.pointer{ cursor:pointer;}
.pointer:hover{ opacity:.8}
.msg_content li{ border:none !important}
.msg_content strong{margin-left: 25px !important;}
.msg_content button.close{right: inherit !important; top:inherit !important}
.timeline{background: #F8F8F8;
border-radius: 5px;
border: 1px solid #CFCFCF;
padding: 10px 0 10px 5px;
max-height: 370px;
overflow-y: auto;margin-bottom:3px !important}
.timeline:before{ left:35px !important; }
.timeline > li > .timeline-item > .timeline-header{font-weight: bold;text-transform: capitalize;color: rgb(34, 0, 145);}
 
</style>
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
<div class="col-lg-12">
<?php 
$sql="SELECT * FROM clinic WHERE (doctor_id='".$this->session->userdata('id')."' OR other_doctors LIKE '%,".$this->session->userdata('id').",%') AND id=$clinic_id";

$numrows=$this->db->query($sql)->num_rows();
if(!$numrows)die('Clinic id is not valid');

//Get Clinic data
$sql="SELECT * FROM clinic where id=$clinic_id LIMIT 1";
$clinic_data=$this->db->query($sql)->result();
$clinic_data=$clinic_data[0];
?>
<h1 class="page-header">
    Appointments under <?php echo $clinic_data->name?><small>Add or Edit your appointments</small>
</h1>

<ol class="breadcrumb">
    <li class="active">
        <i class="fa fa-dashboard"></i> Dashboard
        </li><li class="active">
        <i class="fa fa-edit"></i> Appointment /  
        <i class="fa fa-plus-square"></i> <?php echo $clinic_data->name?>
    </li>
    
</ol>
</div>
<div style="clear:both">
	<!-- Calender and details holder -->
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    	<!-- Calender holder -->
        
        <div class="datepicker ll-skin-siena"></div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-6 hidden-xs">
    	<!-- Clinic details holder -->
    </div>
    
    <!-- End of Calender and details holder -->
</div>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link href="<?php echo bu('style/datepicker.css')?>" rel="stylesheet" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script>
	$(document).ready(function(e) {
        date='<?php echo date('m/d/y');?>';
		get_sheet();
		
		var today = new Date();
		//var tomorrow = new Date(today.getTime() + (24 * 60 * 60 * 1000));
		tomorrow =today;
		$('.datepicker').datepicker({
			  maxDate: "+1m",
			  minDate: tomorrow,
			  autoSize: true,
			  showAnim: "fold",
			  dateFormat: "mm/dd/yy",
				onSelect: function (date) {
				$('#sheet_holder').html('<div align="center"><img src="<?php echo bu('images/ajax-loader.gif');?>"></div>');
				get_sheet(date);
				}
			});
		
		 
		
    });
	
	function get_sheet(date){
		if(!date) date='<?php echo date('m/d/y');?>';
		clinic_id='<?php echo $clinic_data->id;?>';
		$.post('<?php echo bu('doctor/generete_sheet');?>',{date:date,clinic_id:clinic_id},function(data){
			$('#sheet_holder').html(data);
			
			dateString=date;
			var startDate = new Date(dateString);

			// seconds * minutes * hours * milliseconds = 1 day 
			var day = 60 * 60 * 24 * 1000;
			var tomorrow = new Date(startDate.getTime() + day);
			next_day=((tomorrow.getMonth() + 1) + '/' + tomorrow.getDate() + '/' +  tomorrow.getFullYear());
			get_sheet_2(next_day);
			});
		}
		
	function get_sheet_2(date){
		if(!date) date='<?php echo date('m/d/y');?>';
		clinic_id='<?php echo $clinic_data->id;?>';
		$.post('<?php echo bu('doctor/generete_sheet');?>',{date:date,clinic_id:clinic_id,blue:1},function(data){
			$('#sheet_holder').append(data);
			});
		}
	
	function add_adder(self){
		input_name	=self.parent().prev().prev();
		input_phone	=self.parent().prev();
		submit_btn	=self.parent();
		timestamp	=self.attr('data-timestamp');
		
		input_name.html('<div class="input-group"> <span class="input-group-addon"><i class="fa fa-user"></i></span><input type="text" class="form-control input-sm" placeholder="Name" name="name"></div>');
		input_phone.html('<div class="input-group"> <input type="text" pattern="[0-9]*" class="form-control input-sm" placeholder="Phone" name="phone"></div>');
		submit_btn.html('<button data-timestamp="'+timestamp+'" class="btn btn-xs btn-default btn-block" onclick="save_appointment($(this))"><i class="fa fa-fw fa-floppy-o"></i> Save</button>');
		}
	
	function save_appointment(self){
		name_td		=self.parent().prev().prev();
		input_name	=self.parent().prev().prev().find($('input')).val();
		phone_td	=self.parent().prev();
		input_phone	=self.parent().prev().find($('input')).val();
		msg_content =self.parent().parent().parent().parent().next();
		submit_btn	=self.parent();
		timestamp	=self.attr('data-timestamp');
		errors=[];
		
		if((input_name.length==0)){errors.push('Name can not be empty')}
		if((input_phone.length==0)){errors.push('Phone number is required')}
		if((timestamp.length==0)){errors.push('Time is not feed')}
		if(errors.length){
			html='<div class="alert alert-danger alert-dismissable" style="margin-left:0; padding:0; margin-top:10px"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Errors</strong><br><ol>';
			for(var i in errors){
				html+='<li>'+errors[i]+'</li>';
				}
			html+='<ol></div>';
			msg_content.html(html);
			return;
			}
		else{
			$.post('<?php echo bu('helper/set_appointment');?>',{name:input_name,phone:input_phone,clinic_id:<?php echo $this->uri->segment(3)?>,doctor_id:<?php echo $this->session->userdata('id');?>,time:timestamp,manual:true},function(data){
				if(data && data.indexOf('duplicate')<0){
					//Success
					submit_btn.html('<span class="complete_btn"><i class="glyphicon glyphicon-step-forward btn btn-xs"  data-app_id="'+data+'" title="Complete this Appointment"   onclick="complete_appointment($(this))"></i></span><i class="glyphicon glyphicon-trash btn btn-xs" title="Delete this Appointment"  data-app_id="'+data+'" onclick="if(confirm(\'Are you sure?\')) delete_appointment($(this))"></i><i class="glyphicon glyphicon-open btn btn-xs" data-toggle="modal" data-target=".bs-example-modal-lg" title="See patient past records" onclick="patient_details($(this))" data-phone="'+input_phone+'" data-name="'+input_name+'" data-email="0"></i>');
					name_td.html('<strong>'+input_name+'</strong>');
					phone_td.html(input_phone);
					}
				if(data==0){
					//Failure
					submit_btn.html('<button data-timestamp="'+timestamp+'" class="btn btn-xs btn-danger btn-block" onclick="save_appointment($(this))"><i class="fa fa-fw fa-floppy-o"></i> Save</button>');
					}
				if(data.indexOf('duplicate')>=0){
					//Duplicate appointment entry warning message
					array=data.split('_');
					dama=array[1];
					submit_btn.html('<span class="complete_btn"><i class="glyphicon glyphicon-step-forward btn btn-xs"  data-app_id="'+dama+'" title="Complete this Appointment"   onclick="complete_appointment($(this))"></i></span><i class="glyphicon glyphicon-trash btn btn-xs" title="Delete this Appointment"  data-app_id="'+dama+'" onclick="if(confirm(\'Are you sure?\')) delete_appointment($(this))"></i><i class="glyphicon glyphicon-open btn btn-xs" data-toggle="modal" data-target=".bs-example-modal-lg" title="See patient past records" onclick="patient_details($(this))" data-phone="'+input_phone+'" data-name="'+input_name+'" data-email="0"></i>');
					
					name_td.html('<strong>'+input_name+'</strong>');
					phone_td.html(input_phone);
					msg_content.html('<div class="alert alert-danger alert-dismissable" style="margin-left:0; padding:0; margin-top:10px"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Duplicate Entry</strong><br>Appointment added but another appoint is already fixed on this day from this phone.</div>');
					}
				
				});
			}
		
		}
	function complete_appointment(self){
		app_id=self.attr('data-app_id');
		$.post('<?php echo bu('doctor/complete_appointment');?>',{app_id:app_id},function(data){
			if(data==1){self.parent().html('<i class="glyphicon glyphicon-ok btn-xs  "></i>');}
			});
		}
	function delete_appointment(self){
		app_id=self.attr('data-app_id');
		$.post('<?php echo bu('doctor/delete_appointment');?>',{app_id:app_id},function(data){
			if(data==1){self.parent().parent().parent().parent().parent().remove();}
			});
		}
	function patient_details(self){
		phone=self.attr('data-phone');
		email=self.attr('data-email');
		if(email==0) ref_email='N/A';
		else ref_email=email;
		name=self.attr('data-name');
		$('#patient_details').html('<div align="center"><img src="<?php echo bu('images/ajax-loader.gif');?>" style="margin:50px; " /></div>');
				
		html='<div class="row"><div class="col-lg-4 col-sm-4 col-xs-6"><h5><strong><i class="fa fa-fw fa-user"></i> '+name+'</strong></h5></div> <div class="col-lg-4 col-sm-4 col-xs-6"><h5> <i class="fa fa-fw fa-phone"></i>'+phone+'</h5></div> <div class="col-lg-4 col-sm-4 col-xs-6"><h5><i class="fa fa-fw fa-envelope"></i> '+ref_email+'</h5></div></div>';
		
		$.post('<?php echo bu('doctor/get_patient_details/');?>'+name,{phone:phone},function(data){
			html+=data;
			$('#patient_details').html(html);
			$('.patient_report').wysihtml5();
			});
		}
	function save_patient_report(self){
		event.preventDefault();
		if(!$(event.target).hasClass('submit_rt')) return;
		
		title=self.find($('.title_f')).val();
		patient_report=self.find($('.patient_report')).val();
		phone_number=self.find($('.phone_number')).val();
		
		$.post('<?php echo bu('doctor/save_report');?>',
		{title:title,report:patient_report,phone:phone_number},function(data){
			if(data!=1){$('.report_msg_holder').html(data);}
			else if(data==1){self.find($('.submit_rt')).addClass('btn-success').html('<i class="fa fa-check"></i> <strong>Saved</strong>');}
			});
		}
		
		function update_patient_report(self){
		event.preventDefault();
		if(!$(event.target).hasClass('submit_rt')) return;
		
		title=self.find($('.title_f')).val();
		patient_report=self.find($('.patient_report')).val();
		phone_number=self.find($('.phone_number')).val();
		
		$.post('<?php echo bu('doctor/update_report');?>',
		{title:title,report:patient_report,phone:phone_number},function(data){
			if(data!=1){$('.report_msg_holder').html(data);}
			else if(data==1){self.find($('.submit_rt')).addClass('btn-success').html('<i class="fa fa-check"></i> <strong>Saved</strong>');}
			});
		}
	
	function append_report(name,offset,phone){
		$('#patient_details').html('<div align="center"><img src="<?php echo bu('images/ajax-loader.gif');?>" style="margin:50px; " /></div>');
		html='<div class="row"><div class="col-lg-4 col-sm-4 col-xs-6"><h5><strong><i class="fa fa-fw fa-user"></i> '+name+'</strong></h5></div> <div class="col-lg-4 col-sm-4 col-xs-6"><h5> <i class="fa fa-fw fa-phone"></i>'+phone+'</h5></div> <div class="col-lg-4 col-sm-4 col-xs-6"><h5><i class="fa fa-fw fa-envelope"></i> '+ref_email+'</h5></div></div>';
		url='<?php echo bu('doctor/get_patient_details/');?>'+name+'/'+offset;
		$.post(url,{phone:phone},function(data){
			html+=data;
			$('#patient_details').html(html);
			});
		}
	
	function append_full_report(name,offset,phone,code){
		$('#patient_details').html('<div align="center"><img src="<?php echo bu('images/ajax-loader.gif');?>" style="margin:50px; " /></div>');
		html='<div class="row"><div class="col-lg-4 col-sm-4 col-xs-6"><h5><strong><i class="fa fa-fw fa-user"></i> '+name+'</strong></h5></div> <div class="col-lg-4 col-sm-4 col-xs-6"><h5> <i class="fa fa-fw fa-phone"></i>'+phone+'</h5></div> <div class="col-lg-4 col-sm-4 col-xs-6"><h5><i class="fa fa-fw fa-envelope"></i> '+ref_email+'</h5></div></div>';
		url='<?php echo bu('doctor/get_patient_details_full/');?>'+name+'/'+offset+'/'+code;
		$.post(url,{phone:phone},function(data){
			html+=data;
			$('#patient_details').html(html);
			});
		}
		
		
	function add_report_form(self,phone,name){
		
		$('#patient_details').html('<div align="center"><img src="<?php echo bu('images/ajax-loader.gif');?>" style="margin:50px; " /></div>');
				
		html='<div class="row"><div class="col-lg-4 col-sm-4 col-xs-6"><h5><strong><i class="fa fa-fw fa-user"></i> '+name+'</strong></h5></div> <div class="col-lg-4 col-sm-4 col-xs-6"><h5> <i class="fa fa-fw fa-phone"></i>'+phone+'</h5></div> <div class="col-lg-4 col-sm-4 col-xs-6"><h5><i class="fa fa-fw fa-envelope"></i> N/A</h5></div></div>';
		
		$.post('<?php echo bu('doctor/get_patient_details/');?>'+name,{phone:phone,update:1},function(data){
			html+=data;
			$('#patient_details').html(html);
			$('.patient_report').wysihtml5();
			});
		}
	
	function verify_phone_total_report(self,phone,name){
		self.after('<div class="hidden_ajax" align="center"><img src="<?php echo bu('images/ajax-loader.gif');?>" style="margin:50px; " /></div>');
		$.post('<?php echo bu('doctor/generate_verification_and_sms/');?>',{phone:phone},function(data){
			if(data==1){
				self.replaceWith('<div style="margin: 5px 0;" class="alert alert-success"><b><i class="fa fa-fw fa-check-square"></i> Verification required.</b>A verification sms has been sent to <strong>'+phone+'</strong>. Please enter the code below and click verify. <div style="width: 30%;min-width: 200px;" class="input-group input-group-sm"> <input type="text" class="form-control"> <span class="input-group-btn"> <button class="btn btn-success btn-flat" type="button" data-phone="'+phone+'" onclick="verify_and_serve_result($(this))"> <i class="fa fa-fw fa-check-circle"></i> Verify</button>  </span>  </div></div>');
				}
			
			else self.replaceWith('<div style="margin: 5px 0;" class="alert alert-danger"><b><i class="fa-exclamation-triangle"></i> Error.</b>Something went wrong.</div>');
			});
			$('.hidden_ajax').remove();
		
				}
		function verify_and_serve_result(self){
			code=self.parent().prev().val();
			phone=self.attr('data-phone');
			$('#patient_details').html('<div align="center"><img src="<?php echo bu('images/ajax-loader.gif');?>" style="margin:50px; " /></div>');
		html='<div class="row"><div class="col-lg-4 col-sm-4 col-xs-6"><h5><strong><i class="fa fa-fw fa-user"></i> '+name+'</strong></h5></div> <div class="col-lg-4 col-sm-4 col-xs-6"><h5> <i class="fa fa-fw fa-phone"></i>'+phone+'</h5></div> <div class="col-lg-4 col-sm-4 col-xs-6"><h5><i class="fa fa-fw fa-envelope"></i> '+ref_email+'</h5></div></div>';
		url='<?php echo bu('doctor/get_patient_details_full/');?>'+name;
		$.post(url,{phone:phone,code:code},function(data){
				if(data==0){
					html+='<div style="margin: 5px 0;" class="alert alert-danger"><b><i class="fa fa-fw fa-check-square"></i> Invalid code.</b>Please try again. <div style="width: 30%;min-width: 200px;" class="input-group input-group-sm"> <input type="text" class="form-control"> <span class="input-group-btn"> <button class="btn btn-danger btn-flat" type="button" data-phone="'+phone+'" onclick="verify_and_serve_result($(this))"> <i class="fa fa-fw fa-exclamation-circle"></i> Verify</button>  </span>  </div></div>';
					}
				else{
					html+=data;
					}
				$('#patient_details').html(html);
				});
			}
</script>

<br  clear="all" />
<hr />

<!--<button class="btn btn-primary" onclick="get_sheet()">Get Sheet</button>-->

<div style="clear:both" id="sheet_holder">

</div>



</div><!-- End of warper -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
     <div class="modal-header bg-blue-gradient" style="border-top-left-radius:5px;border-top-right-radius:5px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-fw fa-wheelchair"></i> Patient Details</h4>
      </div>
      <div class="modal-body" id="patient_details" style="padding-bottom: 0;">
       <div align="center"><img src="<?php echo bu('images/ajax-loader.gif');?>" style="margin:50px; " /></div>
      </div>
      <div class="modal-footer" style="background: #EDEDED;">
        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" >Close</button>
      </div>
    </div>
  </div>
</div>
