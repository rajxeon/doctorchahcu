
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
.sp{ display:block !important}
.spt{ display:run-in}
 
.print_header, .p_details {
	border-bottom: 1px solid #999
}
 
.p_data {
	padding: 30px
}
.print_footer {
	font-size: 14px
}
.np {
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

table{ 
    width: 100%;
} 
</style>
<div  id="main_container" style="max-width:700px; margin:0 auto; text-align:center">
  <div class="print_header" align="center" <?php if(@$printer_data['include_header']==0) echo 'style="display:none"';?>>
    <h3><?php echo @$printer_data['header_text'];?></h3>
    <table style="width:100%">
      <tr>
        <td style="width:48%; padding-right:2%; text-align:right"><?php echo @$printer_data['left_text'];?></td>
        <td style="width:48%; padding-left:2%"><?php echo @$printer_data['right_text'];?></td>
      </tr>
    </table>
  </div>
  
  <div class="p_data row" >
    <div class="row">
      <div class="col-xs-6"> <strong><?php echo ucfirst(str_replace('_',' ',$print_type))?></strong> </div>
      <div class="col-xs-6" align="right"><strong>Date:<?php echo date('d/m/Y');?></strong></div>
    </div>
    <?php echo $data;?> 
    </div>
  
</div>
 