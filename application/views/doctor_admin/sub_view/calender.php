<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='<?php echo bu('style/fullcalendar.css');?>' rel='stylesheet' />
<script src='<?php echo bu('js/plugins/fullcalender/moment.min.js');?>'></script> 
<script src='<?php echo bu('js/plugins/fullcalender/fullcalendar.min.js');?>'></script>
 

<?php $timing=$c_data->timing;
if(!empty($timing)) {
	$timing_json=json_decode($timing,true);
	
	$timing_array=array();
	foreach($timing_json as $a=>$b){
		$timing_array[]=$a;
		}
	
	
	$days_array=array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
	$index_array=array();
	foreach($days_array as $a=>$b){
		if(in_array($b,$timing_array)) $index_array[]=$a;
		}
	$dummy_array=array(0,1,2,3,4,5,6);
	$norm_array=array_diff ($dummy_array,$index_array);
	
	//Get the earliest opening time of the clinic in the week
	//var_dump($timing_json);	
	$opening=array();
	foreach($timing_json as $a=>$day){
		$start=$day[0]['start'];
		$temp=explode(':',$start);
		$opening[]=$time_in_24_hour_format  = date("H:i", strtotime($temp[0].':'.$temp[1].' '.$temp[2]));;
		}
	$opening=array_unique($opening);
	$opening=min($opening);
	
	//Get the latest closing time of the clinic in the week
	
	$closing=array();
	foreach($timing_json as $a=>$day){
		if(isset($day[1]['end'])) $end=$day[1]['end'];
		else $end=$day[0]['end'];
		$temp=explode(':',$end);
		$closing[]=$time_in_24_hour_format  = date("H:i", strtotime($temp[0].':'.$temp[1].' '.$temp[2]));;
		}
	$closing=array_unique($closing);
	$closing=max($closing);
	 
	}
?>
<script>
	$(document).ready(function() {	 

		/* initialize the calendar
		-----------------------------------------------------------------*/
		
		$('#calendar').fullCalendar({ 
			
		
			hiddenDays: [<?php echo implode(',',$norm_array);?>],
			header: {
				left: 'prev,next,today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultDate: '<?php echo date('Y-m-d');?>',
			editable: true,
			eventLimit: true, // allow "more" link when too many events 
			events: <?php echo $app_data;?>,
			scrollTime:'<?php echo $opening;?>',
			minTime:'<?php echo $opening;?>',
			maxTime:'<?php echo $closing;?>',
			slotDuration:'00:15:00',
			eventColor:'#f39c12', 
			eventClick: function(calEvent, jsEvent, view) {				
				open_dialogue(calEvent, jsEvent, view);				 
			}
			 		
			
			
		});


	});
function open_dialogue(calEvent, jsEvent, view){
	$('#myModal2').modal('show');
	console.log(calEvent, jsEvent, view);
	target='evt_'+calEvent.id;
	$(jsEvent.currentTarget).addClass(target);
	str='';
	str+='<h3>'+calEvent.title+'</h3>';
	
	if(calEvent.completed==0)
	str+='<small class="badge pull-right bg-yellow">Not completed</small>';
	else 
	str+='<small class="badge pull-right bg-green">Completed</small>';
	
	str+='<h4>'+calEvent.phone+'</h4>';
	if(calEvent.email!=0)
	str+='<h4>'+calEvent.email+'</h4>';
	str+='<input type="hidden" value="'+calEvent.id+'" id="app_id">';
	str+='<input type="hidden" value="'+jsEvent.currentTarget+'" id="target">';
	str+='<h5>Time:'+(calEvent._start._i).replace('T',' at ')+'</h5>'; 
	str+='<hr>';
	
	str+='<button id="del_btn" class="btn btn-flat btn-danger btn-sm"	onclick="del_app('+calEvent.id+','+calEvent.timestamp+')"><i class="fa fa-trash-o"></i> Delete</button>&nbsp;&nbsp;&nbsp;';
	str+='<button class="btn btn-flat btn-success btn-sm">Mark as Complete</button>';
	$('#app_detail').html(str);
	}

function del_app(id,timestamp){
	//console.log(target);
	$('#del_btn').html('<img src="<?php echo bu('images/ajax_rt.gif');?>"> Please wait');
	
	$.post('<?php echo bu('doctor/ajax_del_app');?>',{'id':id,'timestamp':timestamp},function(data){
		data=data.trim(); 
		if(data!=0)		$('#del_btn').html('<i class="fa fa-check"></i> Deleted');
		if(data==0)		$('#del_btn').html('<i class="fa fa-times"></i> Error');
		selector='.evt_'+data;  
		$(selector).hide(200);
		$('#deleted_flag').val(1);
		});
	}

$(document).on('click',$('.fc-month-button,.fc-agendaWeek-button,.fc-agendaDay-button'),function(event){
	location=location.href;
	if($('#deleted_flag').val()==1){
		//Reload the page
		document.location.href('');
		console.log(2);
		}
	});
</script>
<input type="hidden" id="deleted_flag" value="0">
<style> 
 
.fc-nonbusiness{ background:#666; cursor:no-drop}
	 
		
	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
	}
		
	#external-events .fc-event {
		margin: 10px 0;
		cursor: pointer;
	}
		
	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
	}
		
	#external-events p input {
		margin: 0;
		vertical-align: middle;
	}

	#calendar { 
		width: 100%;
	}
.fc-unthemed th, .fc-unthemed td, .fc-unthemed thead, .fc-unthemed tbody, .fc-unthemed .fc-divider, .fc-unthemed .fc-row, .fc-unthemed .fc-popover{ border-color:#000;}
.fc th, .fc td{ background:rgba(255,255,255,.4);font-weight: bold;}
.content {padding: 20px 0px;}
.old,.new{ color:#CCC}
.day{ cursor:pointer;text-align: center;}
.active.day{ background:#00BDF7 !important;}
.day:hover{ background:#3C8DBC; color:#FFF}
.datepicker{ width:220px}
.datepicker-switch,.next,.prev{ text-align:center; cursor:pointer}
.table.table-condensed{ margin-bottom:0}
#datepicker{max-width: 100%;
margin-bottom: 10px;} 
.content {background: url(<?php echo bu('images/blur-background09.jpg');?>) !important;}
.mmon:hover{ opacity:.8} 

</style>

<div class="modal fade bs-example-modal-md" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Appointment Details</h4>
      </div>
      <div class="modal-body" id="app_detail">
      	...
      </div>
    </div>
  </div>
</div>

<aside class="right-side" >

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <i class="fa fa-fw fa-hospital-o"></i> <?php echo $c_data->name;?> 
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo bu('doctor/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Calender</li>
                    </ol>
                </section>

                <!-- Main content -->
                 <section class="content">
                <div class="container" style="  width: 100%;">

		<div  class="col-lg-2 no-pad" id='external-events'> 
        <h4><i class="fa fa-fw fa-medkit"></i> Appointments</h4>
			<a class="btn btn-flat btn-xs btn-block btn-info" href="<?php echo bu('doctor/calender');?>">All Appointments</a>
			
            <?php 
			//Get all the doctors belongs to the clinic
			$all_doctors=get_all_doctor_by_clinic($this->session->userdata('primary'));
			foreach($all_doctors as $a=>$b):
			if(!empty(get_doctor_name_by_id($b))):
			?>
             <a class="btn mmon btn-flat btn-xs btn-block btn-primary" style="background:<?php echo random_color($b);?>" 
             href="<?php echo bu('doctor/calender/'.$b);?>">Dr.<?php echo get_doctor_name_by_id($b);?></a>
             
             <?php endif;endforeach;?>
			<p>
			</p>
             
		</div>
		<div class="col-lg-10 ">
        
		<div  id="calendar"></div>
        </div>

		<div style='clear:both'></div>

	</div>
                 
                 </section>
                <!-- /.content -->
            </aside>
