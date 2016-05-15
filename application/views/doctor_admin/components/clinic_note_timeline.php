<?php $json=json_decode($patient_data->clinical_notes,true);
if(!isset($json[$this->session->userdata('id')]))
$json='';
else
$json=$json[$this->session->userdata('id')];

?>

<?php  
if(empty($json)) echo 'No record found';

if(!empty($json) and is_array($json)){
echo '<ul class="timeline">';
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
                                            <th>Complaints</th>
                                            <th>Observations</th>
                                            <th >Diagnoses</th>
                                        </tr>
                                        
                                        <?php
										$counter=1;
										foreach($b as $x=>$y){
											$exp=explode('-::-',$y);
											echo '<tr>';
											echo ' <td>'.$counter.'.</td>';
											echo ' <td>'.$exp[0].'.</td>';
											echo ' <td>'.$exp[1].'.</td>';
											echo ' <td>'.$exp[2].'.</td>';
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