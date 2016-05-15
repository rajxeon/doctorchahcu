<style>
.smc{width: inherit;  display: inline-block; margin-left:-4px}
.smss{  display: block;  color: #009;  text-decoration: none;  cursor: pointer; display:none}
.smss:hover{ text-decoration:underline}
.error_day{  background-color: rgb(255, 207, 207) !important; border-left: 5px solid #FF5F5F; 
background-image:url(<?php echo bu('images/overlay-pattern1.png');?>)}
.loader_overlay{ left:0}
</style>

<script>
	
	function copy_to_all(self){
		parent=self.closest('tr');
		
		s1fh=$(parent).find('.s1fh').val();
		s1fm=$(parent).find('.s1fm').val();
		s1fap=$(parent).find('.s1fap').val();
		s1th=$(parent).find('.s1th').val();
		s1tm=$(parent).find('.s1tm').val();
		s1tap=$(parent).find('.s1tap').val();
		
		s2fh=$(parent).find('.s2fh').val();
		s2fm=$(parent).find('.s2fm').val();
		s2fap=$(parent).find('.s2fap').val();
		s2th=$(parent).find('.s2th').val();
		s2tm=$(parent).find('.s2tm').val();
		s2tap=$(parent).find('.s2tap').val(); 
		
		s2checked=$(parent).find('.s2checked').prop('checked');
		 
		//Find all the open day
		$('.selectedTr').each(function(index, element) {
            $(this).find('.s1fh').val(s1fh);
			$(this).find('.s1fm').val(s1fm);
			$(this).find('.s1fap').val(s1fap);
			$(this).find('.s1th').val(s1th);
			$(this).find('.s1tm').val(s1tm);
			$(this).find('.s1tap').val(s1tap); 
			
			$(this).find('.s2fh').val(s2fh);
			$(this).find('.s2fm').val(s2fm);
			$(this).find('.s2fap').val(s2fap);
			$(this).find('.s2th').val(s2th);
			$(this).find('.s2tm').val(s2tm);
			$(this).find('.s2tap').val(s2tap); 
			
			if(s2checked==true)  $(this).find('.s2checked').prop('checked',true);
			else $(this).find('.s2checked').prop('checked',false);
        });
		
		}
	
	$(document).ready(function(e) {
		 
		
		checker_unchecker_auto();
		
		$('.s2').change(function(e) {
            parent=$(this).closest('tr');
			$(parent).find('.smc').prop('checked', true);
        }); 
		
		$('.check_unchecker').click(function(e) {
            check_uncheck($(this));
        });
		
		$('.cp2a').click(function(e) {
            copy_to_all($(this));
        });
    });
	function checker_unchecker_auto(){
		$('.check_unchecker:checked').each(function(index, element) {
            check_uncheck($(this));
        	});
		}
	function check_uncheck(self){
		checked=(self.context.checked);
		parent=self.closest('tr');
		
		if(checked==true){
			$(parent).addClass('selectedTr');
			$(parent).find('.smc').removeAttr('disabled');
			$(parent).find('.smss').show(0);
			}
		
		else {
			$(parent).removeClass('selectedTr');
			$(parent).find('.smc').attr('disabled','disabled');
			$(parent).find('.smss').hide(0);
			}
		}
	
	function prepare_json(self){
		$('.error_day').removeClass('error_day');
		self.html('<img src="<?php echo bu('images/ajax_rt.gif');?>"> Please Wait');
		days_array={} ;
		$('.check_unchecker:checked').each(function(index, element) {
			parent=$(this).closest('tr');
			day=$(this).attr('data-day');
			
			array=new Array();
			
			str={};
			str.start=$(parent).find('.s1fh').val()+':'+$(parent).find('.s1fm').val()+':'+$(parent).find('.s1fap').val();
			str.end=$(parent).find('.s1th').val()+':'+$(parent).find('.s1tm').val()+':'+$(parent).find('.s1tap').val();			
			array.push(str);
		
			s2checked=$(parent).find('.s2checked');
			s2checked=(s2checked.is(':checked'));
			
			if(s2checked){
				str={};
				str.start=$(parent).find('.s2fh').val()+':'+$(parent).find('.s2fm').val()+':'+$(parent).find('.s2fap').val();
				str.end=$(parent).find('.s2th').val()+':'+$(parent).find('.s2tm').val()+':'+$(parent).find('.s2tap').val();			
				array.push(str);
				}
			
			days_array[day]=array;
            
        });
		json=JSON.stringify(days_array); 		//Ajax call to the controller
		$.post('<?php echo bu('doctor/set_timing_ajax');?>',{'json':json},function(data){ 
			//console.log(data);return;
			if(data==1) self.html('<i class="fa fa-check"></i> Saved');
			else if(data==0) self.html('<i class="fa fa-times"></i> Error');
			else {
				self.html('<i class="fa fa-times"></i> Error');
				r_json=JSON.parse(data);  
				for (i = 0; i < r_json.length; i++) { 						
						$('#'+r_json[i]).addClass('error_day');
					}
				}
			
			
			
		});
		
		}
		
		function save_consultation_time(self){
			self.html('<img src="<?php echo bu('images/ajax_rt.gif');?>"> Saving');
			selected=$('#consultation_time').val();
			$.post('<?php echo bu('doctor/ajax_save_consultation_time');?>',{'time':selected},function(data){				
				if(data==0) self.html('<i class="fa fa-times"></i> Error');
				if(data==1) self.html('<i class="fa fa-check"></i> Saved');
				});
			}
</script>

 
<div id="page-wrapper" style=" position:relative;min-height: 100vh;"  class="right-side">
<?php $clinic_data=$clinic_data;?>
<div class="col-lg-12">
<h1 class="page-header">
	<?php echo $clinic_data->name;?>
    <small>Set Your Clinic Timing Timing </small>
</h1>
<ol class="breadcrumb">
    <li class="active">
        <i class="fa fa-dashboard"></i> Dashboard
        </li><li class="active">
        <i class="fa  fa-calendar-o"></i> Calander / <i class="fa fa-medkit"></i> Set Clinic Timing
        
    </li>
    
</ol>
</div>

<div class="container">
<h1 class="page-header" style="margin-bottom:0; width:40%">
	 <div class="form-group">
        <div class="input-group" style="width:80%;  float: left;"> <span class="input-group-addon"><i class="fa fa-fw fa-clock-o"></i>
         Consultation Time</span>
         <?php 
		 $options = array(
                  '3'  => '3 mins',
                  '5'    => '5 mins',
                  '7'   => '7 mins',
                  '10' => '10 mins',
				  '15'=>'15 mins',
				  '20'=>'20 mins',
				  '30'=>'30 mins',
				  '45'=>'45 mins',
				  '60'=>'60 mins'
                );
 	
		echo form_dropdown('time', $options, $clinic_data->consultation_time,' id="consultation_time" class="form-control" ');
		 
		 ?>       
             
        </div>
        <button class="btn  btn-success btn-flat" onclick="save_consultation_time($(this))" style="width:20%">Save</button>
    </div>
    
</h1> 

<!--Start of table box-->

<div class=" row box" style="  border: 0;"> 
    <div class="box-body no-padding">
        <table class="table table-striped">
            <tbody><tr>
                <th style="width: 10%" class="bg-blue">Clinic is Open</th>
                <th style="width: 44%" class="bg-blue">Session 1</th>
                <th style="width: 2%" class="bg-blue">&nbsp;</th>
                <th style="width: 44%" class="bg-blue">Session 2</th> 
            </tr>
            <?php $day_array=array('monday','tuesday','wednesday','thursday','friday','saturday','sunday'); ?>            
			<form id="reseter">
			<?php 
            foreach($day_array as $a=>$b){
               from_to($b);			
                }
            ?> 
            </form>
        </tbody></table>
    </div><!-- /.box-body -->
</div>
<!--End of table box-->

   

</div>    
<button onClick="prepare_json($(this))" class="btn btn-flat btn-sm btn-success pull-right" style="margin-right:40px"><i class="fa fa-save"></i> Save</button>


<button onClick="document.getElementById('reseter').reset();"
class="btn btn-flat btn-sm  btn-primary pull-right" style="margin-right:10px"><i class="fa fa-refresh"></i> Reset</button>