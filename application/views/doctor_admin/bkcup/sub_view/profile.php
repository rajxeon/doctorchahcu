


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
    background-image:url(<?php echo bu('images/no_image.jpg');?>);
    height: 180px;
    background-position: center center;
    background-size: cover;
    -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
    margin: 0 auto;
   margin-bottom: 15px;
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
				    success: function(data){
					  console.log(data); // display response from the PHP script, if any
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


$(document).on('click','.reduce_speciality',function(e) {
    $(this).prevUntil('.xeon').html('').remove();
    $(this).remove();
});

</script>
<div id="page-wrapper">

            <div class="container-fluid">
            
            	<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Profile <small>Some details about you</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                                <li class="active">
                                <i class="fa fa-edit"></i> Profile
                            </li>
                            </li>
                        </ol>
                       <?php if(isset($post_message) and !empty($post_message)) display_msg($post_message,'danger');?>
                       
                       <?php display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));?>
                       
                    </div>
                </div>
                
                <div class="row">
               	 <div class="col-lg-7">
                   	<?php echo form_open(bu('doctor/profile'));?>
                        <h3>Personal Details</h3>
                        
                        <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" placeholder="Email" disabled value="<?php echo $this->session->userdata('email');?>">
                        </div>
                        
                        
                        
                        <?php 
					$userdata=$this->doctor_m->get($this->session->userdata('id'));
					
				?>
                        
                        <div class="form-group">
                                <label>Name*</label>
                                <input class="form-control" name="name" placeholder="Name" value="<?php 	if(empty($userdata->name))echo $this->session->userdata('name');else echo trim($userdata->name);?>">
                        </div>
                        <div class="form-group">
                                <label>Phone*</label>
                                <input class="form-control" placeholder="Phone number" disabled value="<?php echo $userdata->phone;?>">
                        </div>
                        
                        <div class="form-group">
                               <label>Gender</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" id="optionsRadios1" value="M" 
						    <?php if(empty($userdata->gender)) echo 'checked';?>
						    <?php if($userdata->gender=='M') echo 'checked';?>>Male
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" id="optionsRadios2" value="F"
                                        <?php if($userdata->gender=='F') echo 'checked';?>>Female
                                    </label>
                                </div>
                                
                        </div>
                        
                        <div class="form-group">
                                <label>Address Line 1</label>
                                <input class="form-control" placeholder="Address 1" name="address_1" value="<?php echo $userdata->address_1;?>">
                        </div>
                        
                        <div class="form-group">
                                <label>Address Line 2</label>
                                <input class="form-control" placeholder="Address 2" name="address_2" value="<?php echo $userdata->address_2;?>">
                        </div>
                        
                         <div class="form-group">
                                <label>Land Phone</label>
                                <input class="form-control" placeholder="Land Phone" name="landline" value="<?php echo $userdata->landline;?>">
                        </div>
                            
                        
                        
                        
                        
                        <hr>
                        	<h3>Social Links</h3>
                              
                              <div class="form-group">
                                <i class="fa fa-facebook" style="font-size: 20px;background: rgb(51, 122, 183);color: #fff;padding: 5px 10px;border-radius: 4px;margin-right: 14px;margin-bottom: 5px;"></i>
                                <label>Facebook</label>
                                <input class="form-control" name="facebook" placeholder="Facebook Link" value="<?php echo $userdata->facebook;?>">
                        	</div>
                              
                              <div class="form-group">
                                <i class="fa fa-twitter" style="font-size: 20px;background: rgb(120, 193, 255);color: #fff;padding: 5px 10px;border-radius: 4px;margin-right: 14px;margin-bottom: 5px;"></i>
                                <label>Twitter</label>
                                <input class="form-control"  name="twitter" placeholder="Twitter Link" value="<?php echo $userdata->twitter;?>">
                        	</div>
                              
                              <div class="form-group">
                                <i class="fa fa-google" style="font-size: 20px;background: #D64435;color: #fff;padding: 5px 10px;border-radius: 4px;margin-right: 14px;margin-bottom: 5px;"></i>
                                <label>Google+</label>
                                <input class="form-control" name="google_plus"  placeholder="Google+ Link" value="<?php echo $userdata->google_plus;?>">
                        	</div>
                              
                              <div class="form-group">
                                <i class="fa fa-globe" style="font-size: 20px;background: rgb(174, 120, 255);color: #fff;padding: 5px 10px;border-radius: 4px;margin-right: 14px;margin-bottom: 5px;" ></i>
                                <label>Website</label>
                                <input class="form-control" name="website"  placeholder="Website Link" value="<?php echo $userdata->website;?>">
                        	</div>
                              
                            
                          
                          <hr>
                        	<h3>Professional Details</h3>
                              
                              <div class="form-group">
                              
                              <label>Speciality</label>
                              
                              
                              <table>
                              	<?php 
					 $speciality=array_filter(explode(',',$userdata->speciality));
					 foreach($speciality as $a=>$b){
						 get_speciality($b);
						 }
					
					if(empty($userdata->speciality)) get_speciality();//helper/custom_helper.php
					?>
                               
                               <div id="speciality_holder"></div>
                              </table>
                              
                              
                              
                              <br>
                              <button type="button" class="btn btn-sm btn-info" onClick="add_speciality()">+ Add another speciality</button>
                                
                        	</div>
                              
                              <div class="form-group">
                                <label>Achivements</label>
                                <input class="form-control" name="achivements" placeholder="Separate achivements by comma" value="<?php echo $userdata->achivements;?>">
                        	</div>
                              
                              <div class="form-group"> 
                                <label>Experience</label>
                                <textarea name="experience" class="form-control"><?php echo $userdata->experience;?></textarea>
                        	</div>
                              
                               <button type="submit" class="btn btn-success">Update  Profile</button>
                       		 <button type=" " class="btn btn-primary">Refresh Form</button>
                   	  </form>
                   </div>
                  
                  <div class="col-lg-5" align="center">
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
                             <input id="uploadFile" name="image" class="img" type="file">
                        </span>
                  </div>
                   
                <input type="hidden" id="unique_id" value="<?php echo $userdata->unique_id;?>">
                <input type="hidden" id="user_id" value="<?php echo $userdata->id;?>">
                   
                </div><!--End of row class -->
            
            </div>
</div>