

<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">

<div class="col-lg-12">
<h1 class="page-header">
    Clinic <small>Add or Edit your clinic details</small>
</h1>
<ol class="breadcrumb">
    <li class="active">
        <i class="fa fa-dashboard"></i> Dashboard
        </li><li class="active">
        <i class="fa fa-edit"></i> Clinic
    </li>
    
</ol>
</div>
<br clear="all">

<div id="add_form" class="col-lg-12">
<div class="alert alert-info alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
      <i class="fa fa-info-circle"></i><strong><?php 
	$this->clinic_m->get_clinic_number_limit();
	
	?></strong>
      For adding more clinic please upgrade your membership. 
      <a href="'.bu('doctor/plans').'"><button type="button" class="btn btn-success">View plans</button></a>. 
                    
 </div>
<?php if(isset($message) and isset($type))display_msg($message,$type);
display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));
?>
</div>
<div id="add_form" class="col-lg-5">
<div class="panel panel-primary">
      <div class="panel-heading">
        	<h3 class="panel-title">Add new clinic</h3>
      </div>
      <div class="panel-body">
      <div align="center"><img src="<?php echo bu('images/clinic.png'); ?>"></div>
      
      <?php echo form_open(bu('doctor/clinic'));?>
      
       	 <div class="form-group">
             
              <label>Clinic name</label>
              <input class="form-control" type="text" placeholder="Enter your clinic name" name="name" required>
            </div>
            
            <div class="form-group">
             
              <label>Clinic Pin code</label>
              <input class="form-control" placeholder="The postal code of your clinic" type="number" name="pin" maxlength="6" required>
            </div>
            <?php if($this->clinic_m->get_clinic_number_limit(TRUE)<=0){
			
			echo '<button type="button" class="btn btn btn-warning">Clinic Limit reached</button><br><br clear="all">';
			echo '<div class="alert alert-danger" role="alert" style="text-align: center;">
      			Please upgrade your plan to add more clinic <a href="'.bu('doctor/plans').'"><button type="button" class="btn btn-warning">View plans</button></a>  </div><p></p>';
			}
			else echo '<button  type="submit" class="btn btn-success btn-labeled"class="btn btn-success btn-labeled" style="width: 100%;"><span class="btn-label icon fa fa-plus" style=" display:block"></span>Add a clinic</button>';
		?>
     
      </form>
      </div>
</div>
    
    
	

</div>
<div id="add_form" class="col-lg-7">
<div class="bs-example" data-example-id="panel-without-body-with-table">
    <div class="box box-solid box-info">
      <!-- Default panel contents -->
      <div class="box-header">
       	<h3 class="box-title">Available Clinics</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>

      <!-- Table -->
      <div class="box-body">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Clinic Name</th>
            <th></th>
            <th>Visibility</th>
            <th style="text-align:center">Sort</th>
            <th>Edit</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
        
      <?php 
	$sql="SELECT * FROM clinic WHERE doctor_id='".$this->session->userdata('id')."' OR other_doctors LIKE '%,".$this->session->userdata('id').",%' ORDER BY sort_order";
	
	$data=$this->db->query($sql)->result();
	$counter=0;
	if(sizeof($data)==0) echo '<tr><td>No clinic available.Click on Add clinic button to add a clinic</td></tr>';
	foreach($data as $a=>$b){
		$counter+=1;
		echo '<tr>';
		echo '<th scope="row">'.$counter.'</th>
            <td style="max-width:200px">'.$b->name.'</td>
		<td>'; 
		if($b->doctor_id==$this->session->userdata('id')){
			echo '<small class="badge pull-right bg-green" title="You edit all the parameters of this clinic">admin</small>';
			}
		echo '</td>
		<td>';
		if($b->visibility==1) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<i class="glyphicon glyphicon-eye-open"></i>
		
		';
		else echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-close"></i>';
		echo '</td>
		<td style="text-align:center">	';
		echo $b->sort_order;	  
		echo '</td>
            
		<td>';
		if($b->doctor_id==$this->session->userdata('id'))
			echo '<a href="'.bu('doctor/edit_clinic/'.$b->id.'/'.$this->session->userdata('unique_id')).'">
			<i class="glyphicon glyphicon-pencil"></i></a>';
		else echo '<a href="'.bu('doctor/edit_clinic_ext/'.$b->id.'/'.$this->session->userdata('unique_id')).'">
			<i class="glyphicon glyphicon-pencil"></i></a>';
		echo '</td>
		
            <td>
			<a onClick="return(confirm(\'Are you sure you want to delete this clinic?\'))" href="'.bu('doctor/delete_clinic/'.$b->id.'/'.$this->session->userdata('unique_id')).'">
				<i class="glyphicon glyphicon-trash"></i>
			</a>
		</td>';
		echo '</tr>';
		}
	?>
        </tbody>
      </table>
      </div>
    </div>
  </div>
</div>