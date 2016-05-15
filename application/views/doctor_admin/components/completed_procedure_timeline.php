<?php $json=json_decode($patient_data->treatment_plans,true);
if(!isset($json[$this->session->userdata('id')]))
$json='';
else
$json=$json[$this->session->userdata('id')];

?>
<script>
function submit_edit_plan(self){
	element=self.parent();
	
	note=element.prev();
	note_txt=note.find($('input')).val();
	
	paid=element.prev().prev().prev();
	paid_txt=paid.find($('input')).val();
	
	discount=element.prev().prev().prev().prev().prev();
	discount_txt=discount.find($('input')).val();
	
	cost=element.prev().prev().prev().prev().prev().prev();
	cost_txt=cost.find($('input')).val();
	
	treatment=element.prev().prev().prev().prev().prev().prev().prev();
	treatment_txt=treatment.find($('input')).val();
	
	index	=self.attr('data-index');
	date	=self.attr('data-date');
	
	//console.log(note_txt,paid_txt,discount_txt,cost_txt,treatment_txt);
	url="<?php echo bu('doctor/handle_post_patirnt_expand/'.$patient_data->id.'/tab3/com_pro_edit');?>";
	
	$.post(url,{index:index,date:date,treatment_plan:treatment_txt,cost:cost_txt,discount:discount_txt,advance:paid_txt,note:note_txt},function(data){
		if(data==1) window.location.href="<?php echo bu('doctor/patients/'.$patient_data->id.'/tab3');?>";
		});
	
	}

function edit_plan(self,date,index){
	element=self.parent().parent().parent().parent();
	element.html('<button class="btn btn-success btn-sm form-control" data-date="'+date+'" onclick="submit_edit_plan($(this))" data-index="'+index+'" style="margin-top:8px">Save</button>');
	
	note=element.prev();
	note_txt=note.text();
	
	paid=element.prev().prev().prev();
	paid_txt=paid.text();
	
	discount=element.prev().prev().prev().prev().prev();
	discount_txt=discount.text();
	
	cost=element.prev().prev().prev().prev().prev().prev();
	cost_txt=cost.text();
	
	treatment=element.prev().prev().prev().prev().prev().prev().prev();
	treatment_txt=treatment.text();
	
	treatment.html('<input type="text" class="form-control treatment" value="'+treatment_txt+'">');
	note.html('<input type="text" class="form-control note" value="'+note_txt+'">');
	paid.html('<input type="number" class="form-control paid" value="'+paid_txt+'">');
	discount.html('<input type="number" class="form-control discount" value="'+discount_txt+'">');
	cost.html('<input type="number" class="form-control cost" value="'+cost_txt+'">');
	
	}
</script>

<?php  
if(empty($json)) echo 'No record found';

if(!empty($json) and is_array($json)){
echo '<ul class="timeline">';
$json=array_reverse($json);
foreach($json as $a=>$b): 

$has_item=0;


//check if any completed procedure on a day
foreach($b as $x=>$y){
	$exploded_y=explode('-::-',$y);
	if($exploded_y[0]==1){ $has_item=1; break;}
	}

if($has_item):
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
											if($exp[0]==1):
											$has_item=1;
											echo '<tr>';
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
                        <li><a onclick="delete_plan($(this),\''.$a.'\','.$x.')"><i class="fa fa-fw fa-trash-o"></i> Delete</a></li>
						<li><a onclick="edit_plan($(this),\''.$a.'\','.$x.')"><i class="fa fa-fw fa-pencil"></i> Edit</a></li>';
                       	
						
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