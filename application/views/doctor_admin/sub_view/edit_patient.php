
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
  <div class="col-lg-12">
    <h1 class="page-header"> Edit patient:<?php echo ucfirst($p_data->name);?><small>Edit details of patient in your library</small> 
    
    </h1>
    <ol class="breadcrumb">
      <li class="active"> <i class="fa fa-dashboard"></i> Dashboard </li>
      <li class="active"> <i class="fa fa-plus"></i> Edit patient</li>
      
      	 
      
      <a  href="<?php  echo bu('doctor/view_patient/'.$p_data->id) ; ?>"   style="float: right; margin:-4px 10px"  class="btn btn-default btn-flat btn-sm"><i class="fa fa-times"></i> Cancel </a>
      <button  style="float: right; margin:-4px 10px" class="btn btn-primary btn-flat btn-sm" onClick="save_patient_details()"><i class="fa fa-save"></i> Save </button>
      <a  href="<?php echo bu('doctor/delete_patient/'.$p_data->id);;?>"  style="float: right; margin:-4px 10px"  class="btn btn-danger btn-flat btn-sm" onclick="return(confirm('Are you sure you want to delete this patient?'))"><i class="fa fa-times"></i> Delete </a>
     
    </ol>
  </div>
  <div class="container-fluid">
  	<div class="row">
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
          	<img class="user_img" src="<?php echo bu('images/user.png')?>">
          </div>
          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
          	<?php $this->load->view('doctor_admin/components/edit_patient_form',$this->data);?>
          </div>
          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
          	<?php $this->load->view('doctor_admin/components/edit_patient_meta_form',$this->data);?>
          </div>
    </div>
     
</div>
</div>

