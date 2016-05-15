<?php echo '<link href="'.base_url().'style/fluid.css" rel="stylesheet" type="text/css">';?>
<section>

      <div class="container-fluid">
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5" style="padding:0 !important">
              
              <div class="signup-leftpane">
                  <div id="cont">
                      <div class="signup-logo">
                          <h1>Be a part of Doctor Chachu</h1>
                      </div>
                      <br>
                      
                      <?php 
			    if(isset($post_message_type)) $type=$post_message_type; else $type='danger';
			    if(isset($post_message))display_msg($post_message,$type); ?>
                      
                      <?php $this->load->view('components/register_form.php');?>
                      </div>
                      <div class="clear"></div>
                  </div>
              </div>
              
              <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7" style="padding:0 !important; background-color:#00BDF7">
              
              <div class="signup-rightpane col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="signup-head ">
                <br>
                    <h1 style="margin-top: 8px;">Get Listed</h1>
                    <p>
                        Thousands of patients are looking for doctors on doctor chachu.<br>Let them find you
                    </p>
                </div>
                <a href="<?php echo base_url().'doctor/login'?>"><input type="button" class="button" style="width:280px;" value="Already a menber? Login"></a>
               <a href="<?php echo base_url().'doctor'?>"><input type="submit" class="button" style="width:280px;" value="Register"></a>
                <div class="signup-whybox">
                    <div class="signup-feature">
                        <img src="<?php echo base_url(); ?>images/free.png">
                        <p class="strong feature-head">IT'S FREE FOR LIFE!</p>
                        <p>Let the world know about your clinic, your facilities, services and availability without spending a buck.</p>
                    </div>
                    <div class="signup-feature last">
                        <img src="<?php echo base_url(); ?>images/24x7.png">
                        <p class="strong feature-head">LET PATIENTS BOOK APPOINTMENTS 24X7</p>
                        <p>Your staff can cater to patients only during office hours, but on doctor chachu patients can book appointments when they are free.</p>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="signup-whybox">
                    <div class="signup-feature">
                        <img src="<?php echo base_url(); ?>images/convert.png">
                        <p class="strong feature-head">CONVERT CURIOUS VISITORS INTO LOYAL PATIENTS</p>
                        <p>Put up appointment booking widgets on your website and blog.</p>
                    </div>
                    <div class="signup-feature last">
                        <img src="<?php echo base_url(); ?>images/fb.png">
                        <p class="strong feature-head">GET YOUR FACEBOOK FANS TO BOOK APPOINTMENTS</p>
                        <p>If they like you on Facebook, all they need is our facebook widget to book appointments with you.</p>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="signup-whybox">
                    <div class="signup-feature">
                        <img src="<?php echo base_url(); ?>images/4x.png">
                        <p class="strong feature-head">GET 4 TIMES MORE APPOINTMENTS WITH A PROFILE PICTURE</p>
                        <p>And we got stats to prove that. Pictures and consultation fee are a great way to reassure patients (a.k.a strangers) and increase your google ranking.</p>
                    </div>
                    </div>
                     <div class="signup-whybox">
                    <div class="signup-feature last">
                        <img src="<?php echo base_url(); ?>images/100.png">
                        <p class="strong feature-head">EVEN 1% OF OUR VISITORS COULD MEAN 100 PATIENTS A DAY FOR YOU</p>
                        <p>Everyday we have 10,000 patients looking for doctors on doctor chachu. Your impressive profile will increase their chances of booking appointments with you.</p>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
              
              </div>
            </div>
      </div>
</section>