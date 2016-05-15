<style>
.nav-tabs.nav-justified>li{ display:table-cell !important}
.nav li  a{border:none !important;}
#search_box{font-size: 12px;height: 34px;width: 87%;float: left;border-top-right-radius: 0;border-bottom-right-radius: 0;}
</style>
<div class="row">
                  <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12" align="center" style="padding:0">
                  <span  style="height:90px; display:inline-block">
                  <a href="<?php echo bu('')?>"><img src="<?php echo bu('images/logo.png');?>" style="margin-top: 10px;max-height: 80px;"></a>
                  </span>
                  	
                  </div>
                  <div class="col-md-4 col-lg-4 hidden-sm hidden-xs"></div>
                  <div class="col-md-5 col-lg-5 col-sm-6 col-xs-12">
                  <?php $this->load->view('components/search_bar');?>
                  </div>
                  
            </div>