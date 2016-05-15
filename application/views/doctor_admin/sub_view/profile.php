<style>
.btn-file {
	position: relative;
	overflow: hidden;
}
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
.listme {
	width: 296px;
	max-height: 200px;
	overflow: auto;
	overflow-x: auto;
	padding: 10px;
	display:none;
	position: absolute;
	background: #fff;
	z-index: 1000;
	border: 1px solid;
}
.p5:hover {
	background: #B4B4B4;
	cursor:pointer;
}
.selected-dd {
	background: #B4B4B4;
}
.speciality_class {
	margin:3px 0;
}
.animate_2 {
	transition:all linear .5s 0s;
-webkit- transition:all linear .5s 0s;
-o- transition:all linear .5s 0s;
-ms- transition:all linear .5s 0s;
-moz- transition:all linear .5s 0s;
}
#education_holder {
	width:100%
}
.speciality_class table {
	width:100%
}
#education_holder .my_td:nth-child(1) {
	width:35%
}
#education_holder .my_td:nth-child(2) {
	width:35%
}
#education_holder .my_td:nth-child(3) {
	width:15%
}
#education_holder .my_td:nth-child(4) {
	width:15%
}
.firaz {
	border-bottom-left-radius: 0;
	border-bottom-right-radius: 0;
}
.zebra {
	background-color: #CFCFCF;
	height: 140px;
	display: block;
}
.coleskar{color: #00A65A;
background: #fff;
border-radius: 100%;
padding: 2px;}
.sub_btn{ width:100px}
.heading{display: inline-block;margin-right: 20px;}
.add_btn{font-weight: bold;color: #19B3F1;cursor: pointer;}
.add_btn:hover{ text-decoration:underline}
input{ color:#000000 !important}
.gray_bg{background: rgb(238, 238, 238);
padding: 10px;}
#experience_holder{margin-right:0 !important;}

@media screen and (max-width: 767px) {
	.zebra {
background-color: #CFCFCF;
height: 183px;
display: block;
}
	}
 @media screen and (max-width: 560px) {
#education_holder td {
	display: block;
}
#education_holder .my_td:nth-child(1) {
	width:100%
}
#education_holder .my_td:nth-child(2) {
	width:100%
}
#education_holder .my_td:nth-child(3) {
	width:100%
}
#education_holder .my_td:nth-child(4) {
	width:100%
}

}
</style>
<script type="text/javascript">
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
				    url: 'upload_profile_image/'+$('#user_id').val(), // point to server-side PHP script 
				    dataType: 'text',  // what to expect back from the PHP script, if anything
				    cache: false,
				    contentType: false,
				    processData: false,
				    data: form_data,                         
				    type: 'post',
				    success: function(data){// display response from the PHP script, if any
					  if(data=='TRUE'){
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

function add_speciality(){
	$('#speciality_holder').append('<?php get_speciality();//helper/custom_helper.php?>');
	}

function add_education(){
	$('#education_holder').append('<?php get_education();//helper/custom_helper.php?>');
	}


$(document).on('click','.reduce_speciality',function(e) {
    $(this).prevUntil('.xeon').html('').remove();
    $(this).remove();
});
</script>
<script>
//Script for combobox filter
$('html').click(function(event) {
	target=(event.target.className.split(" ")[0]);
	if(target!='dd_btn' && target!='combo_filter'){
		$('.listme').slideUp(200);
		}
});

$(document).on('click',('.dd_btn'),function(){
	element=$(this).parents('table').next();	
	element.slideToggle(200);
	});

$(document).on('click',('.p5'),function(){
	$('.p5').removeAttr('data-selected-dd');
	$('.p5').removeClass('selected-dd');
	$(this).attr('data-selected-dd','selected').addClass('selected-dd');
	$(this).parents('.listme').prev().find('.combo_filter').val($(this).html());
	$('.listme').slideUp(200);
	})

function hanle_change(self){
	element=$(self);
	val=element.val();
	drop=element.parents('table').next();
	drop.slideDown(200);
	//console.log($('*[data-name="'+val+'"]').val());
	array=[];
	drop.find('optgroup').hide();
	drop.find('.p5').hide();
	drop.find('option').each(function(index, element) {
		temp=$(element).html().toLowerCase();
		if(temp.indexOf(val)==0){
			$(element).parent().show();
			$(element).show();
			}
      });
	}

function hanle_change_ajax(self){
	element=$(self);
	val=element.val();
	drop=element.parents('table').next();
	
	//console.log($('*[data-name="'+val+'"]').val());
	if(val.length>=2){
		flag=$('#meta_collapse').val();
		if(flag==1){
			drop.slideDown(200);
			}
		
		drop.html('<center><img src="<?php echo bu('images/ajax_rt.gif');?>"></center>');
		$.post('<?php echo bu('doctor/get_institution_name/');?>'+val,function(data){
			if(data.length==0){drop.html('');drop.slideUp(0);$('#meta_collapse').val(0);}
			else {
				drop.html(data);
				$('#meta_collapse').val(1);
				}
			
			});
		}
	else drop.css('display','none');
     
	}

function hanle_change_ajax_registration(self){
	element=$(self);
	val=element.val();
	drop=element.parents('table').next();
	
	//console.log($('*[data-name="'+val+'"]').val());
	if(val.length>=2){
		flag=$('#meta_collapse_reg').val();
		if(flag==1){
			drop.slideDown(200);
			}
		
		drop.html('<center><img src="<?php echo bu('images/ajax_rt.gif');?>"></center>');
		$.post('<?php echo bu('doctor/get_register_council/');?>'+val,function(data){
			if(data.length==0){drop.html('');drop.slideUp(0);$('#meta_collapse_reg').val(0);}
			else {
				drop.html(data);
				$('#meta_collapse_reg').val(1);
				}
			
			});
		}
	else drop.css('display','none');
     
	}
	
function hanle_change_ajax_membership(self){
	element=$(self);
	val=element.val();
	drop=element.parents('table').next();
	
	//console.log($('*[data-name="'+val+'"]').val());
	if(val.length>=2){
		flag=$('#meta_collapse_member').val();
		if(flag==1){
			drop.slideDown(200);
			}
		
		drop.html('<center><img src="<?php echo bu('images/ajax_rt.gif');?>"></center>');
		$.post('<?php echo bu('doctor/get_membership_council/');?>'+val,function(data){
			if(data.length==0){drop.html('');drop.slideUp(0);$('#meta_collapse_member').val(0);}
			else {
				drop.html(data);
				$('#meta_collapse_member').val(1);
				}
			
			});
		}
	else drop.css('display','none');
     
	}
	

	
function hanle_change_ajax_service(self){
	element=$(self);
	val=element.val();
	drop=element.parents('table').next();
	
	//console.log($('*[data-name="'+val+'"]').val());
	if(val.length>=2){
		flag=$('#meta_collapse_service').val();
		console.log(flag);
		if(flag==1){
			drop.slideDown(200);
			}
		
		drop.html('<center><img src="<?php echo bu('images/ajax_rt.gif');?>"></center>');
		$.post('<?php echo bu('doctor/get_service_council/');?>'+val,function(data){
			if(data.length==0){drop.html('');drop.slideUp(0);$('#meta_collapse_service').val(0);}
			else {
				drop.html(data);
				$('#meta_collapse_service').val(1);
				}
			
			});
		}
	else drop.css('display','none');
     
	}	

$(window).scroll(function(e) {
    var scrollTop     = $(window).scrollTop(),
    elementOffset = $('#rt-box').offset().top,
    distance      = (elementOffset - scrollTop);
    if($(window).width()>1200){
    	    if(distance<=40){
		    $('#rt-box').css({'right':'-37px','top':'35px','position':'fixed'});
		    }  
	     if(scrollTop<160){
		      $('#rt-box').css({'right':'inherit','top':'auto','position':'inherit'});
		     }
	    }
    
});
function add_experience(){
	$('#experience_holder').append('<?php get_experience();//helper/custom_helper.php?>');
	}
function add_achivements(){
	$('#achivements_holder').append('<?php get_achivements();//helper/custom_helper.php?>');
	}
function add_registration(){
	$('#registration_holder').append('<?php get_registration();//helper/custom_helper.php?>');
	}
function add_membership(){
	$('#membership_holder').append('<?php get_membership();//helper/custom_helper.php?>');
	}
	
function add_service(){
	$('#service_holder').append('<?php get_service();//helper/custom_helper.php?>');
	}
$(document).ready(function(e) {
	$('.sub_btn').click(function(e) {
           $(this).find('.icon').html(' <img src="<?php echo bu('images/ajax_rt.gif');?>"> &nbsp;&nbsp;Saving');
	     $(this).find('.icon').addClass('tick_image');
      });
	
      $('#profileform').submit(function(e) {//
	    e.preventDefault();
	    var formData = new FormData(this);
	    $.ajax({
		  url: "<?php echo bu('doctor/profile');?>",
		  data: formData,
		  processData: false,
		  contentType: false,
		  type: 'POST',
		  success: function(_receiveddata) {
			 $('.tick_image').html(' <i class="fa fa-fw fa-check coleskar"></i> &nbsp;&nbsp;Saved');
			 //console.log(_receiveddata);
		    }
});
	    
      
});
});
 </script>
<div class="right-side">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Profile <small>Some details about you</small> </h1>
                <ol class="breadcrumb">
                    <li class="active"> <i class="fa fa-dashboard"></i> Dashboard
                    <li class="active"> <i class="fa fa-edit"></i> Profile </li>
                    </li>
                </ol>
                <?php if(isset($post_message) and !empty($post_message)) display_msg($post_message,'danger');?>
                <?php display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));?>
            </div>
        </div>
        <div class="row"> 
            <!--<div class="col-lg-5 hidden-lg" align="center">
                  <h3>Profile Picture</h3>
                  	<div id="imagePreview"> 
                        <img  style="width:100%; height:100%" src="
				<?php 
					
					$exists=0;
					if(is_file(('user_upload/'.$userdata->unique_id.'/dp.jpg'))){
						echo bu('user_upload/'.$userdata->unique_id.'/dp.jpg');
						$exists=1;
						}
						
					elseif(is_file( ('user_upload/'.$userdata->unique_id.'/dp.png'))){
						echo bu('user_upload/'.$userdata->unique_id.'/dp.png');
						$exists=1;
						}
						
					elseif(is_file( ('user_upload/'.$userdata->unique_id.'/dp.gif'))){
						echo bu('user_upload/'.$userdata->unique_id.'/dp.gif');
						$exists=1;
						}
						
					elseif(is_file( ('user_upload/'.$userdata->unique_id.'/dp.jpeg'))){
						echo bu('user_upload/'.$userdata->unique_id.'/dp.jpeg');
						$exists=1;
						}
						
				?>"></div>
                        <span class="btn btn-success btn-file" style="width: 200px;margin: 0 auto;display: block;">
                            <i class="glyphicon glyphicon-picture"></i>&nbsp;&nbsp;
                            &nbsp;
                            <?php if($exists==1) echo 'Update Photo';
				    		else echo 'Browse';
				    ?>
                            &nbsp;&nbsp;
                            <img id="ajax-img"  style=" width: 19px; ">
                             <input id="uploadFile" name="image" class="img" type="file" onclick="console.log(2)">
                        </span>
                  </div>-->
            <input id="meta_collapse" value="1" type="hidden" />
            <input id="meta_collapse_service" value="1" type="hidden" />
            <input id="meta_collapse_reg" value="1" type="hidden" />
            <input id="meta_collapse_member" value="1" type="hidden" />
            <div class="col-lg-8 .col-md-12">
                <?php
			$attributes = array('id' => 'profileform');
		 	echo form_open(bu('doctor/profile'),$attributes);
		?>
                <h3>Personal Details</h3>
                <div class="form-group">
                 <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-envelope"></i> Email &nbsp;&nbsp;</span>
                    <input class="form-control" placeholder="Email" disabled value="<?php echo $this->session->userdata('email');?>">
                </div></div>
                <?php 
					$userdata=$this->doctor_m->get($this->session->userdata('id'));
					
				?>
                <div class="form-group">
                    <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-group"></i> Name*</span>
                    <input class="form-control" name="name" placeholder="Name" value="<?php 	if(empty($userdata->name))echo $this->session->userdata('name');else echo trim($userdata->name);?>">
                </div></div>
                <div class="form-group">
                <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-phone"></i> Phone*</span>
                    <input class="form-control" placeholder="Phone number" disabled value="<?php echo $userdata->phone;?>">
                </div></div>
                <div class="form-group">
                <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-tint"></i> About</span>
                    <textarea class="form-control" name="about" rows="4" ><?php echo $userdata->about;?></textarea>
                </div></div>
                <div class="form-group">
                    <label>Gender</label>
                    <div class="radio">
                        <label> <i class="fa fa-male"></i> &nbsp;&nbsp;
                            <input type="radio" name="gender" id="optionsRadios1" value="M" 
						    <?php if(empty($userdata->gender)) echo 'checked';?>
						    <?php if($userdata->gender=='M') echo 'checked';?>>
                             Male </label>
                    </div>
                    <div class="radio">
                        <label> <i class="fa fa-female"></i> &nbsp;&nbsp;
                            <input type="radio" name="gender" id="optionsRadios2" value="F"
                                        <?php if($userdata->gender=='F') echo 'checked';?>>
                             Female </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-home"></i> Address Line 1</span>
                          <input class="form-control" placeholder="Address 1" name="address_1" value="<?php echo $userdata->address_1;?>">
                </div> </div>
                <div class="form-group">
                    <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-home"></i> Address Line 2</span>
                     	  <input class="form-control" placeholder="Address 2" name="address_2" value="<?php echo $userdata->address_2;?>">
                </div> </div>
                <div class="form-group">
               	 <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-phone"></i> Land Phone &nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <input class="form-control" placeholder="Land Phone" name="landline" value="<?php echo $userdata->landline;?>">
                </div></div>
                    <button type="submit" class="btn btn-success btn-sm sub_btn"><span class="icon">Save</span></button>
                <hr>
                
                
                <h3>Social Links</h3>
                <div class="form-group"> 
                    <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-facebook"></i></i></span>
                          <input class="form-control" name="facebook" placeholder="Facebook Link" value="<?php echo $userdata->facebook;?>">
                    </div>
                </div>
                <div class="form-group">
                     <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-twitter"></i></i></span>
                    	   <input class="form-control"  name="twitter" placeholder="Twitter Link" value="<?php echo $userdata->twitter;?>">
                     </div>
                </div>
                <div class="form-group"> 
                    <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-google"></i></span>
                    	  <input class="form-control" name="google_plus"  placeholder="Google+ Link" value="<?php echo $userdata->google_plus;?>">
                     </div>
                </div>
                <div class="form-group">  
                    <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                   	  <input class="form-control" name="website"  placeholder="Website Link" value="<?php echo $userdata->website;?>">
                </div> </div>
                    <button type="submit" class="btn btn-success btn-sm sub_btn"><span class="icon">Save</span></button>
                <hr>
               
                <!-- __________________________________________________________________________________________ -->
                <div class="form-group gray_bg">
                	  <h3 class="heading"> <img src="<?php echo bu('images/services_blue.png');?>" /> Servies </h3>
                    <span class="add_btn" onClick="add_service()">+ Add  Service</span>
                    <div class="row" id="service_holder">
                        <?php 
				
				 $service=array_filter(explode(':-:',$userdata->service));
				 foreach($service as $a=>$b){
					 get_service($b);
					 }
				
				if(empty($userdata->service)) get_service(); //helper/custom_helper.php
			  ?>
                    </div>
                    <br />
                    <button type="submit" class="btn btn-success btn-sm sub_btn"><span class="icon">Save</span></button>
                </div>
                
                <div class="form-group gray_bg">
                    <h3 class="heading"><img src="<?php echo bu('images/specialties_blue.png');?>" /> Specializations </h3>
                    <span class="add_btn" onClick="add_speciality()">+ Add another speciality</span>
                    <table id="speciality_holder">
                        <?php 
					 $speciality=array_filter(explode(',',$userdata->speciality));
					 foreach($speciality as $a=>$b){
						 get_speciality($b);
						 }
					
					if(empty($userdata->speciality)) get_speciality();//helper/custom_helper.php
				?>
                    </table>
                    <br>
                    <button type="submit" class="btn btn-success btn-sm sub_btn"><span class="icon">Save</span></button>
                    
                </div>
                <!-- __________________________________________________________________________________________ -->
                
                <div class="form-group gray_bg">
                    <h3 class="heading"> <img src="<?php echo bu('images/qualifications_blue.png');?>" /> Education </h3>
                    <span class="add_btn" onClick="add_education()">+ Add another education</span>
                    <table id="education_holder" >
                        <?php 
				
					 $education=array_filter(explode(':-:',$userdata->education));
					 foreach($education as $a=>$b){
						 get_education($b);
						 }
					
					if(empty($userdata->education)) get_education(); //helper/custom_helper.php
				?>
                    </table>
                    <br>
                    <button type="submit" class="btn btn-success btn-sm sub_btn"><span class="icon">Save</span></button>
                </div>
                <div class="form-group gray_bg">
                	  <h3 class="heading"><img src="<?php echo bu('images/organizations_blue.png');?>" />  Experience </h3>
                    <span class="add_btn" onClick="add_experience()">+ Add another experience</span>
                    <div class="row" id="experience_holder" style="margin-left: 0px;">
                        <?php 
				
				 $experience=array_filter(explode(':-:',$userdata->experience));
				 foreach($experience as $a=>$b){
					 get_experience($b);
					 }
				
				if(empty($userdata->experience)) get_experience(); //helper/custom_helper.php
			  ?>
                    </div>
                    <br />
                    <button type="submit" class="btn btn-success btn-sm sub_btn"><span class="icon">Save</span></button>
                </div>
                
                <div class="form-group gray_bg">
                	  <h3 class="heading"> <img src="<?php echo bu('images/awards_blue.png');?>" /> Awards and Recognization </h3>
                    <span class="add_btn" onClick="add_achivements()">+ Add  Awards and Recognization</span>
                   
                    <div class="row" id="achivements_holder">
                        <?php 
				
				 $achivements=array_filter(explode(':-:',$userdata->achivements));
				 foreach($achivements as $a=>$b){
					 get_achivements($b);
					 }
				
				if(empty($userdata->achivements)) get_achivements(); //helper/custom_helper.php
			  ?>
                    </div>
                    <br />
                    <button type="submit" class="btn btn-success btn-sm sub_btn"><span class="icon">Save</span></button>
                </div>
                <div class="form-group gray_bg">
                	  <h3 class="heading"><img src="<?php echo bu('images/registrations_blue.png');?>" /> Registration </h3>
                    <span class="add_btn" onClick="add_registration()">+ Add  Registration</span>
                    <div class="row" id="registration_holder">
                        <?php 
				
				 $registration=array_filter(explode(':-:',$userdata->registration));
				 foreach($registration as $a=>$b){
					 get_registration($b);
					 }
				
				if(empty($userdata->registration)) get_registration(); //helper/custom_helper.php
			  ?>
                    </div>
                    <br />
                    <button type="submit" class="btn btn-success btn-sm sub_btn"><span class="icon">Save</span></button>
                </div>
                <div class="form-group gray_bg">
                	  <h3 class="heading"> <img src="<?php echo bu('images/memberships_blue.png');?>" /> Membership </h3>
                    <span class="add_btn" onClick="add_membership()">+ Add  Membership</span>
                    <div class="row" id="membership_holder">
                        <?php 
				
				 $membership=array_filter(explode(':-:',$userdata->membership));
				 foreach($membership as $a=>$b){
					 get_membership($b);
					 }
				
				if(empty($userdata->membership)) get_membership(); //helper/custom_helper.php
			  ?>
                    </div>
                    <br />
                    <button type="submit" class="btn btn-success btn-sm sub_btn"><span class="icon">Save</span></button>
                </div>
                </form>
            </div>
            <div class="col-lg-4 animate_2" id="rt-box" align="center">
                <h3>Profile Picture</h3>
                <div id="imagePreview"> <img  style="width:100%; height:100%" src="
				<?php 
					
					$exists=0;
					if(is_file(('user_upload/'.$userdata->unique_id.'/dp.jpg'))){
						echo bu('user_upload/'.$userdata->unique_id.'/dp.jpg');
						$exists=1;
						}
						
					elseif(is_file( ('user_upload/'.$userdata->unique_id.'/dp.png'))){
						echo bu('user_upload/'.$userdata->unique_id.'/dp.png');
						$exists=1;
						}
						
					elseif(is_file( ('user_upload/'.$userdata->unique_id.'/dp.gif'))){
						echo bu('user_upload/'.$userdata->unique_id.'/dp.gif');
						$exists=1;
						}
						
					elseif(is_file( ('user_upload/'.$userdata->unique_id.'/dp.jpeg'))){
						echo bu('user_upload/'.$userdata->unique_id.'/dp.jpeg');
						$exists=1;
						}
						
				?>"></div>
                <span class="btn btn-success btn-file" style="width: 200px;margin: 0 auto;display: block;"> <i class="glyphicon glyphicon-picture"></i>&nbsp;&nbsp;
                &nbsp;
                <?php if($exists==1) echo 'Update Photo';
				    		else echo 'Browse';
				    ?>
                &nbsp;&nbsp; <img id="ajax-img"  style=" width: 19px; ">
                <input id="uploadFile" name="image" class="img" type="file">
                </span> </div>
            <input type="hidden" id="unique_id" value="<?php echo $userdata->unique_id;?>">
            <input type="hidden" id="user_id" value="<?php echo $userdata->id;?>">
        </div>
        <!--End of row class --> 
        
    </div>
</div>
