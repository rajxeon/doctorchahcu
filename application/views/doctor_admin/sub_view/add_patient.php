
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
  <div class="col-lg-12">
    <h1 class="page-header"> New patient form <small>Add new patient in your library</small> </h1>
    <ol class="breadcrumb">
      <li class="active"> <i class="fa fa-dashboard"></i> Dashboard </li>
      <li class="active"> <i class="fa fa-plus"></i> Add new patient</li>
      
      	 
      
      <button   style="float: right; margin:-4px 10px"  class="btn btn-default btn-flat btn-sm"><i class="fa fa-times"></i> Cancel </button>
      <button  style="float: right; margin:-4px 10px" class="btn btn-primary btn-flat btn-sm" onClick="save_patient_details()"><i class="fa fa-save"></i> Save </button>
     
    </ol>
  </div>
  <div class="container-fluid">
  	<div class="row">
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
          	<img class="user_img" src="<?php echo bu('images/user.png')?>">
          </div>
          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
          	<?php $this->load->view('doctor_admin/components/add_patient_form',$this->data);?>
          </div>
          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
          	<?php $this->load->view('doctor_admin/components/add_patient_meta_form',$this->data);?>
          </div>
    </div>
     
</div>
</div>

