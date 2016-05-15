<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
  <div class="col-lg-12">
     
    <ol class="breadcrumb">
      <li class="active"> <i class="fa fa-dashboard"></i> Dashboard </li>
      <li class="active"> <i class="fa fa-plus"></i> Add Doctor</li>
      
      	  
     
    </ol>
  </div>
    <div class="container-fluid">
    
<div class="signup-form">
                      <h2>Add new doctor</h2>
                      <?php echo form_open(base_url().'doctor','id=doctorSignupStepOne');?>
                           
                           
                           <div class="floating-placeholder">
                                  <input type="text" name="primary_email_address" style="width:280px;" class="text-field animate_3 form-control"  autocomplete="off" placeholder="Email" value="<?php echo $this->input->post('primary_email_address');?>">
                                 
                              </div>
                              
                              
                              
                              <div class="floating-placeholder"> 
                                   <input type="text" name="name" style="width:280px;" class="text-field animate_3 form-control"  autocomplete="off" placeholder="Name" value="<?php echo $this->input->post('name');?>">
                              </div>
      
      
                                 <div class="floating-placeholder">
                                 <input type="number" name="primary_contact_number" style="width:280px;" class="text-field animate_3 form-control"  autocomplete="off" placeholder="Mobile Number" value="<?php echo $this->input->post('primary_contact_number');?>">
                              </div>
      
                              
                              
                              
                              <div class="floating-placeholder">
                                  <input type="password" name="password" style="width:280px;" class="text-field animate_3 form-control"  autocomplete="off" placeholder="Password">
                                 
                              </div>
                              
                              <div class="floating-placeholder">
                                  <input type="password" name="c_password" style="width:280px;" class="text-field animate_3 form-control"  autocomplete="off" placeholder="Confirm Password">
                                  
                                  <input type="hidden" name="agent" value="<?php echo $this->session->userdata('a_id');?>">
                                 
                              </div>
      <br>
                             <div class="alpha omega grid_11 topmargin_10">
                                  <input type="submit" class="button btn btn-primary btn-flat" style="width:280px;" 
                                  value="Submit">
                              </div>
                          </form>
                          
                      </div>
                      <br /><br />
    </div>
</div>
</div>
