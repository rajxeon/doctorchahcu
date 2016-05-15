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
.taber_header{ height:20px; display:none}
.total_price{ font-weight:bold;}
.discount_parent{ display:none}
.note{ margin-bottom:3px; display:none}
.note_txt{font-size: 13px !important;margin: 1px 0;line-height: 1;}
.counter_holder{ display:none}
</style>
<link rel="stylesheet" href="<?php echo bu('style/counter.css');?>" />
<?php $patient_data=$patient_data;?>
<?php 
//Combine all the json
$json=array();
$bum_array=array();
foreach($t_data as $a=>$b){
	$bum_array[$b->id]=json_decode($b->json,true); 
	}

foreach($treatment_ids as $a=>$b){
	$temp=explode(':',$b);
	$temp_ar=$bum_array[$temp[0]][$temp[1]];
	
	$json[]=$temp_ar;
	}
$main_json=json_encode($json);
$imploded_treatment_ids=implode('-::-',$treatment_ids);
?>
<div id="page-wrapper" style=" position:relative;min-height: 100px;"  class="right-side">
  <div class="col-xs-12 page-header">
    <div class="col-xs-2 no-pad"> <a data-toggle="modal" onclick="event.preventDefault();" class="btn btn-default" href="<?php echo bu('doctor/records/0/treatment_plans')?>" data-target=".bs-example-modal-lg"> <i class="fa fa-fw fa-users"></i> </a>
      <h4 style="display: inline;">All Patients </h4>
    </div>
    <div class="col-xs-6">
      <a href="<?php echo bu('doctor/view_patient/'.$patient_data->id);?>">
          <div class="col-md-4 col-xs-12" style="margin-top: -6px;">
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
    <div class="col-xs-4 no-pad" align="right"> 
    	<div class="btn-group">
            <a class="btn btn-sm btn-flat btn-info fr" 
            onclick="event.preventDefault();prepare_json($(this))"><i class="fa fa-fw fa-save"></i>Save As Completed</a> 
            <span id="add_fund" style="float:right">
             <a class="btn btn-sm  btn-flat btn-success fr"  
            onclick="event.preventDefault();inv_prepare_json($(this))"><i class="fa fa-fw fa-save"></i>Save & Invoice</a> 
            </span>
           
            <a href="<?php if(isset($_SERVER['HTTP_REFERER']))  echo $_SERVER['HTTP_REFERER'];else  echo bu('doctor/treatment_plans'); ?>"  class="btn btn-sm  btn-flat btn-default fr"  style="width:100px"><i class="fa fa-fw fa-times"></i> Cancel </a> 
   	</div> 
   </div>
  </div>
  <!-- End of header--> 
  
  <!-- Body-->
<script src="<?php echo bu('js/counter.js')?>" type="application/javascript"></script>
<script>

$(document).ready(function(e) {
	//$('.header,.left-side').hide();
    json='<?php  echo  $main_json;?>';
	json=JSON.parse(json);
	dummy='';
	
		for(var i in json){  
		dummy+='<div class="tabber col-xs-12">'; 
		if(json[i].completed==1)
		dummy+='<input type="hidden" class="completed" value="1">';
		dummy+='<input type="hidden" class="speciality" value="'+json[i].speciality+'"><i class="fa fa-fw fa-times-circle close" onClick="$(this).parent().remove();calculate_gross()"></i><div class="col-xs-4 no-pad"><p><u class="treatment_plan_name">'+json[i].treatment_plan_name+'</u></p><a href=""';
		
		if(1) dummy+='onClick="event.preventDefault(); $(this).next().next().slideToggle(200);"';
		else dummy+='onClick="event.preventDefault();"';
		dummy+=' >+ Add note</a><p class="note_txt">'+json[i].note_txt+'</p><input type="text" class="form-control note" placeholder="Enter Note" onBlur="$(this).slideUp(200);$(this).prev().text($(this).val())" value="'+json[i].note_txt+'"></div><div class="col-xs-8 no-pad mokal" style="padding-top:8px !important"><div class="col-xs-5 no-pad" align="center"><div class="col-xs-1  no-pad"></div><div class="col-xs-5 no-pad"><input type="number"  class="form-control qty"  onChange="calculate_total($(this))"'; 
		if(json[i].completed==1) dummy+='disabled="disabled" ';
		dummy+=' value="'+json[i].qty+'" ></div><div class="col-xs-5 no-pad"><input type="number"  class="form-control price" onChange="calculate_total($(this))" value="'+json[i].price+'"';
		if(json[i].completed==1) dummy+='disabled="disabled" ';
		dummy+=' ></div><div class="col-xs-1 no-pad"></div></div><div class="col-xs-5 no-pad" align="center"><a href=""  onclick="event.preventDefault();toggle_discount($(this))"> + Add Discount</a><div class="discount_parent"><div class="col-xs-1 no-pad"></div><div class="col-xs-5 no-pad"><input type="number"  class="form-control discount"  onChange="calculate_total($(this))" value="'+json[i].discount+'" '; 
		if(json[i].completed==1) dummy+='disabled="disabled" ';
		dummy+='></div><div class="col-xs-5 no-pad"><select '; 
		
		if(json[i].completed==1) dummy+='disabled="disabled" ';
		dummy+='class="form-control inr_or_per" onChange="calculate_total($(this))"><option value="inr"';
		if(json[i].inr_or_per=='inr') dummy+=' selected="selected"' ;
		
		dummy+='>INR</option><option value="percentage"';
		 
		if(json[i].inr_or_per=='percentage') dummy+=' selected="selected"' ;
		dummy+= '>%</option></select></div><div class="col-xs-1 no-pad"></div></div></div><div class="col-xs-2 no-pad total_price" align="right"> '+json[i].total_price+'</div></div><div align="center" style="clear:both">';
	dummy+=button_by_speciality(json[i].speciality,json[i].vig,json[i].vig_txt);
	
	if(json[i].completed==0)
	dummy+='<div class="col-xs-12 counter_holder"></div></div></div>'; 
	else dummy+=' </div></div>'; 
		}
	$('#bar_holder').html(dummy);
	calculate_gross();
	
	
});

function inv_prepare_json(self){
	//prepare_invoice();
	prepare_json(self,1);
	}

function prepare_json(self,inv){
	
	if (inv === undefined) {    inv = 0;  }
	
	self.html('');
	self.html('<img src="<?php echo bu('images/ajax_rt.gif')?>"> Please Wait..');
	doctor_id=		'<?php echo $this->session->userdata('id');?>';
	clinic_id=		'<?php echo $clinic_data->id;?>';
	patient_id	=	'<?php echo $patient_data->id;?>';
	
	//First save the newly added tabs in treatment plans
	if($('.tabber_new').length==0){ add_hoc(self,inv); return;	}
	
	array=[];
		$('.tabber_new').each(function(index, element) {
			treatment_plan_name=($(this).find('.treatment_plan_name').text());
			speciality	=($(this).find('.speciality').val());
			qty			=($(this).find('.qty').val());
			price		=($(this).find('.price').val());
			discount	=($(this).find('.discount').val());
			inr_or_per	=($(this).find('.inr_or_per').val());
			total_price	=($(this).find('.total_price').text());
			note_txt	=($(this).find('.note_txt').text());
			vig			=($(this).find('.counter_invoker').attr('data-vig'));
			vig_txt		=($(this).find('.counter_invoker').text()); 
			completed	=1;
			
			multiply=0;
			select_all_teeth=0;
			if($(this).find('.multiply').is(':checked'))  multiply =1;
			if($(this).find('.select_all_teeth ').is(':checked'))  select_all_teeth =1;
			
			var object = {'treatment_plan_name':treatment_plan_name, 'speciality':speciality, 'qty':qty, 'price':price,'discount':discount,'inr_or_per':inr_or_per, 
			'total_price':total_price,'note_txt':note_txt,'vig':vig,'vig_txt':vig_txt,'multiply':multiply,'select_all_teeth':select_all_teeth,'completed':completed,'invoiced':0
			};
			
			array[index]=object;
		
		}); 
		
		
		$.post('<?php echo bu('doctor/ajax_save_treaatment_plan');?>'+'/'+inv,{
			doctor_id:doctor_id,
			clinic_id:clinic_id, 
			patient_id:patient_id,
			json:JSON.stringify(array),
			treatment_ids:'<?php echo $imploded_treatment_ids;?>'
			},function(data){ 
				if(data==1) {self.html('<i class="fa fa-fw fa-check"></i> Saved').removeAttr('onClick')
				add_hoc(self); }
				else self.html('<i class="fa fa-fw fa-exclamation-circle"></i> Error'); 
				//console.log(data);
				})
			
			
	
	 
	}

function add_hoc(self,inv){
	array=[];
		$('.tabber').each(function(index, element) {
			treatment_plan_name=($(this).find('.treatment_plan_name').text());
			speciality	=($(this).find('.speciality').val());
			qty			=($(this).find('.qty').val());
			price		=($(this).find('.price').val());
			discount	=($(this).find('.discount').val());
			inr_or_per	=($(this).find('.inr_or_per').val());
			total_price	=($(this).find('.total_price').text());
			note_txt	=($(this).find('.note_txt').text());
			vig			=($(this).find('.counter_invoker').attr('data-vig'));
			vig_txt		=($(this).find('.counter_invoker').text()); 
			completed	=1;
			if(inv==1) 	invoiced=1;
			else 		invoiced=0;
			
			multiply=0;
			select_all_teeth=0;
			if($(this).find('.multiply').is(':checked'))  multiply =1;
			if($(this).find('.select_all_teeth ').is(':checked'))  select_all_teeth =1;
			
			var object = {'treatment_plan_name':treatment_plan_name, 'speciality':speciality, 'qty':qty, 'price':price,'discount':discount,'inr_or_per':inr_or_per, 
			'total_price':total_price,'note_txt':note_txt,'vig':vig,'vig_txt':vig_txt,'multiply':multiply,'select_all_teeth':select_all_teeth,'completed':completed,'invoiced':invoiced
			};
			
			array[index]=object;
		
		});  
		$.post('<?php echo bu('doctor/ajax_save_completed_procedure');?>'+'/'+inv,{
			t_id:'<?php echo '';?>',
			doctor_id:doctor_id,
			clinic_id:clinic_id, 
			patient_id:patient_id,
			json:JSON.stringify(array),
			treatment_ids:'<?php echo $imploded_treatment_ids;?>'
			},function(data){  
				if(inv==1 && data!=0){ 
				
					html='<form action="<?php echo bu('doctor/handle_post_redirect/'.$patient_data->id);?>" method="post"><input type="hidden" name="data" value="'+data+'"><button type="submit" class="btn btn-sm btn-flat btn-warning" ><i class="fa fa-money"></i>Pay Now</form>';
					$('#add_fund').html(html);
					self.html('<i class="fa fa-fw fa-check"></i> Success'); 
					return;
					}
				if(data==1) {self.html('<i class="fa fa-fw fa-check"></i> Saved').removeAttr('onClick')
				window.location.href='<?php refferer(bu('doctor/treatment_plans'));?>';
				}
				else 		self.html('<i class="fa fa-fw fa-exclamation-circle"></i> Error');
				 
				//console.log(data);
				})
	}

	
	
function toggle_discount(self){
	self.toggle();
	self.next().toggle();
	}

function calculate_gross(){
	var total=0;
	var discount_amt=0; 
	$('.mokal').each(function(index, element) {
        qty=$(this).find('.qty').val();
		price=$(this).find('.price').val();
		temp=qty*price;
		discount=$(this).find('.discount').val();
		inr_or_per=$(this).find('.inr_or_per:selected').val();		
		if(inr_or_per=='inr') discount_amt+=parseInt(discount);
		else{discount_amt+=(temp)*.01*discount}
		
		total=total+(temp);
		
    });
	
	$('#gross').text(total);
	$('#gross_discount').text(parseInt(discount_amt));
	$('#grand_total').text(parseInt(total-discount_amt));
	}
function calculate_total(self,flag){
	parent=self.closest('.mokal');
	if(flag) parent=self;
	//console.log(parent);
	//if(flag) parent=self.parent().parent().parent().parent();
	//else  parent=self.parent().parent().parent();
	
	
	qty=parent.find('.qty').val();
	price=parent.find('.price').val();
	inr_or_per=parent.find('.inr_or_per').val();
	discount=parent.find('.discount').val();
	total=qty*price;
	if(inr_or_per=='inr') total-=discount;
	else{total=total-total*.01*discount}
	
	total_price=parent.find('.total_price');
	total_price.text(total);
	calculate_gross();
	}

$(document).ready(function(e) {  
$('.tab_footer').width($('#tab_1-1').width()+20);
$(document).resize(function(e) {
	 $('.tab_footer').width($('#tab_1-1').width()+20);	
});

$('.pointers').click(function(e) {
	$('#sdad').hide(0);
	attach_object($(this).attr('data-q'),$(this).attr('data-price'),$(this).attr('data-speciality'));
	});
});
//Funstions that govers the behavoour of counter based on speciality Like 'Show teeth'
function counter_show_teeth(self){
	vig_array=self.attr('data-vig').split('|');
	main_parent=self.closest('.tabber ');
	holder=self.next();
	holder.slideToggle(200);
	holder.html('<?php echo counter_show_teeth();?>');
	for (var i in vig_array) { 
		main_parent.find('*[data-id="'+vig_array[i]+'"]').addClass('btn-info');;
		}
	}


//\Functions that govers the behavoour of counter based on speciality Like 'Show teeth'
function button_by_speciality(speciality,vig,vig_txt){
	if(vig==undefined) vig='';
	if(vig_txt==undefined) vig_txt='';
	if(vig_txt.length==0 && speciality=='Dentist') vig_txt='Show Teeth';
	
	switch(speciality){
		case('Dentist'): return '<a href=""  data-vig="'+vig+'"  class="counter_invoker"  onclick="event.preventDefault(); counter_show_teeth($(this))">'+vig_txt+'</a>';
		
		default: return '';
		}
	}



function attach_object(name,price,speciality){
	$('#sacrificer').remove();
	$('.taber_header').show(0);  
	dummy='<div class="tabber col-xs-12 tabber_new"><input type="hidden" class="speciality" value="'+speciality+'"><i class="fa fa-fw fa-times-circle close" onClick="$(this).parent().remove();calculate_gross()"></i><div class="col-xs-4 no-pad"><p><u class="treatment_plan_name">'+name+'</u></p><a href="" onClick="event.preventDefault(); $(this).next().next().slideToggle(200);">+ Add note</a><p class="note_txt"></p><input type="text" class="form-control note" placeholder="Enter Note" onBlur="$(this).slideUp(200);$(this).prev().text($(this).val())"></div><div class="col-xs-8 no-pad mokal" style="padding-top:8px !important"><div class="col-xs-5 no-pad" align="center"><div class="col-xs-1  no-pad"></div><div class="col-xs-5 no-pad"><input type="number"  class="form-control qty"  onChange="calculate_total($(this))" value="0" ></div><div class="col-xs-5 no-pad"><input type="number"  class="form-control price" onChange="calculate_total($(this))" value="'+price+'" ></div><div class="col-xs-1 no-pad"></div></div><div class="col-xs-5 no-pad" align="center"><a href=""  onclick="event.preventDefault();toggle_discount($(this))"> + Add Discount</a><div class="discount_parent"><div class="col-xs-1 no-pad"></div><div class="col-xs-5 no-pad"><input type="number"  class="form-control discount"  onChange="calculate_total($(this))" value="0" ></div><div class="col-xs-5 no-pad"><select class="form-control inr_or_per" onChange="calculate_total($(this))"><option value="inr">INR</option><option value="percentage">%</option></select></div><div class="col-xs-1 no-pad"></div></div></div><div class="col-xs-2 no-pad total_price" align="right"> 0</div></div><div align="center" style="clear:both">';
	dummy+=button_by_speciality(speciality)
	dummy+='<div class="col-xs-12 counter_holder"></div></div></div>'; 
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

</script>
  <div class="col-sm-8 col-xs-12 no-pad">
  
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs pull-right">
        <li class="pull-left header"><i class="fa fa-th"></i> Treatment Plans</li>
      </ul>
      <div class="tab-content">
      

        <div class="tab-pane active" id="tab_1-1" style="height:67vh; overflow:auto; overflow-x:hidden">
        <div class="taber_header col-xs-12 no-pad">
          <div class="col-xs-4 no-pad">TREATMENT</div>
              <div class="col-xs-8 no-pad">
                <div class="col-xs-4 no-pad" align="center">QTY &nbsp;&nbsp;&nbsp;&nbsp; X &nbsp;&nbsp;&nbsp;&nbsp;	COST</div>
                <div class="col-xs-4 no-pad" align="center">DISCOUNT</div>
                <div class="col-xs-4 no-pad" align="right">TOTAL(<i class="fa fa-wa fa-inr"></i>)</div>
              </div>
           </div>
           <div id="bar_holder">
           <img id="sdad" src="<?php echo bu('images/ajax-loader.gif');?>" style="margin:60px auto; display:block" />
           
           </div>
        	
            
            
            
        </div>
        <!-- /.tab-pane --> 
        
      </div>
      <!-- /.tab-content --> 
    </div>
    <!--Footer -->
   <div class="tab_footer bg-primary" align="center">   
   		<div class="col-xs-2 no-pad" >Total Cost 				<br /><i class="fa fa-wa fa-inr"></i> <span id="gross">0</span></div>
        <div class="col-xs-2 no-pad" > - Total Discount 		<br /><i class="fa fa-wa fa-inr"></i> <span id="gross_discount">0</span></div>
        <div class="col-xs-2 no-pad" > = Grand Total 			<br /><i class="fa fa-wa fa-inr"></i> <span id="grand_total">0</span></div>
        <div class="col-xs-2 no-pad"  ></div>
        <!--<div class="col-xs-6" >By Dr.<?php echo $this->session->userdata('name').' on '.date('d-m-y');?></div>-->
   </div>
    <!--/Footer --> 
  </div>
  <div class="col-sm-4 col-xs-12 no-pad">
    <div class="box" style="height:81vh; ">
        <div class="box-header" data-toggle="tooltip" title="" data-original-title="Procedures ( in INR )">
            <h3 class="box-title">Procedures ( in INR )</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs" onclick="$(this).parent().next().next().slideToggle(200);"><i class="fa fa-plus"></i> Add</button> 
            </div>
            <div style="clear:both"></div>
            <div style="display:none">
            <form action="<?php echo bu('doctor/add_treatment_plan_template')?>" method="post">
            	<div class="col-xs-12">
                	<div class="input-group" style="width: 100%;">
                    	<span class="input-group-addon"  style="width:70px">Name</span>
                        <input type="text" class="form-control" placeholder="Name" name="name">
                    </div>
                </div>
                <div class="col-xs-12">
                	<div class="input-group" style="width: 100%;" >
                    	<span class="input-group-addon" style="width:70px"><i class="fa fa-wa fa-inr"></i></span>
                        <input  class="form-control" placeholder="INR" type="number" name="price">
                    </div>
                </div>
                
                <div class="col-xs-12">
                	<div class="form-group">
                        <label>Select Procedures Speciality</label>
                        <select class="form-control" name="speciality">
                        <?php 
						$speciality_array=explode(',',$clinic_data->speciality);
						if(!empty($speciality_array)){ 
							foreach($speciality_array as $a=>$b){
								echo '<option>'.$b.'</option>';
								}
							}
						?>
                            
                        </select>
                    </div>
                </div>
                
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
			 $treatment_plans_template=json_decode($clinic_data->treatment_plans,true);
			 foreach($treatment_plans_template as $a=>$b):
			 $exploded=explode('-::-',$b);
			 ?>
             	<tr class="pointers searchable" data-q="<?php echo $a?>"  data-price="<?php echo @$exploded[1]?>"
                data-speciality="<?php echo @$exploded[0]?>">
                	<td><?php echo $a?></td>
                    <td><i class="fa fa-wa fa-inr"></i> <?php echo @$exploded[1]?></td>
                    <td>
                    	<a href="<?php echo bu('doctor/delete_treatment_plan_template/'.urlencode($a))?>" onclick="event.stopPropagation();return(confirm('Are you sure?'))">
                        	<i class="fa fa-wa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
             
             
             <?php endforeach;?>
             	
             </table>
             <hr />
             
             <table style="width:100%" class="table table-striped">
             <?php 
			 $treatment_plans_template=json_decode($sbs_data->json,true);
			 if(!empty($treatment_plans_template))
			 foreach($treatment_plans_template as $a=>$b):
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
