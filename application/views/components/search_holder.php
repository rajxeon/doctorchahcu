<style>
#search_holder{width:100%; margin-top:50px}
#search_holder li{ min-width:80px}
.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
.autocomplete-suggestion { padding: 5px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #FF33B2; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
.autocomplete-group strong {display: block;border-bottom: 1px solid #D8D8D8  !important;color: rgb(255, 155, 22) !important;font-size: 16px !important;}
.autocomplete-group {padding: 5px 5px !important;}
.autocomplete-suggestion{ cursor:pointer;}
.helper{display: inline-block;color: rgb(180, 180, 180); float:right;}
.autocomplete-suggestion:nth-child(odd) {background:#F3F3F3;}
.autocomplete-suggestion:hover{ background-color:#00BDF7 !important; color:#000 !important; font-weight:bold}
.autocomplete-suggestion:hover .helper{ color: #FFF !important}
.autocomplete-suggestion:hover .autocomplete-suggestions strong{ color:#FFF !important}
</style>

<div id="search_holder">
	<li class="animate_2" id="li_selected">Doctors</li>
    <li class="animate_2">Clinics</li>
    <li class="animate_2">Search</li>
    
    <div id="bar_holder">
    
    	
    
    	<div data-tab="0" class="tabbed"  >
        <div class="row" style="margin:0">
        	<div class="col-lg-5 col-md-5 col-sm-5 no-pad">
            
            <form onSubmit="event.preventDefault();speciality_h(event);">
            	<select class="text_wide" id="speciality_s">
                <option disabled selected>Select Speciality</option>
			<?php 
                $sql="SELECT COLUMN_NAME
                FROM   information_schema.columns
                WHERE  table_name = 'speciality' order by COLUMN_NAME";
                $results=$this->db->query($sql)->result();
                
                foreach($results as $a=>$b){
                    if($b->COLUMN_NAME!='id'){
                        echo '<option> '.$b->COLUMN_NAME.' </option>';
                    
                        
                        }
                    
                    }
            
            ?>
            </select>
            </div>
            <div class="col-lg-5  col-md-5 col-sm-5 no-pad">
            <input class="text_wide city_s" type="text" id="autocomplete" placeholder="Enter Your City"/>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2  no-pad">
            <button type="submit" class="btn btn-info btn-block search_btn"><i class="fa fa-fw fa-search"></i></button>
            </form>
            </div>
        </div>
            
            
        </div>
        
        
        
        
        
        <div data-tab="1" class="tabbed"  >
        <div class="row" style="margin:0">
        	<div class="col-lg-5  col-md-5 col-sm-5 no-pad">
            
            <form onSubmit="event.preventDefault();clinic_speciality_h(event);">
            	<select class="text_wide" id="clinic_speciality_s">
                <option disabled selected>Select Speciality of Doctors in Clinic</option>
			<?php 
                $sql="SELECT COLUMN_NAME
                FROM   information_schema.columns
                WHERE  table_name = 'speciality' order by COLUMN_NAME";
                $results=$this->db->query($sql)->result();
                
                foreach($results as $a=>$b){
                    if($b->COLUMN_NAME!='id'){
                        echo '<option> '.$b->COLUMN_NAME.' </option>';
                    
                        
                        }
                    
                    }
            
            ?>
            </select>
            </div>
            <div class="col-lg-5  col-md-5 col-sm-5 no-pad">
            <input class="text_wide clinic_city_s" type="text" id="autocomplete_clinic" placeholder="Enter Clinic City"/>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2  no-pad">
            <button type="submit" class="btn btn-info btn-block search_btn"><i class="fa fa-fw fa-search"></i></button>
            </form>
            </div>
        </div>
            
            
        </div>
        
        
        
        
        
        <div data-tab="2" class="tabbed" style="display: none;">
        	<div class="row" style="margin:0">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 no-pad">
                    <input class="text_wide" id="doc_autocomplete" type="text" style="margin: 8px 0px;" 
                    placeholder="Enter name of doctors,clinic or hospital. Eg: Nirmal Sinha"> 
                </div>
                
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2  no-pad">
                <button class="btn btn-info btn-block search_btn"><i class="fa fa-fw fa-search"></i></button>
                </div>
        	</div>
        </div>
        
        
        
        
    	
    </div>
   
	
</div>
<div class="msg_tholder"></div>

<script type="text/javascript" src="<?php echo bu('js/jquery.mockjax.js');?>"></script>
<script type="text/javascript" src="<?php echo bu('js/jquery.autocomplete.js');?>"></script>
<script>
 
  $('#doc_autocomplete').autocomplete({
    serviceUrl: 'helper/search_autocomplete/',
	type:'POST',
	groupBy: 'catagory',
	formatResult: function (suggestion, currentValue) { 
		return suggestion.value+'<div class="helper">'+suggestion.data.helper+'</div>';
		},
    onSelect: function (suggestion,query) {
		window.location.href=suggestion.data.link;
        //alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
    },
	//transformResult: function(response, originalQuery) {console.log(response)} 
 
});
	
    $('#autocomplete').autocomplete({
    serviceUrl: 'helper/city/',
	type:'POST',
    onSelect: function (suggestion,query) {
        //alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
    },
	//transformResult: function(response, originalQuery) {console.log(response)} 
 
});


  $('#autocomplete_clinic').autocomplete({
    serviceUrl: 'helper/city/',
	type:'POST',
    onSelect: function (suggestion,query) {
        //alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
    },
	//transformResult: function(response, originalQuery) {console.log(response)} 
 
});

function clinic_speciality_h(){
	
	speciality_s=$('#clinic_speciality_s').val();
	city_s=$('.clinic_city_s').val();
	
	
	if(speciality_s==null)$('.msg_tholder').html('<div class="alert alert-danger" role="alert"> <i class="fa fa-fw fa-exclamation-triangle"></i> Please select speciality</div>'); 
	
	else if(city_s.length==0)$('.msg_tholder').html('<div class="alert alert-danger" role="alert"><i class="fa fa-fw fa-exclamation-triangle"></i> Please select your city</div>'); 
	
	else window.location.href="search/clinics/"+city_s+"/"+speciality_s+"/NULL/NULL/0";
		
	
	}

function speciality_h(){
	speciality_s=$('#speciality_s').val();
	city_s=$('.city_s').val();
	
	
	if(speciality_s==null)$('.msg_tholder').html('<div class="alert alert-danger" role="alert"> <i class="fa fa-fw fa-exclamation-triangle"></i> Please select speciality</div>'); 
	
	else if(city_s.length==0)$('.msg_tholder').html('<div class="alert alert-danger" role="alert"><i class="fa fa-fw fa-exclamation-triangle"></i> Please select your city</div>'); 
	
	else window.location.href="search/doctors/"+city_s+"/"+speciality_s+"/NULL/NULL/0";
		
	}
</script>