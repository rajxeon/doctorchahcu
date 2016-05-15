<style>
hr {	margin: 3px}
.fr {	margin: 0 5px;}
.modal-lg {	width: auto;}
@media (min-width: 768px) {.modal-dialog {	margin: 30px 5%;}}
.page-header {	font-size: 15px !important;}
.tab_footer{min-height: 40px;position: fixed;bottom: 0;z-index: 6;}
.box {border-top: 0;margin-bottom: 0;border-radius: 0;border-left: 1px solid #bbb;box-shadow: none; overflow:auto; overflow-x:hidden} 
.alert { margin-bottom:0 !important}
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
.inv_box{margin-bottom:7px}
.inv_box h3.box-title{float: none !important; display:inherit !important;border-bottom: 1px solid;}
.bg-primary{color: #fff !important; background-color: #428bca !important; cursor:pointer}
.bg-primary.inv_box:hover{ background-color:#4BBDE1  !important; }
 

.box::-webkit-scrollbar {   width: 8px;   }  
.box::-webkit-scrollbar-track {  
    background-color: #eaeaea;  
    border-left: 1px solid #ccc;  
}  
.box::-webkit-scrollbar-thumb {  
    background-color: #000;  
}  
.box::-webkit-scrollbar-thumb:hover {  
    background-color: #aaa;  
}   
.bg-yellow{ background-color:#FFFAC3 !important; color:#000 !important}
.noselect {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
#recept_no:focus{ outline:none}
.table-bordered tr th{font-weight: normal;
font-size: 10px;
padding: 0;
text-align: center;}
.table-bordered td{ padding:0 !important; text-align:center}
.close_me{ cursor:pointer; color:#F00} 
.close_me:hover{ opacity:.8}
.doted-border{ border-top:1px dashed #aaa; padding-top:3px}
.cpl{margin-bottom:0; margin-top:6px}
.cpl:focus{ outline:none !important}
</style>

<link rel="stylesheet" href="<?php echo bu('style/counter.css');?>" />
<?php $patient_data=$patient_data;?>
<div id="page-wrapper" style=" position:relative;min-height: 100px;"  class="right-side">
  <div class="col-xs-12 page-header">
    <div class="col-xs-2 no-pad"> <a data-toggle="modal" onclick="event.preventDefault();" class="btn btn-default" href="<?php echo bu('doctor/records/0/add_payment')?>" data-target=".bs-example-modal-lg"> <i class="fa fa-fw fa-users"></i> </a>
      <h4 style="display: inline;">All Patients </h4>
    </div>
    <div class="col-xs-7">
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
        <small class="badge pull-right 
               
               <?php
			   $balence=0; 
			   $sql="SELECT * FROM payment WHERE patient_id=".@$patient_data->id." AND clinic_id=".$this->session->userdata('primary');
			   $payment=$this->db->query($sql)->result();
			   if(isset($payment[0])) {
				   $payment=$payment[0];
			   	   $balence=$payment->balence;
			   }
			   ?>
               <?php 
			   $abs_balence=abs($balence);
			   if($balence<0)echo ' bg-red ';
			   else echo ' bg-green';
			   ?>
               " style="margin:11px 10px"><i class="fa fa-inr" ></i> <?php echo $abs_balence?> <?php  
			   if($balence<0)echo '(Due)';
			   else if($balence>0) echo '(Adv)';?>
               </small> 
      </div>
    </div>
    <div class="col-xs-3" align="right"> 
    <a class="btn btn-sm btn-flat btn-success fr" style="width:100px" 
    onclick="event.preventDefault();prepare_json($(this))"><i class="fa fa-fw fa-save"></i> Save </a> 
    <a href="<?php echo r(bu('doctor/payment/'.$patient_data->id));  ?>"  class="btn btn-sm btn-flat btn-default fr"  style="width:100px"><i class="fa fa-fw fa-times"></i> Cancel </a> </div>
  </div>
  <!-- End of header--> 
  
  <!-- Body-->
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="<?php echo bu('js/counter.js')?>" type="application/javascript"></script> 
<script>
$(document).ready(function(e) {
    $('.datepicker').datepicker({
		dateFormat: "dd/mm/yy",
		});
});

function prepare_json(self){
	self.html('');
	self.html('<img src="<?php echo bu('images/ajax_rt.gif')?>"> Please Wait..'); 
	clinic_id=		'<?php echo $clinic_data->id;?>';
	patient_id	=	'<?php echo $patient_data->id;?>';
	
	flag=$('#helper_flag').val();
	array=[];
	if(flag=='advance'){
		amount		=$('.amount').val();
		mode		=$('.mode').val();
		note		=$('.note').val();
		recept_no	=$('#recept_no').val();
		p_date		=$('#p_date').val(); 
		var object = {'amount':amount, 'mode':mode, 'note':note,'recept_no':recept_no,'date':p_date}
		$.post('<?php echo bu('doctor/ajax_add_advance');?>',{  
			patient_id:patient_id, 
			json:JSON.stringify(object)
				},function(data){ 
				if(data==1) {self.html('<i class="fa fa-fw fa-check"></i> Saved').removeAttr('onClick')
				window.location.href='<?php  echo (bu('doctor/payment/'.$patient_data->id));?>';
				}
				else 		self.html('<i class="fa fa-fw fa-exclamation-circle"></i> Error');
				 
				//console.log(data);
				})
		}
	if(flag=='inv_pay'){
		holder_array=[];
		$('tr.due_h').each(function(index, element) {
			inv_id		=$(this).find('.inv_id').text();
			amount		=$(this).find('.cpl').val();
			pro_name	=$(this).find('.pro_name').text(); 
			
			object 		= {'inv_id':inv_id,'pro_name':pro_name,'amount':amount}
			holder_array[index]=(object);
        	});
		json=JSON.stringify(holder_array); 
		$.post('<?php echo bu('doctor/ajax_add_advance_by_invoice');?>',{  
			patient_id:patient_id, 
			clinic_id:clinic_id,
			note:$('.note').val(),
			mode:$('#inv_mode').val(),
			recept_no:$('#recept_no').val(),
			p_date: $('#p_date').val(), 
			json:json
				},function(data){ 
				console.log(data);
				if(data==1) {self.html('<i class="fa fa-fw fa-check"></i> Saved').removeAttr('onClick')
				window.location.href='<?php  echo (bu('doctor/payment/'.$patient_data->id));?>';
				}
				else 		self.html('<i class="fa fa-fw fa-exclamation-circle"></i> Error');
				 
				//console.log(data);
				})
		}
	
	
	
	} 
	
$(document).ready(function(e) {  
	$('.bi').click(function(e) {
        $('.bi,.mono').toggle();
		attach_inv();
    });

	$('.tab_footer').width($('#tab_1-1').width()+20);
	$(document).resize(function(e) {
		 $('.tab_footer').width($('#tab_1-1').width()+20);	
	});
	
	$('.pointers').click(function(e) {
		attach_object($(this).attr('data-q'),$(this).attr('data-price'),$(this).attr('data-speciality'));
		});
	attach_inv();
	});
 
 
 
function deattach_object(self){
	parent=self.parent().parent();
	index_id_f=parent.attr('data-index_id_f');
	$('*[data-index_id="'+index_id_f+'"]').removeClass('inv_selected'); 
	attach_inv();
	}

	
$(document).on('click','.inv_box',function(){
	$(this).toggleClass('inv_selected');
	attach_inv();
	});

$(document).on('keyup change','.cpl',function(){
	if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')
	calculate_after_pay();
	total_payable(); 
	});
	
	
function calculate_after_pay(){
	
	//Find all the .cpl
	$('.cpl').each(function(index, element) {
		parent=$(this).closest('.due_h');
		paid_h=parent.find('.paid_h').text();
		due_h=parent.find('.due_h').text();
		parent.find('.dap').text(due_h-$(this).val());
		 
	});
	
	
	}
			
function attach_inv(){  

if($('.inv_selected').length>0) {
	$('#bar_holder,.payment_only').hide(0);
	$('.inv_only').show(0);
	$('#helper_flag').val('inv_pay'); 
	}
	
else {
	$('#bar_holder,.payment_only').show(0);
	$('.inv_only').hide(0);
	$('#helper_flag').val('advance'); 
	
	}
$('.inv_box').show(0);
$('.inv_selected').hide(0);
html='';
$('.inv_selected').each(function(index, element) { 
	
	html+='<tr data-index_id_f="'+$(this).attr('data-index_id')+'" class="due_h">';
	 html+='<td>';
		html+='<strong class="inv_id">'+$(this).attr('data-inv_no')+'</strong>';
		html+='<br>';
		html+=$(this).attr('data-date');
	 html+='</td>';
	 html+='<td>';
		html+='<strong class="pro_name">'+$(this).attr('data-procedure_name')+'</strong>';
	 html+='</td>';
	 html+='<td>';
		html+=$(this).attr('data-price');
	 html+='</td>';
	 
	 html+='<td class="due_h">';
		html+=$(this).attr('data-due') ;
	 html+='</td>';
	 
	  html+='<td class="paid_h">';
		html+= $(this).attr('data-paid') ;
	 html+='</td>';
	 
	  html+='<td>';
		html+= '<input type="number" max="'+$(this).attr('data-due')+'" class="form-group cpl" pattern="[0-9]*" value="'+$(this).attr('data-due')+'" >' ;
	 html+='</td>';
	 
	  html+='<td>';
		html+= '<i class="fa fa-inr"></i><strong class="dap"></strong>' ;
	 html+='</td>';
	 
	  html+='<td>';
		html+= '<i class="fa fa-times close_me" onclick="deattach_object($(this))"></i>' ;
	 html+='</td>';
	html+='</tr>';
});
$('#inv_holder').html(html);

calculate_after_pay();
total_payable(); 
}

function total_payable(){
sum=0;
$('td.due_h').each(function(index, element) {
	sum+=parseInt($(this).text()); 
	 }); 
$('#total_payable').html('<i class="fa fa-inr"></i>'+sum);

sum=0;
$('.cpl').each(function(index, element) {
	sum+=parseInt($(this).val()); 
	 }); 
$('#total_payment').html(sum);
total=sum;

sum=0;
$('.dap').each(function(index, element) {
	sum+=parseInt($(this).text()); 
	 }); 
$('#total_due').text(sum);


$('#bafter_p').text(<?php echo $balence;?>+total);

 
}
				
		 
</script>
<input type="hidden" id="helper_flag" value="advance" />
 
<?php 
$inv_ids=array();
$inv_id_list=array();
$inv_ids[]=@$this->session->userdata('inv_id'); 
if(!empty($this->session->userdata('inv_id_list'))){
	$inv_id_list=explode('-::-',$this->session->userdata('inv_id_list'));
	}
$inv_ids=array_filter(array_unique(array_merge($inv_ids,$inv_id_list)));
//var_dump($this->session->userdata);
//clear the user data
$this->session->unset_userdata('inv_id');
$this->session->unset_userdata('inv_id_list');
 
?>
  <div class="col-sm-8 col-xs-12 no-pad">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs ">
        <li class=" header"><i class="fa fa-money"></i> Add Fund
        </li> 
        <a href="" class="btn btn-default btn-sm pull-right disabled btn-flat" style="margin:5px">Add Fund</a>
        <a href="<?php echo bu('doctor/refund_invoice/'.$patient_data->id);?>" class="btn btn-flat btn-success btn-sm pull-right" style="margin:5px">Refund</a>
      </ul>
      <div class="tab-content">
      

        <div class="tab-pane active" id="tab_1-1" style="height:67vh; overflow:auto; overflow-x:hidden">
        <div class="box box-solid bg-yellow payment_only">
            <div class="box-header" style="color: #000;">
                <h3 class="box-title" style="display:inherit; float:none">
                <div class="col-xs-2" style="margin-top: 8px;">
                PAY NOW
                </div>
                <div class="col-xs-3 no-pad">
                <input type="number" class="form-control amount" value="0" min="0"></div>
                <div class="col-xs-3 no-pad">
                	 <select class="form-control mode">
                        <option>Cash</option>
                        <option>Cheque</option>
                        <option>Card</option>
                    </select>
                </div> 
                <small >*This will be an advance payment</small>
               
                </h3>
            </div>
            <div class="box-body">
            </div><!-- /.box-body -->
        </div>
        <div class="inv_only" style="display:none">
        <table class="table table-bordered" style="margin-bottom:5px">
        	<thead>
            	<tr>
                	<th>INVOICE NO</th>
                    <th>PROCEDURES</th>
                    <th>TOTAL</th>
                    <th>DUE (<i class="fa fa-inr"></i>)</th>
                    <th>PAID (<i class="fa fa-inr"></i>)</th>
                    <th>PAY NOW (<i class="fa fa-inr"></i>)</th>
                    <th>DUE AFTER PAYMENT (<i class="fa fa-inr"></i>)</th>
                    <th></th>
                </tr>
            	
            </thead>
            <tbody id="inv_holder">
            	
            </tbody>
        </table>
        <div class="row">
        	<div class="col-xs-5 doted-border">
            	TOTAL PAYABLE:  <span class="badge pull-right bg-red" id="total_payable"> 0</span>
            </div>
            <div class="col-xs-2 doted-border"></div>
            <div class="col-xs-5 doted-border">
            	AVAILABLE ADVANCE: 
                
                <small class="badge pull-right 
               
               <?php
			   $balence=0; 
			   $sql="SELECT * FROM payment WHERE patient_id=".@$patient_data->id." AND clinic_id=".$this->session->userdata('primary');
			   $payment=$this->db->query($sql)->result();
			   if(isset($payment[0])) {
				   $payment=$payment[0];
			   	   $balence=$payment->balence;
			   }
			   ?>
               <?php 
			   $abs_balence=abs($balence);
			   if($balence<0)echo ' bg-red ';
			   else echo ' bg-green';
			   ?>
               " ><i class="fa fa-inr" ></i> <?php echo $abs_balence?> <?php  
			   if($balence<0)echo '(Due)';
			   else if($balence>0) echo '(Adv)';?>
               </small> 
            </div> 
            <br clear="all" />
            <div style="background:#FFFAC3;padding: 5px; margin:0" class="doted-border row"> 
            	<div class="col-xs-5">TOTAL:</div> 
                <div class="col-xs-2"></div>
            	<div class="col-xs-2"><i class="fa fa-inr"></i> <span id="total_payment">0</span></div> 
                <div class="col-xs-2">
                	<select class="form-control" id="inv_mode" style="height: 25px;padding: 0 12px;">
                        <option>Cash</option>
                        <option>Cheque</option>
                        <option>Card</option>
                    </select>
                </div>
                <div class="col-xs-1"></div>
                 
            	<div class="col-xs-5">TOTAL DUE AFTER PAYMENT:</div> 
                <div class="col-xs-2"></div>
            	<div class="col-xs-5"><i class="fa fa-inr"></i> <span id="total_due">0</span></div> 
                
                <div class="col-xs-5">BALENCE AFTER PAYMENT:</div> 
                <div class="col-xs-2"></div>
            	<div class="col-xs-5"><i class="fa fa-inr"></i><span id="bafter_p">0</span> </div> 
                
            	
            </div> 
            
            
            
        </div>
        
        </div>  
        
        <p class="pull-right noselect" style="cursor:pointer" onclick="$(this).next().slideToggle(200)" >+Add note</p>
        <textarea class="form-control note" rows="2" placeholder="Additional Notes" style="display:none"></textarea>
        
        <div class="taber_header col-xs-12 no-pad">
          <div class="col-xs-4 no-pad">TREATMENT</div>
              <div class="col-xs-8 no-pad">
                <div class="col-xs-4 no-pad" align="center">QTY &nbsp;&nbsp;&nbsp;&nbsp; X &nbsp;&nbsp;&nbsp;&nbsp;	COST</div>
                <div class="col-xs-4 no-pad" align="center">DISCOUNT</div>
                <div class="col-xs-4 no-pad" align="right">TOTAL(<i class="fa fa-wa fa-inr"></i>)</div>
              </div>
           </div>
           <div id="bar_holder">
           <button id="sacrificer" class="btn btn-default btn-flat disabled" style="margin:80px auto; display:block">
            	You can also select pending invoice(s) from the right
            </button>
           </div>
        	
            
            
            
        </div>
        <!-- /.tab-pane --> 
        
      </div>
      <!-- /.tab-content --> 
    </div>
    <!--Footer -->
   <div class="tab_footer bg-primary">  
   		<div class="col-xs-6 no-pad" style="margin-top: 5px;" > 
        	Receipt No: 
            <span class="mono"><u>Auto generated </u></span>
            <span class="mono" style="display:none"><input id="recept_no" placeholder="Recept #" type="text" style="color:#000"/></span>
            
            <button class="btn btn-xs btn-default bi" style="margin:0 10px"> Edit </button>
            <button class="btn btn-xs btn-default bi" style="margin:0 10px; display:none"> Auto generate </button>
        </div>
        <div class="col-xs-6 no-pad" style="margin-top: 5px;" > 
        	Payment Date: 
            <input class="datepicker ll-skin-siena" data-date-format="dd/mm/yyyy" style="color:#000; height:23px" id="p_date" value="<?php echo date('d/m/Y');?>">
             
        </div>
      
   </div>
    <!--/Footer --> 
  </div>
  <div class="col-sm-4 col-xs-12 no-pad">
    <div class="box" style="height:81vh; ">
        <div class="box-header" data-toggle="tooltip" title="" data-original-title="Procedures ( in INR )">
            <h3 class="box-title">Pending Invoice</h3>
           <button class="btn btn-primary btn-xs pull-right" style="margin:5px" onclick="$(this).parent().next().next().slideToggle(200);"><i class="fa fa-plus"></i> Add </button> 
            
        </div>
        
            <hr /> 
        <div class="box-body"> 
        
        <?php 
		$invoice_data=$invoice_data;
		foreach($invoice_data as $a=>$b):  ?>
        
        	 <div class="box box-solid bg-primary inv_box <?php if(in_array(@$b->id,$inv_ids)) echo  ' inv_selected'; ?>" data-price="<?=@$b->price?>" data-date="<?=@$b->date?>" data-inv_no="<?=@$b->id?>"  
               data-procedure_name="<?=@$b->procedure_name?>"
               data-amount=" <?=@$b->price+@$b->tax-@$b->discount?>" 
               data-paid=" <?=@$b->paid?>" 
               data-due="<?=@$b->price+@$b->tax-@$b->discount-@$b->paid?>"
               data-index_id="<?=$a?>"
               >
               
                <div class="box-header">
                    <h3 class="box-title">
                    <span><?=@$b->id?></span>
                    <span class="pull-right"><?=@$b->date?></span>
                    </h3>
                    
                </div>
                <div class="box-body">
                    <strong>
                        <span><?=@$b->procedure_name?></span>
                        <span class="pull-right"></span>
                    </strong>
                    <hr />
                    <div>
                        <span>Invoice amount</span>
                        <span class="pull-right"><i class="fa fa-inr"></i> <?=@$b->price+@$b->tax-@$b->discount?></span>
                    </div>
                    <div>
                        <span>Paid amount</span>
                        <span class="pull-right"><i class="fa fa-inr"></i> <?=@$b->paid?></span>
                    </div>
                    <hr />
                    <strong>
                        <span>Amount Due</span>
                        <span class="pull-right"><i class="fa fa-inr"></i><?=@$b->price+@$b->tax-@$b->discount-@$b->paid?></span>
                    </strong>
                    
                </div><!-- /.box-body -->
            </div>
               
       
       
       <?php endforeach;?>
             
            
                            
            
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
 