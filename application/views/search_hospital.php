<?php $this->load->view('components/h1.php',$this->data);?>
<?php $city=$this->uri->segment(3);$this->data['city']=$city;?>
<link rel="stylesheet" href="<?php echo bu('style/s_style.css')?>">
<style>
.doc_name{ font-size:1.3em}
.rt{text-align:right}
.stars{ left:0;}
.disabled_stars{ left:0}
.star_holder {position: absolute;width: 109px;height: 20px;text-align: right;right: 15px;}
.std{margin-top: 25px;}
</style>

<div class="row" style="background: #3E205B;"> 
	<div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
    <div class="col-lg-10  col-md-12 col-sm-12 col-xs-12 header_row" >
    
    <header>
    	<!-- Logo --->
        <div class="col-lg-3  col-md-3 col-sm-3 col-xs-6 s_logo">
        	<a href="<?php echo bu('');?>"><img class="lazy" data-original="<?php echo bu('images/logo.png');?>" alt="Doctor chachu logo-Click to go to home"></a>
        </div>
        <div class="col-lg-3  col-md-3 col-sm-3 col-xs-6">
        	
        	<?php 
			$this->data['type']='hospitals';
			$this->load->view('components/city_selector',$this->data);?>
        </div>
        <div class="col-lg-6  col-md-6 col-sm-6 col-xs-12">
        	<?php $this->load->view('components/search_bar');?>
        </div>
    </header>
    </div>
    <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
</div>

<!-- Search results -->
	<div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12" style="padding: 0;">
    <!-- Filter Holder -->
    
     <?php $this->load->view('components/hospital_filter',$this->data);?>
        
    </div>
    <div class="col-lg-8 col-md-10 col-sm-9 col-xs-12">
    	<div class="row no-pad">
        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-pad">
            	<span class="label label-success btn-block label-number"><strong><?php echo $hospital_count;?></strong> Results found</span>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 no-pad" style="text-align:right">
            	<?php $this->load->view('components/doc_pagination',$this->data);?>
            </div>
        </div>
        <div class="row no-pad">
        	<?php $this->load->view('components/hospital_tile',$this->data);?>
        </div>
        <div class="row no-pad">
        	<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 no-pad"></div>
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 no-pad" style="text-align:right">
            	<?php $this->load->view('components/doc_pagination',$this->data);?>
            </div>
        </div>
    </div>
    <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
    

   
<script src="<?php echo bu('js/jquery.lazyload.min.js');?>"></script>
<script>
$(function() {
    $("img.lazy").lazyload({
    effect : "fadeIn"
});
});
</script>    