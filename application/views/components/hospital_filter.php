<script>
$(document).ready(function(e) {
    $('.app_btn').click(function(e) {
		e.stopImmediatePropagation();
		e.stopPropagation();
		apply();
		});
});


String.prototype.stripSlashes = function(){
    return this.replace(/\\(.)/mg, "$1");
}
function apply(page){
		if(typeof  page=='undefined') page=0;
		//City
		city=$('#drop4').text();
		city=city.trim();
		if(city.length==0) city='NULL'; 
		//Locality
		locality='';
		holder=[];
		$('.filter-locality:checked').each(function(index, element) {
			elem=$(element); 
			temp=elem.val();
			if(holder.indexOf(temp)<0){
				temp=temp.replace('/','_or_');
				temp=encodeURIComponent(temp);
				locality+=temp+'-';
				holder.push(temp);
				}
			
        });
		locality = locality.slice(0, -1);		
		if($('.filter-locality:checked').length==0) locality='NULL'; 
		
		url='<?php echo bu('search/hospitals/');?>'+city+'/'+locality+'/'+page;
		window.location.href=url;
    
	}
</script>
<?php   require_once(('application/libraries/Mobile_Detect.php'));
		$detect = new Mobile_Detect;
?>



    

<div class="filters">
    <button class="btn bg-info btn-sm btn-block btn-filter btn-flat" type="button" data-toggle="collapse" data-target="#locality_h" aria-expanded="true" aria-controls="collapseExample">
          Locality  
          
          <span class="btn btn-xs btn-success app_btn">Apply</span>
        </button>
        <div  class="collapse <?php if ( !($detect->isMobile() && !$detect->isTablet()) ) {echo ' in ';}?>" id="locality_h">
          <div class="well">
<?php 
$city=sql_filter($city);
$sql="SELECT pin,locality FROM location WHERE city='$city' order by locality";
$results=$this->db->query($sql)->result();
foreach($results as $a=>$b){
	if(in_array($b->pin,$pin))
		echo '<div class="checkbox"> <label><input checked class="filter-locality" type="checkbox" value="'.$b->pin.'">'.$b->locality.' </label> </div>';
		
		else echo '<div class="checkbox"> <label><input class="filter-locality" type="checkbox" value="'.$b->pin.'">'.$b->locality.' </label> </div>';
		
	
	}
?>
          </div>
        </div>
    </div>