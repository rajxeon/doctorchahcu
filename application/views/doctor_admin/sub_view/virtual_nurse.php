<script src="<?php echo bu('js/jquery.dataTables.min.js');?>"></script>
<script>
$(document).ready(function() {
    $('#data_tables').DataTable();
} );
</script>
<style>
.no-mar{ margin:0}
.no-pad{ padding:0}
.te_c{ text-align:center}
.adon{height: 34px;border-left: 1px solid #D8D8D8 !important;}
table .close{ opacity:1 !important; float:left !important;}
table.dataTable.row-border tbody th, table.dataTable.row-border tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td{ padding:0 4px;}
.c_btn{padding: 4px;margin: 2px auto;}
.green_m{ background: rgb(114, 224, 126);}
</style>

<link rel="stylesheet" href="http://cdn.datatables.net/1.10.5/css/jquery.dataTables.css">
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">

<div class="col-lg-12">
<h1 class="page-header">
    Patients <small>Add or Edit your clinic details</small>
</h1>
<ol class="breadcrumb">
    <li class="active">
        <i class="fa fa-dashboard"></i> Dashboard
        </li><li class="active">
        <i class="fa fa-edit"></i> Virtual Nurse / <i class="fa fa-info"></i> Patients
        
    </li>
    
</ol>
</div>
<div class="col-lg-12">
<?php if(isset($msg) and isset($type)) {
	
	switch($type){
		case('success'):
		$type_txt='Success';		break;
		case('danger'):
		$type_txt='Alert';break;
		case('info'):
		$type_txt='Info';break;
		
		}
	echo '<div class="alert alert-'.$type.' alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>'.$type_txt.'</b> '.$msg.'
                                    </div>';
	
	}


display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));	

?>
</div>
<br><br clear="all">

<?php 
//Check if patient exists
$sql="SELECT * FROM patient WHERE id='$id' LIMIT 1";
$num_rows=$this->db->query($sql)->num_rows();
if($num_rows){
	$temp=$this->db->query($sql)->result();
	$this->data['patient_data']=$temp[0];
	$this->load->view('doctor_admin/components/patient_expand',$this->data);
	} 
?>

<div class="col-lg-12">
<h1 class="page-header">
   Add New Patients
</h1>
</div>

<form action="<?php echo bu('doctor/patients')?>" method="post">
<div class="col-lg-12">

	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control" placeholder="Name * " name="name" 
            value="<?php echo $this->input->post('name')?>"  required>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
            <input type="text" class="form-control" placeholder="Phone * " name="phone" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  required
            value="<?php echo $this->input->post('phone')?>">
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input type="email" class="form-control" placeholder="Email" name="email"
            value="<?php echo $this->input->post('email')?>">
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="input-group">
    	<div class="col-lg-3 col-md-3 col-sm-3  col-xs-3 no-mar no-pad "><span class="input-group-addon adon"><strong>D.O.B</strong></span></div>
    	<div class="col-lg-3 col-md-3 col-sm-3  col-xs-3 no-mar no-pad ">
        
        <select class="form-control te_c no-pad" name="date">
        	<option disabled selected>DD</option>
            <?php for($i=1;$i<=31;$i++){
				echo '<option value="'.$i.'">'.$i.'</option>';
				}
				?>
        </select>
        </div>
        
        
        <div class="col-lg-3 col-md-3 col-sm-3  col-xs-3 no-mar no-pad ">
        <select class="form-control te_c no-pad" name="month">
        	<option disabled selected>MM</option>
            <?php for($i=1;$i<=12;$i++){
				echo '<option value="'.$i.'">'.$i.'</option>';
				}
				?>
        </select>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3  col-xs-3 no-mar no-pad ">
         <select class="form-control te_c no-pad" name="year">
        	<option disabled selected>YYYY</option>
            <?php 
			$year=date('Y');
			$limit_year=$year-100;
			for($i=$year;$i>=$limit_year;$i--){
				echo '<option value="'.$i.'">'.$i.'</option>';
				}
				?>
        </select>
        </div>
    </div> 
    
    </div><input style="margin: 7px 15px;" type="submit" class="btn btn-success btn-flat" value="+ Add Patient"> 
</div>
</form>

<div class="col-lg-12">
<h1 class="page-header">
   Available Patients
</h1>
</div>
	<div class="col-lg-12">
    
    	<table id="data_tables" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Age</th>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Age</th>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </tfoot>
 
        <tbody>
        <?php 
		$sql="SELECT id,name,phone,email,dob FROM patient WHERE doctors like '%,".$this->session->userdata('id').",%'";
		$results=$this->db->query($sql)->result();
		foreach($results as $a=>$b):?>
			
			<tr>
            <td><?php echo $b->name;?></td>
            <td><?php echo $b->phone;?></td>
            <td><?php echo $b->email;?></td>
            <td><?php echo date('Y',time())-date('Y',strtotime(str_replace('/','-',$b->dob)));?></td>
            <td>
                <div class="btn-group close">
                    <button type="button" class="btn btn-default dropdown-toggle c_btn" data-toggle="dropdown">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu in" style="margin-left: -126px;">
                        <li> <a onClick="return confirm(('Are you sure?'))" href="<?php echo bu('doctor/delete_patient/'.$b->id);?>"> <i class="fa fa-fw fa-trash-o"></i> Delete</a></li>
                        <li><a href="<?php echo bu('doctor/patients/'.$b->id)?>"> <i class="fa fa-fw fa-expand"></i> Expand</a></li>
                    </ul>
                </div>
            </td>
            
            </tr>
			
		<?php endforeach;?>
       
        </tbody>
    </table>
    </div>
