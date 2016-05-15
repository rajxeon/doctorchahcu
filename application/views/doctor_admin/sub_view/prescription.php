<script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#data_tables').DataTable();
} );
</script>
<script>
function submit_edit_template(self){
	element=self.parent();
	
	
	instruction=element.prev().prev();
	instruction_txt=instruction.find($('input')).val();
	
	duration=element.prev().prev().prev();
	duration_txt=duration.find($('input')).val();
	
	drug=element.prev().prev().prev().prev();
	drug_txt=drug.find($('input')).val();
	
	namee=drug.prev();
	name_txt=drug.prev().find($('input')).val();
	
	
	index	=self.attr('data-index');
	 
	url="<?php echo bu('doctor/prescription/')?>"+index;
	
	
	$.post(url,{name:name_txt,drug:drug_txt,duration:duration_txt,instruction:instruction_txt},function(data){
		if(data==1) {location.reload();}
		});
	
	}

function edit_template(self,index){
	element=self.parent().parent().parent().parent();
	element.html('<button class="btn btn-success btn-sm form-control"  onclick="submit_edit_template($(this))" data-index="'+index+'" style="margin:3px 0">Save</button>');
	
	instruction=element.prev().prev();
	instruction_txt=instruction.text();
	
	duration=element.prev().prev().prev();
	duration_txt=duration.text();
	
	drug=element.prev().prev().prev().prev();
	drug_txt=drug.text();
	
	namee=drug.prev();
	name_txt=drug.prev().text();
	
	instruction.html('<input type="text" class="form-control instruction" value="'+instruction_txt+'">');
	duration.html('<input type="text" class="form-control duration" value="'+duration_txt+'">');
	drug.html('<input type="text" class="form-control paid" value="'+drug_txt+'">');
	namee.html('<input type="text" class="form-control paid" value="'+name_txt+'">');
	
	}
</script>
<style>
.no-mar{ margin:0}
.no-pad{ padding:0}
.te_c{ text-align:center}
.input-group-addon{ padding:3px; font-size:12px; width:80px}
.input-group{width:100%}
.adon{height: 34px;border-left: 1px solid #D8D8D8 !important;}
table .close{ opacity:1 !important; float:left !important;}
table.dataTable.row-border tbody th, table.dataTable.row-border tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td{ padding:0 4px;}
.c_btn{padding: 4px;margin: 2px auto;}
.green_m{ background: rgb(114, 224, 126);}
.moha .input-group{margin-bottom: 10px;}
</style>

<link rel="stylesheet" href="http://cdn.datatables.net/1.10.5/css/jquery.dataTables.css">
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">

<div class="col-lg-12">
<h1 class="page-header">
    Prescription <small>Add or Edit your prescription template</small>
</h1>
<ol class="breadcrumb">
    <li class="active">
        <i class="fa fa-dashboard"></i> Dashboard
        </li><li class="active">
        <i class="fa fa-edit"></i> Virtual Nurse / <i class="fa fa-info"></i> Prescription
        
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

?>

<div class="col-lg-12">
<h1 class="page-header">
   Add New Prescription
</h1>
</div>

<form action="<?php echo bu('doctor/prescription')?>" method="post" class="moha">
<div class="col-lg-12">

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-asterisk"></i> Name</span>
            <input type="text" class="form-control" placeholder="Template name * " name="name" 
            value="<?php echo $this->input->post('name')?>"  >
        </div>
    </div>
	
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-dot-circle-o"></i> Drug</span>
            <input type="text" class="form-control" placeholder="Drug * " name="drug" 
            value="<?php echo $this->input->post('drug')?>"  >
        </div>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-clock-o"></i> Duration</span>
            <input type="text" class="form-control" placeholder="Duration " name="duration" 
            value="<?php echo $this->input->post('duration')?>"  >
        </div>
    </div>
    
   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-info-circle"></i> Instruction</span>
            <input type="text" class="form-control" placeholder="Instruction " name="instruction" 
            value="<?php echo $this->input->post('instruction')?>"  >
        </div>
    </div>
    
    <br clear="all" />
    
    
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-sun-o"></i> Morning</span>
            
            <input type="text" class="form-control" placeholder="Morning Dose " name="morning" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  
            value="<?php echo $this->input->post('morning')?>">
        </div>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-cloud"></i> Noon</span>
            
            <input type="text" class="form-control" placeholder="Noon Dose  " name="noon" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  
            value="<?php echo $this->input->post('noon')?>">
        </div>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
   		 <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-fw fa-moon-o"></i> Night</span>
            
            <input type="text" class="form-control" placeholder="Night Dose " name="night" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  
            value="<?php echo $this->input->post('night')?>">
        </div>
    </div>
   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <button type="submit" class="btn btn-primary btn-sm btn-flat"> <i class="fa fa-fw fa-save"></i> Save Template</button>
                      </div>
    
    
    
</div>
</form>

<div class="col-lg-12">
<h1 class="page-header">
   Available Template
</h1>

</div>
	<div class="col-lg-12">
    
    	<table id="data_tables" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Drug</th>
                <th>Duration</th>
                <th>Instruction</th>
                <th>Frequency</th>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Drug</th>
                <th>Duration</th>
                <th>Instruction</th>
                <th>Frequency</th>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </tfoot>
 
        <tbody>
        	<?php 
			$json=json_decode($prescription,true);
			if(sizeof($json))
			foreach($json as $a=>$b):
			$exp=explode('-::-',$b);
			?>
            <tr>
            	<td><?php echo $exp[0]?></td>
                <td><?php echo $exp[1]?></td>
                <td><?php echo $exp[2]?></td>
                <td><?php echo $exp[3]?></td>
                <td><?php echo $exp[4].'-'.$exp[5].'-'.$exp[6];?></td>
                <td style="padding:0 3px">
											<div class="btn-group close" style="width:100%">
                    <button type="button" class="btn  btn-default dropdown-toggle c_btn btn-block" data-toggle="dropdown">
                        Menu <i class="fa fa-fw fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu in" style="margin-left: -40px;">
                        <li><a href="<?php echo bu('doctor/delete_prescription_template/'.$a)?>" onclick="return confirm('Are you sure?')"><i class="fa fa-fw fa-trash-o"></i> Delete</a></li>
						<li><a onclick="edit_template($(this),<?php echo $a;?>)"><i class="fa fa-fw fa-pencil"></i> Edit</a></li>
                       	
						
                   </ul>
                </div>
											
											</td>
            </tr>
            
            <?php endforeach;?>
       
        </tbody>
    </table>
    </div>
