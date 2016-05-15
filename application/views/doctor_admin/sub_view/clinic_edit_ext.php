<style>
#ajax_field input {
	float: right;
	display: inline-block;
}
#ajax_field label {
	min-width:100px
}
table td {
	text-align:center
}
.mega_me a {
	cursor:pointer;
}
.mega_me {
	width:100%;
	-webkit-user-select: none;  /* Chrome all / Safari all */
	-moz-user-select: none;     /* Firefox all */
	-ms-user-select: none;      /* IE 10+ */
	/* No support for these yet, use at own risk */
  -o-user-select: none;
	user-select: none;
}
i.fa.fa-fw.fa-times-circle {
	float: right;
	color: #3C8DBC;
}
i.fa.fa-fw.fa-times-circle:hover {
	color:#0066FF
}
#jama_holder .dropdown-menu {
	z-index:100
}
input.form-control.time_picker {
	z-index:1
}
.chk_box {
	height:18px;
	width:18px;
	display:inline-block;
background:url(<?php echo bu('style/iCheck/minimal/minimal.png');
?>);
	background-position: 100px 0;
	cursor:pointer;
	margin: -4px 5px;
}
.chk_box:hover {
	background-position: 80px 0;
}
.chk_box_selected {
	background-position: 60px 0;
}
#jama_holder hr {
	margin:0;
	margin:10px 0 10px 0
}
</style>
<?php 
$clinic_id=$this->uri->rsegment(3);
$doctor_id=$this->session->userdata('id');
$clinic_data=$this->db->query("SELECT * FROM clinic WHERE (doctor_id='$doctor_id' OR other_doctors LIKE '%,".$this->session->userdata('id').",%') AND id='$clinic_id' ")->result(); 

$clinic_data=$clinic_data[0];

?>
<script>
function get_address(val){
		$('.ajax_img_holder').html('<img src="<?php echo bu('images/ajax_rt.gif');?>"/>');
		url='<?php echo bu('doctor/ajax_address_getter/');?>'+val;
            $.post(url,'',function(data){
			if(data==0){
				$('.ajax_img_holder').html('');
				$('.error_holder').html('<div class="alert alert-danger" role="alert"><i class="glyphicon glyphicon-remove"></i><strong>Pin error</strong> The pin code is not valid or this pin is not in our database </div>');
				}
			else{
				$('.error_holder').html('');
				var obj = JSON.parse(data);
				$('#ajax_state').val(obj.state);
				$('#ajax_district').val(obj.district);
				
				city_list=obj.city;
				city_list=city_list.split(',');
				str=''
				selected_city='<?php echo $clinic_data->city; ?>';
				
				for(var key in city_list){
					if((city_list[key]).trim()==selected_city.trim()) str+='<option selected>'+city_list[key]+'</option>';
					else str+='<option>'+city_list[key]+'</option>';
					}
				$('#ajax_city').html(str);
				
				locality_list=obj.locality;
				locality_list=locality_list.split(',');
				selected_locality='<?php echo $clinic_data->locality; ?>';
				str=''
				for(var key in locality_list){
					if((locality_list[key]).trim()==selected_locality.trim()) str+='<option selected>'+locality_list[key]+'</option>';
					else str+='<option>'+locality_list[key]+'</option>';
					}
				$('#ajax_locality').html(str);
				//$('#ajax_district').removeAttr('disabled');
//				$('#ajax_state').removeAttr('disabled');
				$('.ajax_img_holder').html('');
				}
			}
		);
      
	}
$(document).ready(function(e) {
      $('#pin_finder').blur(function(e) {get_address($(this).val())});
	get_address($('#pin_finder').val());
	
	$('.form_submition').submit(function(e) {
		ajax_holder=$(this).find('#ajax_holder')
		ajax_holder.html('<img src="<?php echo bu('images/ajax_rt.gif');?>">');
		id=$(this).attr('id')
		e.preventDefault();
		data_array={}
		data_array['id']		=$('#'+id+" [name=\'id\']").val();
		data_array['doctor_id']	=$('#'+id+" [name=\'doctor_id\']").val();
		data_array['clinic_id']	=$('#'+id+" [name=\'clinic_id\']").val();
		day={}
		$('#'+id+" [name=\'ckb_sunday\']").each(function(index, element) {
			day[$(this).val()]=$(this)[0].checked;
            });
		data_array['days']	=day;
		
		start_end='['
		$('#'+id+" [name=\'start\']").each(function(index, element) {
			end_element=$(this).parentsUntil('tr').next().find('[name=\'end\']');
			start_end+='{';
			
			start_end+='"'+$(this).attr('data-role')+'":"'+$(this).val().replace(' ',':')+'",';
			start_end+='"'+end_element.attr('data-role')+'":"'+end_element.val().replace(' ',':')+'"';
			
			start_end+='},';
            });
		start_end=start_end.slice(0, -1)
		start_end+=']'
		data_array['start_end']=start_end;
		
		$.post('<?php echo bu('doctor/ajax_form_submit_shedule')?>',{data_array:(JSON.stringify(data_array))},function(data){
			ajax_holder.html('<img width="20px" src="<?php echo bu('images/clear-tick-icon-black.png');?>">');
			//console.log(data);
			populate_days();
			})
		
      });

});

</script>

<div id="page-wrapper" style=" position:relative;min-height: 200vh;" class="right-side">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Clinic <small>Edit and shedule your appointments</small> </h1>
        <ol class="breadcrumb">
            <li class="active"> <i class="fa fa-dashboard"></i> Dashboard </li>
            <li class="active"> <i class="fa fa-edit"></i> Clinic </li>
            <li class="active"> <i class="glyphicon glyphicon-th-large"></i> Edit </li>
        </ol>
    </div>
    <div class="col-lg-12">
        <div class="row"> <br clear="all" />
            <?php 
		if(isset($message) and isset($type))display_msg($message,$type);
		display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));
		
	?>
            <div class="col-lg-7 col-md-12">
                
                <?php 
		    if($clinic_data->visibility==0){
			    echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-warning"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b> This clinic is not visible to the public. Please contact the clinic admin to activate this clinic.
						   
                                    </div>';
			    }
		    ?>
                <h3 style="margin: 0;">Clinic Details</h3>
                <hr />
                <?php echo form_open();?>
                <div class="form-group">
                
                	  <div class="input-group" style="width:100%">
                      <span class="input-group-addon" style="width:100px"><i class="fa fa-fw fa-hospital-o"></i> Clinic Name</span>
                      <input class="form-control"   readonly="readonly" value="<?php echo $clinic_data->name;?>">
                    </div>
                    
                   
                    
                </div>
                <div class="form-group">
                <div class="input-group" style="width:100%">
                   <span class="input-group-addon"  style="width:100px"><i class="fa fa-fw fa-phone"></i> Phone</span>
                   <input class="form-control"  readonly="readonly" value="<?php echo $clinic_data->phone;?>" type="text">
                </div>
                   
                </div>
                <div class="form-group">
                <div class="input-group" style="width:100%">
                   <span class="input-group-addon" style="width:100px"><i class="fa fa-fw fa-money"></i> Fee </span>
                   <?php 
			  $json=json_decode($clinic_data->fee,true);
			  if(isset($json[$this->session->userdata('id')])) {
				  $fee=$json[$this->session->userdata('id')];
				  }
			  else $fee=0;
			  
			  ?>
                    <input class="form-control" placeholder="Fees" name="fee" value="<?php echo $fee;?>" type="number">
                </div>
                
                  
                    
                </div>
                
                
                <div class="form-group">
                 <div class="input-group" style="width:100%">
                   <span class="input-group-addon" style="width:100px"><i class="fa fa-fw fa-clock-o"></i>Consultation  Time</span>
                  
                    <?php 
			  $json=json_decode($clinic_data->time,true);
			  if(isset($json[$this->session->userdata('id')])) {
				  $time=$json[$this->session->userdata('id')];
				  }
			  else $time=5;
			  
			  ?>
                    <select name="time" class="form-control">
                        <option value="3"  <?php if($time==3)  echo 'selected';?>>3 mins</option>
                        <option value="5"  <?php if($time==5)  echo 'selected';?>>5 mins</option>
                        <option value="7"  <?php if($time==7)  echo 'selected';?>>7 mins</option>
                        <option value="10" <?php if($time==10) echo 'selected';?>>10 mins</option>
                        <option value="15" <?php if($time==15) echo 'selected';?>>15 mins</option>
                        <option value="20" <?php if($time==20) echo 'selected';?>>20 mins</option>
                        <option value="30" <?php if($time==30) echo 'selected';?>>30 mins</option>
                        <option value="45" <?php if($time==45) echo 'selected';?>>45 mins</option>
                        <option value="60" <?php if($time==60) echo 'selected';?>>60 mins</option>
                    </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i> Update Clinic Details</button>
                <br />
                <br clear="all" />
                <?php echo form_close();?> 
                <hr />
                
                <h3>Address</h3>
                
                
                
                <div class="form-group" style="width:100%">
                	<div class="input-group" style="width:100%">
                      <span class="input-group-addon" style="width: 85px;">Landmark</span>
                      <input type="text" readonly="readonly"  
                      class="form-control" value="<?php if(!empty($clinic_data->landmark)) echo $clinic_data->landmark;?>">
                  </div>
                </div>
                
                <div class="form-group" style="width:100%">
                	<div class="input-group" style="width:100%">
                      <span class="input-group-addon" style="width: 85px;">Street </span>
                      <input type="text" readonly="readonly"  
                      class="form-control" value="<?php if(!empty($clinic_data->street)) echo $clinic_data->street;?>">
                  </div>
                </div>
                
                <div class="form-group" style="width:100%">
                	<div class="input-group" style="width:100%">
                      <span class="input-group-addon" style="width: 85px;">Locality</span>
                      <input type="text" readonly="readonly"  
                      class="form-control" value="<?php if(!empty($clinic_data->locality)) echo $clinic_data->locality;?>">
                  </div>
                </div>
                
                <div class="form-group" style="width:100%">
                	<div class="input-group" style="width:100%">
                      <span class="input-group-addon" style="width: 85px;">City</span>
                      <input type="text" readonly="readonly"  
                      class="form-control" value="<?php if(!empty($clinic_data->city)) echo $clinic_data->city;?>">
                  </div>
                </div>
                
                <div class="form-group" style="width:100%">
                	<div class="input-group" style="width:100%">
                      <span class="input-group-addon" style="width: 85px;">District</span>
                      <input type="text" readonly="readonly"  
                      class="form-control" value="<?php if(!empty($clinic_data->district)) echo $clinic_data->district;?>">
                  </div>
                </div>
                
                <div class="form-group" style="width:100%">
                	<div class="input-group" style="width:100%">
                      <span class="input-group-addon"  style="width: 85px;">State</span>
                      <input type="text" readonly="readonly"  
                      class="form-control" value="<?php if(!empty($clinic_data->state)) echo $clinic_data->state;?>">
                  </div>
                </div>  
                
                <div class="form-group" style="width:100%">
                	<div class="input-group" style="width:100%">
                      <span class="input-group-addon" style="width: 85px;">Pin</span>
                      <input type="text" readonly="readonly"  
                      class="form-control" value="<?php if(!empty($clinic_data->pin)) echo $clinic_data->pin;?>">
                  </div>
                </div>  
                 
                
               </div>
            <script>
		
		function populate_input_with_time(time){ $('.time_picker').val(time);}
		
		
		$(document).ready(function(e) {
			var dt = new Date();
			if(dt.getHours()>12) am_pm='PM'
			else  am_pm='AM'
			var time = dt.getHours()%12 + ":" + '00' + ":" + am_pm;
			$('#current_time').val(time);
			//populate_input_with_time(time);
			
			
			$('.chk_box').click(function(e) {
				holder=$(this).parents('table').parent().parent().find('.picker_body');
				holder.html('');
				$('.chk_box').removeClass('chk_box_selected');
                        $(this).addClass('chk_box_selected');
				day=$(this).parent().parent().attr('data-day');
				if($(this).attr('data-name')=='clone'){
					url='<?php echo bu('doctor/ajax_clone/');?>'+day;
					holder.html('<center><img src="<?php echo bu('images/ajax-loader.gif')?>" width="30px"></center>');
					$.post(url,function(data){
						holder.html(data);
						});
					}
				if($(this).attr('data-name')=='pick'){
					url='<?php echo bu('doctor/ajax_time_range/');?>'+day+'/<?php echo $this->uri->segment(3).'/'.$this->uri->segment(4);?>';
					console.log(url);
					holder.html('<center><img src="<?php echo bu('images/ajax-loader.gif')?>" width="30px"></center>');
					$.post(url,function(data){
						holder.html(data);
						});
					}
				
                  });
			
			//Populate of days
			populate_days();
			
			});
		
		function populate_days(){
			$('.off_days').iCheck('uncheck');
			var off_days=$.post('<?php echo bu("doctor/off_days/$clinic_id/$doctor_id")?>',function(data){
				data=JSON.parse(data);
				dummy=['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
				for (var i = 0; i < dummy.length; i++) { 
				    if((data[dummy[i]])==0){
					    $('#off_'+dummy[i]).iCheck('check');
					    }
					}
				
				
				});
			}
		
		$(document).on('click','.disco,.disco span',function(e){
			$('.d .dropdown-menu').hide(0);
			class_man=($(e.target).attr('class'));
			e.stopPropagation();
			if(class_man=='btn disco btn-default dropdown-toggle'){
				$(this).find('.dropdown-menu').toggle(200);
				}
			});
		$(document).on('click','.close_dropdown',function(e){
			$('.dropdown-menu').hide(200);
			})
		$(document).on('click','.change_inc td a',function(e){
			action=($(this).attr('data-action'));
			number=$(this).next().val();
			if(number==undefined) {number=$(this).parent().find('.d_val').val();}
			switch(action) {
			    case 'incrementHour':
				 number=(parseInt(number)+1)%12;
				 $(this).next().val(number);
				 $(this).parent().find('.bootstrap-timepicker-hour').text(Math.abs(number));
				 hour=number;
				 minute=parseInt($(this).parent().next().next().find('.d_val').val());
				 maridian=$(this).parent().next().next().next().next().find('.d_val').val();
				 break;
			    case 'incrementMinute':
				 number=(parseInt(number)+15)%60;
				 $(this).next().val(number)
				 $(this).parent().find('.bootstrap-timepicker-minute').text(Math.abs(number));
				 minute=number;
				 hour=parseInt($(this).parent().prev().prev().find('.d_val').val());
				 maridian=$(this).parent().next().next().find('.d_val').val();
			    	 break;
			    case 'decrementHour':
			        number=(parseInt(number)-1)%12;
				  $(this).parent().find('.d_val').val(number);
				  $(this).parent().find('.bootstrap-timepicker-hour').text(Math.abs(number));
				  hour=number;
				  minute=parseInt($(this).parent().next().next().find('.d_val').val());
				  maridian=$(this).parent().next().next().next().next().find('.d_val').val();
				  break;
			    case 'decrementMinute':
			    	  number=(parseInt(number)-15)%60;
				  $(this).parent().find('.d_val').val(number);
				  $(this).parent().find('.bootstrap-timepicker-minute').text(Math.abs(number));
				  minute=number;
				  hour=parseInt($(this).parent().prev().prev().find('.d_val').val());
				  maridian=$(this).parent().next().next().find('.d_val').val();
				  break;
			    case 'toggleMeridian':
				  if(number=='AM'){
					  maridian='PM';
					  $(this).next().val(maridian);
					  $(this).parent().find('.bootstrap-timepicker-meridian').text((maridian));
					  }
				  if(number=='PM'){
					  maridian='AM';
					  $(this).next().val(maridian);
					  $(this).parent().find('.bootstrap-timepicker-meridian').text((maridian));
					  }
				  break;		    
				}
			($(this).parent().parent().parent().parent().parent().parent().parent().next().val(("0"+Math.abs(hour)).slice(-2)+':'+("0"+Math.abs(minute)).slice(-2)+' '+maridian));
			//update_parent();
			})
		
		$(document).on('click','.add_ad',function(e){
			add_ad($(this));
			});
		
		
		function add_ad(me){
			time		=$('#current_time').val();
			tm		=time.split(":");
			hour		=tm[0];
			minute	=tm[1];
			meridian	=tm[2];
			
			element=(me.parent().find('.ss_j_holder'));
			
			$(element).append('<label><i class="fa fa-fw fa-wheelchair"></i>Next Hour <small>&nbsp;&nbsp;&nbsp;Please Select Time Range </small></label> <table> <tr> <td><div class="input-group margin"> <div class="input-group-btn input-group"> <button type="button" class="btn disco btn-default dropdown-toggle">Start Time <span class="fa fa-caret-down"></span> <ul class="dropdown-menu"> <i class="fa fa-fw fa-times-circle close_dropdown"></i> <table class="mega_me"> <tbody> <tr class="change_inc"> <td> <a data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a> <input type="hidden" class="d_val" value="'+hour+'"/> <div class="bootstrap-timepicker-hour">'+hour+'</div><a data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a> </td><td>:</td><td> <a data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a> <input type="hidden" class="d_val" value="'+minute+'"/> <div class="bootstrap-timepicker-minute">'+minute+'</div><a data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a> </td><td>&nbsp;</td><td> <a data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a> <input type="hidden" class="d_val" value="'+meridian+'"/> <div class="bootstrap-timepicker-meridian">'+meridian+'</div><a >&nbsp;</a> </td></tr></tbody> </table> </ul> </button> </div><input type="text" class="form-control time_picker" value="'+hour+':'+minute+' '+meridian+'"  name="start" data-role="start" readonly="readonly"> </div></td><td><div class="input-group margin"> <div class="input-group-btn input-group"> <button type="button" class="btn disco btn-default dropdown-toggle">End Time <span class="fa fa-caret-down"></span> <ul class="dropdown-menu"> <i class="fa fa-fw fa-times-circle close_dropdown"></i> <table class="mega_me"> <tbody> <tr class="change_inc"> <td> <a data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a> <input type="hidden" class="d_val" value="'+hour+'"/> <div class="bootstrap-timepicker-hour">'+hour+'</div><a data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a> </td><td>:</td><td> <a data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a> <input type="hidden" class="d_val" value="'+minute+'"/> <div class="bootstrap-timepicker-minute">'+minute+'</div><a data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a> </td><td>&nbsp;</td><td> <a data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a> <input type="hidden" class="d_val" value="'+meridian+'"/> <div class="bootstrap-timepicker-meridian">'+meridian+'</div><a >&nbsp;</a> </td></tr></tbody> </table> </ul> </button> </div><input type="text" class="form-control time_picker" value="'+hour+':'+minute+' '+meridian+'"  name="end" data-role="end" readonly="readonly"> </div></td></tr><span style="margin-left:20px; color:#900; cursor:pointer" onclick="$(this).next().remove();$(this).prev().remove();$(this).remove();"><i class="fa fa-fw fa-trash-o" ></i>Delete this timing</span></table>');
			}
		
		
		</script>
            <input id="current_time"  type="hidden" value=""/>
            
                
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12" id="jama_holder">
             <div class="box box-solid bg-aqua">
              <div class="box-header">
                  <h3 class="box-title"><i class="fa fa-fw fa-coffee"></i>Off days</h3>
              </div>
              <hr />
              <div class="box-body">
                  <form action="<?php echo bu('doctor/post_off_days')?>" method="post">
                    <table style="width:100%">
                        <tbody>
                            <tr>
                            	<td><strong>Sun : </strong><input name="sunday" id="off_sunday" class="off_days" type="checkbox" /></td>
                              <td><strong>Mon : </strong><input name="monday" id="off_monday" class="off_days" type="checkbox" /></td>
                              <td><strong>Tue : &nbsp;</strong><input name="tuesday"  id="off_tuesday" class="off_days" type="checkbox" /></td>
                              <td><strong>Wed : </strong><input name="wednesday" id="off_wednesday" class="off_days" type="checkbox" /></td>
                              <td><strong>Thr : </strong><input name="thursday" id="off_thursday" class="off_days" type="checkbox" /></td>
                              <td><strong>Fri : </strong><input name="friday" id="off_friday" class="off_days" type="checkbox" /></td>
                              <td><strong>Sat : </strong><input name="saturday" value="1" id="off_saturday" class="off_days" type="checkbox" /></td>
                              <td>
                              <button class="btn btn-primary btn-flat btn-block" style="margin-top: 7px;"><i class="fa fa-fw fa-plus-square"></i> Submit</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor_id?>" />
                    <input type="hidden" name="clinic_id" value="<?php echo $clinic_id?>" />
                    
                </form>
              </div><!-- /.box-body -->
          	</div>
            
                
                <h2>Set Timming</h2>
                <?php 
		 $temp=$this->db->query('SELECT * FROM shedule WHERE clinic_id="'.$clinic_id.'" AND doctor_id="'.$this->session->userdata('id').'"')->result();
		
		foreach($temp as $a=>$b){
			$this->data['counter']		=$a;
			$this->data['doctor_id']	=$b->doctor_id;
			$this->data['clinic_id']	=$b->clinic_id;
			$this->data['id']			=$b->id;
			$this->data['json']		=$b->json;
			
			
			$memp=$this->db->query("SELECT sunday,monday,tuesday,wednesday,thursday,friday,saturday FROM clinic WHERE (doctor_id='$doctor_id' OR other_doctors LIKE '%,".$this->session->userdata('id').",%') AND id='$clinic_id' ")->result(); 
			
			
			$this->data['sunday']		=get_day($memp[0]->sunday	,$this->session->userdata('id'));
			$this->data['monday']		=get_day($memp[0]->monday	,$this->session->userdata('id'));
			$this->data['tuesday']		=get_day($memp[0]->tuesday	,$this->session->userdata('id'));
			$this->data['wednesday']	=get_day($memp[0]->wednesday	,$this->session->userdata('id'));
			$this->data['thursday']		=get_day($memp[0]->thursday	,$this->session->userdata('id'));
			$this->data['friday']		=get_day($memp[0]->friday	,$this->session->userdata('id'));
			$this->data['saturday']		=get_day($memp[0]->saturday	,$this->session->userdata('id'));
			
			
			$this->load->view('doctor_admin/components/shedule_form',$this->data);
			}
		
		$time_stamp=time();
		?>
                <a href="<?php echo bu('doctor/add_shedule/'.$clinic_id.'/'.$this->session->userdata['id']).'/'.ghash($time_stamp).'/'.$time_stamp
		
		?>">
                <button class="btn btn-success btn-flat btn-block"><i class="fa fa-fw fa-plus-square"></i> Add new Timming</button>
                </a> </div>
        </div>
    </div>
</div>
