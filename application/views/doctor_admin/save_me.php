 
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
h3{text-align:center}
#print_logo {
	max-height: 3cm;
}
.print_header, .p_details {
	border-bottom: 1px solid #999
}
 
.p_data {
	padding: 30px
}
.print_footer {
	font-size: 14px
}
  .np,.np * {
display:none;
font-size:0.1px;
color:#fff;
zoom:.001; opacity:0; padding:0; margin:0; border:0;
}
.np img{ zoom:.1}
.table-condensed tr:nth-child(odd){ 
background-color:#ccc;
	border: 1px solid !important
} 
.table-condensed tr th{ border:1px dotted; background:#FFF}
#main_container {
	width: 98%;
	margin: 0 auto;
	padding: 1%;
}
table,table tr{ width:100%;}
</style>
</head>

<body>
<div  id="main_container">
  <div class="print_header" align="center" <?php if(@$printer_data['include_header']==0) echo 'style="display:none"';?>>
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
    <h3><?php echo @$printer_data['header_text'];?></h3>
    <table>
      <tr>
        <td style="width:45%; padding-right:5%; text-align:right"><?php echo @$printer_data['left_text'];?></td>
        <td style="width:45%; padding-left:5%"><?php echo @$printer_data['right_text'];?></td>
      </tr>
    </table>
  </div>
  <div class="p_details row" <?php if(@$printer_data['show_p_details']==0) echo 'style="display:none"';?>>
    <table>
      <tr>
        <td style="width:45%; padding-right:5%; text-align:right"><?=@$patient_data->name?>
          <br>
          <span <?php if(in_array('phone',$printer_data['exclude'])) echo 'style="display:none"'?>>
          <?=@$patient_data->phone?>
          </span> <br>
          <?php 
			$medical_history=@$patient_data->medical_history;
			$medical_history=json_decode($medical_history,true);
			$medical_history=@$medical_history[$this->session->userdata('id')];
			?>
          <span <?php if(in_array('medical_history',$printer_data['exclude'])) echo 'style="display:none"'?>><u>Medical History</u>:
          <?=implode(',',@$medical_history);?>
          </span></td>
        <td style="width:45%; padding-left:5%">
        <?php 
			$gender='';
			if($patient_data->gender=='M') $gender='MALE';
			if($patient_data->gender=='F')  $gender='FEMALE';
			?>
      <span <?php if($printer_data['ex_p_gender_dob']==1) echo 'style="display:none"'?>>
      <?=$gender?>
      , <?php echo get_dob($patient_data); ?></span> <br>
      <span <?php if(in_array('blood_group',$printer_data['exclude'])) echo 'style="display:none"'?>><u>Blood Group :</u>:
      <?=$patient_data->blood_group?>
      </span> <br>
      <span <?php if(in_array('address',$printer_data['exclude'])) echo 'style="display:none"'?>>
      <?=$patient_data->locality;?>
      ,
      <?=$patient_data->street;?>
      ,
      <?=$patient_data->city;?>
      ,
      <?=$patient_data->pin;?>
      </span> <br>
      <span <?php if(in_array('email',$printer_data['exclude'])) echo 'style="display:none"'?>>
      <?=$patient_data->email;?>
      </span>  
        
        </td>
      </tr>
    </table>
     
      
  </div>
  <div class="p_data row" >
    <div class="row">
      <div class="col-xs-6"> <strong><?php echo ucfirst(str_replace('_',' ',$print_type))?></strong> </div>
      <div class="col-xs-6" align="right"><strong>Date:<?php echo date('d/m/Y');?></strong></div>
    </div>
    <?php echo $data;?> </div>
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

<!--
<button class="btn btn-primary" onclick="window.print();">Print this</button>-->
</body>
</html>