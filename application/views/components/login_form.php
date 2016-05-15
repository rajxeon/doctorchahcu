<div class="signup-form">
                      
                      <?php echo form_open(base_url().'doctor/login','id=doctorSignupStepOne');?>
                           
                           
                           <div class="floating-placeholder">
                           	    <input style="display:none">
                                  <input type="text" name="email" style="width:280px;" class="text-field animate_3"   placeholder="Email" value="<?php echo $this->input->post('email');?>">
                              </div>
                              <div class="floating-placeholder">
                                  <input style="display:none">
                                  <input type="password" name="password" style="width:280px;" class="text-field animate_3"  autocomplete="off" placeholder="Password">
                                 
                              </div>
                              
                           
      
                             <div class="alpha omega grid_11 topmargin_10">
                                  <input type="submit" class="button" style="width:280px;" value="Login">
                              </div>
                          </form>
                          
                      </div>
                      <br /><br />