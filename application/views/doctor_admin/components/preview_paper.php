<style>
.preview_text{position: absolute;right: 10px;}
.paper{ background:#FFF;max-height: 700px;	min-height: 700px;	overflow: auto;	overflow-x: hidden;	border: 1px solid #CCC;}
.header_margin,.footer_margin,footer_top_margin{ height:0px;}
.left_margin,.right_margin{ width:0px}
#print_logo{ max-height:2cm;}
.print_header,.p_details{ border-bottom:1px solid #999}
.print_footer{ font-size:14px}
h3{ margin:0}
img.desaturate { -webkit-filter: grayscale(100%); filter: grayscale(100%); }
table{ width:100%}


[data-wysihtml5-command="insertUnorderedList"],
[data-wysihtml5-command="insertOrderedList"],
[data-wysihtml5-command="Outdent"],
[data-wysihtml5-command="Indent"],
[data-wysihtml5-command="createLink"],
[data-wysihtml5-command="insertImage"]{ display:none}
.p_data{ padding:30px}
pre{ padding:0; background:none; text-decoration:underline; font-size:12px; border:none}
.total_summary tr td{height: 2px;}
</style>
<script>

</script>

<?php 
if(empty($json)) $json=array();
$json=json_decode($json,true);
if(!is_array($json['exclude']))$json['exclude']=array();
?>

<div class="col-sm-7 col-xs-12 paper no-pad">
<button class="btn btn-default btn-flat preview_text">Preview</button>
<div class="header_margin" style="height:<?php echo @$json['top_margin']?>cm"></div>

<table>
	<tr>
    	<td class="left_margin" style="width:<?php echo @$json['left_margin']?>cm"></td>
        <td>
        	<!--This is the main content -->
        	<div class="print_header" align="center" <?php if(@$json['include_header']==0) echo 'style="display:none"';?>>
            <?php if(@$json['include_logo']==1):
			$logo_src=''; 
			if(file_exists(('clinic_images/'.$this->session->userdata('primary').'/logo.jpg'))){
				$logo_src=bu('clinic_images/'.$this->session->userdata('primary').'/logo.jpg');
				echo '<img src="'.$logo_src.'" id="print_logo" ';
				if(@$json['p_type']=='black_and_white') echo ' class="desaturate" ';
				echo '>';
				}
			?>
            
            <?php endif;?>
            	<h3><?php echo @$json['header_text'];?></h3>
                <table>
                	<tr>
                    	<td style="width:48%; padding-right:2%; text-align:right"><?php echo @$json['left_text'];?></td>
                        <td style="width:48%; padding-left:2%"><?php echo @$json['right_text'];?></td>
                    </tr>
                </table> 
            </div> 
            <div class="p_details row" <?php if(@$json['show_p_details']==0) echo 'style="display:none"';?>>
            	<div class="col-xs-5"> 
                	Mrs. Geethalakshmi
                    <br>
                    <span <?php if(in_array('phone',$json['exclude'])) echo 'style="display:none"'?>>+919900990099</span>
                    <br>
                    <span <?php if(in_array('medical_history',$json['exclude'])) echo 'style="display:none"'?>><u>Medical History</u>: HyperTension</span>
                </div>
                <div class="col-xs-7">
                	<span <?php if($json['ex_p_gender_dob']==1) echo 'style="display:none"'?>>Female, 29 Years</span>
                    <br>
                    <span <?php if(in_array('blood_group',$json['exclude'])) echo 'style="display:none"'?>><u>Blood Group :</u>: A+</span>
                    <br>
                    <span <?php if(in_array('address',$json['exclude'])) echo 'style="display:none"'?>>4th Floor, Abhaya Heights, Bannerghatta, Bangalore</span>
                    <br>
                    <span <?php if(in_array('email',$json['exclude'])) echo 'style="display:none"'?>>rajxeon@gmail.com</span>
                </div>
            
        </div>
        <div class="p_data row" >
        
        <?php echo $dummy_html;?>
        </div>
        
        <div class="print_footer row">
        	<div class="footer_top_margin" style="height:<?php echo @$json['footer_margin']?>cm"></div>
            <div class="col-xs-12"><?php echo @$json['footer_content']?></div>
            <div class="col-xs-6"><?php echo @$json['left_sign']?></div>
            <div class="col-xs-6" align="right"><?php echo @$json['right_sign']?></div>
        </div>
        
        </td>
        <td class="right_margin" style="width:<?php echo @$json['right_margin']?>cm"></td>
    </tr>
</table>
<div class="footer_margin" style="height:<?php echo @$json['bottom_margin']?>cm"></div>

</div> 