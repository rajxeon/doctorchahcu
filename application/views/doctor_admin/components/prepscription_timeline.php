<?php $json=json_decode($patient_data->prepscription,true);
if(!isset($json[$this->session->userdata('id')]))
$json='';
else
$json=$json[$this->session->userdata('id')];

?>
<script>
function delete_prepscription(self,date,index){
	if(!confirm('Are you sure you want to delete this drug?')) return;
	event.preventDefault();
	$.post('<?php echo bu('doctor/ajax_delete_prepscription')?>',{date:date,index:index,id:<?php echo $patient_data->id;?>},function(data){
		//console.log(data);
		if(data==1) self.parent().parent().parent().parent().parent().hide(200);
		});
	}
	
function submit_prep(self){
	element=self.parent();
	
	night=element.prev();
	night_txt=night.find($('input')).val();
	
	noon=element.prev().prev();
	noon_txt=noon.find($('input')).val();
	
	morning=element.prev().prev().prev();
	morning_txt=morning.find($('input')).val();
	
	instruction=element.prev().prev().prev().prev();
	instruction_txt=instruction.find($('input')).val();
	
	duration=element.prev().prev().prev().prev().prev();
	duration_txt=duration.find($('input')).val();
	
	drug=element.prev().prev().prev().prev().prev().prev();
	drug_txt=drug.find($('input')).val();
	
	names=element.prev().prev().prev().prev().prev().prev().prev();
	names_txt=names.find($('input')).val();
	
	index	=self.attr('data-index');
	date	=self.attr('data-date');
	
	//console.log(night_txt,noon_txt,morning_txt,instruction_txt,duration_txt,drug_txt,names_txt,index,date);
	url="<?php echo bu('doctor/edit_prep');?>";
	
	$.post(url,{index:index,date:date,name:names_txt,drug:drug_txt,duration:duration_txt,instruction:instruction_txt,morning:morning_txt,noon:noon_txt,night:night_txt,pid:<?php echo $patient_data->id?>},function(data){
		console.log(data);
		if(data==1) window.location.href="<?php echo bu('doctor/patients/'.$patient_data->id.'/tab5');?>";
		});
	
	}

function edit_prep(self,date,index){
	element=self.parent().parent().parent().parent();
	element.html('<button class="btn btn-success btn-sm form-control" data-date="'+date+'" onclick="submit_prep($(this))" data-index="'+index+'" style="margin-top:8px">Save</button>');
	
	night=element.prev();
	night_txt=night.text();
	
	noon=element.prev().prev();
	noon_txt=noon.text();
	
	morning=element.prev().prev().prev();
	morning_txt=morning.text();
	
	instruction=element.prev().prev().prev().prev();
	instruction_txt=instruction.text();
	
	duration=element.prev().prev().prev().prev().prev();
	duration_txt=duration.text();
	
	drug=element.prev().prev().prev().prev().prev().prev();
	drug_txt=drug.text();
	
	names=element.prev().prev().prev().prev().prev().prev().prev();
	names_txt=names.text();
	
	night.html('<input type="number" class="form-control night" value="'+night_txt+'">');
	noon.html('<input type="number" class="form-control noon" value="'+noon_txt+'">');
	morning.html('<input type="number" class="form-control morning" value="'+morning_txt+'">');
	instruction.html('<input type="text" class="form-control instruction" value="'+instruction_txt+'">');
	duration.html('<input type="text" class="form-control duration" value="'+duration_txt+'">');
	drug.html('<input type="text" class="form-control drug" value="'+drug_txt+'">');
	names.html('<input type="text" class="form-control names" value="'+names_txt+'">');
	
	}

</script>

<?php  
if(empty($json)) echo 'No record found';

if(!empty($json) and is_array($json)){
echo '<ul class="timeline">';
$json=array_reverse($json);
foreach($json as $a=>$b): 

$has_item=0;



if(1):
?>

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
                                            <th>Name</th>
                                            <th>Drug</th>
                                            <th>Duration</th>
                                            <th>Instruction</th>
                                            <th>Morning</th>
                                            <th>Noon</th>
                                            <th>Night</th>
                                            <th></th>
                                        </tr>
                                        <?php
										$counter=1;
										foreach($b as $x=>$y){
											$exp=explode('-::-',$y);
											if(11):
											echo '<tr>';
											echo ' <td>'.$counter.'</td>';
											echo ' <td>'.$exp[0].'</td>';
											echo ' <td>'.$exp[1].'</td>';
											echo ' <td>'.$exp[2].'</td>';
											echo ' <td>'.$exp[3].'</td>';
											echo ' <td>'.$exp[4].'</td>';
											echo ' <td>'.$exp[5].'</td>';
											echo ' <td>'.$exp[6].'</td>';
											echo ' <td style="padding:0 3px">';
											echo '<div class="btn-group close" style="width:100%">
                    <button type="button" class="btn  btn-default dropdown-toggle c_btn btn-block" data-toggle="dropdown"">
                        Menu <i class="fa fa-fw fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu in" style="margin-left: -40px;">
                        <li><a onclick="delete_prepscription($(this),\''.$a.'\','.$x.')"><i class="fa fa-fw fa-trash-o"></i> Delete</a></li>
						<li><a onclick="edit_prep($(this),\''.$a.'\','.$x.')"><i class="fa fa-fw fa-pencil"></i> Edit</a></li>';
                       	
						
                   echo ' </ul>
                </div>';
											
											echo '</td>';
											$counter++;
											endif;
											}
                                        
										?>
                                        
                                      
                                         
                                         
                                         
                                    </tbody></table>
            </div>

           
        </div>
    </li>

<?php endif; endforeach;}?>

    <!-- timeline time label -->
    
    
</ul>