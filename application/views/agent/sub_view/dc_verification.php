<style>
.callout.callout-success { 
  color: #3c763d;
  background-color: #dff0d8;
  border-color: #d6e9c6;
}
.callout { 
  padding: 7px 15px 7px 15px; margin:0}
 .callout-danger{ color:#A42121}
 .dc_plan{ zoom:1.3;}
 .inhid{ display:none;  float: right;}
</style>
<script>
	$(document).ready(function(e) {
        $.post('<?php echo bu('agent/dc_verified_list');?>',{'did':<?=$did;?>},function(data){ 
			$('.dc_ver_holder').html(data);
			});
    });
</script>
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
  <div class="col-lg-12">
     
    <ol class="breadcrumb">
      <li class="active"> <i class="fa fa-dashboard"></i> Dashboard </li>
      <li class="active"> <i class="fa fa-plus"></i> DC Verification</li>
      
      	  
     
    </ol>
  </div>
    <div class="container-fluid">
     <?php display_msg($this->session->flashdata('messages'),$this->session->flashdata('success'));?>
    	<div class="dc_ver_holder">
        <div align="center" style="margin-top:100px">
        <img src="<?php echo bu('images/ajax-loader.gif');?>">
        </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(e) {
    show_hide_label();
});
 
function show_hide_label(){
	$('.inhid').hide();
	$('.dc_plan:checked').next().next().next().show();
	}
	
function calculate_total(coupon){
	amount=$('.dc_plan:checked').val();
	period=$('.dc_plan:checked').attr('data-period');
	total=amount*parseInt(period); 
	$('#coupon_operator').attr('data-amount',amount).attr('data-period',period).attr('data-total',total);
	 
	if(coupon!=undefined){
		console.log(3);
		}
	show_hide_label();
	}
function validate_coupon(self){
	 self.html('<img src="<?php echo bu('images/ajax_rt.gif');?>"> Apply');
	 parent=self.closest('#coupon_operator');
	 coupon=parent.find('#coupon').val();
	 total=parent.attr('data-total'); 
	 
	 $.post('<?php echo bu('agent/validate_coupon');?>',{'coupon':coupon,'total':total},function(data){
		 $('#coupon_text').html(data); 
		 calculate_total(coupon);
		 self.html('Apply');
		 });
	 }
 
</script>

<!-- Modal -->
<div class="modal fade" id="selectPlan" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select DC Verification Period</h4>
      </div>
      <div class="modal-body"> 
       <input type="radio" class="dc_plan simple" onChange="calculate_total()" data-period="1m" name="dc_plan" value="500" checked> <label>1 Month</label> <i class="fa fa-inr"></i> 500 per Month
       <div class="callout callout-info inhid">Total: <i class="fa fa-inr"></i> 500</div>
       <br>
        
       <input type="radio" class="dc_plan simple" onChange="calculate_total()" data-period="6m"  name="dc_plan" value="400"> <label>6 Month</label> <i class="fa fa-inr"></i> 400 per Month
        <div class="callout callout-info inhid">Total: <i class="fa fa-inr"></i> 2400</div>
        <br>
       <input type="radio" class="dc_plan simple" onChange="calculate_total()" data-period="12m"  name="dc_plan" value="350"> <label>12 Month</label> <i class="fa fa-inr"></i> 350 per Month
        <div class="callout callout-info inhid">Total: <i class="fa fa-inr"></i> 4200</div>
        <br>
       <hr>
       <div id="coupon_operator">
       <input type="text" class="form-control" id="coupon" style="width:40%;  float: left;" placeholder="Coupon">
       <button class="btn btn-info btn-sm btn-flat" style="  height: 34px;width: 80px; " onClick="validate_coupon($(this))">Apply</button>
      	<hr>
       <div id="coupon_text" ></div>
         
       </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success"><i class="fa fa-money"> </i> Pay Now</button>
      </div>
    </div>
  </div>
</div>


<!-- ---------------------------------------------------- -->
