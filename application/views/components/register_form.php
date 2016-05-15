
<div class="signup-form">
                      
                      <?php echo form_open(base_url().'doctor','id=doctorSignupStepOne');?>
                           
                           
                           <div class="floating-placeholder">
                                  <input type="text" name="primary_email_address" style="width:280px;" class="text-field animate_3"  autocomplete="off" placeholder="Email" value="<?php echo $this->input->post('primary_email_address');?>">
                                 
                              </div>
                              
                              
                              
                              <div class="floating-placeholder">
                              <span class="input-group-addon" id="basic-addon1">Dr.</span>
                                   <input type="text" name="name" style="width:240px;" class="text-field animate_3"  autocomplete="off" placeholder="Name" value="<?php echo $this->input->post('name');?>">
                              </div>
      
      
                                 <div class="floating-placeholder">
                                 <input type="number" name="primary_contact_number" style="width:280px;" class="text-field animate_3"  autocomplete="off" placeholder="Mobile Number" value="<?php echo $this->input->post('primary_contact_number');?>">
                              </div>
      
                              
                              
                              
                              <div class="floating-placeholder">
                                  <input type="password" name="password" style="width:280px;" class="text-field animate_3"  autocomplete="off" placeholder="Password">
                                 
                              </div>
                              
                              <div class="floating-placeholder">
                                  <input type="password" name="c_password" style="width:280px;" class="text-field animate_3"  autocomplete="off" placeholder="Confirm Password">
                                 
                              </div>
      
                             <div class="alpha omega grid_11 topmargin_10">
                                  <input type="submit" class="button" style="width:280px;" value="Continue to Clinic Details">
                              </div>
                          </form>
                          
                      </div>
                      <br /><br />