


</aside> <!-- End of class="right-side" -->
</div><!-- ./wrapper class="wrapper row-offcanvas row-offcanvas-left"-->

 <!-- add new calendar event modal -->


        <script type="text/javascript" async="async"  src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script async="async"  src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
        <script async="async"  src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script async="async"  src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        
	  <script async="async"  src="<?php echo base_url().'/';?>js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script async="async"  src="<?php echo base_url().'/';?>js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script async="async"  src="<?php echo base_url().'/';?>js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <!--<script async="async"  src="<?php echo base_url().'/';?>js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>-->
        <!-- jQuery Knob Chart -->
        <script async="async"  src="<?php echo base_url().'/';?>js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
         <!-- iCheck -->
         
        <script  src="<?php echo base_url().'/';?>js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        
         
	<script>
	
	
	
        $(document).on('click','.printme,.printme_dot_matrix,.email_me,.save_me,.print_payment_history',function(event ){
        event.preventDefault();
            parent			=$(this).closest('.p_parent');
            print_type		=$(this).attr('data-print_type'); 
			patient_id		=$(this).attr('data-pid'); 
			
			
			 
			//Email handler
			if($(this).hasClass('email_me')){
				$.post('<?php echo bu("doctor/ajax_prepare_email"); ?>',{'data':parent.html(),'print_type':print_type,'pid':patient_id,dot_matrix:1},function(data){
						///html=jQuery.parseHTML(data); 
						//html=$(data).removeClass('np');
						html=$('.np',data).remove();
						//html=$(data).find('#main_container');
						console.log(html);
						if(data==1)
						setTimeout(function(){$('.mob').toggle();},100) 
					return;
					})
				return;
				}
			
			
			
			
			//Save handler
			if($(this).hasClass('save_me')){
				
				$('#saveAsModal').modal('show');
				$.post('<?php echo bu("doctor/saveme"); ?>',{'data':parent.html(),'print_type':print_type,'pid':patient_id,dot_matrix:1},function(data){
					//console.log(data);
					$('#saveAsMessage').html('<div align="center"><img src="<?php echo bu('images/ajax-loader.gif');?>" /></div><div class="callout callout-warning"> <h4>Generating PDF..<small>Please Wait</small></h4></div>');
					$.post('<?php echo bu("doctor/make_pdf_from_html"); ?>',{'html':data,'patient_id':patient_id},function(data5){
						
					$('#saveAsMessage').html(data5);
						});
					return;
					})
				return;
				}  
			inv_ids='';
			parent.find('.mega_p').each(function(index, element) { 
			   inv_ids+=$(this).attr('data-inv_id')+',';
            }); 
			html='<form id="submit_print" target="_blank" action="<?php echo bu("doctor/printme"); ?>" method="post">';
			if($(this).hasClass('print_payment_history')) {
				html+='<input type="hidden" name="print_payment_history" value=\''+'1'+'\'>';
				}
			if($(this).hasClass('printme_dot_matrix')) {
				html+='<input type="hidden" name="dot_matrix" value=\''+'1'+'\'>';
				}
			html+=' <input type="hidden" value="'+inv_ids+'" name="inv_ids"> <input type="hidden" name="data" value=\''+parent.html()+'\'><input type="hidden" name="print_type" value="'+print_type+'"><input type="hidden" name="pid" value="'+patient_id+'"></form>';
			$('#submit_print').remove();
			$('body').append(html);
			$('#submit_print').submit();
        })
		
		
     </script>
        <!-- daterangepicker -->
        <script async="async"  src="<?php echo base_url().'/';?>js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- datepicker -->
       <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/css/bootstrap-datepicker.min.css" rel="stylesheet" />-->
        <!--<script   src="<?php echo base_url().'/';?>js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>-->
        <!-- Bootstrap WYSIHTML5 -->
        <script async="async"  src="<?php echo base_url().'/';?>js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
       
        <!-- AdminLTE App -->
        <script  src="<?php echo base_url().'/';?>js/AdminLTE/appss.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--<script async="async"  src="<?php echo base_url().'/';?>js/AdminLTE/dashboard.js" type="text/javascript"></script>-->

        <!-- AdminLTE for demo purposes -->
        <script async="async"  src="<?php echo base_url().'/';?>js/AdminLTE/demo.js" type="text/javascript"></script>
<style>.no-print{display:none !important}</style>


    </body>
</html>
<div class="modal fade" role="dialog" id="saveAsModal" aria-labelledby="saveAsModal" aria-hidden="true">
    <div class="modal-dialog" style="margin:150px auto">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Save As PDF</h4>
        </div>
        <div class="modal-body" id="saveAsMessage">
        	<div align="center"><img src="<?php echo bu('images/ajax-loader.gif');?>" /></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <a type="button" href="<?php echo bu('doctor/file_manager');?>" class="btn btn-success"><i class="fa  fa-file-text"></i> &nbsp;File Manager</a>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>

 

<!-- /.modal -->
<?php $this->load->view('doctor_admin/components/email_dialog');?>