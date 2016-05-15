<?php 
$json=json_decode($json,true);
//var_dump($json);
$time5=time();
?>

<div class="box box-solid box-primary collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-fw fa-clock-o"></i><?php echo addOrdinalNumberSuffix($counter+1);?> Shedule of Week &nbsp;</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-primary btn-sm" onClick="location.reload()" data-toggle="tooltip" title="Refresh this shedule" data-original-title="Collapse"><i class="fa fa-refresh"></i></button>
                            <a href="<?php echo bu('doctor/delete_shedule/'.$id.'/'.$doctor_id.'/'.$clinic_id.'/'.$time5.'/'.ghash($time5))?>" onClick="return confirm('Are you sure you want to delete this shedule?')"><button class="btn btn-primary btn-sm"><i class="fa fa-trash-o"></i></button></a>
                            <button class="btn btn-primary btn-sm"  data-widget="collapse" ><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body" style="display: none;">
                        
                        <form class="form_submition" id="form_<?php echo $id;?>">
                        <input type="hidden" name="id" 		value="<?php echo $id?>">
                        <input type="hidden" name="clinic_id" 	value="<?php echo $clinic_id?>">
                        <input type="hidden" name="doctor_id" 	value="<?php echo $doctor_id?>">
                        <div class="ss_j_holder">
                        
                        <table style="width:100%">
                        	<tr>
                              	<td><input name="ckb_sunday" type="checkbox"  value="sunday" 
						<?php if($sunday==$id) echo 'checked';?>/> <label> Sun</label></td>
                                    <td><input name="ckb_sunday" type="checkbox" value="monday"
                                    <?php if($monday==$id) echo 'checked';?>/> <label> Mon</label></td>
                                    <td><input name="ckb_sunday" type="checkbox" value="tuesday"
                                    <?php if($tuesday==$id) echo 'checked';?>/> <label> Tues</label></td>
                                    <td><input name="ckb_sunday" type="checkbox" value="wednesday"
                                    <?php if($wednesday==$id) echo 'checked';?>/> <label> Wed</label></td>
                                    <td><input name="ckb_sunday" type="checkbox" value="thursday"
                                    <?php if($thursday==$id) echo 'checked';?>/> <label> Thru</label></td>
                                    <td><input name="ckb_sunday" type="checkbox" value="friday"
                                    <?php if($friday==$id) echo 'checked';?>/> <label> Fri</label></td>
                                    <td><input name="ckb_sunday" type="checkbox" value="saturday"
                                    <?php if($saturday==$id) echo 'checked';?>/> <label> Sat</label></td>
                              </tr>
                        </table>
                        <hr />

<?php
if(!empty($json))
foreach($json as $a=>$b){
	$start	=explode(':',$b['start']);
	$end		=explode(':',$b['end']);
	
	$start_hour		=$start[0];
	$start_minute	=$start[1];
	$start_maridian	=$start[2];
	
	$end_hour		=$end[0];
	$end_minute		=$end[1];
	$end_maridian	=$end[2];
	
	
	echo '<label><i class="fa fa-fw fa-wheelchair"></i></i>'.addOrdinalNumberSuffix($a+1).' Hour <small>&nbsp;&nbsp;&nbsp;Please Select Time Range</small></label>

<table>
    <tr>
            <td>
        <div class="input-group margin">
            <div class="input-group-btn input-group">
                    <button type="button" class="btn disco btn-default dropdown-toggle">
                Start Time <span class="fa fa-caret-down"></span>
                <ul class="dropdown-menu">
                    <i class="fa fa-fw fa-times-circle close_dropdown"></i>
                    <table class="mega_me">
                        <tbody>
                            <tr class="change_inc">
                                <td>
                            <a data-action="incrementHour">
                        <i class="glyphicon glyphicon-chevron-up"></i>
                            </a>
                        
                        <input type="hidden" class="d_val" value="'.$start_hour.'" />
                        <div class="bootstrap-timepicker-hour">'.$start_hour.'</div>
                        <a data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            </td>
                        
                        
                            <td>:</td>
                            <td><a data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                <input type="hidden" class="d_val" value="'.$start_minute.'" />
                                <div class="bootstrap-timepicker-minute">'.$start_minute.'</div>
                                <a data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td>
                            <td>&nbsp;</td>
                            <td><a data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                <input type="hidden" class="d_val" value="'.$start_maridian.'" />
                                <div class="bootstrap-timepicker-meridian">'.$start_maridian.'</div>
                                <a >&nbsp;</a></td>
                        </tr>
                            </tbody>
                        
                    </table>
			  
                </ul>
                    </button>
            </div>
            <!-- /btn-group -->
            <input type="text" class="form-control time_picker" name="start" data-role="start" value="'.$start_hour.':'.$start_minute.' '.$start_maridian.'" readonly>
        </div>
            </td>
            <td>
        <div class="input-group margin">
            <div class="input-group-btn input-group">
                    <button type="button" class="btn disco btn-default dropdown-toggle">
                End Time <span class="fa fa-caret-down"></span>
                <ul class="dropdown-menu">
                    <i class="fa fa-fw fa-times-circle close_dropdown"></i>
                    <table class="mega_me">
                        <tbody>
                            <tr class="change_inc">
                                <td>
                            <a data-action="incrementHour">
                        <i class="glyphicon glyphicon-chevron-up"></i>
                            </a>
                        
                        <input type="hidden" class="d_val" value="'.$end_hour.'" />
                        <div class="bootstrap-timepicker-hour">'.$end_hour.'</div>
                        <a data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            </td>
                        
                        
                            <td>:</td>
                            <td><a data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                <input type="hidden" class="d_val" value="'.$end_minute.'" />
                                <div class="bootstrap-timepicker-minute">'.$end_minute.'</div>
                                <a data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td>
                            <td>&nbsp;</td>
                            <td><a data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                <input type="hidden" class="d_val" value="'.$end_maridian.'" />
                                <div class="bootstrap-timepicker-meridian">'.$end_maridian.'</div>
                                <a >&nbsp;</a></td>
                        </tr>
                            </tbody>
                        
                    </table>
                </ul>
                    </button>
            </div>
            <!-- /btn-group -->
            <input type="text" class="form-control time_picker" name="end" data-role="end" value="'.$end_hour.':'.$end_minute.' '.$end_maridian.'" readonly>
        </div>
            </td>
    </tr>
    <span style="margin-left:20px; color:#900; cursor:pointer" onclick="$(this).next().remove();$(this).prev().remove();$(this).remove();"><i class="fa fa-fw fa-trash-o" ></i>Delete this timing</span>
</table>';
	}

?>           </div>  <!-- end of ss_j_holder-->
                        <button class="btn btn-info btn-block" type="submit"> <span id="ajax_holder"></span> &nbsp;&nbsp;Update</button>
                        
                        </form>
                        <br />
                        <button class="btn btn-success add_ad" type="button"> + Add Another Time Range</button>
                              
                              
                        
                    </div><!-- /.box-body -->
                </div>