<?php $this->load->view('components/h1.php',$this->data);?>

<link href="<?php echo bu('style/star-rating.min.css');?>" media="all" rel="stylesheet" type="text/css"/>
<script src="<?php echo bu('js/star-rating.min.js');?>" type="text/javascript"></script>


<link rel="stylesheet" type="text/css" href="<?php echo bu('style/da-slider/style2.css');?>" />
<script type="text/javascript" src="<?php echo bu('js/modernizr.custom.28468.js');?>"></script>



<style>
.row{ margin:auto 0}
.row dasiv{ min-height:70px; border:1px solid #000}
header{ background:#3E205B; height:90px}

.item{ height:300px}
#dp_holder{ height: 200px;width: 200px;border: 6px solid #FFFFFF;border-radius: 100%;overflow: hidden;box-shadow: 0px 3px 9px 1px #000;margin: -87px auto;position: relative;z-index: 1;}
#dp_holder img{border-radius: 100%;}
.css3-shadow,.css3-gradient1,.css3-gradient2{  position:relative;-webkit-box-shadow:0 1px 11px 3px rgba(0, 0, 0, 0.3);box-shadow:0 1px 11px 3px rgba(0, 0, 0, 0.3);}
.css3-shadow:after{	content:"";    position:absolute;z-index:-1;-webkit-box-shadow:0 8px 55px rgba(0,0,0,0.8);box-shadow:0 8px 55px rgba(0,0,0,0.8);    bottom:0px;	width:80%;	height:50%;    -moz-border-radius:100%;    border-radius:100%;	left:10%;	right:10%;}
.box {	padding:0px;background:#fff;	border-radius:2px;}
.doctor_intro{ color:#555; z-index:20}
.doctor_intro p{ text-align:right; font-weight:bold; font-size:16px; margin:1px}
.doctor_intro p small{ font-weight:normal; cursor:pointer;}
.doctor_intro p small:hover{ text-decoration:underline}
.review_zone{ color:#555; font-size:16px; margin-top:7px}
#recomendation{ font-size:18px; font-weight:bold;color: #00B3E7;}
.review_zone span.glyphicon{font-size: 17px;color: #00B3E7;}
#interaction{ margin-top:5px}
#interaction span{cursor:pointer;}
#interaction small{cursor:pointer; font-size:70%}
#interaction span:hover{ color:#0033CC;}
.custom-dd{ width:250px; left:auto; right:0; padding:10px}
.custom-dd h3{ margin-top:5px}
.shedule_holder{ background:#FFFFFF;box-shadow: 0 0 4px rgba(0,0,0,0.2); margin-bottom:5px; padding:10px}
.city_name{font-size: 16px;text-decoration: underline; cursor:pointer}
.main_cont{ color:#666666; padding:0}
.shedule_holder h3{ margin-top:5px}
.clinic_thumb {width: 24%;height: 40px;margin: 2px;border: 1px solid #4A4A4A;cursor: pointer;border-radius: 8px;}
.clinic_thumb:hover{ opacity:.8}
.qr_holder img{margin: -15px 0;}
.side_shedule{margin-left: 0.5%;width: 24%;}
@media screen and (max-width: 991px) {
	.side_shedule{ width: 100% !important; margin-left:0}
	.css3-shadow:after{ position:inherit}
	.small-dp{}
	}
@media screen and (max-width: 768px) {
	.small-dp{ margin-top:5%}
	#dp_holder { height: initial;
	max-width:200px;
	width: initial;
border: 2px solid #FFFFFF;
border-radius: 100%;
overflow: hidden;
box-shadow: 0px 0px 6px 1px #000;
margin: 9px auto;
z-index: 1;
position: inherit;
 
}
	}
.carousel-inner>.item>img, .carousel-inner>.item>a>img{height:100%}
</style> 
<?php $clinic_data=$clinic_data;?>

<header>

<div class="row">
      <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
      <div class="col-md-12 col-lg-10 col-sm-12 col-xs-12" >
      	<!-- This is the main container -->
            
            <?php $this->load->view('components/public_navigation.php');?>
            <!--  End of nav header -->
            
           	<div class="box css3-shadow hidden-xs" >
            	<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="3500">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                          <li data-target="#myCarousel" data-slide-to="1"></li>
                          <li data-target="#myCarousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                        <?php 
							  if(empty($clinic_data)){echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <h4>Oh snap! You got an error!</h4>
      <p>Sorry the doctor you are trying to find has not linked any clinic. </p>
	  <p>If you are <strong>Dr.'.$clinic_data->name.'</strong> please login to your control panel and create atleast 1 clinic.</p>
      
    </div>';die();}
							  $id=$clinic_data->id; 
						?>
                          <div class="item active">
                          <?php 
						  
						  	if(file_exists((config_item('clinic_image').$clinic_data->id.'/1.jpg')))
							echo '<img src="'.bu(config_item('clinic_image').$clinic_data->id.'/1.jpg').'"  width="100%" height="450" alt="'.$clinic_data->name.' first image">';
							else echo '<img src="http://static.wixstatic.com/media/b04e14_0d2c941048cb4d5ca18b3e563c344dc0.jpg_srz_975_536_85_22_0.50_1.20_0.00_jpg_srz"  width="100%" height="450" alt="First slide">';
						  ?>
                            
                            
                          </div>
                          <div class="item">
                          <?php 
						  if(file_exists((config_item('clinic_image').$clinic_data->id.'/2.jpg')))
							echo '<img src="'.bu(config_item('clinic_image').$clinic_data->id.'/2.jpg').'"  width="100%" height="450" alt="'.$clinic_data->name.' second image">';
							else echo '<img src="http://www.johnmuirhealth.com/content/dam/jmh/Locations%20or%20Facilities/pediatric_specialty_clinic_exam_room.jpg"  width="100%"  height="450" alt="Second slide">';
						  ?>
                            
                            
                          </div>
                          <div class="item">
                          <?php 
						  if(file_exists((config_item('clinic_image').$clinic_data->id.'/3.jpg')))
							echo '<img src="'.bu(config_item('clinic_image').$clinic_data->id.'/3.jpg').'"  width="100%" height="450" alt="'.$clinic_data->name.' third image">';
							else echo ' <img src="http://www.clinicinacan.org/wp-content/images/2012/06/Clinic-In-A-Can-20-foot-ultrasound.jpg"  width="100%"  height="450" alt="Third slide">';
						  ?>
                           
                            
                          </div>
                        </div>
                       
                      </div>
            </div>
            
            <!-- End of Gallery -->
            
            <div class="row">
            	<div class="col-md-3 col-lg-3 hidden-sm hidden-xs">
                  
                  	<center id="dp_holder">
                        	<img src="<?php 
							if(file_exists((config_item('clinic_image').$clinic_data->id.'/logo.jpg')))
							echo (bu(config_item('clinic_image').$clinic_data->id.'/logo.jpg'));
							else { echo bu('images/clinic.jpg');}
							
							?>">
                    </center>
                  </div>
                  <div class="col-md-6 col-lg-6 hidden-sm hidden-xs doctor_intro">
                  	<h2>
					<i class="fa fa-fw fa-hospital-o"></i>
	   <?php echo str_replace('clinic','',str_replace('Clinic', '',$clinic_data->name));?> Clinic</h2>
       <p>  <?php  echo $clinic_data->street.','.$clinic_data->locality.','.$clinic_data->city; ?></p>
       <p style="font-weight:normal">  <?php  echo $clinic_data->city.','.$clinic_data->district.','.$clinic_data->state.','.$clinic_data->pin; ?><small><span style="color:#f00" data-toggle="modal" data-clinic_name="Ninni" super="" clinic="" data-target="#myMapModal" data-longitude="<?php echo $clinic_data->longitude?>" 
                data-latitude="<?php echo $clinic_data->latitude?>" onclick="open_map($(this))"><i class="fa fa-fw fa-map-marker"></i> View on map</span>
				 </small></p>
                  </div>
                  <div class="hidden-md hidden-lg col-sm-4 col-xs-5 ">
                  	<center id="dp_holder"> <img src="<?php if(file_exists((config_item('clinic_image').$clinic_data->id.'/logo.jpg')))
							echo (bu(config_item('clinic_image').$clinic_data->id.'/logo.jpg'));
							else { echo bu('images/clinic.jpg');}
?>">  </center>
                  </div>
                  <div class="hidden-md hidden-lg col-sm-4 col-xs-7 small-dp no-pad">
                  
                  	<h2 style="font-size: 23px;">
					<i class="fa fa-fw fa-hospital-o"></i>
					<?php echo str_replace('clinic','',str_replace('Clinic', '',$clinic_data->name));?> Clinic</h2>
                        <p>
                        <?php  echo $clinic_data->street.','.$clinic_data->locality.','.$clinic_data->city; ?>
                        <p>
						<?php  echo $clinic_data->city.','.$clinic_data->district.','.$clinic_data->state.','.$clinic_data->pin; ?>
                         
                         <span style="color:#f00" data-toggle="modal" data-clinic_name="Ninni" super="" clinic="" data-target="#myMapModal" data-longitude="<?php echo $clinic_data->longitude?>" 
                data-latitude="<?php echo $clinic_data->latitude?>" onclick="open_map($(this))">
		<i class="fa fa-fw fa-map-marker"></i> View on map</span>
        </p>
                  
                  </div>
                  <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12 review_zone">
                  	<table style="width:100%">
                        	<div>
                              	<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                                    <span id="recomendation"><?php echo $clinic_data->like;?></span>
                                    <small> Recomendations</small>
                              </div>
                              <div>
                              	<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                                    <span id="recomendation"><?php echo $clinic_data->review_count?></span>
                                    <small> Rewiews</small>
                              </div>
                              <input id="input-21e" data-command="rating"  value="<?php echo $clinic_data->rating;?>" type="number" class="rating" min=0 max=5 step=0.5 data-size="xs" >
<script src="<?php echo bu('js/jquery.cookie.js');?>"></script>
<script>
	$(document).ready(function(e) {
		$('#input-21e').on('rating.change', function(event, value, caption) {
			if($.cookie('clinic_rating')==undefined)
			$.post('<?php echo bu('helper/rating/clinic_m');?>',{value:value,id:'<?php echo $clinic_data->id;?>'},function(data){console.log(data);
				if(data=='rated'){
					$.cookie('clinic_rating', '<?php echo $clinic_data->id;?>', { expires: 30 });
					}
				});
				
		});
		
		
		
		
		
        $('.command').click(function(e) {
            command=$(this).attr('data-command');
			$('.command').removeAttr('style');
			$(this).css('color','#00F');
			if(command=='like' && $.cookie('clinic_like')!=1){
				$.post('<?php echo bu('helper/command/clinic_m');?>',{command:command,id:'<?php echo $clinic_data->id;?>'},function(data){
				if(data=='liked') {
					$.cookie('clinic_like', '1', { expires: 30 });
					$.cookie('clinic_dislike', '0', { expires: 30 });
					$(this).css('color','#00F');
					}
				});
			}
				
			if(command=='dislike' && $.cookie('clinic_dislike')!=1){
				$.post('<?php echo bu('helper/command/clinic_m');?>',{command:command,id:'<?php echo $clinic_data->id;?>'},function(data){
				if(data=='disliked') {
					$.cookie('clinic_dislike', '1', { expires: 30 });
					$.cookie('clinic_like', '0', { expires: 30 });
					$(this).css('color','#00F');
					}
				});
				}
        });
		
		
		
		
		
		
    });
	
	function submit_review(self){
		name=$('#InputName').val();
		text=$('#review_text').val();
		if($.cookie('clinic_review')!=<?php echo $clinic_data->id?>) review_cookie=null;
		else review_cookie=$.cookie('clinic_review');
		$.post('<?php echo bu('helper/submit_review/clinic_m');?>',{review_cookie:review_cookie,name_review:name,text:text,id:'<?php echo $clinic_data->id;?>'},function(data){
			$('#review_msg').html(data);
			$.cookie('clinic_review', '<?php echo $clinic_data->id?>', { expires: 7 });
			
			});
		}
</script>
                              <table width="100%" id="interaction">
                              	<tr>
                                    	<a>
                                          	<td>
                                                	<span class="glyphicon glyphicon-thumbs-up command" aria-hidden="true" data-command="like"></span>
                                                      <small> Like </small>
                                                </td>
                                          </a>
                                          <a>
                                          <td>
                                          	<span class="glyphicon glyphicon-thumbs-down command" aria-hidden="true" data-command="dislike"></span>
                                                <small> Dislike </small>
                                          </td>
                                          </a>
                                          
                                          
                                        	<td>
                                          <div class="dropdown">
                                                 <button class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true" style="background: transparent;border: none;">
                                                      <span class="glyphicon glyphicon-comment" aria-hidden="true">
                                                      </span><small> Add review </small>
                                                      <div class="dropdown">
                                                    
                                                  </button>
                                                  <ul class="dropdown-menu custom-dd" role="menu" aria-labelledby="dropdownMenu1" style="z-index:10000">
                                                  <span style="float: right;" class="glyphicon glyphicon-remove" aria-hidden="true"
                                                  onClick="$('#dropdownMenu1').click();$('#review_msg').html('');"></span>
                                                  <h3>Add a review</h3>
                                                  <div class="form-group">
                                                    <input type="text" name="name_review" class="form-control" id="InputName" placeholder="Your name">
                                                  </div>
                                                  <div class="form-group">
                                                    <textarea name="review" class="form-control" style="width:100%; height:80px" id="review_text" onfocus="this.select();">Your review</textarea>
                                                  </div>
                                                  <div id="review_msg" align="center"></div>
                                                  <button type="submit" onclick="submit_review($(this));" class="btn btn-success btn-sm btn-block">Submit</button>
                                                  </ul>
                                                </div>
                                          </td> 
                                        
                                            
                                    </tr>
                              </table>
                        </table>
                  </div>
            </div>
            
            <!-- End of Details -->
            
            <div class="row" style="height:200px">
                  <div class="col-md-9 col-lg-9 main_cont">
                  	<div class="row">
                         	<div class="col-md-12 col-lg-12 shedule_holder">
                              <h4>About <?php echo str_replace('clinic','',str_replace('Clinic', '',$clinic_data->name));?></h4>
                              <span id="summaryText" ><?php echo $clinic_data->about;?></span>
                              <br />
                              </div>
<ul class="nav nav-tabs self_nav">
    <li class="active" data-child="doctors_h">
    	<a> <i class="fa fa-fw fa-user-md"></i> Doctors</a>
    </li>
    <li  data-child="service_h">
    	<a> <i class="fa fa-fw fa-medkit"></i> Services</a>
    </li>
    <li  data-child="report_h">
    	<a> <i class="fa fa-fw fa-plus-square"></i> Test Reports</a>
    </li>
</ul>
<style>
.colapasble_handle{
	padding: 7px;
	cursor:pointer
	}
.colapasble_handle:hover{  color:rgb(64, 150, 176)}
.colapasble_handle i{
	font-size: 24px;
	float: right;}
.colapasble_handle span{font-size: 20px;}
body{min-height: 1460px !important;}
.shedule_holder li{cursor: pointer;font-size: 13px;color: rgb(252, 97, 97);}
.shedule_holder li:hover{ text-decoration:underline}
.no-pad{ padding:0}
.color_th{color: rgb(64, 150, 176);}
.instant_appointment{ cursor:pointer;max-width: 155px;}
.instant_appointment:hover{ opacity:.8}
.less_pad{padding: 3px 5px;font-size: 13px; text-transform:capitalize; cursor:default}
.inst_appoint_holder{ background:#F3F3F3;padding: 10px;box-shadow: 0px 0px 2px;}
.img_pre img{height: 220px;border: 1px solid #AFAFAF;}
.no_style{height: auto !important;border:none !important;box-shadow:none !important; padding-top:80px}
.input-group-addon:first-child{ border-radius:0px !important; width:82px}
.input-group .form-control:last-child{ border-radius:0px !important}
.ui-widget-content{ width:100% !important}
.slot_picker{zoom: 1.4; margin:0;
margin-right: 6px;}
.shedular_top{ margin: -10px;
min-height: 40px;padding: 10px 5px;
margin-bottom: 7px;
background: rgb(46, 169, 206);}
.slot_label{ margin:0; font-weight:normal}
.shedule_holder_ajax{padding-right: 0;padding-left: 4px;}
.fiver{max-height: 350px;overflow: auto;background: #fff;padding-left: 6px;margin-right: 5px;border: 1px solid #D1D1D1;border-radius: 5px;}
@media screen and (min-width: 991px) {
    .by_collapsale {
	    display:block;
    }
    .instant_appointment{ position:inherit; max-width:155px !important}
}
.fiver::-webkit-scrollbar {
    width: 5px;
}
 
.fiver::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
}
 
.fiver::-webkit-scrollbar-thumb {
  background-color: darkgrey;
  outline: 1px solid slategrey;
}
.not_available{zoom: 0.8;margin: 0 10px;padding: 0 10px;margin-right: 0px;}
.review_box_name{padding: 4px;border: none;color: #000;font-size: 20px;font-family: serif; background:#F4E6CB;position:relative;
}
.comment_arrow{zoom: 1.9;position: absolute;bottom: -12px;left: 13px;color: #F4E6CB;}
.avatar_holdar{height: 55px;float: left;margin: 4px;}
.by_mm{color: chocolate !important;float: right;text-transform: lowercase;}
.nav>li {position: relative;display: block;border: 1px solid #ddd;border-top-left-radius: 10px;border-top-right-radius: 10px;background: #fff;}
.nav li a{margin:0;}
.nav-tabs>li>a{border-radius: 10px 10px 0 0;}
li.active a{background-color: #00B3E7 !important;color: #fff !important;}
.self_nav li{ cursor:pointer}
.sr_holder li{ color:#000; cursor:default; margin:5px 0}
.sr_holder li:hover{text-decoration:none;}
.ini_hidden{ display:none};
.social{zoom: 1.8;}
.social a i{font-size: 20px; cursor:pointer}
.social a i:hover{ opacity:.8}
.fa-facebook-square{ color:#43609C}
.fa-twitter-square{ color:#09F}
.fa-google-plus-square{ color:#C30}
.fa-facebook-globe{ color:#090}
</style>

<script>
	$(document).ready(function(e) {
		$('.self_nav li').click(function(e) {
			$('.self_nav li').removeClass('active');
			$(this).addClass('active');
			my_child=$(this).attr('data-child');
			$('.self_h').hide(0);
			child=$('#'+my_child);
			child.show(0);
			
			if(my_child=='service_h' ){
				container=$('#'+child.attr('id')+'>div');
				loaded=$(container).attr('data-loaded');
				if(loaded=='false'){
					//Get service list
					$.post('<?php echo bu('helper/get_all_services');?>',{'id':'<?php echo $clinic_data->id?>'},
					function(data){
						
						container.html(data);
						
						})
					container.attr('data-loaded','true');
					}
				
				}
		});
		$('.colapasble_handle').click(function(e) {
			  $(this).next().slideToggle(200);
		});
			
	});
	
	$(document).on('submit',$('.shedule_form'),function(e){
		e.preventDefault();
		name 			=$(this).find($('[name="name"]')).val(); 
		email			=$(this).find($('[name="email"]')).val(); 
		phone			=$(this).find($('[name="phone"]')).val(); 
		clinic_id		=$(this).find($('[name="clinic_id"]')).val(); 
		doctor_id		=$(this).find($('[name="doctor_id"]')).val(); 
		time			=$(this).find($('[name="ask_slot"]:checked')).val(); 
		msg_holder		=$(this).find($('#msg_holder')); 
		ajax_holder		=$(this).find($('#ajax_holder')); 
		html			=''; 
		msg_holder.html('');
		ajax_holder.html('<img src="<?php echo bu('images/ajax_rt.gif');?>">');
		errors=[];
		
		if(name.length==0) 		errors.push('Name can not be empty');
		if(email.length==0) 	errors.push('Email can not be empty');
		if(phone.length==0)   	errors.push('Phone number can not be empty');
		if(time==undefined) 	errors.push('Please select time slot');
		if(isNaN(phone)) 		errors.push('Phone number is not valid');
		
		if((errors.length)>0){
			html='<div class="alert alert-danger" role="alert" style="margin: 0;margin-top: 10px;"><strong>Input Errors</strong>';
		for(var i in errors){
			html+='<p>'+errors[i]+'</p>'
			}
		html+='</div>';
			}
		
		if((errors.length)==0){
			$.post('<?php echo bu('helper/set_appointment');?>',{name:name,email:email,phone:phone,clinic_id:clinic_id,doctor_id:doctor_id,time:time},function(data){
				msg_holder.html(data);
				});
			}
		msg_holder.html(html);
		
		ajax_holder.html('');
		});
	function destroy_shedule_form(){
		$( ".datepicker" ).datepicker( "destroy" );
		}
		
	function prepare_instant(self){
		destroy_shedule_form();
		$('.inst_appoint_holder').slideUp(0);
		bob=(self).parent().parent().next();
		datepicker=bob.find($('.datepicker'));
		shedule_ajax=bob.find($('.shedule_holder_ajax'));		
		$('.shedule_form').remove();
		bob.slideToggle(200);
		$('html,body').animate({
        scrollTop: $(bob).offset().top},
        'slow');
		
		var today = new Date();
		//var tomorrow = new Date(today.getTime() + (24 * 60 * 60 * 1000));
		tomorrow =today;
		datepicker.datepicker({
			  maxDate: "+1m",
			  minDate: tomorrow,
			  autoSize: true,
			  showAnim: "fold",
			  dateFormat: "DD-dd/mm/yy",
				onSelect: function (date) {
					shedule_ajax.html('<div align="center" style="padding-top: 15%;"><img  height="70"  src="<?php echo bu('images/ajax-fast-loader.gif')?>"></div>');
					clinic_id=bob.attr('data-clinic_id');
					doctor_id=bob.attr('data-doctor_id');
					
					$.post('<?php echo bu('helper/ajax_appoint_sheduler')?>',{day:date,clinic_id:clinic_id,doctor_id:doctor_id},function(data){
						shedule_ajax.html(data);
						})
					
				}
			});
		  }
	
	
</script>     

<div id="doctors_h" class="self_h">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>        
<script src="<?php echo bu('libs/lightbox/js/lightbox.min.js')?>"></script>
<link href="<?php echo bu('libs/lightbox/css/lightbox.css')?>" rel="stylesheet" />
<link href="<?php echo bu('style/datepicker.css')?>" rel="stylesheet" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<?php 
$doctor_list=array_filter(explode(',',$clinic_data->other_doctors));
$doctor_list[]=$clinic_data->doctor_id;
$sql="SELECT id FROM doctors WHERE special_clinic=".$clinic_data->id;
$results=$this->db->query($sql)->result();
if(isset($results[0])){
	$results=$results[0];
	$doctor_list[]=$results->id;	
	}
$sql="SELECT * FROM doctors WHERE id in (".implode(',',$doctor_list).")";
$doctor_data=$this->db->query($sql)->result();

?>    
                              
<?php foreach($doctor_data as $a=>$b):?>
   <div class="col-md-12 col-lg-12  shedule_holder">
     	<a href="<?php echo bu('doctors/'.$b->username);?>"><h3 class="link">
		<?php echo " <i class=\"fa fa-fw fa-user-md\"></i> Dr ".$b->name; ?></h3></a>
       	<span class="city_name"><?php  if(!empty($row->city)) echo ','.$b->city;?></span>
        <div class="row no-pad">
       		<div class="col-lg-2 col-md-2 col-sm-2  col-xs-6 no-pad"> 
                        	<a href="<?php echo bu('doctors/'.$b->username);?>"><img  class="dp_x_holder" src="<?php 
							if(file_exists('user_upload/'.$b->unique_id.'/dp.jpg'))
							echo bu('user_upload/'.$b->unique_id.'/dp.jpg');
							else {
								if($b->gender=='M')
								echo bu('images/avatar5.png');
								else echo  bu('images/avatar3.png');
								}
							
							?>"></a>
              </div>
         	<div class="col-lg-3 col-md-3 col-sm-3  col-xs-6 ">
             	<!-- This is the section for the address of the clinic -->
                 <address><?php echo get_doctor_speciality($b);?> </address>
                                               
                                                
                                          </div>
                                          <div class="col-lg-4 col-md-4 col-sm-4  col-xs-6 ">
                                          	<!--This section is for timing of the clinic -->
                                                <?php echo get_clinic_timing($clinic_data->id,$b->id);?>
                                          </div>
                                          <div class="col-lg-3 col-md-3 col-sm-3  col-xs-6 ">
                                          	<!--This section is for fees and Instant Booking -->
                                                <h3>
                                                <i class="fa fa-fw fa-money color_th"></i>
                                                <i class="fa fa-fw fa-inr"></i>
												<?php $temp=json_decode($clinic_data->fee,true);
												if(isset($temp[$b->id]))
													echo $temp[$b->id];
												else echo 'N/A';
												?>
                                                </h3>
                                                <h4>
                                                <i class="fa fa-fw fa-phone color_th"></i><a href="tel:<?php echo $b->phone;?>"><?php echo $b->phone;?> </h4></a>     
                                                <div class="col-lg-12 col-md-4 col-sm-4 col-xs-10" style="clear:both;padding-left: 0;">
       <div class="social">
        <?php 
        if(!empty($b->facebook))	echo '<a href="'.$b->facebook.'"><i class="fa fa-fw fa-facebook-square"></i></a>';
        if(!empty($b->twitter))		echo '<a href="'.$b->twitter.'"><i class="fa fa-fw fa-twitter-square"></i></a>';
        if(!empty($b->google_plus))	echo '<a href="'.$b->google_plus.'"><i class="fa fa-fw fa-google-plus-square"></i></a>';
        if(!empty($b->website))		echo '<a href="'.$b->website.'"><i class="fa fa-fw fa-globe"></i></a>';
        ?>
        </div>
                                                </div><br />
                                                
                                                <img  class="instant_appointment" src="<?php echo bu('images/instant.png');?>" alt="Instant Booking" onclick="prepare_instant($(this));" />
                                                
                                          </div>
                                    </div>
                                    
                                    <div class="row inst_appoint_holder" style="clear:both; display:none" 
                                    data-doctor_id="<?php echo $b->id ?>"
                                    data-clinic_id="<?php echo $clinic_data->id ?>">
                                    
                                    <!--Place Holder for Insatnt Appointment -->
                                    <div class="row">
                                    
                                        	<div class="shedular_top">
                                            <strong style="color:#FFF">SELECT DATE
                                            	<i class="glyphicon glyphicon-chevron-right"></i>
                                                PICK TIME SLOT
                                                <i class="glyphicon glyphicon-chevron-right"></i>
                                                PROVIDE YOUR DETAILS
                                                <i class="glyphicon glyphicon-chevron-right"></i>
                                                BOOK APPOINTMENT
                                            </strong>
                                            <button class="btn btn-primary btn-sm" style="float: right;margin-top: -5px;
" onclick="$(this).parent().parent().parent().slideUp(200);">
                                            	<i class="glyphicon glyphicon-minus"></i>
                                            </button>
                                            </div>
                                    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:0">
                                        	<h4><i class="glyphicon glyphicon-calendar"></i> Select Date</h4>
                                        	<div class="datepicker ll-skin-latoja "></div>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 shedule_holder_ajax">
                                        
                                        </div>
                                    </div>
                                    	
                                    </div>
                              </div>

                              <?php endforeach;?>
                               
                              
                              
                  </div>
                  </div>
                <!-- doctor_h end -->
                
               <div id="service_h" class="self_h ini_hidden">
               		<div class="col-md-12 col-lg-12  shedule_holder" data-loaded="false">
                    	<img src="<?php echo bu('images/ajax-loader.gif');?>" alt="Loading content" 
                        style="display:block; margin:15px auto"/>
                    </div>
               </div>
               <div id="report_h" class="self_h ini_hidden">
               		<div class="col-md-12 col-lg-12  shedule_holder" data-loaded="false">
                    	<img src="<?php echo bu('images/ajax-loader.gif');?>" alt="Loading content" 
                        style="display:block; margin:15px auto"/>
                    </div>
               </div>
             </div><!-- main_cont end -->
                  <div class="col-md-3 col-lg-3 shedule_holder side_shedule" >
                  <!-- Reviews Corusal -->
                  <p style="font-size: 18px;"><i class="fa fa-fw fa-comments"></i>  Latest Reviews</p>
                  
                  <div  id="da-slider" class="da-slider">
                  <?php 
				   $temp_array=json_decode($clinic_data->review,true);
				   if(is_array($temp_array)){
				   $review=array_slice(array_reverse($temp_array),0,5);
				   if(is_array($review))
				   foreach($review as $a=>$b):
				   	$temp=explode(':-:',$b);
					$time_stamp=$temp[0];
					$review=$temp[1];
					$name=$a;
				   ?>
                   
				   	<div class="da-slide">
                    	<h2>
                        	<div class="alert alert-warning review_box_name">
                                <i class="fa fa-fw fa-user"></i><i><?php echo $name?></i>
                                <i class="fa fa-fw fa-caret-down comment_arrow"></i>
                              </div>
                        </h2>
						<p> 
                        <img src="<?php echo bu('images/doctor-clip-art.png');?>" class="avatar_holdar" />
                        	"<?php echo $review;?>"
                        </p>
						<a class="da-link by_mm"> --By @<?php echo $name.'-'.date('M d,Y',$time_stamp);?></a>
                        
                        <div class="da-img"></div>
						
                    </div>
				   
       			   <?php endforeach;} ?>
				   
                  	
                     
                 
                    
                  
                  </div>
                  
                  	<!--<img src="http://media02.hongkiat.com/stylish-blockquotes-pullquotes/04-psd2html-services-reviews.jpg">-->
                  </div>
            </div>
      </div>
      
      <div class=" col-lg-1 hidden-md hidden-sm hidden-xs"></div>

</div>
</header>

<script>
    $(document).ready(function () {
	  $('.custom-dd').click(function(e) {
		  e.stopImmediatePropagation();
		  e.stopPropagation();
		e.stopImmediatePropagation();
		e.stopPropagation();
            e.preventDefault();
      });
        $("#input-21f").rating({
            starCaptions: function(val) {
                if (val < 3) {
                    return val;
                } else {
                    return 'high';
                }
            },
            starCaptionClasses: function(val) {
                if (val < 3) {
                    return 'label label-danger';
                } else {
                    return 'label label-success';
                }
            },
            hoverOnClear: false
        });
        
        $('#rating-input').rating({
              min: 0,
              max: 5,
              step: 1,
              size: 'lg'
           });
           
        $('#btn-rating-input').on('click', function() {
            var $a = self.$element.closest('.star-rating');
            var chk = !$a.hasClass('rating-disabled');
            $('#rating-input').rating('refresh', {showClear:!chk, disabled:chk});
        });
        
        
        $('.btn-danger').on('click', function() {
            $("#kartik").rating('destroy');
        });
        
        $('.btn-success').on('click', function() {
            $("#kartik").rating('create');
        });
        
        $('#rating-input').on('rating.change', function() {
            alert($('#rating-input').val());
        });
        
		
        
        $('.rb-rating').rating({'showCaption':true, 'stars':'3', 'min':'0', 'max':'3', 'step':'1', 'size':'xs', 'starCaptions': {0:'status:nix', 1:'status:wackelt', 2:'status:geht', 3:'status:laeuft'}});
    });
	</script>
 <script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"> </script>
 <script> 
var map = null, marker = null;

function open_map(self) {
		latitude=self.attr('data-longitude');
		longitude=self.attr('data-latitude');
		clinic_name=self.attr('data-clinic_name');
		
		var myLatlng = new google.maps.LatLng(longitude,latitude);
		var mapOptions = {
		zoom: 18,
		center: myLatlng,
	  	};
	  var map = new google.maps.Map(document.getElementById('map_container'),mapOptions);
	  setTimeout(function(){ google.maps.event.trigger(map, 'resize'); map.setZoom(14); }, 300);
	  
	  var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title:clinic_name+' Clinic'
		});
	
	$('.qr_holder').html('<img src="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=http://maps.google.com/maps?q='+longitude+','+latitude+'" alt="Scan this code to get location on your smart phone">');
		 
	}


</script>
<script type="text/javascript" src="<?php echo bu('js/jquery.cslider.js')?>"></script>
		<script type="text/javascript">
			$(function() {
			
				$('#da-slider').cslider({
					bgincrement	: 0,
					
					autoplay	: true,
					// slideshow on / off
					
					interval	: 4000  
					// time between transitions
				});
			
			});
		</script>	
<div class="modal fade" id="myMapModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary" style="border-radius: 4px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align: right;"><span aria-hidden="true" 
        style="text-align: right;">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-fw fa-map-marker"></i> Clinic Position</h4>
      </div>
      <div class="modal-body" id="map_container" style="height:300px;width: 100%">
  		 
      </div>
      <div class="modal-footer">
      <span class="qr_holder" style="float: left;"></span>
      <span style="float: left;margin-top: 25px;">
      <strong ><i class="fa fa-fw fa-location-arrow"></i>
      Scan the <u>QR Code</u> to get the direction in your <i class="fa fa-fw fa-tablet"></i>  smart phone</strong></span>
        <button style="margin-top: 38px;" type="button" class="btn btn-primary btn-sm" data-dismiss="modal"> <i class="fa fa-fw fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>
