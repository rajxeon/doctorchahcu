<?php display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));?>
<?php 

$json=json_decode($json,true);
//var_dump($json);
$this->load->helper('form');
?>
<div class="tab-content">

              <div class="tab-pane active" id="prescription">
                <div class="row" style="margin:0">
                  <div class="col-sm-5 col-xs-12 "> 
                    <center>
                      <div class="btn-group">
                        <button type="button" class="btn btn-info tabber" data-t="prescription_page_setup">Page Setup</button>
                        <button type="button" class="btn btn-default tabber" data-t="prescription_header">Header</button>
                        <button type="button" class="btn btn-default tabber" data-t="prescription_patient">Patient</button>
                        <button type="button" class="btn btn-default tabber" data-t="prescription_footer">Footer</button>
                      </div>
                    </center>
                    <div class="tab_content">
                      <div data-s="prescription_page_setup" class="ini_hidden" style="display:block">
                        <h4 >PAGE SETUP</h4>
                        <hr>
                        <div class="form-group">
                          <label>Paper Size:</label>
                          <?php 
						  $options = array('A4','A5','B4','B5','LETTER');
						  echo form_dropdown('', $options, @$json['paper_size'], 'class="form-control" id="paper_size"');
						  ?>
                          
                        </div>
                        <div class="form-group">
                          <label>Orientation:</label>
                          <br>
                          <?php  
						  if($json['orientation']=='')
						  echo form_radio('orientation', 'portrait', TRUE,'class="simple orientation"'); 
						  
						  else{
						  if($json['orientation']=='landscape')
						  echo form_radio('orientation', 'landscape', TRUE,'class="simple orientation"'); 
						  else 
						  echo form_radio('orientation', 'landscape', FALSE,'class="simple orientation"');}
						  ?>
                          
                          <label> &nbsp; Landscape &nbsp;&nbsp;&nbsp; <img src="<?php echo bu('images/landscape.png');?>"> </label>
                          <br>
                          <?php  
						  if($json['orientation']=='portrait')
						  echo form_radio('orientation', 'portrait', TRUE,'class="simple orientation"'); 
						  else 
						  echo form_radio('orientation', 'portrait', FALSE,'class="simple orientation"');
						  ?>
                          
                           
                          <label> &nbsp; Portrait &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="<?php echo bu('images/portrait.png');?>"> </label>
                        </div>
                        <div class="form-group">
                          <label>Printer Type:</label>
                          <br>
                          <?php  
						  if($json['p_type']=='')
						  echo form_radio('printer_type', 'color', TRUE,'class="simple p_type"'); 
						  
						  else{
						  if($json['p_type']=='color')
						  echo form_radio('printer_type', 'color', TRUE,'class="simple p_type"'); 
						  else 
						  echo form_radio('printer_type', 'color', FALSE,'class="simple p_type"');}
						  ?>
                           
                          <label> &nbsp; Color </label>
                          <br>
                          <?php  
						  if($json['p_type']=='black_and_white')
						  echo form_radio('printer_type', 'black_and_white', TRUE,'class="simple p_type"'); 
						  else 
						  echo form_radio('printer_type', 'black_and_white', FALSE,'class="simple p_type"');
						  ?> 
                          <label> &nbsp; Black & White </label>
                        </div>
                        <div class="col-sm-6 col-xs-12 no-mar">
                        <div class="form-group">
                          <label>Top Margin:</label>
                          <?php 
						  $options = array(); 
						  for($i=0.0;$i<=5.0;$i=$i+0.25){ 
							  $options["$i"]=$i.' cm';
							  }
						  echo form_dropdown('', $options, @$json['top_margin'], 'class="form-control" id="top_margin"');
						  ?>
                          
                          
                         </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 no-mar">
                        	<div class="form-group">
                          <label>Left Margin:</label>
                          <?php echo form_dropdown('', $options, @$json['left_margin'], 'class="form-control" id="left_margin"');?>
                          
                         </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 no-mar">
                        	<div class="form-group">
                          <label>Bottom Margin:</label>
                          <?php echo form_dropdown('', $options, @$json['bottom_margin'], 'class="form-control" id="bottom_margin"');?>
                         </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 no-mar">
                        	<div class="form-group">
                          <label>Right Margin:</label>
                          <?php echo form_dropdown('', $options, @$json['right_margin'], 'class="form-control" id="right_margin"');?>
                         </div>
                        </div>
                      </div>
                      <div data-s="prescription_header"  class="ini_hidden">
                        <h4  >CUSTOMIZE HEADER</h4>
                        <hr>
                        <div class="form-group">
                          <label>Include Header :</label>
                          <br>
                          <?php  
						  if($json['include_header']=='')
						  echo form_radio('include_header', '1', TRUE,'class="simple include_header"'); 
						  
						  else{
						  if($json['include_header']=='1')
						  echo form_radio('include_header', '1', TRUE,'class="simple include_header"'); 
						  else 
						  echo form_radio('include_header', '1', FALSE,'class="simple include_header"');}
						  ?>
                            
                         
                          <label>  Yes </label>
                          <br>
                          <?php  
						  if($json['include_header']=='0')
						  echo form_radio('include_header', '0', TRUE,'class="simple include_header"'); 
						  else 
						  echo form_radio('include_header', '0', FALSE,'class="simple include_header"');
						  ?>  
                          <label> No. I already have a letter head.</label>
                        </div>
                        
                        <div class="form-group">
                        	<div class=" col-sm-10 col-xs-12 no-mar">
                            	<label>Header:</label>
                            	<textarea class="form-control" rows="3" id="header_text" > <?php echo trim(@$json['header_text']);?> </textarea>
                            </div>
                            <div class=" col-sm-2  hidden-xs  no-mar">
                            	<img src="<?php echo bu('images/header.png')?>" class="ssa">
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                        	<div class=" col-sm-10 col-xs-12 no-mar">
                            	<label>Left Text:</label>
                            	<textarea class="form-control" rows="3" id="left_text" ><?php echo trim(@$json['left_text']);?></textarea>
                            </div>
                            <div class=" col-sm-2  hidden-xs  no-mar">
                            	<img src="<?php echo bu('images/left.png')?>" class="ssa">
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                        	<div class=" col-sm-10 col-xs-12 no-mar">
                            	<label>Right Text:</label>
                            	<textarea class="form-control" rows="3" id="right_text" ><?php echo trim(@$json['right_text']);?></textarea>
                            </div>
                            <div class=" col-sm-2  hidden-xs  no-mar">
                            	<img src="<?php echo bu('images/right.png')?>" class="ssa">
                            </div>
                            
                        </div>
                        
                        <div class="form-group ">
                          <label>Include Logo :</label>
                          <br>
                          <div class="col-xs-6">
                          <?php  
						  if($json['include_logo']=='')
						  echo form_radio('include_logo', '1', TRUE,'class="simple include_logo"'); 
						  
						  else{
						  if($json['include_logo']=='1')
						  echo form_radio('include_logo', '1', TRUE,'class="simple include_logo"'); 
						  else 
						  echo form_radio('include_logo', '1', FALSE,'class="simple include_logo"');}
						  ?>
                            
                         <label>  Yes </label> 
                          </div>
                          <div class="col-xs-6">
                          <?php  
						  if($json['include_logo']=='0')
						  echo form_radio('include_logo', '0', TRUE,'class="simple include_logo"'); 
						  else 
						  echo form_radio('include_logo', '0', FALSE,'class="simple include_logo"');
						  ?>
                          
                           
                           
                          <label> No</label> 
                          </div>
                         
                        </div>
                        
                        
                      </div>
                      <div data-s="prescription_patient"  class="ini_hidden">
                        <h4  >CUSTOMIZE PATIENT DETAILS</h4>
                        <hr>
                        
                        
                        <div class="form-group">
                        	<input type="checkbox" class="simple" 
                            onClick="if($(this).is(':checked')){$(this).next().show(0)} 
                            else{$(this).next().hide(0)}" id="show_p_details" <?php if(@$json['show_p_details']) echo 'checked'?>> Show Patient Details
                            <div style="margin-left:20px; display:none"> 
                            	<input type="checkbox" class="simple mmk exclude" value="medical_history"
                                <?php if(in_array('medical_history',@$json['exclude'])) echo 'checked'?>
                                > Exclude medical history <br>
                                <input type="checkbox" class="simple mmk exclude" value="address" 
                                 <?php if(in_array('address',@$json['exclude'])) echo 'checked'?>
                                 > Exclude address  		<br>
                                <input type="checkbox" class="simple mmk exclude" value="phone" 
                                 <?php if(in_array('phone',@$json['exclude'])) echo 'checked'?>
                                > Exclude phone number    <br>
                                <input type="checkbox" class="simple mmk exclude" value="email" 
                                 <?php if(in_array('email',@$json['exclude'])) echo 'checked'?>
                                > Exclude email  			<br>
                                <input type="checkbox" class="simple mmk exclude" value="blood_group" 
                                 <?php if(in_array('blood_group',@$json['exclude'])) echo 'checked'?>
                                > Exclude blood group     <br>
                            </div>
                        </div>
                       
                       <div class="form-group">
                        	<input type="checkbox" class="simple" id="ex_p_gender_dob" <?php if(@$json['ex_p_gender_dob']) echo 'checked'?>>
                            Exclude Patient Gender and DOB
                       </div>
                        
                       </div>
                        <div data-s="prescription_footer"  class="ini_hidden">
                            <h4  >CUSTOMIZE FOOTER</h4>
                            <hr>
                            <div class="col-sm-6 col-xs-12 no-mar">
                        <div class="form-group">
                          <label>Top Margin:</label>
                          <?php echo form_dropdown('', $options, @$json['footer_margin'], 'class="form-control" id="footer_margin"');?>
                          
                         </div>
                        </div>
                        <div class="form-group">
                        	<div class=" col-sm-10 col-xs-12 no-mar">
                            	<label>Full Width Content:</label>
                            	<textarea class="form-control" rows="5" id="footer_content" ><?php echo trim(@$json['footer_content']);?></textarea>
                            </div>
                            <div class=" col-sm-2  hidden-xs  no-mar">
                            	<img src="<?php echo bu('images/header.png')?>" class="ssa">
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                        	<div class=" col-sm-10 col-xs-12 no-mar">
                            	<label>Left Signature:</label>
                            	<textarea class="form-control" rows="3" id="left_sign" ><?php echo trim(@$json['left_sign']);?></textarea>
                            </div>
                            <div class=" col-sm-2  hidden-xs  no-mar">
                            	<img src="<?php echo bu('images/left.png')?>" class="ssa">
                            </div>
                            
                        </div>
                        
                        
                        <div class="form-group">
                        	<div class=" col-sm-10 col-xs-12 no-mar">
                            	<label>Right Signature:</label>
                            	<textarea class="form-control" rows="3" id="right_sign"  ><?php echo trim(@$json['right_sign']);?></textarea>
                            </div>
                            <div class=" col-sm-2  hidden-xs  no-mar">
                            	<img src="<?php echo bu('images/right.png')?>" class="ssa">
                            </div>
                            
                        </div>
                        </div>
                        <button class="btn btn-sm btn-info"><i class="fa fa-arrows-alt"></i> Show Full Preview</button>
                        <button class="btn btn-sm btn-info" onClick="save_json($(this),0)" id="save_btn">
                        <img src="<?php echo bu('images/ajax_rt.gif');?>" style="display:none">
                        <i class="fa fa-save"></i> Save</button>
                        <button class="btn btn-sm btn-primary" onClick="save_json($(this),1)">
                        <img src="<?php echo bu('images/ajax_rt.gif');?>" style="display:none">
                        <i class="fa fa-paste"></i> Save For All</button>
                    </div>
                  </div>
                 <?php $this->load->view('doctor_admin/components/preview_paper');?>
                  
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4"> </div>
              <!-- /.tab-pane --> 
            </div>