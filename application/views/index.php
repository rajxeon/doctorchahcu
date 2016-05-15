<?php $this->load->view('components/h1.php',$this->data);?>
<link rel="stylesheet" href="<?php echo bu('style/index_style.css');?>">
<script src="<?php echo  bu('js/jquery.lazyload.min.js');?>" type="text/javascript"></script>

<?php $this->load->view('components/index_navigation',$this->data);?>

<div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
<div id="header-container" class="header-container">
	<div class="header-step1 col-lg-4 col-md-4 col-sm-4 col-xs-4 no-pad ">
        <p>STEP 1</p>
        <h1>Find a doctor</h1>
    </div>
    <div class="header-step2 col-lg-4 col-md-4 col-sm-4 col-xs-4 no-pad  ">
        <p>STEP 2</p>
        <h1>Get appointment</h1>
    </div>
    <div class="header-step3 col-lg-4 col-md-4 col-sm-4 col-xs-4  no-pad ">
        <p>STEP 3</p>
        <h1>Meet the doctor</h1>
    </div>
</div>
<br />
<?php $this->load->view('components/search_holder',$this->data);?>
</div>
<div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>

<br clear="all" />

<div class="col-lg-12 hidden-xs no-pad" style="max-width: 100%;overflow: hidden;">
<?php $this->load->view('components/da-slider-home');?>
</div>

<div class="hidden-lg hidden-sm hidden-md"><br /><br /><br /></div>

<div class="col-lg-12 no-pad no-mar" >
<div id="android_ad" class="row no-mar">


<br>
	<h1>Doctor Chachu is here for you..</h1>
    <br>
    <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
    <div class="col-lg-3  col-md-4 col-sm-4 col-xs-6">
    <img  src="images/time.svg" alt="time" style="width: 40%; max-width:150px">
            	<h3>Searching Doctor in secounds</h3>
                <p> 
                Time can be the most important medicine in case of emmergency. Find doctors and hospital in emmergency situation without wasting any time with doctor chachu the best doctor search engine in India</p>
    </div>
    
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
    <img  src="images/visibility.svg" alt="time" style="width: 40%; max-width:150px">
            	<h3>Improve your family health</h3>
                <p> 
                Do you feel like your awesome website is a bit invisible on the web? It shouldn’t be that way. An SEO audit will highlight precisely what parts of your website need to change most urgently in order to avoid Google penalties. You won’t have to worry about losing traffic – even if Google comes out with a new update.</p>
    </div>
    
    <div class="col-lg-3  col-md-4 col-sm-4 hidden-xs">
    <img  src="images/happy.svg" alt="time" style="width: 40%; max-width:150px">
            	<h3>Spend less time on great SEO</h3>
                <p> 
                SEO has a lot to do with the value your website adds to a visitor’s experience. When we carry out an SEO audit of your site, we’ll let you know how to make your website much more usable and visitor-friendly. This will keep your visitors coming back for more.</p>
    </div>
    <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
            	
          
</div>
</div>

<div class="row no-pad no-mar mrs">

	<div align="center"><img class="lazy" data-original="images/doctor-clip-art.png" width="100"></div>
	<h2 align="center">Are you a medical service provider?</h2>
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wt_bg" align="center">
    	<div class="l_text">
        	<span class="blue">Doctor</span>
        	<span class="violet">Chachu</span>
        </div>
        <strong class="violet">Online </strong>
        <strong class="blue"> Profile</strong>
        <br />
        <p>Establish your online presence
and get more appointments</p>
	<button class="btn btn-info">Get Listed</button><br />
	<img class="lazy" data-original="images/search-screenshot.png"  style="width:100%;max-width: 300px;">
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wt_bg" align="center">
    	<div class="l_text">
        	<span class="blue">Virtual</span>
        	<span class="violet">Nurse</span>
        </div>
        <strong class="violet">Practice Manag </strong>
        <strong class="blue"> ement Software</strong>
        <br /> 
		<p>Take care of your patients,
we will take care of everything else.</p>
	<button class="btn btn-success">Know More</button>
    <br />
	<img class="lazy" data-original="images/ray-screenshot.png" style="width:100%;max-width: 300px;">
    </div>
    
    
    
    
    
  
    
</div>

<!-- Footer of index -->
<?php $this->load->view('components/footer');?>


<script>
$("img.lazy").lazyload({
    effect : "fadeIn"
});
</script>