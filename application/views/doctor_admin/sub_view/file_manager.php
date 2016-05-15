<style>
hr{ margin:3px 0}
.modal-lg {
width: auto ;
}
@media (min-width: 768px){
.modal-dialog {
margin: 30px 5%;
}
}
.tp{ padding:0 10px; }
.sm_dp{ height:40px;}
.detail_head{ width:100%}
.table{margin-bottom:5px}
.s-menu{ position:absolute; right:0}
.callout.callout-success {
background-color: #f0fdf0;
border-color: #d2f0d0;
}
.hid_text{text-overflow: ellipsis;max-width: 120px;overflow: hidden;}
.sm_btn{ display:none}
.sm_btn:last-child{display:block}
.detail_head{ color:#39C}
.detail_head:hover{ color:#666}
.badge{ margin:0 10px}
.mega_p p{ margin:0}
.bokka{float: right;}
.mega_p a{ color:#33B2E2 !important}
.file{ width:120px; background:#fff; float:left; margin:5px; cursor:pointer; text-align:center;border-radius: 14px;margin-bottom: 21px;}
.checker,.icheckbox_minimal{ margin:1px !important; zoom:1.6}
.jp{margin: 10px; margin-bottom:0px;height: 50px;}
.file_n {font-size: 11px;
overflow: hidden;
max-width: 120px;}
#img_prev_holder{ padding:10px; max-height:400px; text-align:center}
#pre_img{ max-height:100%}
.markme{ cursor:pointer}
.markme.disabled{ cursor:default; color:rgba(0,0,0,.4)}

.show_more:not(:last-child) { display:none}
.mha:not(:first-child) { display:none}

</style>
<script>

function prepare_attachment(self){ 
	pid=self.attr('data-pid');
	attachment=self.attr('data-rel_path');
	$.post('<?php echo bu('doctor/ajax_prepare_attachment');?>',{'attachment':attachment,'pid':pid},function(data){ 
		if(data==1) {setTimeout(function(){$('.mob').toggle();},1000)}
		});
	}

function check_uncheck(){
	length=$('.checker:checked').length;
	if(length){
		$('.markme').removeClass('disabled');
		}
	else {$('.markme').addClass('disabled');}
	}

$(document).on('click','.checker',function(){
	check_uncheck()
	});

$(document).ready(function(e) { 
  get_files();
});

function append_result(offset){
	$.post('<?php echo bu('doctor/get_files/');?>'+offset,{'type':type,'filter':filter,'search_key':search_key,<?php if(isset($pid)) echo 'pid:'.$pid?>},function(data){ 
	 // console.log(data);
		$('#main_box').append(data); 
		check_uncheck();
		})
		
	 
	}
function selall(deselect){
	if(deselect==1){$('.checker').prop('checked',false) ;}
	else{$('.checker').prop('checked',true) ;}
	check_uncheck();
	}
 
$(document).on('click','.change_filter',function(){ 
	event.preventDefault();
	$('.change_filter').removeClass('bg-blue');
	$(this).addClass('bg-blue');
	$('#type_helper').val($(this).attr('data-row'));
	$('#filter_helper').val($(this).attr('data-filter'));
	
	get_files();
	
	});

function get_files(offset){
	if(offset==undefined){offset=0}
	
	html='<div align="center">        <br /><br /><br /><br /><br /><br />        <img src="<?php echo bu('images/ajax-loader.gif')?>"></div>    </div>';
	$('#main_box').html(html);
	type	=$('#type_helper').val();
	filter	=$('#filter_helper').val();
	search_key=$('#search_key').val();
	  $.post('<?php echo bu('doctor/get_files/');?>'+offset,{'type':type,'filter':filter,'search_key':search_key,<?php if(isset($pid)) echo 'pid:'.$pid?>},function(data){ 
	 // console.log(data); 
		$('#main_box').html(data); 
		check_uncheck();
		})
	}

$(document).on('click','.img_preview',function(){
	$('#img_preview').modal('show');
	html='<img src="'+$(this).attr('data-src')+'" class="pre_img">';
	$('#img_prev_holder').html(html);
	});

$(document).on('submit','#s_form',function(){
	event.preventDefault();
	$('#type_helper').val('');
	$('#filter_helper').val('');
	get_files();
	});

function delete_file(self){
	parent=self.closest('.file');
	file_src=$(parent).attr('data-src'); 
	$.post('<?php echo bu('doctor/ajax_delete_file');?>',{'src_id':file_src},function(data){
		console.log(data);
		if(data==1 || data==11){
			get_files()
			}
		})
	}

function delete_selected(){ 
	$('.checker:checked').each(function(index, element) {
		parent=$(this).closest('.file');
		file_src=(parent.attr('data-src'));
		console.log(file_src);
		$.post('<?php echo bu('doctor/ajax_delete_file');?>',{'src_id':file_src},function(data){})
		});
	get_files();
	}
</script>


<input type="hidden" id="type_helper" value="" />
<input type="hidden" id="filter_helper" value="" />

<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
 

<h1 class="page-header" style="padding: 10px;">
	 
     
    <a data-toggle="modal" onclick="event.preventDefault();" class="btn btn-default" href="<?php echo bu('doctor/records/0/file_manager')?>" data-target=".bs-example-modal-lg">
     	 <i class="fa fa-fw fa-users"></i>
     </a>
     <?php if(isset($pid)):?>
      <a style="margin:0 5px" href="<?php echo bu('doctor/upload_file/'.$pid);?>" class="btn btn-primary btn-flat btn-sm pull-right">+ Upload File</a>
      <?php endif;?>
    FILE MANAGER  

</h1>
<?php 
$percentage=100;
$total=100000000;
$total_used_memory=$total_used_memory;
$percentage=intval(((100000000-$total_used_memory)/100000000)*100);

?>
<div class="container">
<div class="col-xs-6">
<strong><i class="fa fa-fw fa-bar-chart-o"></i>Available Memory </strong> <small class="pull-right"><?=$percentage?>% Remaining</small>
<div class="progress progress-striped active">
    <div class="progress-bar progress-bar-<?php if($percentage<=30 and $percentage>15) echo 'warning';
	elseif($percentage<=15) echo 'danger';
	else echo 'success';
	?>" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percentage;?>%">
        
    </div>
</div>
</div>

</div>

<?php display_msg($this->session->flashdata('message'),$this->session->flashdata('type'));?>


<div class="<?php if(isset($p_data)) echo 'col-sm-8'; else echo 'col-sm-12';?> col-xs-12 ">
    <div class="col-xs-12  no-pad">
                            <div class="box box-solid">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4" style="border-right: 1px dotted #B9B9B9;">
                                             
<div style="margin-top: 15px;">
    <ul class="nav nav-pills nav-stacked">
        <li class="header">Type</li>
        <li><a href="#" class="change_filter" data-row="type" data-filter=""><i class="fa  fa-file-text"></i> All File</a></li>
        <li><a href="#"  class="change_filter"  data-row="type"  data-filter="pdf"><i class="fa  fa-file-text-o"></i> PDFs</a></li>
        <li><a href="#"  class="change_filter"  data-row="type"  data-filter="image"><i class="fa fa-picture-o"></i> Images</a></li>
       
    </ul>
    
    <ul class="nav nav-pills nav-stacked">
        <li class="header">Time</li>
        <li><a href="#"  class="change_filter"  data-row="date_created"  data-filter="today"><i class="fa  fa-file-text"></i> Today</a></li>
        <li><a href="#" class="change_filter" data-row="date_created" data-filter="last_seven"><i class="fa  fa-file-text-o"></i> Last 7 Days</a></li>
        <li><a href="#" class="change_filter" data-row="date_created" data-filter=""><i class="fa fa-picture-o"></i> All time</a></li>
       
    </ul>
</div>
                                        </div><!-- /.col (LEFT) -->
                                        <div class="col-md-9 col-sm-8" style="max-height: 450px;overflow: auto;">
                                            <div class="row pad">
                                                <div class="col-sm-6">
                                                    
                                                    <!-- Action button -->
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
    <ul class="dropdown-menu" role="menu">
        <li><a   class="markme disabled" onclick="event.preventDefault();delete_selected()"><i class="fa fa-trash-o"></i> Delete</a></li>
         <li><a   class="markme disabled"><i class="fa fa-envelope"></i> Email
         </a></li> 
        <li class="divider"></li>
        <li><a href="" onclick="event.preventDefault();selall();"><i class="fa fa-check-square-o"></i> Select All</a></li>
        <li><a href="" onclick="event.preventDefault();selall(1);"><i class="fa fa-square-o"></i> Deselect All</a></li>
    </ul>
                                                    </div>

                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form id="s_form" class="text-right">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control input-sm" placeholder="Search" id="search_key">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="q" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.row -->
 
    <div class="table-responsive">
        <!-- THE MESSAGES -->
        <div  id="main_box">
         
        
         
         
        
        
        
        <div align="center">
        <br /><br /><br /><br /><br /><br />
        <img src="<?php echo bu('images/ajax-loader.gif')?>" /></div>
        </div>
        
    </div><!-- /.table-responsive -->
</div><!-- /.col (RIGHT) -->
                                    </div><!-- /.row -->
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    
                                </div><!-- box-footer -->
                            </div><!-- /.box -->
                        </div> 
</div>
 
<?php if(isset($p_data))$this->load->view('doctor_admin/components/patient_note',array('p_data'=>$p_data));?>
 


 
</div>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      </div>
    </div>
  </div>
</div>
</div>

</div>

<div class="modal fade" role="dialog" id="img_preview" aria-hidden="true" >
    <div class="modal-dialog" style="margin: 100px auto;">
      <div class="modal-content">
        
        <div class="modal-body" id="img_prev_holder">
        
        <div align="center">
        <br /><br /><br />
        <img src="<?php echo bu('images/ajax-loader.gif')?>" />
        <br /><br /><br />
        </div>
        </div>
        
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


