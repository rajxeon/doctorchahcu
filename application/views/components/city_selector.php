<br>
 <?php   if(!isset($type)) $type='doctors'; ?>
<script>
$(document).ready(function(e) {
    $('#cityInput').click(function(e) {
        e.stopImmediatePropagation();
		e.stopPropagation();
    });
	
	$('#cityInput').keyup(function(e) {
		
       city=($(this).val());
	   if(city.length>1){
		  $('.city_holder').html('<img style="margin: 0px auto;display: block;" src="<?php echo bu('images/ajax-loader.gif');?>">');
		   $.post('<?php echo bu('helper/generate_city_li/'.$type);?>',{city:city},function(data){
			   $('.city_holder').html(data);
			   //console.log(data);
			   });
		   }
    }); 
});
</script>

<a id="drop4" href="#" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false" style="font-weight: bold;color: #737373 !important;text-transform: capitalize;"> 
	<img src="<?php echo bu('images/flag.gif')?>" alt="India Flag"> &nbsp;
    <?php if(!$city) echo 'Select Your City'; else echo urldecode($city);?>
<span class="caret" style="margin: 2px;zoom: 1.4;"></span> </a>


<?php 
	$starting_city=array('all city','kolkata','delhi','mumbai','pune','hydrabad');

?>
<ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4" style="margin: 2px 0 0 15px; min-width:250px">
 
  <li role="presentation">
  	<div class="form-group" style="padding: 0 10px;">
        <label for="exampleInputEmail1">Search City</label>
        <input type="text" class="form-control" id="cityInput" placeholder="Enter City">
      </div>
  </li>
  <li role="presentation" class="divider"></li>
  <div class="city_holder">
 
  	<?php foreach($starting_city as $a=>$b){
			echo '  <li role="presentation">
						<a role="menuitem" tabindex="-1" href="'.bu('search/'.$type.'/'.$b).'">
							<span class="prefix">'.ucfirst(substr($b,0,1)).'</span>'.ucfirst($b).'
						</a>
					</li>';
		}
	?> 
 
  </div>
  
 
</ul>
