<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" media="print" src="<?php echo bu('style/print_stylesheet.css');?>" />
<script type="text/javascript"   src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script   src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link id="page_favicon" href="http://localhost/doctorchachu/images/fav.png" rel="icon" type="image/x-icon">
<title>
<?=@$page_title;?>
</title>
<?php 
$printer_data=json_decode($printer_data,true);
$paper_size=@$printer_data['paper_size'];
$ps='A4';
switch($paper_size){
	case('1'): $ps='A4'; break;
	case('1'): $ps='A5'; break;
	case('1'): $ps='B4'; break;
	case('1'): $ps='B5'; break;
	case('1'): $ps='LETTER'; break;
	}
$orientation=@$printer_data['orientation'];
$p_type=@$printer_data['p_type'];

?>
<style>
.mms{  width: 30%;  display: block;  float: left;}
.sp{ display:block !important}
.spt{ display:run-in}
#print_logo {
	max-height: 3cm;
}
  .print_header,.p_details {
	border-bottom: 1px solid #999
}
@page {
 size:<?=$ps;
?> <?=$orientation;
?>;
 margin-top:		<?=@$printer_data['top_margin'];
?>cm;
 margin-bottom:	<?=@$printer_data['bottom_margin'];
?>cm;
 margin-left:	<?=@$printer_data['left_margin'];
?>cm;
 margin-right:	<?=@$printer_data['right_margin'];
?>cm;
}
.p_data {
	padding: 30px
}
.print_footer {
	font-size: 14px
}
<?php if($p_type!='color') echo '* {
filter: grayscale(100%);
-webkit-filter: grayscale(100%);
filter: gray;
filter: grayscale(100%);
filter: url(desaturate.svg#greyscale);
}
';
?>  .np {
display:none
}
.p_data table tr th {
	border: 1px solid;
	border-top: 1px solid !important
}
.p_data table tr td {
	border: 1px solid 
}
#main_container {
	width: 98%;
	margin: 0 auto;
	padding: 1%;
}
<?php if($dot_matrix) echo '#main_container{width:70%; margin:0 auto; padding:1%;  }';
?>
table{ 
    width: 100%;
}
.table{ margin-bottom:0;}
.first_show{ display:none} 
.first_show:first-of-type { display:block}
.inv_t tr th,.inv_t tr td{ width:10%}
.inv_t tr th,.inv_t tr td:nth-child(2){ width:30%} 
</style>
</head>

<body>
<div  id="main_container">
  <div class="print_header" align="center" <?php if(@$printer_data['include_header']==0) echo 'style="display:none"';?>>
 <table  class="print_header_table">
  <tr>
    <td rowspan="3" style="width:20%">
    	 <?php if(@$printer_data['include_logo']==1):
			$logo_src=''; 
			if(file_exists(('clinic_images/'.$this->session->userdata('primary').'/logo.jpg'))){
				$logo_src=bu('clinic_images/'.$this->session->userdata('primary').'/logo.jpg');
				echo '<img src="'.$logo_src.'" id="print_logo" ';
				if(@$printer_data['p_type']=='black_and_white') echo ' class="desaturate" ';
				echo '>';
				}
			?>
    <?php endif;?>
    </td> 
  </tr>
  <tr>
    <td colspan="2"><h3 style="margin:0"><?php echo @$printer_data['header_text'];?></h3></td>  
  </tr>
  <tr>
  <td style="width:38%; margin: 0 1%"><?php echo @$printer_data['left_text'];?></td> 
    <td style="width:58%; margin: 0 1%"><?php 
	$text=str_replace('Phone','<img src="'.bu('images/phone.jpg').'"> Phone',@$printer_data['right_text']);
	echo $text=str_replace('Email','<img src="'.bu('images/email.jpg').'"> Email',$text);
	?></td>
    
  </tr>
</table>
   
     <br />
  </div>
  <div class="p_details row" <?php if(@$printer_data['show_p_details']==0) echo 'style="display:none"';?>>
    <table>
      <tr>
        <td style="width:48%; padding-right:2%; text-align:right">
		<?=@$patient_data->name;
		$optional_id=(@$patient_data->optional_id);
		$optional_id=json_decode($optional_id,true);
		$doc_id=$this->session->userdata('id');
		if(!empty($optional_id[$doc_id])) echo '(ID:'.@$optional_id[$doc_id].')';
		?>
          <br>
           <?php 
			$gender='';
			if($patient_data->gender=='M') $gender='MALE';
			if($patient_data->gender=='F')  $gender='FEMALE';
			?>
      <span <?php if($printer_data['ex_p_gender_dob']==1) echo 'style="display:none"'?>>
      <?=$gender?>
      , <?php echo get_dob($patient_data); ?></span> <br>
          <span <?php if(in_array('phone',$printer_data['exclude'])) echo 'style="display:none"'?>>
          <?='<img src="'.bu('images/phone.jpg').'"> '.@$patient_data->phone?>
          </span> <br>
          <?php 
			$medical_history=@$patient_data->medical_history;
			$medical_history=json_decode($medical_history,true);
			$medical_history=@$medical_history[$this->session->userdata('id')];
			?>
            <div <?php if(in_array('blood_group',$printer_data['exclude'])) echo 'style="display:none"'?>><strong>Blood Group :</strong>
      <?=$patient_data->blood_group?>
      </div> 
          </td>
        <td style="width:48%; padding-left:2%">
       <span <?php if(in_array('medical_history',$printer_data['exclude'])) echo 'style="display:none"'?>><strong>
          <?php if(sizeof(@$medical_history)): ?> 
          Medical History</strong>:
          <?=implode(',',@$medical_history);?>
          <?php endif;?>
          </span>
      
      <?php $address='';?>
      <div <?php if(in_array('address',$printer_data['exclude'])) echo 'style="display:none"'?>>
      <?php if(!empty($patient_data->locality)) $address.= $patient_data->locality.',';?>
      <?php if(!empty($patient_data->street)) $address.=  $patient_data->street.',';?>
      <?php if(!empty($patient_data->city)) $address.=  $patient_data->city.',';?>
      <?php if(!empty($patient_data->pin)) $address.=  $patient_data->pin;?>
      <?php if(!empty($address)) echo '<strong>Address</strong> :'.$address?>
      </div> 
      <div <?php if(in_array('email',$printer_data['exclude'])) echo 'style="display:none"'?>> 
      <?php if(!empty($patient_data->email)) echo '<img src="'.bu('images/email.jpg').'" > '.@$patient_data->email;?>
      </div>  
        
        </td>
      </tr>
    </table>
     
      
  </div>
  <div class="p_data row" >
    <div class="row">
      <div class="col-xs-6"> <strong><?php echo ucfirst(str_replace('_',' ',$print_type))?></strong> </div>
      <div class="col-xs-6" align="right"><strong>Date:<?php echo date('d/m/Y');?></strong></div>
    </div>
    <?php  
	$primary=$this->session->userdata('primary');
	$sql="SELECT * FROM payment WHERE patient_id=$pid and clinic_id=$primary limit 1";
	$result=$this->db->query($sql)->result();
	$result=@$result[0];
	$json=json_decode(@$result->json,true);
	if($print_payment_history==1): 
	?>
    <table class="table table-striped"> 
    	<thead>
        	<tr>
            	<th>Date</th>  
                <th>Towards</th> 
                <th>Amount</th>
                <th>Mode</th>
                <th>Recept#</th>
            </tr>
        	
        </thead>
        <tbody>
	<?php foreach($json as $a=>$b): 
			foreach($b as $c=>$d): 
	?>
    	<?php if(@$d['amount']>0):?>
    	<tr>
        	<td><?=str_replace('-','/',$a);?></td> 
            <td><?=@$d['towards']?></td>  
            <td><?=@intval($d['amount'])?></td>
            <td><?=ucfirst(@$d['mode']);?></td>
            <td><?=@$d['recept_no']?></td> 
        </tr>
        <?php endif;?>
     <?php  endforeach;?>	
    <?php  endforeach;?>
    </tbody>	
    </table>
	<?php
	
	else: echo $data;
	
	endif;
	
	?> 
    <?php if($print_type=='invoice'):
	//Get the payment history of the patient
	?>
    <h5><strong>Payment Details</strong></h5>
    <?php 

	//var_dump($json);?> 
    <table class="table table-striped">
    	<thead>
        	<tr>
            	<th>Total Cost</th>
                <th>Total Discount</th>
                <th>Grand Total</th>
                <th>Amount Received</th>
                <th>Balence Amount</th> 
            </tr>
        </thead>
        <tbody>
        <?php  
		$inv_ids=$this->input->post('inv_ids');
		$inv_ids_array=array_filter(explode(',',$inv_ids));
		$inv_ids=rtrim($inv_ids,',');
		$sql="SELECT * FROM invoice WHERE id in ($inv_ids)";
		$res=$this->db->query($sql)->result();
		
		$total_cost=0;
		$total_discount=0;
		$received=0;
		foreach($res as $a=>$b){
			$total_cost+=$b->price;
			$total_discount+=$b->discount;
			$received+=$b->paid;
			
			}
		
		 
		
		?>
        <tr>
        
        	<td><?=$total_cost?></td>
            <td><?=$total_discount?></td>
            <td><?=($total_cost-$total_discount);?></td>
            <td> <?=$received; ?>
            </td>
            <td>
			<?php 
			$balence=$payment_data->balence;
			if($balence<0) $post_fix='(Due)';
			else $post_fix='(Adv)';
			echo abs(intval($balence));
			echo $post_fix;
			
			?>
			 </td>
        </tr>
        
        </tbody>
    	
    </table>
    <h5><strong>Payment History</strong></h5>
    <table class="table table-striped"> 
    	<thead>
        	<tr>
            	<th>Date</th>  
                <th>Towards</th> 
                <th>Amount</th>
                <th>Mode</th>
                <th>Recept#</th>
            </tr>
        	
        </thead>
        <tbody>
	<?php foreach($json as $a=>$b): 
			foreach($b as $c=>$d): 
	?>
    	<?php if(@$d['amount']>0):?>
    	<tr>
        	<td><?=str_replace('-','/',$a);?></td> 
            <td><?=@$d['towards']?></td>  
            <td><?=@intval($d['amount'])?></td>
            <td><?=ucfirst(@$d['mode']);?></td>
            <td><?=@$d['recept_no']?></td> 
        </tr>
        <?php endif;?>
     <?php  endforeach;?>	
    <?php  endforeach;?>
    </tbody>	
    </table> 
     
	<?php endif;?>
    </div>
  <div class="print_footer row">
    <div class="footer_top_margin" style="height:<?php echo @$printer_data['footer_margin']?>cm"></div>
    <div class="col-xs-12"><?php echo @$printer_data['footer_content']?></div>
    <div class="col-xs-6"><?php echo @$printer_data['left_sign']?></div>
    <div class="col-xs-6" align="right"><?php echo @$printer_data['right_sign']?></div>
  </div>
</div>
<?php  

//echo generate_print_html_by_name($print_type);
//var_dump($data);
//var_dump($_POST);?>
</div>
<script>
$(document).ready(function(e) {
	<?php if(!$dot_matrix) echo ' window.print();';?>
    
});
</script> 
<!--
<button class="btn btn-primary" onclick="window.print();">Print this</button>-->
</body>
</html>