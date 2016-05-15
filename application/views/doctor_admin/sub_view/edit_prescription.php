<style>
hr {	margin: 3px}
.fr {	margin: 0 5px;}
.modal-lg {	width: auto;}
@media (min-width: 768px) {.modal-dialog {	margin: 30px 5%;}}
.page-header {	font-size: 15px !important;}
.tab_footer{min-height: 40px;position: fixed;bottom: 0;z-index: 6;}
.box {border-top: 0;margin-bottom: 0;border-radius: 0;border-left: 1px solid #bbb;box-shadow: none; overflow:auto; overflow-x:hidden} 
.alert { margin-bottom:0 !important}
tr td:nth-child(1){ width:70%}
tr td:nth-child(2){ width:20%}
tr td:nth-child(3){ width:10%}
.pointers{ cursor:pointer;}
.pointers:hover{ opacity:.9} 
.tabber{min-height: 70px;border-bottom: 1px solid #ccc;border-top: 1px solid #ccc;}
.tabber p{font-size: 19px;}
.close{margin-right: -18px;color: #F40000; opacity:.8; font-size:14px}
.taber_header{ height:20px; }
.total_price{ font-weight:bold;}
.discount_parent{ display:none}
.note{ margin-bottom:3px; display:none}
.note_txt{font-size: 13px !important;margin: 1px 0;line-height: 1;}
.counter_holder{ display:none}
</style>
<link rel="stylesheet" href="<?php echo bu('style/counter.css');?>" />
<?php $patient_data=$patient_data;?>
<div id="page-wrapper" style=" position:relative;min-height: 100px;"  class="right-side">
  <div class="col-xs-12 page-header">
    <div class="col-xs-2 no-pad"> <a data-toggle="modal" onclick="event.preventDefault();" class="btn btn-default" href="<?php echo bu('doctor/records/0/treatment_plans')?>" data-target=".bs-example-modal-lg"> <i class="fa fa-fw fa-users"></i> </a>
      <h4 style="display: inline;">All Patients </h4>
    </div>
    <div class="col-xs-7">
      <a href="<?php echo bu('doctor/view_patient/'.$patient_data->id);?>">
          <div class="col-md-4 col-xs-12" style="margin-top: -6px; padding:0">
            <?php 
            $img_src='';
            if(file_exists('patients/'.$patient_data->id.'/dp.jpg')) $img_src='patients/'.$patient_data->id.'/dp.jpg';
            else{
                if($patient_data->gender=='M') $img_src =bu('images/avatar5.png');
                else if($patient_data->gender=='F') $img_src= bu('images/avatar_lady.jpg');
                else  $img_src =bu('images/user.png');
                }
            echo '<img src="'.$img_src.'" style="height: 40px;margin-right: 10px;">';
            echo $patient_data->name;?>
          </div>
      </a>
      <div class="col-md-4 col-xs-12">
        <?php if($patient_data->gender=='M') echo 'Male';
			if($patient_data->gender=='F') echo 'Female';
			
			if(!empty($patient_data->dob))
			echo ', '.@date_diff(date_create(str_replace('/','-',$patient_data->dob)), date_create('today'))->y.' years';
		?>
      </div>
      <div class="col-md-4 col-xs-12">ID:
        <?php $op_id=json_decode($patient_data->optional_id,true);
		if(isset($op_id[$this->session->userdata('id')])) echo $op_id[$this->session->userdata('id')];
		?>
      </div>
    </div>
    <div class="col-xs-3" align="right"> 
    <a class="btn btn-sm btn-flat btn-success fr" style="width:100px" 
    onclick="event.preventDefault();prepare_json($(this))"><i class="fa fa-fw fa-save"></i> Save </a> 
    <a href="<?php echo bu('doctor/treatment_plans'); ?>"  class="btn btn-sm btn-flat btn-default fr"  style="width:100px"><i class="fa fa-fw fa-times"></i> Cancel </a> </div>
  </div>
  <!-- End of header--> 
  
  <!-- Body-->
<script src="<?php echo bu('js/counter.js')?>" type="application/javascript"></script>
<script>


 
 


$(document).ready(function(e) {  
 

$('.pointers').click(function(e) {
	attach_object($(this).attr('data-q'),$(this).attr('data-strength'),$(this).attr('data-units'));
	});
});
 

 

function calculate_total(self,flag){
	parent=self.closest('.mokal');
	if(flag) parent=self;
	//console.log(parent);
	//if(flag) parent=self.parent().parent().parent().parent();
	//else  parent=self.parent().parent().parent();
	morning_dose=Math.abs(parent.find('.morning_dose').val());
	noon_dose	=Math.abs(parent.find('.noon_dose').val());
	night_dose	=Math.abs(parent.find('.night_dose').val());
	
	
	daily_dose=morning_dose+noon_dose+night_dose;
	
	qty=parent.find('.qty').val();
	duration=parent.find('.duration').val();
	if(duration=='Days(s)') multyplier=1;
	if(duration=='Week(s)') multyplier=7;
	if(duration=='Month(s)') multyplier=30;
	if(duration=='Year(s)') multyplier=365;
	
	
	
	cap_count=qty*daily_dose*multyplier;
	
	cap_count_h=parent.find('.cap_count');
	console.log(parent,cap_count_h);
	cap_count_h.text(cap_count); 
	}


function prepare_json(self){
	self.html('');
	self.html('<img src="<?php echo bu('images/ajax_rt.gif')?>"> Please Wait..');
	doctor_id=		'<?php echo $this->session->userdata('id');?>';
	clinic_id=		'<?php echo $this->session->userdata('primary');?>';
	patient_id	=	'<?php echo $patient_data->id;?>';
	 
	array=[];
	$('.tabber').each(function(index, element) {
        drug_name=($(this).find('.drug_name').text()); 
		strength	=($(this).find('.strength').val());
		units		=($(this).find('.units').val());
		qty			=($(this).find('.qty').val());
		duration	=($(this).find('.duration').val());
		morning_dose=($(this).find('.morning_dose').val());
		noon_dose	=($(this).find('.noon_dose').val());
		night_dose	=($(this).find('.night_dose').val());
		cap_count	=($(this).find('.cap_count').text());
		after_before=($(this).find('.after_before:checked').val());
		note_txt	=($(this).find('.note_txt').text());
		
		console.log(drug_name,strength,units,qty,duration,morning_dose,noon_dose,night_dose,cap_count,after_before);
		 //return;
		
		var object = {'drug_name':drug_name, 'strength':strength,'units':units, 'qty':qty, 'strength':strength,'duration':duration,'morning_dose':morning_dose, 
		'noon_dose':noon_dose,'night_dose':night_dose,'cap_count':cap_count,'after_before':after_before,'note_txt':note_txt
		};
		
		array[index]=object;
    });
	$.post('<?php echo bu('doctor/ajax_save_prescription');?>',{
		t_id:<?=@$t_data->id;?>,
		doctor_id:doctor_id,
		clinic_id:clinic_id, 
		patient_id:patient_id,
		json:JSON.stringify(array)
		},function(data){
			if(data==1) {self.html('<i class="fa fa-fw fa-check"></i> Saved').removeAttr('onClick')
			window.location.href='<?php refferer( bu('doctor/treatment_plans'));?>';
			}
			else 		self.html('<i class="fa fa-fw fa-exclamation-circle"></i> Error');
			 
			//console.log(data);
			})
	}

function attach_object(name,strength,units){ 
 
	$('#sacrificer').remove();
	$('.taber_header').show(0);  
	dummy='<div class="tabber col-xs-12"><input type="hidden" class="strength" value="'+strength+'"><i class="fa fa-fw fa-times-circle close" onClick="$(this).parent().remove();calculate_gross()"></i><div class="col-xs-3 no-pad"><p style="margin:0"><u class="drug_name">'+name+'</u></p><a href="" onClick="event.preventDefault(); $(this).next().next().slideToggle(200);">+ Add note</a><p class="note_txt">'+note_txt+'</p><input type="text" class="form-control note" placeholder="Enter Note" onBlur="$(this).slideUp(200);$(this).prev().text($(this).val())" value="'+note_txt+'"></div><div class="col-xs-9 no-pad mokal" style="padding-top:8px !important"><div class="col-xs-3 no-pad" align="center"> <div class="col-xs-6 no-pad"><input type="number"  class="form-control strength"    value="'+strength+'" ></div><div class="col-xs-6 no-pad"><select class="form-control units" style="padding:0"> '; 
	dummy+='<option';
	if(units=='gm') dummy+=' selected ';
	dummy+='>gm</option>';
	
	dummy+='<option';
	if(units=='mcg') dummy+=' selected ';
	dummy+='>mcg</option>';
	
	dummy+='<option';
	if(units=='mg') dummy+=' selected ';
	dummy+='>mg</option>';
	
	dummy+='<option';
	if(units=='mg fifi') dummy+=' selected ';
	dummy+='>mg fifi</option>';
	
	dummy+='<option';
	if(units=='million spores') dummy+=' selected ';
	dummy+='>million spores</option>';
	
	dummy+='<option';
	if(units=='mi') dummy+=' selected ';
	dummy+='>mi</option>';
	
	dummy+='<option';
	if(units=='IU') dummy+=' selected ';
	dummy+='>IU</option>';
	
	dummy+='<option';
	if(units=='units') dummy+=' selected ';
	dummy+='>units</option>';
	
	dummy+='<option';
	if(units=='%') dummy+=' selected ';
	dummy+='>%</option>';
	
	dummy+='<option';
	if(units=='% wv') dummy+=' selected ';
	dummy+='>% w/v</option>';
	
	dummy+='<option';
	if(units=='% ww') dummy+=' selected ';
	dummy+='>% w/w</option>';
	
	dummy+='<option';
	if(units=='NA') dummy+=' selected ';
	dummy+='>NA</option>';
	
	 
	
	dummy+='</select> </div> </div><div class="col-xs-3 no-pad" align="center" style="padding-left:4px !important"><div class="col-xs-6 no-pad"><input type="number"  class="form-control qty"  onChange="calculate_total($(this))" value="0" ></div><div class="col-xs-6 no-pad"><select  class="form-control duration" style=" padding:0"  onChange="calculate_total($(this))">';
	dummy+='<option';
	if(units=='Days(s)') dummy+=' selected ';
	dummy+='>Days(s)</option>';
	
	dummy+='<option';
	if(units=='Week(s)') dummy+=' selected ';
	dummy+='>Week(s)</option>';
	
	dummy+='<option';
	if(units=='Month(s)') dummy+=' selected ';
	dummy+='>Month(s)</option>';
	
	dummy+='<option';
	if(units=='Year(s)') dummy+=' selected ';
	dummy+='>Year(s)</option>';
	 
	dummy+='</select> </div> </div><div class="col-xs-2  " align="center"><input type="number"  class="form-control morning_dose"  onChange="calculate_total($(this))" value="0" ></div> <div class="col-xs-2  " align="center"><input type="number"  class="form-control noon_dose"  onChange="calculate_total($(this))" value="0" ></div> <div class="col-xs-2  " align="center"><input type="number"  class="form-control night_dose"  onChange="calculate_total($(this))" value="0" ></div>  <div style="margin-top:40px"><div class="col-xs-6"><span class="cap_count">0</span> Capsule(s)</div><div class="col-xs-3"><input type="radio" class="after_before" checked name="'+$('.tabber').length+'_after_before" value="after_food">After Food</div><div class="col-xs-3"><input type="radio" class="after_before" name="'+$('.tabber').length+'_after_before" value="before_food">Before Food</div></div></div><div align="center" style="clear:both">'; 
	
	$('#bar_holder').append(dummy);
	
	}

function search_plan(self){
	q=self.val().toLowerCase();;
	$('.searchable').hide(0);
	array=[];
	$('.searchable').each(function(index, element) {
		temp=($(this).attr('data-q')).toLowerCase();
		if(temp.indexOf(q)==0){
			$(this).show(0);				
			}
	});
	}
function add_new_form(){
	$('.taber_header').show(0);
	$('#sacrificer').hide(0);
	dummy='<div class="tabber col-xs-12"><input type="hidden" class="strength" value="0"><i class="fa fa-fw fa-times-circle close" onClick="$(this).parent().remove();calculate_gross()"></i><div class="col-xs-3 no-pad"><p style="margin:0"><u style="display:none" class="drug_name"></u><input style="margin-top: 8px;width: 95%;" onkeyup="$(this).prev().text($(this).val())" class="form-control"></p><a href="" onClick="event.preventDefault(); $(this).next().next().slideToggle(200);">+ Add note</a><p class="note_txt"></p><input type="text" class="form-control note" placeholder="Enter Note" onBlur="$(this).slideUp(200);$(this).prev().text($(this).val())"></div><div class="col-xs-9 no-pad mokal" style="padding-top:8px !important"><div class="col-xs-3 no-pad" align="center"> <div class="col-xs-6 no-pad"><input type="number"  class="form-control strength"    value="0" ></div><div class="col-xs-6 no-pad"><select class="form-control units" style="padding:0">  <option >gm</option> <option >mcg</option> <option >mg</option> <option >mg fifi</option> <option >million spores</option> <option >mi</option> <option >IU</option> <option >units</option> <option >%</option> <option >% w/v</option> <option >% w/w</option> <option >NA</option>'; 
	dummy+='</select> </div> </div><div class="col-xs-3 no-pad" align="center" style="padding-left:4px !important"><div class="col-xs-6 no-pad"><input type="number"  class="form-control qty"  onChange="calculate_total($(this))" value="0" ></div><div class="col-xs-6 no-pad"><select  class="form-control duration" style=" padding:0"  onChange="calculate_total($(this))"><option >Days(s)</option><option>Week(s)</option><option>Month(s)</option><option>Year(s)</option> </select> </div> </div><div class="col-xs-2  " align="center"><input type="number"  class="form-control morning_dose"  onChange="calculate_total($(this))" value="0" ></div> <div class="col-xs-2  " align="center"><input type="number"  class="form-control noon_dose"  onChange="calculate_total($(this))" value="0" ></div> <div class="col-xs-2  " align="center"><input type="number"  class="form-control night_dose"  onChange="calculate_total($(this))" value="0" ></div>  <div style="margin-top:40px"><div class="col-xs-6"><span class="cap_count">0</span> Capsule(s)</div><div class="col-xs-3"><input type="radio" class="after_before" checked name="'+$('.tabber').length+'_after_before" value="after_food">After Food</div><div class="col-xs-3"><input type="radio" class="after_before" name="'+$('.tabber').length+'_after_before" value="before_food">Before Food</div></div></div><div align="center" style="clear:both"></div></div>'; 
	$('#bar_holder').append(dummy);
	}
$(document).ready(function(e) {
    json='<?php echo  str_replace("\n",'',$t_data->json);?>';
	json=JSON.parse(json);
	dummy='';
	for(var i in json){ 
		strength	=json[i].strength;
		name		=json[i].drug_name;
		units		=json[i].units;
		qty			=json[i].qty;
		duration	=json[i].duration;
		morning		=json[i].morning_dose;
		noon		=json[i].noon_dose;
		night		=json[i].night_dose;
		cap_count	=json[i].cap_count;
		after_before=json[i].after_before;
		note_txt	=json[i].note_txt;  
		dummy+='<div class="tabber col-xs-12"><input type="hidden" class="strength" value="'+strength+'"><i class="fa fa-fw fa-times-circle close" onClick="$(this).parent().remove();calculate_gross()"></i><div class="col-xs-3 no-pad"><p style="margin:0"><u class="drug_name">'+name+'</u></p><a href="" onClick="event.preventDefault(); $(this).next().next().slideToggle(200);">+ Add note</a><p class="note_txt">'+note_txt+'</p><input type="text" class="form-control note" placeholder="Enter Note" onBlur="$(this).slideUp(200);$(this).prev().text($(this).val())" value="'+note_txt+'"></div><div class="col-xs-9 no-pad mokal" style="padding-top:8px !important"><div class="col-xs-3 no-pad" align="center"> <div class="col-xs-6 no-pad"><input type="number"  class="form-control strength"    value="'+strength+'" ></div><div class="col-xs-6 no-pad"><select class="form-control units" style="padding:0"> '; 
	dummy+='<option';
	if(units=='gm') dummy+=' selected ';
	dummy+='>gm</option>';
	
	dummy+='<option';
	if(units=='mcg') dummy+=' selected ';
	dummy+='>mcg</option>';
	
	dummy+='<option';
	if(units=='mg') dummy+=' selected ';
	dummy+='>mg</option>';
	
	dummy+='<option';
	if(units=='mg fifi') dummy+=' selected ';
	dummy+='>mg fifi</option>';
	
	dummy+='<option';
	if(units=='million spores') dummy+=' selected ';
	dummy+='>million spores</option>';
	
	dummy+='<option';
	if(units=='mi') dummy+=' selected ';
	dummy+='>mi</option>';
	
	dummy+='<option';
	if(units=='IU') dummy+=' selected ';
	dummy+='>IU</option>';
	
	dummy+='<option';
	if(units=='units') dummy+=' selected ';
	dummy+='>units</option>';
	
	dummy+='<option';
	if(units=='%') dummy+=' selected ';
	dummy+='>%</option>';
	
	dummy+='<option';
	if(units=='% w/v') dummy+=' selected ';
	dummy+='>% w/v</option>';
	
	dummy+='<option';
	if(units=='% w/w') dummy+=' selected ';
	dummy+='>% w/w</option>';
	
	dummy+='<option';
	if(units=='NA') dummy+=' selected ';
	dummy+='>NA</option>';
	 
	
	dummy+='</select> </div> </div><div class="col-xs-3 no-pad" align="center" style="padding-left:4px !important"><div class="col-xs-6 no-pad"><input type="number"  class="form-control qty"  onChange="calculate_total($(this))" value="'+qty+'" ></div><div class="col-xs-6 no-pad"><select  class="form-control duration" style=" padding:0"  onChange="calculate_total($(this))"><option >Days(s)</option><option>Week(s)</option><option>Month(s)</option><option>Year(s)</option> </select> </div> </div><div class="col-xs-2  " align="center"><input type="number"  class="form-control morning_dose"  onChange="calculate_total($(this))" value="'+morning+'" ></div> <div class="col-xs-2  " align="center"><input type="number"  class="form-control noon_dose"  onChange="calculate_total($(this))" value="'+noon+'" ></div> <div class="col-xs-2  " align="center"><input type="number"  class="form-control night_dose"  onChange="calculate_total($(this))" value="'+night+'" ></div>  <div style="margin-top:40px"><div class="col-xs-6"><span class="cap_count">'+cap_count+'</span> Capsule(s)</div>';
	
	dummy+='<div class="col-xs-3"><input type="radio" ';
	if(after_before=='after_food') dummy+=' checked ';
	dummy+=' class="after_before simple" name="'+$('.tabber')+i+'_after_before" value="after_food">After Food</div>';
	
	dummy+='<div class="col-xs-3"><input type="radio" ';
	if(after_before=='before_food') dummy+=' checked ';
	dummy+=' class="after_before simple" name="'+$('.tabber')+i+'_after_before" value="before_food">Before Food</div></div></div><div align="center" style="clear:both"></div></div>'; 
		}
	$('#bar_holder').html(dummy); 
	
	
});

</script>
  <div class="col-sm-8 col-xs-12 no-pad">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs pull-right">
        <li class="pull-left header"><i class="fa fa-th"></i> Prescription</li>
      </ul>
      <div class="tab-content"> 

        <div class="tab-pane active" id="tab_1-1" style="height:72vh; overflow:auto; overflow-x:hidden">
        <div class="taber_header col-xs-12 no-pad">
          <div class="col-xs-3 no-pad">DRUG NAME</div>
              <div class="col-xs-9 no-pad">
                <div class="col-xs-3 no-pad" align="center">STRENGTH</div>
                <div class="col-xs-3 no-pad" align="center">DURATION</div>
                <div class="col-xs-2 no-pad" align="center">MORNING</div> 
                <div class="col-xs-2 no-pad" align="center">NOON</div>
                <div class="col-xs-2 no-pad" align="center">NIGHT</div>
              </div>
           </div>
           <div id="bar_holder">
           <button id="sacrificer" class="btn btn-default btn-flat disabled" style="margin:30px auto; display:block">
            	Select a drug from the right. Multiple drugs can be added.
            </button>
           </div>
           <div align="right">	
           	<a href="" onclick="event.preventDefault();add_new_form()"><strong>Pescribe Custom Drug</strong></a>
           </div>
            
            
            
        </div>
        <!-- /.tab-pane --> 
        
      </div>
      <!-- /.tab-content --> 
    </div>
    <!--Footer -->
   
    <!--/Footer --> 
  </div>
  <div class="col-sm-4 col-xs-12 no-pad">
    <div class="box" style="height:81vh; ">
        <div class="box-header" data-toggle="tooltip" title="" data-original-title="Drugs">
            <h3 class="box-title">Drug Name</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs" onclick="$(this).parent().next().next().slideToggle(200);"><i class="fa fa-plus"></i> Add</button> 
            </div>
            <div style="clear:both"></div>
            <div style="display:none">
            <form action="<?php echo bu('doctor/add_drug')?>" method="post">
            	<div class="col-xs-12">
                	<div class="input-group" style="width: 100%;">
                    	<span class="input-group-addon"  style="width:70px">Drug Name</span>
                        <input type="text" class="form-control" placeholder="Drug Name" name="name">
                    </div>
                </div>
                
                <div class="col-xs-12">
                	<div class="input-group" style="width: 60%; float:left">
                    	<span class="input-group-addon"  style="width:70px">Strength &nbsp; &nbsp;&nbsp;</span>
                        <input type="number" class="form-control"  name="strength" value="0">
                    </div>
                    <div class="input-group" style="width: 40%;"> 
                    	<select name="unit" class="form-control">
                        	<option>mg</option>
                            <option>mcg</option>
                            <option>mg</option>
                            <option>mg fifi</option>
                            <option>million spores</option>
                            <option>mi</option>
                            <option>IU</option>
                            <option>units</option>
                            <option>%</option>
                            <option>% w/v</option>
                            <option>% w/w</option>
                            <option>NA</option> 
                        </select> 
                    </div>
                </div>
                 
                
                 <hr style="clear:both">
                
                <div class="col-xs-12">
                	<button type="submit" class="btn btn-flat btn-block btn-success btn-sm">Submit</button>
                </div>
            </form>
            </div>
        </div>
        
            <hr />
            <?php display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));?>
        <div class="box-body">
       		 <input type="text" class="form-control" placeholder="Search..." onkeyup="search_plan($(this))">
             <hr />
             <table style="width:100%" class="table table-striped">
             <?php 
			 $drug_template=json_decode($doctor_meta->drug,true);
			 foreach($drug_template as $a=>$b):
			 $exploded=explode('-::-',$b);
			 ?>
             	<tr class="pointers searchable" data-q="<?php echo $a?>"  data-units="<?php echo @$exploded[1]?>"
                data-strength="<?php echo @$exploded[0]?>">
                	<td><?php echo $a?></td>
                    <td><?php echo @$exploded[0]?> <?php echo @$exploded[1]?></td>
                    <td>
                    	<a href="<?php echo bu('doctor/delete_drug/'.urlencode($a))?>" onclick="event.stopPropagation();return(confirm('Are you sure?'))">
                        	<i class="fa fa-wa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
             
             
             <?php endforeach;?>
             	
             </table>
             <hr />
             
             <table style="width:100%" class="table table-striped">
             <?php 
			 $drug_template=@json_decode($sbs_data->json,true);
			 if(!empty($drug_template))
			 foreach($drug_template as $a=>$b):
			 ?>
             	<tr class="pointers searchable" data-q="<?php echo $a?>" data-price="<?php echo $b?>" 
                data-speciality="<?php echo $sbs_data->speciality;?>">
                	<td><?php echo $a?></td>
                    <td><i class="fa fa-wa fa-inr"></i> <?php echo $b?></td>
                    <td> 
                        	<i class="fa fa-wa fa-check"></i>
                        
                    </td>
                </tr>
             
             
             <?php endforeach;?>
             	
             </table>
            
        </div><!-- /.box-body -->
         
    </div>
  	
  </div>
  
  <!-- /Body--> 
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content"> </div>
  </div>
</div>
</div>
</div>
</div>
