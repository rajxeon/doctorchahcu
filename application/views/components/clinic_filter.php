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
		//Speciality
		speciality='';
		$('.filter-speciality:checked').each(function(index, element) {
			elem=$(element);
			temp=elem.val();
			temp=temp.replace('/','_or_');
			temp=encodeURIComponent(temp);
			speciality+=temp+'-';
        });
		speciality = speciality.slice(0, -1);	
		if($('.filter-speciality:checked').length==0) speciality='NULL'; 	
		
		if($('#filter-instant:checked').length>0) instant=1; else instant='NULL';
		
		url='<?php echo bu('search/clinics/');?>'+city+'/'+speciality+'/'+locality+'/'+instant+'/'+page;
		window.location.href=url;
    
	}
</script>
<?php   require_once(('application/libraries/Mobile_Detect.php'));
		$detect = new Mobile_Detect;
?>
<div class="filters">
    <button class="btn bg-info btn-sm btn-block btn-filter btn-flat" type="button" data-toggle="collapse"
     data-target="#instant_h" aria-expanded="true" aria-controls="collapseExample">
          Intsant Appointment  
          <span class="btn btn-xs btn-success app_btn">Apply</span>
    </button>
        <div  class="collapse<?php if ( !($detect->isMobile() && !$detect->isTablet()) ) {echo ' in ';}?>" id="instant_h">
          <div class="well">
			
			<div class="checkbox"> 
           
            	<label><input  <?php if($instant==1) echo 'checked';?>  value="1" id="filter-instant" type="checkbox"> Instant Appointment</label> 
            </div>

          </div>
        </div>
    </div>

<div class="filters">
    <button class="btn bg-info btn-sm btn-block btn-filter btn-flat" type="button" data-toggle="collapse"
     data-target="#speciality_h" aria-expanded="true" aria-controls="collapseExample">
          Speciality  
          <span class="btn btn-xs btn-success app_btn">Apply</span>
        </button>
        <div  class="collapse <?php if ( !($detect->isMobile() && !$detect->isTablet()) ) {echo ' in ';}?>" id="speciality_h">
          <div class="well">
<?php 
$sql="SELECT COLUMN_NAME
FROM   information_schema.columns
WHERE  table_name = 'speciality' order by COLUMN_NAME";
$results=$this->db->query($sql)->result();

foreach($results as $a=>$b){
	if($b->COLUMN_NAME!='id'){
		if(in_array($b->COLUMN_NAME,$speciality))
		echo '<div class="checkbox"> <label><input checked value="'.$b->COLUMN_NAME.'" class="filter-speciality" type="checkbox">'.$b->COLUMN_NAME.' </label> </div>';
		
		else echo '<div class="checkbox"> <label><input  value="'.$b->COLUMN_NAME.'" class="filter-speciality" type="checkbox">'.$b->COLUMN_NAME.' </label> </div>';
		
		}
	
	}

?>


          </div>
        </div>
    </div>
    

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