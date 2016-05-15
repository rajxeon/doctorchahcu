<style>
.mot.active {
	border: 1px solid #4C4C4C;
	margin-bottom: -1px !important;
	border-top-color: #000 !important;
	border-bottom:#fff;
	
}
.mot a{ cursor:pointer}
 
hr {
	margin: 0
}
.ini_hidden {
	display: none;
}
.simple {
	zoom: 1.3;
	
}
.no-mar{ padding:0; margin:0}
.ssa{margin-top: 19px;
zoom: 1.3;}
#tab_content_holder{ margin-top:10px;}

</style>
<script>
$(document).on('click','.tabber',function(){
	
		$('.tabber').addClass('btn-default').removeClass('btn-info');
        $(this).addClass('btn-info').removeClass('btn-default');
		data_t=$(this).attr('data-t');
		$('.ini_hidden').hide(0);
		$('*[data-s="'+data_t+'"]').show(0);
   

	});
 

$(document).on('change','input,select',function(){
	if($('#auto_preview').is(':checked')){
		$('#save_btn').trigger('click');
		}
	
}); 

$(document).ready(function(e) {
	
    $('.mot').click(function(e) { 
		$('#tab_content_holder').html('<img src="<?php echo bu('images/ajax-loader.gif');?>" style="display:block; margin:100px auto">');
		
        $('#selected').val($(this).find('a').attr('data-name'));
		load_content_by_data_name($('#selected').val())
		
    });
	load_content_by_data_name($('#selected').val())
});

function load_content_by_data_name(name){
	$.post('<?php echo bu('doctor/ajax_load_tab_content');?>',{name:name},function(data){
		$('#tab_content_holder').html(data);
		 if($('#show_p_details').is(':checked')){$('#show_p_details').next().show(0);}
		 $('textarea').wysihtml5();
		});
	}

function save_json(self,save_all){
	self.find('i').hide(0);
	self.find('img').show(0);
	//generate json and save
	array2={} ;
	array2['paper_size']		=$('#paper_size').val();
	array2['orientation']	=$('.orientation:checked').val();
	array2['p_type']			=$('.p_type:checked').val();
	array2['top_margin']		=$('#top_margin').val();
	array2['right_margin']	=$('#right_margin').val();
	array2['left_margin']	=$('#left_margin').val();
	array2['bottom_margin']	=$('#bottom_margin').val();
	array2['include_header']	=$('.include_header:checked').val();
	array2['include_logo']	=$('.include_logo:checked').val();
	array2['header_text']	=$('#header_text').val();
	array2['left_text']		=$('#left_text').val();
	array2['right_text']		=$('#right_text').val();
	
	if($('#show_p_details').is(":checked")) 
	array2['show_p_details']	=1;
	else 
	array2['show_p_details']	=0;
	exclude=[];
	$('.exclude:checked').each(function(index, element) {
      exclude.push($(this).val());  
    });
	
	array2['exclude']	=exclude;
	
	if($('#ex_p_gender_dob').is(":checked")) 
	array2['ex_p_gender_dob']	=1;
	else 
	array2['ex_p_gender_dob']	=0; 
	array2['footer_margin']		=$('#footer_margin').val();
	
	array2['footer_content']	=$('#footer_content').val();
	array2['left_sign']		=$('#left_sign').val();
	array2['right_sign']		=$('#right_sign').val();
	
	myJsonString = JSON.stringify(array2); 
	$.post('<?php echo bu('doctor/ajax_save_print_settings');?>',
	{save_all:save_all,json:myJsonString,feild:$('#selected').val()},function(data){
		if(data==1) {
			load_content_by_data_name($('#selected').val());
			self.find('i').show(0); self.find('img').hide(0);
			$('html, body').animate({
				scrollTop: $("#page-wrapper").offset().top 
			}, 500);
			
			} 
		});
	
	

	}
</script>

<input type="hidden" id="selected" value="prescription">
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
  <div class="col-lg-12">
    <h1 class="page-header"> Print Settings <small>Setup your print outs</small> </h1>
    <ol class="breadcrumb"> 
    <label style="float:right"><input type="checkbox" class="simple" id="auto_preview"> &nbsp;&nbsp;
    <strong style="position: relative;top: -4px;">Auto Save & Preview</strong> &nbsp;&nbsp;
    	 
    </label> 
    
    
      <li class="active"> <i class="fa fa-dashboard"></i> Dashboard </li>
      <li class="active"> <i class="fa fa-gears"></i> Settings / <i class="fa fa-print"></i> Printouts </li>
    </ol>
  </div>
  <div class="col-sm-12">
    
       
       
          <div class="nav-tabs-custom"  style="background: transparent; box-shadow:none">
            <ul class="nav nav-tabs " style="background: transparent; box-shadow:none;border-bottom-color: #000000;" >
              <li class="mot active"><a data-name="prescription" data-toggle="tab">Prescription</a></li>
              <li class="mot"><a data-name="treatment_plans" data-toggle="tab">Treatment Plans</a></li>
              <li class="mot"><a data-name="case_sheet" data-toggle="tab">Case Sheet</a></li>
              <li class="mot"><a data-name="medical_leave" data-toggle="tab">Medical Leave</a></li>
              <li class="mot"><a data-name="invoice" data-toggle="tab">Invoice</a></li>
              <li class="mot"><a data-name="recept" data-toggle="tab">Recept</a></li>
            </ul>
            <div id="tab_content_holder">
            	<img src="<?php echo bu('images/ajax-loader.gif');?>" style="display:block; margin:100px auto">
            </div>
            
            
            
             
        </div>
  </div>
</div>
