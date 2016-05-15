

<div id="page-wrapper" style=" position:relative;min-height: 150vh;">

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
<div class="alert alert-info alert-dismissable"">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
      <i class="fa fa-info-circle"></i><strong><?php 
	$this->clinic_m->get_clinic_number_limit();
	
	?></strong>
      For adding more clinic please upgrade your membership. 
      <a href="'.bu('doctor/plans').'"><button type="button" class="btn btn-success">View plans</button></a>. 
                    
 </div>
<div id="add_form" class="col-lg-12">
<?php if(isset($message) and isset($type))display_msg($message,$type);
display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));
?>
</div>
<div id="add_form" class="col-lg-4">
<div class="panel panel-primary">
      <div class="panel-heading">
        	<h3 class="panel-title">Add new clinic</h3>
      </div>
      <div class="panel-body">
      
      <?php echo form_open(bu('doctor/clinic'));?>
      
       	 <div class="form-group">
              <label>Clinic name</label>
              <input class="form-control" type="text" name="name" required>
            </div>
            <?php if($this->clinic_m->get_clinic_number_limit(TRUE)<=0){
			
			echo '<button type="button" class="btn btn btn-warning">Clinic Limit reached</button><br><br clear="all">';
			echo '<div class="alert alert-danger" role="alert">
      			Please upgrade your plan to add more clinic <a href="'.bu('doctor/plans').'"><button type="button" class="btn btn-success">View plans</button></a>  </div><p></p>';
			}
			else echo '<button  type="submit" class="btn btn-success btn-labeled"class="btn btn-success btn-labeled" style="width: 100%;"><span class="btn-label icon fa fa-plus"></span>Add a clinic</button>';
		?>
     
      </form>
      </div>
</div>
    
    
	

</div>
<div id="add_form" class="col-lg-8">
<div class="bs-example" data-example-id="panel-without-body-with-table">
    <div class="panel panel-primary">
      <!-- Default panel contents -->
      <div class="panel-heading">Available Clinics</div>

      <!-- Table -->
      <table class="table" style=" width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Clinic Name</th>
            <th>Visibility</th>
            <th>Edit</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
      <?php 
	$data=$this->db->query("SELECT * FROM clinic WHERE doctor_id=".$this->session->userdata('id'))->result();
	$counter=0;
	if(sizeof($data)==0) echo '<tr><td>No clinic available.Click on Add clinic button to add a clinic</td></tr>';
	foreach($data as $a=>$b){
		$counter+=1;
		echo '<tr>';
		echo '<th scope="row">'.$counter.'</th>
            <td style="max-width:200px">'.$b->name.'</td>
		<td>';
		if($b->visibility==1) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<i class="glyphicon glyphicon-eye-open"></i>
		
		';
		else echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-close"></i>';
		echo '</td>
            
		<td>
			<a href="'.bu('doctor/edit_clinic/'.$b->id.'/'.$this->session->userdata('unique_id')).'">
			<i class="glyphicon glyphicon-pencil"></i></a>
		</td>
		
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