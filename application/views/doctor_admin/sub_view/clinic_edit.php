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
html, body, #map-canvas {
	height: 100%;
	margin: 0px;
	padding: 0px
}
.controls {
	margin-top: 16px;
	border: 1px solid transparent;
	border-radius: 2px 0 0 2px;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	height: 32px;
	outline: none;
	box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}
#pac-input {
	background-color: #fff;
	padding: 0 11px 0 13px;
	width: 40%;
	font-family: Roboto;
	font-size: 15px;
	font-weight: 300;
	text-overflow: ellipsis;
	position: absolute;
	z-index: 10;
	margin-left: 10px;
}
#pac-input:focus {
	border-color: #4d90fe; /* Regular padding-left + 1. */
	width: 401px;
}
.pac-container {
	font-family: Roboto;
}
#type-selector {
	color: #fff;
	background-color: #4d90fe;
	padding: 5px 11px 0px 11px;
}
#type-selector label {
	font-family: Roboto;
	font-size: 13px;
	font-weight: 300;
}
#target {
	width: 345px;
}
html, body {overflow-x: hidden !important; height:auto }
.input-group .input-group-addon {min-width: 100px !important;text-align: left !important;}
.btn-file input[type=file] {
	position: absolute;
	top: 0;
	right: 0;
	min-width: 100%;
	min-height: 100%;
	font-size: 100px;
	text-align: right;
	filter: alpha(opacity=0);
	opacity: 0;
	outline: none;
	background: white;
	cursor: inherit;
	display: block;
}
#imagePreview {
	width: 180px;
 background-image:url(<?php echo bu('images/no_image.jpg');
?>);
	height: 180px;
	background-position: center center;
	background-size: cover;
	-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
	margin: 0 auto;
	margin-bottom: 15px;
}
.dd_btn {
	height:34px;
	width:23px;
 background-image:url(<?php echo bu('images/arrow.png');
?>);
	background-position-y: -19px;
	background-position-x: 4px;
	background-repeat: no-repeat;
	background-color: rgb(240, 240, 240);
	margin-left: -7px;
	z-index: 13;
	position: relative;
	border: 1px solid #AAA;
	background-size: 70%;
	-webkit-user-select: none;  /* Chrome all / Safari all */
	-moz-user-select: none;     /* Firefox all */
	-ms-user-select: none;      /* IE 10+ */
	/* No support for these yet, use at own risk */
  	-o-user-select: none;
	user-select: none;
}
.add_btn{-webkit-user-select: none;  /* Chrome all / Safari all */
	-moz-user-select: none;     /* Firefox all */
	-ms-user-select: none;      /* IE 10+ */
	/* No support for these yet, use at own risk */
  	-o-user-select: none;
	user-select: none;}
.dd_btn:hover {
	background-color:#0099FF;
	cursor:pointer
}
</style>
<?php 
$clinic_id=$this->uri->rsegment(3);
$doctor_id=$this->session->userdata('id');

$clinic_data=$this->db->query("SELECT * FROM clinic WHERE doctor_id='$doctor_id' AND id='$clinic_id'")->result(); 
$clinic_data=$clinic_data[0];
?>
<script src="<?php echo bu('js/dropzone.js');?>"></script>
<link href="<?php echo bu('style/dropzone.css');?>" rel="stylesheet" />
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
$(function() {
    $("#uploadFile").on("change", function()
    {
    $('#ajax-img').attr('src','<?php echo bu('images/ajax_rt.gif');?>');
	  $("#imagePreview").css('background-image','none').html('<img style="margin-top: 50px;" src="<?php echo bu('images/29.gif')?>">');
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
		size=files[0].size/1024;  
		type=files[0].type; 
		
		if(size>300) {alert('Please use a file size less than 300 KB');$("#imagePreview").append('<p>Please use a file size less than 300 KB</p>');}
		else if(type!='image/png' && type!='image/jpeg' && type!='image/jpg' && type!='image/gif') {
			alert('Sorry your file type is not recognized');
			$("#imagePreview").append('<p>Please use jpeg,png or gif format for your photo</p>');
			}		
		else{
			
			//File is ok for upload
			var file_data = $('#uploadFile').prop('files')[0];   
			var form_data = new FormData(); 
			form_data.append("file",file_data);
			
			$.ajax({
				    url: '<?php echo bu('doctor/upload_clinic_logo/'.$clinic_id);?>', // point to server-side PHP script 
				    dataType: 'text',  // what to expect back from the PHP script, if anything
				    cache: false,
				    contentType: false,
				    processData: false,
				    data: form_data,                         
				    type: 'post',
				    success: function(data){// display response from the PHP script, if any
					data=data.trim();
					//console.log(data);
					  if(data==='TRUE'){
						   $('#ajax-img').attr('src','<?php echo bu('images/clear-tick-icon-black.png');?>');
						  }
				    }
		     });
					     
			     
			    
			$("#imagePreview").html('');
			$("#imagePreview").css("background-image", "url("+this.result+")");
			}
                
		   
            }
        }
	  else {alert('Sorry your file type is not recognized'); 
		  $("#imagePreview").append('<p>Please use jpeg,png or gif format for your photo</p>');
		  }
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
                <h3>Clinic Details</h3>
                <hr style="margin:2px" />
                
                <div class="col-lg-5 animate_2" id="rt-box" align="center">
                <br />
                <div id="imagePreview"> <img  style="width:100%; height:100%" src="
				<?php 
					
					$exists=0;
					if(is_file((config_item('clinic_image').$clinic_id.'/logo.jpg'))){
						echo bu(config_item('clinic_image').$clinic_id.'/logo.jpg');
						$exists=1;
						}
						
					elseif(is_file((config_item('clinic_image').$clinic_id.'/logo.png'))){
						echo bu(config_item('clinic_image').$clinic_id.'/logo.png');
						$exists=1;
						}
						
					elseif(is_file((config_item('clinic_image').$clinic_id.'/logo.gif'))){
						echo bu(config_item('clinic_image').$clinic_id.'/logo.gif');
						$exists=1;
						}
						
					elseif(is_file((config_item('clinic_image').$clinic_id.'/logo.jpeg'))){
						echo bu(config_item('clinic_image').$clinic_id.'/logo.jpeg');
						$exists=1;
						}
						
				?>"></div>
                <span class="btn btn-success btn-file" style="margin: 10px 0px;display: block;max-width: 185px;"> <i class="glyphicon glyphicon-picture"></i>&nbsp;&nbsp;
                &nbsp;
                <?php if($exists==1) echo 'Update Logo';
				    		else echo 'Browse Logo';
				    ?>
                &nbsp;&nbsp; <img id="ajax-img"  style=" width: 19px; ">
                <input id="uploadFile" name="image" class="img" type="file">
                </span> </div>
                <br>
                <?php echo form_open();?>
                <div class="col-lg-7">
                <div class="form-group">
                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-fw fa-hospital-o"></i> Clinic Name</span>
                        <input class="form-control" placeholder="Clinic Name" name="name" value="<?php echo $clinic_data->name;?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-fw fa-phone"></i> Phone</span>
                        <input class="form-control" placeholder="Phone Number" name="phone" value="<?php echo $clinic_data->phone;?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-fw fa-rupee"></i> Fee</span>
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
                    <div class="form-group">
                        <label>Visibility</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="visibility" id="optionsRadios1" value="1" 
                                        <?php if($clinic_data->visibility==1) echo 'checked';?>>
                                Visible </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="visibility" id="optionsRadios2" value="0" 
                                        <?php if($clinic_data->visibility==0) echo 'checked';?>>
                                Invisible </label>
                        </div>
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-tint"></i> About</span>
                    <textarea class="form-control" name="about" rows="4" ><?php echo $clinic_data->about;?></textarea>
                </div></div>
                <div class="form-group">
                    <div class="input-group"> <span class="input-group-addon">
                    <i class="fa fa-fw fa-sort-numeric-desc"></i> Sort order </span>
                        <?php 
				$data=$this->db->query("SELECT * FROM clinic WHERE doctor_id=".$this->session->userdata('id'))->result();
				$options = array();
				for($x=1;$x<=sizeof($data);$x++){
					$options[$x] = $x;
					}
				echo form_dropdown('sort_order', $options, $clinic_data->sort_order,'class="form-control"');
				?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-fw fa-clock-o"></i>
                     Consultation Time</span>
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
                <script>
                $(document).ready(function(e) {
                   specility_html=$('#speciality_html').html();
				   $('#sp_h_txt').val(specility_html);
                });
				function add_speciality(){
					specility_html=$('#sp_h_txt').val();
					console.log(specility_html);
					$('#speciality_holder').append(specility_html);
					}
                </script>
                <input type="hidden" id="sp_h_txt" value="" />
                <div class="form-group" id="speciality_holder">
                <?php 
				$speciality_array=array_filter(explode(',',$clinic_data->speciality));
				if(sizeof($speciality_array)): foreach($speciality_array as $x=>$y): ?>
                
                <div id="speciality_html">
                        <div class="input-group" > 
                            <span class="input-group-addon"><i class="fa fa-fw fa-cogs"></i> Speciality </span>
                            <div class="col-xs-8" style="padding:0">
                                <select name="speciality[]" class="form-control" id="speciality_unit">
                                    <?php 
                                    $sql="SELECT column_name FROM information_schema.COLUMNS WHERE table_name='speciality'  and column_name!='id' ";
                                    $data=$this->db->query($sql)->result();
                                    foreach($data as $a=>$b):
                                    ?>
                                    <option <?php if($b->column_name==$y) echo 'selected';?>>
										<?php echo $b->column_name;?>
                                    </option>
                                    <?php endforeach;?>
                              </select>
                            </div>
                            <div class="col-xs-4" style="padding:0; padding-top:8px" > 
                                <a href="" onclick="event.preventDefault(); 
                                $(this).parent().parent().remove();">
                                <i class="fa fa-fw fa-times"></i> Delete</a>
                            </div>  
                          
                        </div>
                    </div>
                
                    
                <?php  endforeach;endif; ?>
                	<div id="speciality_html">
                        <div class="input-group" > 
                            <span class="input-group-addon"><i class="fa fa-fw fa-cogs"></i> Speciality </span>
                            <div class="col-xs-8" style="padding:0">
                                <select name="speciality[]" class="form-control" id="speciality_unit">
                                	<option selected="selected" disabled="disabled">Select Speciality</option>
                                    <?php 
                                    $sql="SELECT column_name FROM information_schema.COLUMNS WHERE table_name='speciality'  and column_name!='id' ";
                                    $data=$this->db->query($sql)->result();
                                    foreach($data as $a=>$b):
                                    ?>
                                    <option><?php echo $b->column_name;?></option>
                                    <?php endforeach;?>
                              </select>
                            </div>
                            <div class="col-xs-4" style="padding:0; padding-top:8px" > 
                                <a href="" onclick="event.preventDefault(); 
                                $(this).parent().parent().remove();">
                                <i class="fa fa-fw fa-times"></i> Delete</a>
                            </div>  
                          
                        </div>
                    </div>
                    
                </div>
                <button class="btn btn-xs btn-flat btn-primary" onclick="event.preventDefault(); add_speciality()">+Add another speciality</button>
                
                <hr />
                 <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i> Update Clinic Details</button>
                <h3>Address of the clinic</h3>
                <hr />
                <div class="form-group">
                    <div class="input-group"> <span class="input-group-addon"> <i class="fa fa-fw fa-globe"></i> Landmark</span>
                        <input class="form-control" name="landmark" placeholder="Any landmarks" id="landmark"  
                          value="<?php echo $clinic_data->landmark;?>">
                    </div>
                </div>
                <div class="form-group">
                      <div class="input-group"> <span class="input-group-addon"> <i class="fa fa-fw fa-road"></i> Street</span>
                              <input class="form-control" name="street" placeholder="Street Address" id="street"  value="<?php echo $clinic_data->street;?>">
                          </div> 
                    
                </div>
                <div class="form-group">
                 <div class="input-group"> <span class="input-group-addon"> <i class="fa fa-fw fa-print"></i> Pin Code</span>
                             <input class="form-control" placeholder="Pincode" name="pin" type="number" maxlength="6" value="<?php echo $clinic_data->pin;?>" id="pin_finder">
                             <br /><span class="form-control">(Change pin to update the feilds below)</span>
                          </div>  
                    
                </div>
                
                <!-- Ajax inputs -->
                <div class="error_holder"></div>
                <div id="ajax_field">
                    <div class="form-group">
                          <div class="input-group"> <span class="input-group-addon"> <i class="fa fa-fw fa-umbrella"></i> Locality</span>
                              <select class="form-control" id="ajax_locality" name="locality">
                                  <option selected="selected" disabled="disabled">Please enter pin first.</option>
                              </select>
                          </div> 
                        
                        <span class="ajax_img_holder"></span> </div>
                    <div class="form-group">
                        <div class="input-group"> <span class="input-group-addon"> <i class="fa fa-fw fa-building-o"></i> City</span>
                               <select class="form-control" id="ajax_city" name="city">
                                  <option selected="selected" disabled="disabled">Please enter pin first.</option>
                              </select>
                              <span class="ajax_img_holder"></span> 
                          </div> 
                       
                        </div>
                    <div class="form-group">
                    	<div class="input-group"> <span class="input-group-addon"> <i class="fa fa-fw fa-hdd-o"></i> District</span>
                              <input class="form-control" placeholder="District" name="district" id="ajax_district"  readonly="readonly" />
                       		 <span class="ajax_img_holder"></span> 
                          </div> 
                          
                        </div>
                    <div class="form-group">
                    
                    	<div class="input-group"> <span class="input-group-addon"> <i class="fa fa-fw fa-lemon-o"></i> State</span>
                             <input class="form-control" placeholder="State" name="state" id="ajax_state"  readonly="readonly" />
                        <span class="ajax_img_holder"></span> 
                          </div> 
                        
                        </div>
                    <!-- Ajax inputs --> 
                </div>
                <br />
                <h3>Select Clinic location in Map</h3>
                <?php
		     $this->load->view('doctor_admin/components/map_picker.html');?>
                <input id="lat" type="hidden" name="lat" value="<?php echo $clinic_data->latitude;?>">
                <input id="lon" type="hidden" name="lon" value="<?php echo $clinic_data->longitude;?>">
                <br />
                <br />
                <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i> Update Clinic Details</button>
                <br />
                <br clear="all" />
                <?php echo form_close();?> </div>
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
			$('.off_days').prop('checked',false);
			var off_days=$.post('<?php echo bu("doctor/off_days/$clinic_id/$doctor_id")?>',function(data){
				data=JSON.parse(data);
				dummy=['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
				for (var i = 0; i < dummy.length; i++) { 
				    if((data[dummy[i]])==0){ 
						$('#off_'+dummy[i]).prop('checked',true);
					   // $('#off_'+dummy[i]).iCheck('check');
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
			
			$(element).append('<label><i class="fa fa-fw fa-wheelchair"></i>Next Hour <small>&nbsp;&nbsp;&nbsp;Please Select Time Range</small></label> <table> <tr> <td><div class="input-group margin"> <div class="input-group-btn input-group"> <button type="button" class="btn disco btn-default dropdown-toggle">Start Time <span class="fa fa-caret-down"></span> <ul class="dropdown-menu"> <i class="fa fa-fw fa-times-circle close_dropdown"></i> <table class="mega_me"> <tbody> <tr class="change_inc"> <td> <a data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a> <input type="hidden" class="d_val" value="'+hour+'"/> <div class="bootstrap-timepicker-hour">'+hour+'</div><a data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a> </td><td>:</td><td> <a data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a> <input type="hidden" class="d_val" value="'+minute+'"/> <div class="bootstrap-timepicker-minute">'+minute+'</div><a data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a> </td><td>&nbsp;</td><td> <a data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a> <input type="hidden" class="d_val" value="'+meridian+'"/> <div class="bootstrap-timepicker-meridian">'+meridian+'</div><a >&nbsp;</a> </td></tr></tbody> </table> </ul> </button> </div><input type="text" class="form-control time_picker" value="'+hour+':'+minute+' '+meridian+'"  name="start" data-role="start" readonly="readonly"> </div></td><td><div class="input-group margin"> <div class="input-group-btn input-group"> <button type="button" class="btn disco btn-default dropdown-toggle">End Time <span class="fa fa-caret-down"></span> <ul class="dropdown-menu"> <i class="fa fa-fw fa-times-circle close_dropdown"></i> <table class="mega_me"> <tbody> <tr class="change_inc"> <td> <a data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a> <input type="hidden" class="d_val" value="'+hour+'"/> <div class="bootstrap-timepicker-hour">'+hour+'</div><a data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a> </td><td>:</td><td> <a data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a> <input type="hidden" class="d_val" value="'+minute+'"/> <div class="bootstrap-timepicker-minute">'+minute+'</div><a data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a> </td><td>&nbsp;</td><td> <a data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a> <input type="hidden" class="d_val" value="'+meridian+'"/> <div class="bootstrap-timepicker-meridian">'+meridian+'</div><a >&nbsp;</a> </td></tr></tbody> </table> </ul> </button> </div><input type="text" class="form-control time_picker" value="'+hour+':'+minute+' '+meridian+'"  name="end" data-role="end" readonly="readonly"> </div></td></tr><span style="margin-left:20px; color:#900; cursor:pointer" onclick="$(this).next().remove();$(this).prev().remove();$(this).remove();"><i class="fa fa-fw fa-trash-o" ></i>Delete this timing</span></table>');
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
                                        <td><strong>Sun : </strong>
                                            <input name="sunday" id="off_sunday" class="off_days simple" type="checkbox" /></td>
                                        <td><strong>Mon : </strong>
                                            <input name="monday" id="off_monday" class="off_days simple" type="checkbox" /></td>
                                        <td><strong>Tue : &nbsp;</strong>
                                            <input name="tuesday"  id="off_tuesday" class="off_days simple" type="checkbox" /></td>
                                        <td><strong>Wed : </strong>
                                            <input name="wednesday" id="off_wednesday" class="off_days simple" type="checkbox" /></td>
                                        <td><strong>Thr : </strong>
                                            <input name="thursday" id="off_thursday" class="off_days simple" type="checkbox" /></td>
                                        <td><strong>Fri : </strong>
                                            <input name="friday" id="off_friday" class="off_days simple" type="checkbox" /></td>
                                        <td><strong>Sat : </strong>
                                            <input name="saturday" value="1" id="off_saturday" class="off_days simple" type="checkbox" /></td>
                                        <td><button class="btn btn-primary btn-flat btn-block" style="margin-top: 7px;"><i class="fa fa-fw fa-plus-square"></i> Submit</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" name="doctor_id" value="<?php echo $doctor_id?>" />
                            <input type="hidden" name="clinic_id" value="<?php echo $clinic_id?>" />
                        </form>
                    </div>
                    <!-- /.box-body --> 
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
			
			$memp=$this->db->query('SELECT sunday,monday,tuesday,wednesday,thursday,friday,saturday FROM clinic WHERE id="'.$clinic_id.'" AND doctor_id="'.$this->session->userdata('id').'"')->result();
			
			
			
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
            <style>
			.off_days {
zoom: 1.6;
}
            	.bg_img1{ <?php if(is_file('clinic_images/'.$clinic_id.'/1.jpg'))?> background:url(<?php echo bu('clinic_images/'.$clinic_id.'/1.jpg');?>) !important; background-size:100% 100% !important}
			.bg_img2{ <?php if(is_file('clinic_images/'.$clinic_id.'/2.jpg'))?> background:url(<?php echo bu('clinic_images/'.$clinic_id.'/2.jpg');?>) !important;background-size:100% 100% !important}
			.bg_img3{ <?php if(is_file('clinic_images/'.$clinic_id.'/3.jpg'))?> background:url(<?php echo bu('clinic_images/'.$clinic_id.'/3.jpg');?>) !important; background-size:100% 100% !important}
            </style>
                <button class="btn btn-success btn-flat btn-block"><i class="fa fa-fw fa-plus-square"></i> Add new Shedule</button>
                </a> 
                <h3>Clinic Images</h3>
                         
                <h4>Image 1</h4>
                <form  action="<?php echo bu('doctor/upload_clinic_image/'.$clinic_id.'/1')?>" id="myId"  class="dropzone bg_img1">
                    <div class="fallback">
                      <input name="file" type="file" multiple />
                    </div>
                </form>
                
                <h4>Image 2</h4>
                <form  action="<?php echo bu('doctor/upload_clinic_image/'.$clinic_id.'/2')?>" id="myId"  class="dropzone bg_img2">
                    <div class="fallback">
                      <input name="file" type="file" multiple />
                    </div>
                </form>
                
                <h4>Image 3</h4>
                <form  action="<?php echo bu('doctor/upload_clinic_image/'.$clinic_id.'/3')?>" id="myId"  class="dropzone bg_img3">
                    <div class="fallback">
                      <input name="file" class="input_img" type="file" />
                    </div>
                </form>
            </div>
            </div>
            <script>
		$(document).ready(function(e) {
			$('.input_img').change(function(e) {
              		 console.log(5);          
                  });
              
			
            });
			Dropzone.options.myId = {
			  maxFilesize: 3, // MB
			  maxFiles: 1,
			  accept: function(file, done) {
			    if (file.type != "image/jpeg") {
				done("You can only upload jpeg files");
			    }
			    else { done(); }
			  }
			};
            
            	
            </script>       
            
        </div>
    </div>
</div>
