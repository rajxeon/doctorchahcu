<script>
function toggle_search(){
	event.preventDefault();
	$('.mora').fadeToggle(0);
	}
</script>
<div class="container-fluid" style="padding: 0;">
  	  <div class="col-xs-12 bg-light-blue no-pad" style="padding: 1px 0;">
      	<div class="col-lg-5 col-md-4 col-sm-5 col-xs-8">
        <?php if(!$show_head):?>
        	<a class="btn-info btn btn-flat" href="<?php echo bu('doctor/records');?>" 
            style="width:29%;margin-top: -3px;"> <i class="fa fa-fw fa-external-link-square"></i> See all patient</a>
        <?php endif;?>
        <span class="mora">
        	<input type="text" class="form-control" placeholder="Search Patient Name / Id / Aadhaar / Phone" 
            style="margin: 4px 0;<?php if(!$show_head) echo 'width: 70%; display:inline-block';?>" onKeyUp="search_patient($(this),'<?php echo $link;?>')" value="<?php echo $q;?>" id="search_q">
            
        </span>
        
        <span class="mora" style="display:none">
        	  <input type="text" class="form-control" placeholder="Search Patient Name / Id / Aadhaar / Phone" 
            style="margin: 4px 0;<?php if(!$show_head) echo 'width: 70%; display:inline-block';?>" onKeyUp="search_patient($(this))" value="<?php echo $q;?>" id="search_q">          
        </span>
        
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2  col-xs-4 no-pad">
        	<a href="" class="mora" onclick="toggle_search()" style="color: #fff;display: block;"><br />Advance Search</a>
            <a href="" class="mora" onclick="toggle_search()" style="color: #fff;display:none"><br />Basic Search</a>
        </div>
        <div class="col-lg-5  col-md-6 col-sm-5  col-xs-12 " align="right">
        	<a href="<?php echo bu('doctor/add_patient');?>">
            	<button class="btn btn-default btn-sm" style="margin: 6px;">+Add new patient</button>
            </a>
            <?php if(!$show_head):?>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: 9px;">
             <span aria-hidden="true">&times;</span></button>
             <?php endif;?>
             
        </div>
      </div>
  </div>
  <br clear="all">
  <div class="container-fluid">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding-left: 0;">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Patients</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
        </div>
        <div class="box-body">
          <button class="btn btn-default btn-block btn-flat" onClick="get_patients(0,'<?php echo $link;?>')">All patient 
          <small class="badge pull-right bg-green"><?php echo $patient_count;?></small></button>
          <button class="btn btn-default btn-block btn-flat" >Recently Visited </button>
          <button class="btn btn-default btn-block btn-flat"  onClick="get_recent_patients(0,'<?php echo $link;?>')">Recently added </button>
        </div>
      </div>
      
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Groups</h3>
          <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
        </div>
        <div class="box-body">
        <?php foreach($group_ar_count as $a=>$b):?>
        <button class="btn btn-default btn-block btn-flat" 
        onClick="get_patients_by_group(0,'<?php echo $a?>','<?php echo $link;?>')"><?php echo $a;?> 
        <small class="badge pull-right bg-green"><?php echo $b;?></small></button>
        
        <?php endforeach;?>
          
        </div>
      </div>
      
      
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12"> 
    <?php //echo $debug;?>
    <div class="box box-primary row">
        <div class="box-body " id="patient_h_body" <?php if(!$show_head) echo 'style="max-height: 390px;overflow: auto;"'?>>
        <img src="<?php echo bu('images/ajax-fast-loader.gif');?>" style="display: block;height: 67px;margin: 100px auto;">
          
        </div>
      </div>
     
    
    </div>
  </div>