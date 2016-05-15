<?php foreach($hospital_list as $a=>$b):?>
<?php //var_dump($b);?>
<div class="row doc_tile">
	<div class="col-lg-2 col-md-2 col-sm-2  col-xs-3 no-pad">
    
        <a href="<?php echo bu('hospitals/'.$b->slug);?>">
            <img class="dp lazy" data-original="
            <?php 
            if(file_exists(('hospital_data/'.$b->id.'/dp.jpg')))
                echo bu('hospital_data/'.$b->id.'/dp.jpg');
            else {
				echo  bu('images/hospital.gif'); 
				}
                ?>" 
            alt="<?php echo $b->name;?>" title="<?php echo $b->name;?>">
        </a>
    </div>
    <div class="col-lg-6 col-md-6  col-sm-6 col-xs-5 ">
    <br />
    <a href="<?php echo bu('hospitals/'.$b->name);?>"><h3 class="doc_name">
    <i class="fa fa-fw fa-building-o"></i>
    <?php echo $b->name;?></h3></a>
   
   
    <p><i class="fa fa-fw fa-location-arrow"></i> 
	<?php $address=$b->landmark.', '.$b->locality.', '.$b->city.', '.$b->district.', '.$b->state.', '.$b->pin;
	$address=implode(',',array_filter(array_unique(explode(',',$address))));
	echo $address;
	?></p>
    <a class="view_map" data-toggle="modal" data-clinic_name="<?php echo $b->name;?>" data-city_name="<?php echo $b->city;?>" data-state_name="<?php echo $b->state;?>" clinic="" data-target="#myMapModal" data-longitude="<?php echo $b->longitude;?>" data-latitude="<?php echo $b->latitude;?>" onclick="open_map($(this))">
      
		<i class="fa fa-fw fa-map-marker"></i> View on map</a>
    </div>
   
    
    <div class="col-lg-4 col-md-4  col-sm-4 col-xs-4 rt">
    <br>
    	<div class="star_holder" data-container="body" data-toggle="popover" data-placement="bottom" 
        data-content="<?php echo $b->rating?> Star" data-trigger="hover">
            <div class="disabled_stars"></div>
            <div class="stars" style=" width:<?php echo ($b->rating/5)*100?>%"></div>
        </div>
       <h5 class="std"></h5>
        <?php 
		if(!empty($b->std))
		echo '<h5 class="clinic_name  lil-mar"> <strong>STD</strong>:'.$b->std.'</h5>';
		
		//$phone_array=array_filter(explode(',',str_replace('/',',',$b->phone)));
		//foreach($phone_array as $c=>$d){
			echo '<h5 class="clinic_name lil-mar inline"><i class="fa fa-fw fa-phone"></i>'.
			str_replace('/',', ',str_replace(',',', ',$b->phone)).'</h5>';
			//}
		
		if(!empty($b->fax))
		echo '<h5 class="clinic_name  lil-mar"> <strong>Fax</strong>:'.$b->fax.'</h5>';
		?>
        
        <div class="social">
        <?php 
		if(!empty($b->facebook))	echo '<a href="'.$b->facebook.'"><i class="fa fa-fw fa-facebook-square"></i></a>';
		if(!empty($b->twitter))		echo '<a href="'.$b->twitter.'"><i class="fa fa-fw fa-twitter-square"></i></a>';
		if(!empty($b->google_plus))	echo '<a href="'.$b->google_plus.'"><i class="fa fa-fw fa-google-plus-square"></i></a>';
		if(!empty($b->website))		echo '<a href="'.$b->website.'"><i class="fa fa-fw fa-globe"></i></a>';
		?>
        </div>
        
    <input id="address" type="hidden" value="A G Hospital  Tiripur"></input>
        
    </div>
</div>


<?php endforeach;?>

<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"> </script>
<script> 

var map = null, marker = null;
var geocoder=null;



function open_map(self) {
		latitude=self.attr('data-longitude');
		longitude=self.attr('data-latitude');
		clinic_name=self.attr('data-clinic_name');
		city_name=self.attr('data-city_name');
		state_name=self.attr('data-state_name');
		
		address=clinic_name+' '+city_name;
		
		geocoder = new google.maps.Geocoder();
		var myLatlng = new google.maps.LatLng(longitude,latitude);
		geocoder.geocode( { 'address':address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				
			  map.setCenter(results[0].geometry.location);
			  var marker = new google.maps.Marker({
				  map: map,
				  position: results[0].geometry.location,
			  });
			} else {
			  alert('Can not find the address. ' );
			}
		  });
		
		var mapOptions = {
		zoom: 30,
		center: myLatlng,
	  	};
		
	  var map = new google.maps.Map(document.getElementById('map_container'),mapOptions);
	  setTimeout(function(){ google.maps.event.trigger(map, 'resize'); map.setZoom(18); }, 300);
	 
	 
	
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