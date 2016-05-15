
<?php foreach($doctor_list as $a=>$b):?>
<?php //var_dump($b);?>
<div class="row doc_tile">
	<div class="col-lg-2 col-md-2 col-sm-4  col-xs-3 no-pad">
        <a href="<?php echo bu('clinics/'.$b->slug);?>">
            <img class="lazy dp" data-original="
            <?php 
            if(file_exists(('clinic_images/'.$b->id.'/logo.jpg')))
                echo bu('clinic_images/'.$b->id.'/logo.jpg');
            else {  echo  bu('images/clinic.jpg');   }
                ?>" 
            alt="Dr. <?php echo $b->name;?>" title="Dr. <?php echo $b->name;?>">
        </a>
    </div>
    <div class="col-lg-3 col-md-4  col-sm-8 col-xs-9 no-pad xs-pad">
    <a href="<?php echo bu('clinics/'.$b->slug);?>"><h3 class="doc_name">
    <i class="fa fa-fw fa-hospital-o"></i>
    <?php echo ucfirst(str_replace('clinic','',strtolower($b->name)));?> Clinic </h3></a>
   
    
    <p><i class="fa fa-fw fa-location-arrow"></i> 
	<?php echo $address=str_replace('/','/ ',$b->landmark.', '.$b->street.', '.$b->locality.', '.$b->city.', '.$b->pin);?></p>
    <a class="view_map" data-toggle="modal" data-clinic_name="BT" clinic="" data-target="#myMapModal" data-longitude="<?php echo $b->longitude;?>" data-latitude="<?php echo $b->latitude;?>" onclick="open_map($(this))">
      
		<i class="fa fa-fw fa-map-marker"></i> View on map</a>
    </div>
    <div style="clear:both" class="hidden-md hidden-lg "></div>
    <div class="col-lg-2 col-md-2  col-sm-6 col-xs-8  no-pad sm-pad">
    <div class="row sheduler" style="width: 500px;">
    	<?php echo '<a  href="'.bu('doctors/'.$b->username).'">
		<h4 class="doc_name doc_name_m no-pad no-mar" >  Dr. '.$b->doctor_name.'</h4></a>';?>
        <?php 
		foreach(array_filter(explode(',',$b->speciality_parent)) as $x=>$y ){
			echo '<a class="jing" href="'.bu('search/doctors/Select%20Your%20City/'.$y.'/NULL/NULL/0').'"><li>';
			$tempu=explode('/',$y);
			echo $tempu[0];
			echo '</li></a>';
			}
		
		?>
    	<?php echo get_clinic_timing_for_clinic($b->id,$b->doctor_id);?>
    </div>
        <?php if($b->appointments>0){
			echo '<img class="instant_appointment" src="'.bu('images/instant_sm.png').'" alt="Instant Booking" onclick="prepare_instant($(this));">';
			}
		
		?>
    </div>
    <div class="col-lg-3 col-md-2  col-sm-6 col-xs-6  ">
    	<h5 class=" doc_name_m no-pad no-mar "><i class="fa fa-fw fa-medkit"></i>Other Doctors</h5>
        <?php if(empty($b->other_doctors)){
				echo '<i class="fa fa-fw fa-unlink"></i> No doctors other than <br>
				<strong> Dr. '.$b->doctor_name.'</strong> are available in this clinic.';
				}
			else {
				$sql="SELECT id,name,unique_id,gender,username,speciality_parent from doctors where id in
				(".implode(',',array_filter(explode(',',$b->other_doctors))).")";
				$results=array_filter($this->db->query($sql)->result());
				echo '<div class="row no-pad">';
				foreach($results as $x=>$y):?>
					<div class="col-lg-3 no-pad eess">
                    	<a href="<?php echo bu('doctors/'.$y->username);?>">
                        <img class="dp_tiny lazy" data-original="
						<?php 
                        if(file_exists(('user_upload/'.$y->unique_id.'/dp.jpg')))
                            echo bu('user_upload/'.$y->unique_id.'/dp.jpg');
                        else {
                            if($y->gender=='M') echo  bu('images/avatar5.png'); 
                            else 				echo  bu('images/avatar3.png');
                            }
                        ?>" 
                        alt="Dr. <?php echo $y->name;?>" title="Dr. <?php echo $y->name;?>"></a>
                    </div>
                    <div class="col-lg-9 no-pad">
                    	<a class="sm_link" href="<?php echo bu('doctors/'.$y->username);?>">Dr. <?php echo $y->name;?></a>
                        <?php $sp=array_filter(explode(',',$y->speciality_parent));
							foreach($sp as $aa=>$bb){
								echo '<small><a class="jing" href="'.bu('search/doctors/Select%20Your%20City/'.$bb.'/NULL/NULL/0').'"><li>';
								$tempu=explode('/',$bb);
								echo $tempu[0];
								echo '</li></a></small>';
								}
						?>
                        
                    </div>
				<?php
				endforeach;
				echo  '</div>';
				}
		?>
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
        <?php 
		echo '<h5 class="clinic_name"><i class="fa fa-fw fa-phone"></i>'.(float)$b->phone.'</h5>'?>
        
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
<script>//$(function () { $('[data-toggle="popover"]').popover() ;})</script>
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