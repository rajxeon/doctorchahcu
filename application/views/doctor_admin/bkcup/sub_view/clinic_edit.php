<style> #ajax_field input{float: right;display: inline-block;}
 #ajax_field label{min-width:100px}
 </style>
<?php 
$clinic_id=$this->uri->rsegment(3);
$doctor_id=$this->uri->rsegment(4);
$clinic_data=$this->db->query("SELECT * FROM clinic WHERE doctor_id='$doctor_id' AND id=$clinic_id")->result(); 
$clinic_data=$clinic_data[0];
?> 
<script>
function get_address(val){
		$('.ajax_img_holder').html('<img src="<?php echo bu('images/ajax_rt.gif');?>"/>');
		url='<?php echo bu('doctor/ajax_address_getter/');?>'+val;
            $.post(url,'',function(data){
			if(data==0){
				$('.ajax_img_holder').html('');
				$('.error_holder').html('<div class="alert alert-danger" role="alert"><i class="glyphicon glyphicon-remove"></i><strong>Pin error</strong> The pin code is not valid </div>');
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

});

</script>


<div id="page-wrapper" style=" position:relative;min-height: 200vh;">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Clinic <small>Edit and shedule your appointments</small> </h1>
        <ol class="breadcrumb">
            <li class="active"> <i class="fa fa-dashboard"></i> Dashboard </li>
            <li class="active"> <i class="fa fa-edit"></i> Clinic </li>
            <li class="active"> <i class="glyphicon glyphicon-th-large"></i> Edit </li>
        </ol>
    </div>

<div class="col-lg-12">
      <div class="row">
      <br clear="all" />
      <?php 
		if(isset($message) and isset($type))display_msg($message,$type);
		display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));
		
	?>
            <div class="col-lg-7">
                  <h3>Clinic Details</h3>
                  
                  <hr />
            	<?php echo form_open();?>
                  <div class="form-group">
                          <label>Clinic Name</label>
                          <input class="form-control" placeholder="Clinic Name" name="name" value="<?php echo $clinic_data->name;?>">
                  </div>
                  
                  <div class="form-group">
                          <label>Fee</label>
                          <input class="form-control" placeholder="Fees" name="fee" value="<?php echo $clinic_data->fee;?>" type="number">
                  </div>
                  
                  <div class="form-group">
                          <div class="form-group">
                                <label>Visibility</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="visibility" id="optionsRadios1" value="1" 
                                        <?php if($clinic_data->visibility==1) echo 'checked';?>>Visible
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="visibility" id="optionsRadios2" value="0" 
                                        <?php if($clinic_data->visibility==0) echo 'checked';?>>Invisible
                                    </label>
                                </div>
                                
                            </div>
                  </div>
                  
                  <div class="form-group">
                          <label>Time allocated for each patient</label>
                          <select name="time" class="form-control">
                          	<option value="3"  <?php if($clinic_data->time==3)  echo 'selected';?>>3 mins</option>
                              <option value="5"  <?php if($clinic_data->time==5)  echo 'selected';?>>5 mins</option>
                              <option value="7"  <?php if($clinic_data->time==7)  echo 'selected';?>>7 mins</option>
                              <option value="10" <?php if($clinic_data->time==10) echo 'selected';?>>10 mins</option>
                              <option value="15" <?php if($clinic_data->time==15) echo 'selected';?>>15 mins</option>
                              <option value="20" <?php if($clinic_data->time==20) echo 'selected';?>>20 mins</option>
                              <option value="30" <?php if($clinic_data->time==30) echo 'selected';?>>30 mins</option>
                              <option value="45" <?php if($clinic_data->time==45) echo 'selected';?>>45 mins</option>
                              <option value="60" <?php if($clinic_data->time==60) echo 'selected';?>>60 mins</option>
                          </select>
                  </div>
                  
                  <h3>Address of the clinic</h3>
                  <hr />
                  
                 
                  
                   <div class="form-group">
                          <label>Landmark</label>
                          <input class="form-control" name="landmark" placeholder="Street Address" id="landmark"  
                          value="<?php echo $clinic_data->landmark;?>">
                  </div>
                   <div class="form-group">
                          <label>Street</label>
                          <input class="form-control" name="street" placeholder="Street Address" id="street"  value="<?php echo $clinic_data->street;?>">
                  </div>
                   <div class="form-group">
                          <label>Pin </label>(Change pin to update the feilds below)
                          <input class="form-control" placeholder="Pincode" name="pin" type="number" maxlength="6" value="<?php echo $clinic_data->pin;?>" id="pin_finder">
                  </div>
                  
                  
                  <!-- Ajax inputs -->
                  <div class="error_holder"></div>
                  <div id="ajax_field">
                  <div class="form-group">
                          <label>Locality</label>
                          <select class="form-control" id="ajax_locality" name="locality">
                          	<option selected="selected" disabled="disabled">Please enter pin first.</option>
                          </select>
                          <span class="ajax_img_holder"></span>
                  </div>
                  
                  <div class="form-group">
                          <label>City</label>
                          <select class="form-control" id="ajax_city" name="city">
                          	<option selected="selected" disabled="disabled">Please enter pin first.</option>
                          </select>
                          <span class="ajax_img_holder"></span>
                  </div>
                   
                  <div class="form-group">
                          <label>District</label>
                          <input class="form-control" placeholder="District" name="district" id="ajax_district"  readonly="readonly" />
                          <span class="ajax_img_holder"></span>
                  </div>
                  
                  <div class="form-group">
                          <label>State</label>
                          <input class="form-control" placeholder="State" name="state" id="ajax_state"  readonly="readonly" />
                          <span class="ajax_img_holder"></span>
                  </div>
                  <!-- Ajax inputs -->
                 </div>
                 
                  
                  
                  <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i> Update Clinic Details</button>
                  <?php echo form_close();?>
            
            </div>
            
      </div>
</div>
</div>