<style>

.sp{ display:none !important}
.spt{ display:none !important}
.no-pad{ padding:0 !important}
#page-wrapper{position:inherit !important;}

body::-webkit-scrollbar {  
    width: 8px;  
}  
body::-webkit-scrollbar-track {  
    background-color: #eaeaea;  
    border-left: 1px solid #ccc;  
}  
body::-webkit-scrollbar-thumb {  
    background-color: #ccc;  
}  
body::-webkit-scrollbar-thumb:hover {  
    background-color: #aaa;  
}   
</style>
<header class="header">
            <a href="<?php echo base_url().'doctor/dashboard'?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Doctor Chachu
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php echo bu('images/') ?>avatar3.png" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li><!-- end message -->
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php echo bu('images/') ?>avatar2.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    AdminLTE Design Team
                                                    <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php echo bu('images/') ?>avatar.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Developers
                                                    <small><i class="fa fa-clock-o"></i> Today</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php echo bu('images/') ?>avatar2.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Sales Department
                                                    <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php echo bu('images/') ?>avatar.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Reviewers
                                                    <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users warning"></i> 5 new members joined
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-cart success"></i> 25 sales made
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-person danger"></i> You changed your username
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="label label-danger">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 9 tasks</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Create a nice theme
                                                    <small class="pull-right">40%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Some task I need to do
                                                    <small class="pull-right">60%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">60% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Make beautiful transitions
                                                    <small class="pull-right">80%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">80% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-plus"></i>
                            </a>
                            <ul class="dropdown-menu" style="width:	220px !important" >
                                <li class="header" >Menu</li>
                                <li style="height:140px !important">
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu" >
                                        <li><!-- Task item -->
                                            <a href="<?php echo bu('doctor/add_patient');?>">   <h3>  <i class="fa fa-plus"></i> Add New patient </h3> </a>
                                        </li>
                                        <li><!-- Task item -->
                                            <a href="#">  <h3> <i class="fa fa-plus"></i> Add Walk-in patient </h3> </a>
                                        </li>
                                        <li><!-- Task item -->
                                            <a href="#">  <h3> <i class="fa fa-plus"></i> Add New Expense </h3> </a>
                                        </li>
                                    </ul>
                                </li>
                                
                            </ul>
                        </li>
                        
                        
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php $first_name= explode(' ',$userdata->name);
				    			echo $first_name[0];
				    ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                <img  class="img-circle" alt="User Image"  src="
						<?php 
                                          
                                          $exists=0;
                                          if(is_file(('user_upload/'.$userdata->unique_id.'/dp.jpg'))){
                                                echo bu('user_upload/'.$userdata->unique_id.'/dp.jpg');
                                                $exists=1;
                                                }
                                                
                                          elseif(is_file( ('user_upload/'.$userdata->unique_id.'/dp.png'))){
                                                echo bu('user_upload/'.$userdata->unique_id.'/dp.png');
                                                $exists=1;
                                                }
                                                
                                          elseif(is_file( ('user_upload/'.$userdata->unique_id.'/dp.gif'))){
                                                echo bu('user_upload/'.$userdata->unique_id.'/dp.gif');
                                                $exists=1;
                                                }
                                                
                                          elseif(is_file( ('user_upload/'.$userdata->unique_id.'/dp.jpeg'))){
                                                echo bu('user_upload/'.$userdata->unique_id.'/dp.jpeg');
                                                $exists=1;
                                                }
							else echo bu('images/avatar3.png');
                                                
                                    ?>">
                                	
                                    
                                    <p>
                                        <?php echo $userdata->name;?>
                                        <small>Member since <?php echo date('d-M-Y',strtotime($userdata->joined));?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo bu('doctor/profile');?>" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url();?>doctor/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        
        <!-- header logo: style can be found in header.less -->
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <?php 
					//Primary clinic.
					//Get all the clinic associated with doctor 
					
					$clinic_array=get_all_clinics_by_doctor($userdata->id); 
					
					
					$primary=0;
					//$sql="SELECT id from clinic where doctor_id=".$userdata->id." and `primary`=1 order by sort_order limit 1";
					$sql="SELECT `primary` FROM doctors WHERE id=".$userdata->id;
					$cdata=$this->db->query($sql)->result();
					if(isset($cdata[0])){
						$cdata=$cdata[0];
						$primary=$cdata->primary;
						if(empty($primary))
						$primary=@$clinic_array[0];
						if(!empty($primary)):
						$this->session->set_userdata(array('primary'=>$primary)); 
						else:?> 
							 <script> $(document).ready(function(e) { 
							 setTimeout(function(){$('.nssn').click()},100);}); </script>
						<?php endif;
					}
					 
					if($primary){
						$sql="SELECT * FROM clinic WHERE id=$primary";
						$p_clinic=$this->db->query($sql)->result();
						$p_clinic=$p_clinic[0];
						}
					
					
					?>
                    
                    <div class="user-panel">
                        <div class="pull-left image col-xs-3 no-pad">
                         <img  class="img-circle" alt="User Image"  src="
						<?php 
                                          
                                          $exists=0;
                                          if(is_file(('clinic_images/'.$this->session->userdata('primary').'/logo.jpg'))){
                                                echo bu('clinic_images/'.$this->session->userdata('primary').'/logo.jpg');
                                                $exists=1;
                                                }
                                                
                                          elseif(is_file(('clinic_images/'.$this->session->userdata('primary').'/logo.png'))){
                                                echo bu('clinic_images/'.$this->session->userdata('primary').'/logo.png');
                                                $exists=1;
                                                }
                                                
                                          elseif(is_file(('clinic_images/'.$this->session->userdata('primary').'/logo.gif'))){
                                                echo bu('clinic_images/'.$this->session->userdata('primary').'/logo.gif');
                                                $exists=1;
                                                }
                                                
                                          elseif(is_file(('clinic_images/'.$this->session->userdata('primary').'/logo.jpeg'))){
                                                echo bu('clinic_images/'.$this->session->userdata('primary').'/logo.jpeg');
                                                $exists=1;
                                                }
							else echo bu('images/clinic.jpg');
                                                
                                    ?>">
                        </div>
                         <div class="pull-left info col-xs-9 no-pad">
                         	<form action="<?php echo bu('doctor/records');?>" method="post" class="sidebar-form" style="margin:0; zoom:.8;margin-top: 9px;">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search Patient" value="<?php echo $this->input->post('q')?>"/>
                            <span class="input-group-btn">
                                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                         </div>
                        <div class="pull-left info col-xs-12 no-pad">
                        <div class="dropdown">
  <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-block btn-sm btn-default"> 
   <?php  if(strlen(@$p_clinic->name)>30) echo substr(@$p_clinic->name,0,30).'...';
   else echo @$p_clinic->name;
    ?>
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" style="width: 205px; min-width:140px;font-size: 14px;overflow: hidden;">
   <?php 
   
   
   //List of clinic
   $clinic_array=get_all_clinics_by_doctor($userdata->id);
   if(!empty($clinic_array)):
   $sql="SELECT id,name FROM clinic WHERE id in(".implode(',',$clinic_array).")"; 
    
   $dd=$this->db->query($sql)->result();
   foreach($dd as $a=>$b):
   ?>
   
   <?php if($b->id==$primary):?>
   <li role="presentation" style="cursor:default" data-toggle="tooltip" data-placement="bottom" title="<?php echo $b->name;?>">
   	<a role="menuitem" href="<?php echo bu('doctor/change_primary/'.$b->id);?>" tabindex="-1"  style="padding: 3px 5px;">
		<i class="fa fa-fw fa-dot-circle-o"></i><?php echo $b->name;?>
    </a>
    </li> 
    
   <?php else:?>
       <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo bu('doctor/change_primary/'.$b->id);?>" style="padding: 3px 5px;">
            <i class="fa fa-fw fa-circle-o"></i><?php echo $b->name;?>
        </a>
       </li> 
   
   <?php endif;?>
  
   
   <?php endforeach;endif;?>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" href="<?php echo bu('doctor/clinic/');?>" style="padding: 3px 5px;">
            <i class="fa fa-fw fa-plus"></i>Add new clinic
        </a>
       </li> 
  </ul>
</div> 
                           
                            
                            
                        </div>
                        
                    </div>
                    <!-- search form -->
                    
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active" data-page="dashboard">
                            <a href="<?php echo bu('doctor/dashboard');?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li data-page="clinic">
                            <a href="<?php echo bu('doctor/clinic');?>">
                                <i class="fa fa-th"></i> <span>Clinic</span> <small class="badge pull-right bg-green">new</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Appointments</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                           		<?php 
								$sql="SELECT id,name,doctor_id FROM clinic WHERE doctor_id='".$this->session->userdata('id')."' OR other_doctors LIKE '%,".$this->session->userdata('id').",%' ORDER BY sort_order";
								$results=$this->db->query($sql)->result();
								foreach($results as $a=>$b){
									echo '<li><a href="'.bu('doctor/appointments/'.$b->id).'"><i class="fa fa-angle-double-right"></i>
									'.$b->name.'</a></li>';
									}
								
								?>
                                
                                
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>Virtual Nurse</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                            	<li><a href="<?php echo bu('doctor/records');?>"><i class="fa fa-angle-double-right"></i> Patient Records</a></li>
                                <li><a href="<?php echo bu('doctor/treatment_plans');?>"><i class="fa fa-angle-double-right"></i> Treatment Plans</a></li>
                                
                                <li><a href="<?php echo bu('doctor/completed_procedure');?>"><i class="fa fa-angle-double-right"></i> Completed Procedure</a></li>
                                 
                                 <li><a href="<?php echo bu('doctor/file_manager');?>"><i class="fa fa-angle-double-right"></i> File Manager</a></li>
                                 
                                <!--<li><a href="<?php echo bu('doctor/patients');?>"><i class="fa fa-angle-double-right"></i> Patients</a></li>-->
                                <li><a href="<?php echo bu('doctor/prescription');?>"><i class="fa fa-angle-double-right"></i> Prescription </a></li>
                                 
                                <li><a href="pages/UI/sliders.html"><i class="fa fa-angle-double-right"></i> Sliders</a></li>
                                <li><a href="pages/UI/timeline.html"><i class="fa fa-angle-double-right"></i> Timeline</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Billing</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo bu('doctor/invoice');?>"><i class="fa fa-angle-double-right"></i>Invoice</a></li>
                                <li><a href="<?php echo bu('doctor/payment');?>"><i class="fa fa-angle-double-right"></i>Payments</a></li>
                                <li><a href="<?php echo bu('doctor/ledger');?>"><i class="fa fa-angle-double-right"></i>Ledger</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-gears"></i> <span>Settings</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo bu('doctor/printouts');?>"><i class="fa fa-print"></i> Printouts Settings</a></li>
                                <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-double-right"></i> Advanced Elements</a></li>
                                <li><a href="pages/forms/editors.html"><i class="fa fa-angle-double-right"></i> Editors</a></li>
                            </ul>
                        </li>
                        
                        <li>
                        	<li class="treeview">
                            <a href="#">
                                <i class="fa fa-calendar"></i> <span>Calender</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                              <li><a href="<?php echo bu('doctor/calender');?>"><i class="fa fa-calendar-o"></i> View Calender</a></li>
                              <li><a href="<?php echo bu('doctor/set_timing');?>"><i class="fa fa-clock-o"></i> Set Clinic Timing</a></li>
                                 
                            </ul>
                        	</li>
                         
                        </li>
                        <li>
                            <a href="pages/mailbox.html">
                                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                                <small class="badge pull-right bg-yellow">12</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Examples</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/examples/invoice.html"><i class="fa fa-angle-double-right"></i> Invoice</a></li>
                                <li><a href="pages/examples/login.html"><i class="fa fa-angle-double-right"></i> Login</a></li>
                                <li><a href="pages/examples/register.html"><i class="fa fa-angle-double-right"></i> Register</a></li>
                                <li><a href="pages/examples/lockscreen.html"><i class="fa fa-angle-double-right"></i> Lockscreen</a></li>
                                <li><a href="pages/examples/404.html"><i class="fa fa-angle-double-right"></i> 404 Error</a></li>
                                <li><a href="pages/examples/500.html"><i class="fa fa-angle-double-right"></i> 500 Error</a></li>
                                <li><a href="pages/examples/blank.html"><i class="fa fa-angle-double-right"></i> Blank Page</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            
