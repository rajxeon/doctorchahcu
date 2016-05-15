<style>
.nav-tabs-custom {
	box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
}
.nav-tabs-custom > .nav-tabs {
	margin: 0;
	border-bottom-color: #3C8DBC;
}
.nav-tabs-custom > .nav-tabs > li.active > a {
	border-top: 0;
	border-left-color: #3C8DBC;
	border-right-color: #3C8DBC;
}
.nav-tabs-custom {
	box-shadow: 0px 3px 3px rgba(0, 0, 0, 0.3);
}
.muskil {
	max-height: 1300px;
	overflow: hidden;
	overflow-y: auto
}
.m_btn {
	padding: 2px 6px;
	margin-top: -4px;
}
.input-group-addon{ padding:3px; font-size:12px; width:80px}
.input-group{width:100%}
.adon{height: 34px;border-left: 1px solid #D8D8D8 !important;}
.moha .input-group{margin-bottom: 10px;}
</style>


<?php $patient_data=($patient_data);?>
<div class="col-md-12"> 
  <!-- Info box -->
  <div class="box box-solid box-info ">
    <div class="box-header bg-light-blue">
      <h3 class="box-title "><i class="fa fa-fw fa-wheelchair"></i> <?php echo $patient_data->name;?></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary btn-sm " data-widget="collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div > 
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="<?php if($tab=='tab1') echo 'active';?>"><a href="#tab_1" data-toggle="tab">Clinical Notes</a></li>
            <li class="<?php if($tab=='tab2') echo 'active';?>"><a href="#tab_2" data-toggle="tab">Treatment Plans</a></li>
            <li class="<?php if($tab=='tab3') echo 'active';?>"><a href="#tab_3" data-toggle="tab">Completed Procedures</a></li>
            <li class="<?php if($tab=='tab4') echo 'active';?>"><a href="#tab_4" data-toggle="tab">Files</a></li>
            <li class="<?php if($tab=='tab5') echo 'active';?>"><a href="#tab_5" data-toggle="tab">Prepscriptions</a></li>
            <li class="<?php if($tab=='tab6') echo 'active';?>"><a href="#tab_6" data-toggle="tab">Timeline</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane <?php if($tab=='tab1') echo 'active';?>" id="tab_1">
              <h4>Clinical Notes
                <button class="btn btn-success btn-flat btn-sm" style="float:right" data-toggle="collapse" data-target="#add_clinic_note" aria-expanded="false" aria-controls="add_clinic_note"> + Add Clinical Notes</button>
              </h4>
              <div class="collapse" id="add_clinic_note" style="clear:both">
                <div class="well">
                  <form action="<?php echo bu('doctor/handle_post_patirnt_expand/'.$patient_data->id.'/tab1/clinical_notes');?>" method="post">
                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" placeholder="Complaints" required  name="complaints">
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" placeholder="Observations" required  name="observations">
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" placeholder="Diagnoses"  required name="diagnoses">
                      </div>
                      <br clear="all">
                      <div class="col-lg-12" align="right" style="margin-top:5px">
                        <button class="btn btn-primary btn-sm btn-flat"> <i class="fa fa-fw fa-save"></i> Save Note</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <hr>
              <div class="well muskil">
                <?php $this->load->view('doctor_admin/components/clinic_note_timeline',$this->data);?>
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane <?php if($tab=='tab2') echo 'active';?>" id="tab_2">
              <h4>Treatment Plans 
                <button class="btn btn-success btn-flat btn-sm" style="float:right" data-toggle="collapse" data-target="#add_treatment_paln" aria-expanded="false" aria-controls="add_treatment_paln"> + Add Treatment Plan</button>
              </h4>
              <div class="collapse" id="add_treatment_paln" style="clear:both">
                <div class="well">
                  <form action="<?php echo bu('doctor/handle_post_patirnt_expand/'.$patient_data->id.'/tab2/plan');?>" method="post">
                    <div class="row">
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <input type="text" class="form-control" placeholder="Treatment Plan"   name="treatment_plan">
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <input type="text" class="form-control" placeholder="Cost(INR)"    name="cost">
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <input type="text" class="form-control" placeholder="Discount(INR)"    name="discount">
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <input type="text" class="form-control" placeholder="Advance(INR)"    name="advance">
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
                        <input type="text" class="form-control" placeholder="Note"    name="note">
                      </div>
                      <br clear="all">
                      <div class="col-lg-12" align="right" style="margin-top:5px">
                        <button class="btn btn-primary btn-sm btn-flat"> <i class="fa fa-fw fa-save"></i> Save Plan</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <hr>
              <div class="well muskil">
                <?php $this->load->view('doctor_admin/components/treatment_plan_timeline',$this->data);?>
              </div>
            </div>
            <!-- /.tab-pane --> 
            <div class="tab-pane <?php if($tab=='tab3') echo 'active';?>" id="tab_3">
              <h4>Completed Procedure 
                <button class="btn btn-success btn-flat btn-sm" style="float:right" data-toggle="collapse" data-target="#add_completed_procedure" aria-expanded="false" aria-controls="add_treatment_paln"> + Add Completed Procedure 
</button>
              </h4>
              <div class="collapse" id="add_completed_procedure" style="clear:both">
                <div class="well">
                  <form action="<?php echo bu('doctor/handle_post_patirnt_expand/'.$patient_data->id.'/tab3/com_pro');?>" method="post">
                    <div class="row">
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <input type="text" class="form-control" placeholder="Treatment Plan"   name="treatment_plan">
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <input type="text" class="form-control" placeholder="Cost(INR)"    name="cost">
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <input type="text" class="form-control" placeholder="Discount(INR)"    name="discount">
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <input type="text" class="form-control" placeholder="Advance(INR)"    name="advance">
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <input type="text" class="form-control" placeholder="Note"    name="note">
                      </div>
                      <br clear="all">
                      <div class="col-lg-12" align="right" style="margin-top:5px">
                        <button class="btn btn-primary btn-sm btn-flat"> <i class="fa fa-fw fa-save"></i> Save Plan</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <hr>
              <div class="well muskil">
                <?php $this->load->view('doctor_admin/components/completed_procedure_timeline',$this->data);?>
              </div>
            </div>
            
            <div class="tab-pane <?php if($tab=='tab5') echo 'active';?>" id="tab_5">
            
              <h4>Prepscriptions    
              <strong style="margin-left:30px; cursor:pointer;font-size: 13px;">
              	
              </strong>
              
                <button class="btn btn-success btn-flat btn-sm" style="float:right" data-toggle="collapse" data-target="#add_prepscriptions" aria-expanded="false" aria-controls="add_treatment_paln"> + Add Prepscriptions
</button>

              </h4>
              <div class="collapse" id="add_prepscriptions" style="clear:both">
                <div class="well">
                <div class="row">
                
                  <form action="<?php echo bu('doctor/handle_post_patirnt_expand/'.$patient_data->id.'/tab5/prepscriptions');?>" method="post" class="moha">
                    
<div class="row col-lg-12">

	<div id="msg_for_me"></div>
<div class="fg_holder" >
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-asterisk"></i> Name</span>
            <input type="text" class="form-control" placeholder="Template name * " required name="name[]" 
            value="<?php echo $this->input->post('name')?>"  >
        </div>
    </div>
	
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-dot-circle-o"></i> Drug</span>
            <input type="text" class="form-control" placeholder="Drug * " name="drug[]"  required
            value="<?php echo $this->input->post('drug')?>"  >
        </div>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-clock-o"></i> Duration</span>
            <input type="text" class="form-control" placeholder="Duration " name="duration[]" 
            value="<?php echo $this->input->post('duration')?>"  >
        </div>
    </div>
    
   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-info-circle"></i> Instruction</span>
            <input type="text" class="form-control" placeholder="Instruction " name="instruction[]" 
            value="<?php echo $this->input->post('instruction')?>"  >
        </div>
    </div>
    
    <br clear="all" />
    
    
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-sun-o"></i> Morning</span>
            
            <input type="text" class="form-control" placeholder="Morning Dose " name="morning[]" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  
            value="<?php echo $this->input->post('morning')?>">
        </div>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-cloud"></i> Noon</span>
            
            <input type="text" class="form-control" placeholder="Noon Dose  " name="noon[]" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  
            value="<?php echo $this->input->post('noon')?>">
        </div>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-moon-o"></i> Night</span>
            
            <input type="text" class="form-control" placeholder="Night Dose " name="night[]" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  
            value="<?php echo $this->input->post('night')?>">
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        
                        
                        
                        <a class="btn btn-info btn-sm btn-flat btn-flat indexer" data-toggle="modal"  href="<?php echo bu('doctor/get_template');?>" data-target="#myModal7">+ Use  template</strong></a>
                        <button class="btn btn-success btn-sm btn-flat btn-flat"  style="padding:5px" onClick="save_template_pr($(this))">  Save as Template</button>
                        
      </div>
      
      <hr style="clear:both">
    </div>    
    <br clear="all">
    <div class="col-lg-12" style="text-align: right;">
    <button  class="btn btn-primary btn-sm btn-flat" onClick="add_drug()"> + Add another drug </button>
    <button type="submit" class="btn btn-primary btn-sm btn-flat"> <i class="fa fa-fw fa-save"></i> Save </button>
    
    
    </div> <!-- FG Holder -->
    
    
</div>

</form>
<input id="temp_data" type="hidden" value="1">
                </div>
                </div>
              </div>
              <hr>
              <div class="well muskil">
                <?php $this->load->view('doctor_admin/components/prepscription_timeline',$this->data);?>
              </div>
            </div>
            
          </div>
          <!-- /.tab-content --> 
        </div>
        <!-- nav-tabs-custom --> 
      </div>
    </div>
    <!-- /.box-body --> 
  </div>
  <!-- /.box --> 
</div>
<script>
var html='';


function save_template_pr(self){
	event.preventDefault();
	parent=self.parent();
	
	
	name=parent.prev().prev().prev().prev().prev().prev().prev().prev().find('input').val();
	drug=parent.prev().prev().prev().prev().prev().prev().prev().find('input').val();
	duration=parent.prev().prev().prev().prev().prev().prev().find('input').val();
	instruction=parent.prev().prev().prev().prev().prev().find('input').val();
	morning=parent.prev().prev().prev().find('input').val();
	noon=parent.prev().prev().find('input').val();
	night=parent.prev().find('input').val();
	
	$.post('<?php echo bu('doctor/prescription');?>',{ajax:1,name:name,drug:drug,duration:duration,instruction:instruction,morning:morning,noon:noon,night:night},function(data){
		console.log(data);
		if(data==1){
			url=window.location.href;
			if(url.indexOf('tab')==-1)url+='/tab5'
			window.location.href=url;
			}
		else {$('#msg_for_me').html('<div class="alert alert-danger" role="alert">	<i class="fa fa-ban"></i>'+data+'</div>'	);}
		})
	
	
	//console.log(name,drug,duration,inst,morning,noon,night);
	}



$(document).ready(function(e) {
    html=$('.fg_holder').html();
	$(document).on("click", ".indexer", function() {
		   indexr = $(this).parent().index();
		   indexr=(indexr-8)/10+1;
		   $('#temp_data').val(indexr);
	});
});

function add_drug(){
	event.preventDefault();
	$('.fg_holder').append(html);
	}

function attach_template(self,str){
	index=$('#temp_data').val();
	index=index-1;
	multiplyer=index*7;
	
	targets=$('.fg_holder').find('input');
	
	
	template_name=targets[0+multiplyer];
	drug=targets[1+multiplyer];
	duration=targets[2+multiplyer];
	instruction=targets[3+multiplyer];
	morning=targets[4+multiplyer];
	noon=targets[5+multiplyer];
	night=targets[6+multiplyer];
	
	str_array=str.split('-::-');
	$(template_name).val(str_array[0]);
	$(drug).val(str_array[1]);
	$(duration).val(str_array[2]);
	$(instruction).val(str_array[3]);
	$(morning).val(str_array[4]);
	$(noon).val(str_array[5]);
	$(night).val(str_array[6]);
	
	
	
	}
</script>


<div class="modal fade bs-example-modal-lg" id="myModal7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
     
    </div>
   
  </div>
  
</div>



