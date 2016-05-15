<?php $json=json_decode($patient_data->treatment_plans,true);
if(!isset($json[$this->session->userdata('id')]))
$json='';
else
$json=$json[$this->session->userdata('id')];

?>
<script>

function delete_plan(self,date,index){
	if(!confirm('Are you sure you want to delete this plan?')) return;
	event.preventDefault();
	$.post('<?php echo bu('doctor/ajax_delete_plan');?>',{date:date,index:index,id:<?php echo $patient_data->id;?>},function(data){
		//console.log(data);
		if(data==1) self.parent().parent().parent().parent().parent().hide(200);
		});
	}

function complete_plan(self,date,index){
	if(!confirm('Are you sure you mark this plan as complete? You can not revert back.')) return;
	event.preventDefault();
	$.post('<?php echo bu('doctor/ajax_complete_plan');?>',{date:date,index:index,id:<?php echo $patient_data->id;?>},function(data){
		if(data==1) self.parent().parent().parent().parent().parent().addClass('bg-green');
		});
	}


function add_actual(self,date,index){
	//val=self.prev().val();
	console.log(self);
	}

$(document).ready(function(e) {
    $(document).on('click','.add_actual',function(e){
		val=$(this).parent().prev().val();
		date=$(this).attr('data-date');
		index=$(this).attr('data-index');
		$.post('<?php echo bu('doctor/ajax_add_fund');?>',{val:val,date:date,index:index,id:<?php echo $patient_data->id;?>},function(data){
			window.location.href="<?php 
			if(!strpos($_SERVER['REQUEST_URI'],'tab2')) 
			echo $url=bu(str_replace('/doctorchachu/','',$_SERVER['REQUEST_URI'].'/'.'tab2'));
			else echo $url=bu(str_replace('/doctorchachu/','',$_SERVER['REQUEST_URI']))
			?>";
			//if(data==1) window.location.reload();
			});
		});
});

function add_fund(self,date,index){
	element=self.parent().parent().parent().parent().prev().prev().prev();
	html='<div class="input-group"><input type="number" value="0" class="form-control input-sm"><span class="input-group-btn"> <button data-date="'+date+'"  data-index="'+index+'"  class="btn btn-primary btn-sm add_actual" type="button">Go!</button> </span></div>';
	element.html(html);
	}
</script>

<?php  
if(empty($json)) echo 'No record found';

if(!empty($json) and is_array($json)){
echo '<ul class="timeline">';
$json=array_reverse($json);
foreach($json as $a=>$b): ?>

<li class="time-label">
        <span class="bg-red">
           <?php  echo ($a);?>
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-envelope bg-blue"></i>
        <div class="timeline-item">
        	
        	<span class="time">
            	<a href="javascript:printDiv('div3')"><button type="button" class="btn btn-default dropdown-toggle btn-sm m_btn" >
                        <i class="fa fa-fw fa-print"></i> Print 
                    </button></a>
            </span>
            

            <h3 class="timeline-header"><a href="#">Dr.<?php echo $this->session->userdata('name')?></a></h3>

            <div class="timeline-body">
               <table class="table table-bordered">
                                        <tbody><tr>
                                            <th style="width: 10px">#</th>
                                            <th>Treatment</th>
                                            <th>Cost(<i class="fa fa-fw fa-inr"></i>)</th>
                                            <th>Discount(<i class="fa fa-fw fa-inr"></i>)</th>
                                            <th>Total(<i class="fa fa-fw fa-inr"></i>)</th>
                                            <th>Paid(<i class="fa fa-fw fa-inr"></i>)</th>
                                            <th>Due(<i class="fa fa-fw fa-inr"></i>)</th>
                                            <th>Note</th>
                                            <th></th>
                                        </tr>
                                        
                                        <?php
										$counter=1;
										foreach($b as $x=>$y){
											$exp=explode('-::-',$y);
											if($exp[0]==1) echo '<tr class="bg-green">';
											else echo '<tr>';
											echo ' <td>'.$counter.'</td>';
											echo ' <td>'.$exp[1].'</td>';
											echo ' <td>'.$exp[2].'</td>';
											echo ' <td>'.$exp[3].'</td>';
											echo ' <td>'.$exp[4].'</td>';
											echo ' <td style="max-width: 210px;">'.$exp[5].'</td>';
											echo ' <td>'.$exp[6].'</td>';
											echo ' <td>'.$exp[7].'</td>';
											echo ' <td style="padding:0 3px">';
											echo '<div class="btn-group close" style="width:100%">
                    <button type="button" class="btn  btn-default dropdown-toggle c_btn btn-block" data-toggle="dropdown"">
                        Menu <i class="fa fa-fw fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu in" style="margin-left: -40px;">
                        <li><a onclick="delete_plan($(this),\''.$a.'\','.$x.')"><i class="fa fa-fw fa-trash-o"></i> Delete</a></li>';
                       	if($exp[0]==0) echo '<li><a  onclick="complete_plan($(this),\''.$a.'\','.$x.')"><i class="fa fa-fw fa-compass"></i>Mark as Complete</a></li>';
						
						if($exp[0]==0) echo '<li><a  onclick="add_fund($(this),\''.$a.'\','.$x.')"><i class="fa fa-fw fa-money"></i>Add fund</a></li>';
						
                   echo ' </ul>
                </div>';
											
											echo '</td>';
											$counter++;
											}
                                        
										?>
                                        
                                         
                                         
                                         
                                         
                                    </tbody></table>
            </div>

           
        </div>
    </li>

<?php endforeach;}?>

    <!-- timeline time label -->
    
    
</ul>