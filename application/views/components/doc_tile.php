<?php foreach($doctor_list as $a=>$b):?>
<?php //var_dump($b);?>
<div class="row doc_tile">
<?php if(@$b->dc_verified!=0):?>
<img class="dcv" src="<?php echo bu('images/dc_verified.png');?>" />
<?php endif;?>
	<div class="col-lg-2 col-md-2 col-sm-4  col-xs-3 no-pad">
        <a href="<?php echo bu('doctors/'.$b->username);?>">
            <img class="dp lazy" data-original="
            <?php 
            if(file_exists(('user_upload/'.$b->unique_id.'/dp.jpg')))
                echo bu('user_upload/'.$b->unique_id.'/dp.jpg');
            else {
				if($b->gender=='M') echo  bu('images/avatar5.png'); 
				else 				echo  bu('images/avatar3.png');
				}
                ?>" 
            alt="Dr. <?php echo $b->doctor_name;?>" title="Dr. <?php echo $b->doctor_name;?>">
        </a>
    </div>
    <div class="col-lg-6 col-md-6  col-sm-8 col-xs-9 ">
    <a href="<?php echo bu('doctors/'.$b->username);?>"><h3 class="doc_name">
    <i class="fa fa-fw fa-user-md"></i>
    Dr.<?php echo $b->doctor_name;?></h3></a>
    <p><i class="fa fa-fw fa-medkit"></i> <?php if(!empty($b->speciality)) echo $b->speciality; else echo 'No Speciality';?></p>
    <?php if($b->visibility):?>
    <a href="<?php echo bu('clinics/'.$b->slug);?>">
    
    	<h5 class="clinic_name"><i class="fa fa-fw fa-hospital-o"></i> Clinic: <?php echo $b->name;?></h5>
    </a>
   
    <p><i class="fa fa-fw fa-location-arrow"></i> 
	<?php echo $address=$b->landmark.', '.$b->street.', '.$b->locality.', '.$b->city.', '.$b->pin;?></p>
    <a class="view_map" data-toggle="modal" data-clinic_name="BT" clinic="" data-target="#myMapModal" data-longitude="<?php echo $b->longitude;?>" data-latitude="<?php echo $b->latitude;?>" onclick="open_map($(this))">
      
		<i class="fa fa-fw fa-map-marker"></i> View on map</a>
    <?php endif;//if($b->visibility)?>
    </div>
    <div style="clear:both" class="hidden-md hidden-lg "></div>
    <div class="col-lg-2 col-md-2  col-sm-6 col-xs-6  no-pad ">
    <?php if($b->visibility):?>
    <div class="row sheduler">
    	<?php echo get_clinic_timing($b->id,$b->doctor_id);?>
    </div>
    
        <?php if($b->appointments>0){
			echo '<img class="instant_appointment lazy sm-pad" data-original="'.bu('images/instant.png').'" alt="Instant Booking" onclick="prepare_instant($(this));">';
			}
		
		?>
        <?php endif;?>
    </div>
    <div class="col-lg-2 col-md-2  col-sm-6 col-xs-6 ">
    <br>
    	<div class="star_holder" data-container="body" data-toggle="popover" data-placement="bottom" 
        data-content="<?php echo $b->rating?> Star" data-trigger="hover">
            <div class="disabled_stars"></div>
            <div class="stars" style=" width:<?php echo ($b->rating/5)*100?>%"></div>
        </div>
        <?php $fee=json_decode($b->fee,true);
			  if (isset($fee[$b->doctor_id])) $fee=$fee[$b->doctor_id];
			  else $fee='N/A';
		?>
        <h3 class="no-mar doc_name"><i class="fa fa-fw fa-inr"></i> <?php echo $fee;?></h3>
        <?php if($b->view_contact) 
		echo '<h5 class="clinic_name"><i class="fa fa-fw fa-phone"></i>'.$b->doctor_phone.'</h5>'?>
        
        <div class="social">
        <?php 
		if(!empty($b->facebook))	echo '<a href="'.$b->facebook.'"><i class="fa fa-fw fa-facebook-square"></i></a>';
		if(!empty($b->twitter))		echo '<a href="'.$b->twitter.'"><i class="fa fa-fw fa-twitter-square"></i></a>';
		if(!empty($b->google_plus))	echo '<a href="'.$b->google_plus.'"><i class="fa fa-fw fa-google-plus-square"></i></a>';
		if(!empty($b->website))		echo '<a href="'.$b->website.'"><i class="fa fa-fw fa-globe"></i></a>';
		?>
        </div>
        
    
        
    </div>
</div>
<?php if($b->appointments>0){ $this->load->view('components/instant_form',array('clinic_id'=>$b->id,'doctor_id'=>$b->doctor_id)); } ?>

<?php endforeach;?>
<script>$(function () {
  $('[data-toggle="popover"]').popover()
})</script>
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
<div class="modal fade" id="myMapModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary" style="border-radius: 4px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align: right;"><span aria-hidden="true" 
        style="text-align: right;">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
        <i class="fa fa-fw fa-map-marker"></i> Clinic Position</h4>
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