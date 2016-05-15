

<div class="row inst_appoint_holder" style="clear:both; display:none" 
                                    data-doctor_id="<?php echo $doctor_id ?>"
                                    data-clinic_id="<?php echo $clinic_id ?>"> 
  
  <!--Place Holder for Insatnt Appointment -->
  <div class="row self_style">
    <div class="shedular_top"> <strong style="color:#FFF">SELECT DATE <i class="glyphicon glyphicon-chevron-right"></i> PICK TIME SLOT <i class="glyphicon glyphicon-chevron-right"></i> PROVIDE YOUR DETAILS <i class="glyphicon glyphicon-chevron-right"></i> BOOK APPOINTMENT </strong>
      <button class="btn btn-primary btn-sm" style="float: right;margin-top: -5px;
" onclick="$(this).parent().parent().parent().slideUp(200);"> <i class="glyphicon glyphicon-minus"></i> </button>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:0">
      <h4><i class="glyphicon glyphicon-calendar"></i> Select Date</h4>
      <div class="datepicker ll-skin-latoja "></div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 shedule_holder_ajax"> </div>
  </div>
</div>