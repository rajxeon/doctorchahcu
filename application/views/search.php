<?php $this->load->view('components/h1.php',$this->data);?>
<?php $city=$this->uri->segment(3);$this->data['city']=$city;?>
<link rel="stylesheet" href="<?php echo bu('style/s_style.css')?>">

<div class="row" style="background: #3E205B;"> 
	<div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
    <div class="col-lg-10  col-md-12 col-sm-12 col-xs-12 header_row" >
    
    <header>
    	<!-- Logo --->
        <div class="col-lg-3  col-md-3 col-sm-3 col-xs-6 s_logo">
        	<a href="<?php echo bu('');?>"><img class="lazy" data-original="<?php echo bu('images/logo.png');?>" alt="Doctor chachu logo-Click to go to home"></a>
        </div>
        <div class="col-lg-3  col-md-3 col-sm-3 col-xs-6">
        	<?php $this->load->view('components/city_selector',$this->data);?>
        </div>
        <div class="col-lg-6  col-md-6 col-sm-6 col-xs-12">
        	<?php $this->load->view('components/search_bar');?>
        </div>
    </header>
    </div>
    <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
</div>

<!-- Search results -->
	<div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12" style="padding: 0;">
    <!-- Filter Holder -->
    
     <?php $this->load->view('components/doc_filter',$this->data);?>
        
    </div>
    <div class="col-lg-8 col-md-10 col-sm-9 col-xs-12">
    	<div class="row no-pad">
        	<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 no-pad">
            	<span class="label label-success btn-block label-number"><strong><?php echo $doc_count;?></strong> Results found</span>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 no-pad" style="text-align:right">
            	<?php $this->load->view('components/doc_pagination',$this->data);?>
            </div>
        </div>
        <div class="row no-pad">
        	<?php $this->load->view('components/doc_tile',$this->data);?>
        </div>
        <div class="row no-pad">
        	<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 no-pad"></div>
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 no-pad" style="text-align:right">
            	<?php $this->load->view('components/doc_pagination',$this->data);?>
            </div>
        </div>
    </div>
    <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
    
<script>
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
function destroy_shedule_form(){
		$( ".datepicker" ).datepicker( "destroy" );
		}
</script>


<script src="<?php echo bu('js/jquery.lazyload.min.js');?>"></script>
<script>

$("img.lazy").lazyload({
    effect : "fadeIn"
});
</script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>        
<link href="<?php echo bu('style/datepicker.css')?>" rel="stylesheet" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
