<style>
.user_img {
	display: block;
	margin: 0 auto;
	width: 100%;
}
.high {
	color: #a94442;
}
.lable {
	display: inline-block;
	padding: 7px;
	width:auto;
}
.high_same {
	min-width: 130px
}
.no-pad{padding:0; margin:0;}
#meeo,#meeo_c{ font-weight:bold; color:#09C; cursor:pointer}
</style>
<script>
function generate_date_from_age(self){
	age=self.val();
	month=1;
	day=1;
	var d = new Date();
	var n = d.getFullYear();
	year=n-age; 
	$('#date').val(day);
	$('#month').val(month);
	$('#year').val(year);

	}
$(document).ready(function(e) {
    $('#meeo').click(function(e) {
        $(this).parent().parent().hide(0);
		$(this).parent().parent().next().show(0);
    });
	$('#meeo_c').click(function(e) {
        $(this).parent().parent().hide(0);
		 $(this).parent().parent().prev().show(0);
    });
	 populate_referer();
});

function populate_referer(){
	$.post('<?php echo bu('doctor/populate_referer')?>',function(data){ 
			$('#referer_select').html(data);
			})
	}

function submit_referer(self){
	text=(self.parent().parent().find('input').val());
	self.html('<img src="<?php echo bu('images/ajax_rt.gif')?>"> Please Wait');
	if(text.length){
		$.post('<?php echo bu('doctor/ajax_save_referer')?>',{text:text},function(data){ 
			if(data==1) {populate_referer();self.html('<i class="fa fa-fw fa-check-square"></i> Saved');}
			})
		} 
	}

function clear_data(flag){
	if(flag==0)$('#p_name').val('');
	
	$('#p_aadhaar,#p_pin,#p_email,#p_address,#p_locality,#p_city').val('');
	$('#gender_m').prop('checked', false);
	$('#gender_f').prop('checked', false);
	$('.mofet_group').prop('checked', false);
	$('.mofet_history').prop('checked', false);
	$('select').prop('selectedIndex',0);
	$('.relation').val('');
	$('#p_o_id').val('');
					 
	}

function find_mobile(self){
	val=(self.val());
	if(val.length>=10){
		self.parent().find('.high_same').html('<img src="<?php echo bu('images/ajax_rt.gif');?>"> Mobile');
		if(!isNaN(val)){
			clear_data(0);
			$.post('<?php echo bu('doctor/get_p_details_by_phone')?>',{phone:val},function(data){
				data=data.trim();
				if(data==='empty'){
					$('.ini_inactive').removeAttr('disabled');
					self.parent().find('.high_same').html('<i class="fa fa-fw fa-plus"></i> Mobile');
					}
				else{
					json=JSON.parse(data);
					p_name=$('#p_name');
					p_name.val(json.name);
					
					p_aadhaar=$('#p_aadhaar');
					p_aadhaar.val(json.aadhaar);
					
					
					
					if(json.gender=='F'){$('#gender_f').prop('checked', true);} 
					if(json.gender=='M'){$('#gender_m').prop('checked', true);}
					
					if(json.dob.length){
						dob_array=json.dob.split('/');
						p_dob=$('#p_dob');
						p_dob.val(dob_array[2]+'-'+("0" + dob_array[1]).slice(-2)+'-'+("0" + dob_array[0]).slice(-2));
						}
					$('.blood_group option[value="'+json.blood_group+'"]').attr('selected','selected');
					$('.occupaton option[value="'+json.occupation+'"]').attr('selected','selected');
				
					p_o_id=$('#p_o_id');
					opt_id=json.optional_id; 
					//return;
					if(opt_id.length){
						o_id=JSON.parse(json.optional_id);
						p_o_id.val(o_id['<?php echo $this->session->userdata('id');?>']);
						}
					
					
					p_pin=$('#p_pin');
					p_pin.val(json.pin);
					
					p_email=$('#p_email');
					p_email.val(json.email);
					
					p_address=$('#p_address');
					p_address.val(json.street);
					
					p_locality=$('#p_locality');
					p_locality.val(json.locality);
					
					p_city=$('#p_city');
					p_city.val(json.city);
					
					dob=(json.dob).split('/');
					$('#date option[value="'+dob[0]+'"]').attr("selected","selected");
					$('#month option[value="'+dob[1]+'"]').attr("selected","selected");
					$('#year option[value="'+dob[2]+'"]').attr("selected","selected");
					
					
					refered_by=(json.refered_by); 
					if(refered_by.length){
						refered_by=JSON.parse(refered_by);
						refered_by=refered_by['<?php echo $this->session->userdata('id');?>'];
						$('#referer_select option[value="'+refered_by+'"]').attr("selected","selected");
						}
					
					 
					med_history_array=json.medical_history;
					
					if(med_history_array.length){
					med_history_array=JSON.parse(med_history_array);
					med_history_array=(med_history_array[<?php echo $this->session->userdata('id');?>]);
					if(typeof(med_history_array)!='undefined'){
							$('.mofet_history').each(function(index, element) {
							if(med_history_array.indexOf($(this).val())>=0) {
								$(this).prop('checked', true);;
								}
							});
						}
					}
					
					
					 
					group_array=json.group.split('-::-');
					group_array = group_array.filter(function(n){ return n != '' }); 
					id=<?php echo $this->session->userdata('id');?>;
					
					group_array_filtered=[];
					
					for(var key in group_array){
						splited=group_array[key].split('_');
						group_array_filtered.push(splited[1]);
						}
					if(typeof(group_array_filtered)!='undefined'){
							$('.mofet_group').each(function(index, element) {
							if(group_array_filtered.indexOf($(this).val())>=0) {
								$(this).prop('checked', true);
								}
							});
						}
					
					family=json.family.split('-::-');
					$('.family option[value="'+family[0]+'"]').attr("selected","selected");
					$('.relation').val(family[1]);
					
					$('.ini_inactive').removeAttr('disabled');
					self.parent().find('.high_same').html('<i class="fa fa-fw fa-check-square"></i> Mobile');
					
					}
				});
			}
		}
	}

function save_patient_details(){
	p_phone		=$('#p_phone').val();
	p_name		=$('#p_name').val();
	p_aadhaar	=$('#p_aadhaar').val();
	blood_group	=$('.blood_group').val();
	family		=$('.family').val();
	relation	=$('.relation').val();
	occupaton	=$('.occupaton').val();
	
	p_email			=$('#p_email').val();
	p_address		=$('#p_address').val();
	p_locality		=$('#p_locality').val();
	p_city			=$('#p_city').val();
	p_pin			=$('#p_pin').val();
	
	p_o_id			=$('#p_o_id').val();
	
	date			=$('#date').val();
	month			=$('#month').val();
	year			=$('#year').val();
	dob=date+'/'+month+'/'+year;
	
	
	medical_history='';
	$('.mofet_history:checked').each(function(index, element) {
		medical_history+=($(this).val())+'-::-';
    });
	group='';
	$('.mofet_group:checked').each(function(index, element) {
		group+=($(this).val())+'-::-';
    });
	 
	gender='';
	if($('#gender_m').is(":checked")){ gender='M'}
	if($('#gender_f').is(":checked")){ gender='F'}
	 
	referer=$('#referer_select').val();
	
	$.post('<?php echo bu('doctor/save_patient_handler')?>',{
		p_phone:p_phone,
		p_name:p_name,
		p_aadhaar:p_aadhaar,
		blood_group:blood_group,
		family:family,
		occupaton:occupaton,
		relation:relation,
		p_email:p_email,
		p_address:p_address,
		p_locality:p_locality,
		p_city:p_city,
		p_pin:p_pin,
		medical_history:medical_history,
		group:group,
		gender:gender,
		referer:referer,
		dob:dob,
		p_o_id:p_o_id
		
		},function(data){ 
		$('#msg_holder').html(data);
		}); 
	}


</script>
<div id="msg_holder"></div>
<div class="input-group"> <span class="input-group-addon high_same"> Mobile <span class="high">*</span></span>
  <input type="text"  pattern="[0-9]*"  class="form-control" placeholder="Ex:9475956718" onKeyUp="find_mobile($(this))"  id="p_phone" value="">
</div>
<div class="input-group"> <span class="input-group-addon high_same">Patient Name <span class="high">*</span></span>
  <input type="text" class="form-control ini_inactive" disabled placeholder="Patient Name" onKeyUp="clear_data(1)" id="p_name">
</div>
<div class="input-group"> <span class="input-group-addon high_same">Aadhaar ID </span>
  <input type="text" class="form-control ini_inactive" disabled placeholder="Aadhaar ID" id="p_aadhaar">
</div>
<div class="input-group"> <span class="input-group-addon high_same">Optional ID </span>
  <input type="text" class="form-control ini_inactive" disabled placeholder="Any ID that you may want to assign" id="p_o_id">
</div>
<div class="input-group">
  <label class="lable" >Male</label>
  <input type="radio" name="gender" class="ini_inactive simple" value="M"  style="zoom:1.2" id="gender_m" >
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <label class="lable"  >Female</label>
  <input type="radio" name="gender" class="ini_inactive simple"    value="F"  style="zoom:1.2"  id="gender_f" >
</div>

<div class="input-group">
    	<div class="col-lg-3 col-md-3 col-sm-3  col-xs-3 no-mar no-pad ">
        <span class="input-group-addon" style="height: 34px;border-left: 1px solid #C9C9C9;">Date of birth </span>
        </div>
    	<div class="col-lg-3 col-md-3 col-sm-3  col-xs-3 no-mar no-pad ">
        
        <select class="form-control te_c no-pad ini_inactive" disabled id="date">
        	<option disabled selected>DD</option>
            <?php for($i=1;$i<=31;$i++){
				echo '<option value="'.$i.'">'.$i.'</option>';
				}
				?>
        </select>
        </div>
        
        
        <div class="col-lg-3 col-md-3 col-sm-3  col-xs-3 no-mar no-pad ">
        <select class="form-control te_c no-pad ini_inactive" disabled id="month">
        	<option disabled selected>MM</option>
            <?php for($i=1;$i<=12;$i++){
				echo '<option value="'.$i.'">'.$i.'</option>';
				}
				?>
        </select>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3  col-xs-3 no-mar no-pad ">
         <select class="form-control te_c no-pad ini_inactive" disabled id="year">
        	<option disabled selected>YYYY</option>
            <?php 
			$year=date('Y');
			$limit_year=$year-100;
			for($i=$year;$i>=$limit_year;$i--){
				echo '<option value="'.$i.'">'.$i.'</option>';
				}
				?>
        </select>
        </div>
    </div>
 
<div class="col-xs-6 no-pad">
	<div class="input-group">
        <span class="input-group-addon">Or Enter Age</span>
        <input type="number" class="form-control ini_inactive" disabled="disabled" placeholder="Optional" onblur="generate_date_from_age($(this))">
    </div>
</div>



<div class="form-group">
	<div class="col-lg-8 no-pad  ">
    	<label>Refered by</label>
        <select class="form-control ini_inactive" disabled  id="referer_select">
            
        </select>
    </div>
    <div class="col-lg-4  no-pad "> <br><br>&nbsp;&nbsp; <strong id="meeo">Or add new</strong></div>
</div>

<div class="form-group" style="display:none">
	<div class="col-lg-8 no-pad  ">
    <label>Refered by</label>
          <input type="text" class="form-control" placeholder="Referer">
        
    </div>
    <div class="col-lg-2 no-pad ">
    <br>
    	<button style="margin-top: 5px;" class="btn btn-primary btn-flat"  onClick="submit_referer($(this))">Submit</button>
    </div>
    <div class="col-lg-2  no-pad "> <br><br>&nbsp;&nbsp; <strong id="meeo_c">Cancel</strong></div>
</div>
<br clear="all">
<br clear="all">
<div class="col-lg-6 col-xs-12 no-mar no-pad">
    <div class="form-group">
        <label>Blood Group</label>
        <select class="form-control ini_inactive blood_group" disabled>
            <option disabled selected>Select Blood group</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="A1+">A1+</option>
            <option value="A1-">A1-</option>
            <option value="A1B+">A1B+</option>
            <option value="A1B-">A1B-</option>
            <option value="A2+">A2+</option>
            <option value="A2-">A2-</option>
            <option value="A2B+">A2B+</option>
            <option value="A2B-">A2B-</option>
            <option value="B1+">B1+</option>
        </select>
    </div>
</div>

<div class="col-lg-6 col-xs-12 no-mar no-pad">
    <div class="form-group">
        <label>Occupation</label>
        <select class="form-control ini_inactive occupaton" disabled>
            <option disabled selected>Select occupation</option>
            <option value="Buisness">Buisness</option>
            <option value="Service">Service</option>
            <option value="Housewife">Housewife</option>
            <option value="Student">Student</option>
            <option value="Self employed">Self employed</option>
            <option value="Other">Other</option>
        </select>
    </div>
</div>

<label>Family </label>
<div class="form-group">
    
    <div class="col-lg-4 no-pad">
    	<select class="form-control ini_inactive family" disabled>
            <option value="">Relation</option>
            <option value="child">Child</option>
            <option value="parent">Parent</option>
            <option value="sibling">Brother/Sister</option>
            <option value="spouse">Husband/Wife</option>
            <option value="grand child">Grandchild</option>
            <option value="grand parent">Grandparent</option>
            <option value="uncle / aunt">Uncle/Aunt</option>
            <option value="nephew / niece">Nephew/Niece</option>
            <option value="cousin">Cousin</option>
    	</select>
    </div>
    <div class="col-lg-8 no-pad">
    	<input class="form-control ini_inactive relation" disabled>
    </div>
    
</div>
<br clear="all">
<hr class="clearfix">
<h3>Contact Details</h3>


<div class="input-group"> <span class="input-group-addon high_same">Email </span>
  <input type="text" class="form-control ini_inactive" disabled placeholder="Email address" id="p_email">
</div>

<div class="input-group"> <span class="input-group-addon high_same">Street <span class="high">*</span></span>
  <input type="text" class="form-control ini_inactive" disabled placeholder="Street address" id="p_address">
</div>

<div class="input-group"> <span class="input-group-addon high_same">Locality <span class="high">*</span></span>
  <input type="text" class="form-control ini_inactive" disabled placeholder="Locality" id="p_locality">
</div>

<div class="input-group"> <span class="input-group-addon high_same">City <span class="high">*</span></span>
  <input type="text" class="form-control ini_inactive" disabled placeholder="City" id="p_city">
</div>

<div class="input-group"> <span class="input-group-addon high_same">Pin <span class="high">*</span></span>
  <input type="text" class="form-control ini_inactive" disabled placeholder="Pin" id="p_pin">
</div>