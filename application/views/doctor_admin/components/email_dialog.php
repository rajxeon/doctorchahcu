<style>
.p_name{ width:auto !important; display:inline-block !important; margin:10px;}
.dpm {width: 60px !important;}
</style>

<script>
$(document).on("click", "*[data-target=\"#email_dialog\"]", function () {
	
    pid=$(this).attr('data-pid');
	email=$(this).attr('data-p_email');
	loader='<div align="center"><br /><br /><br /><img src="<?php echo bu('images/ajax-loader.gif')?>" /><br /><br /><br /></div></div>';
	$('#m_body').html(loader);
     $.post('<?php echo bu('doctor/ajax_get_p_data_for_email')?>',{'pid':pid},function(data){
		 
		 $('#m_body').html(data);
		 });
});
 
	
function send_email(self){
	initial='<img src="<?php echo bu('images/ajax_rt.gif')?>" /> Please Wait';
	self.html(initial);
	pid=self.attr('data-pid');
	email=$('#recept_email_id').val();
	$.post('<?php echo ('http://doctorchachu.com/email');?>',{'pid':pid,'to':email,'subject':'Attachment From DoctorChachu.com'},function(data){
		self.html('<i class="fa fa-check"></i> Mail sent');
		self.addClass('disabled');
		self.removeAttr('onclick');
		//console.log(data);
		});
	
	}

</script>

<div class="modal fade " tabindex="-1" role="dialog" id="email_dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 60%;margin: 70px auto;">
    <div class="modal-content">
    <div class="modal-header bg-blue" style="border-radius: 5px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="myLargeModalLabel">Email
         
          </h4>
          
        </div>
        
       <div class="modal-body" id="m_body"></div>
      
    </div>
  </div>
</div>