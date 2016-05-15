<?php 

	$config['site_name']		 ='Doctor Chachu';
	$config['site_admin']		 ='admin356';
	$config['ajax_img'] 		 = 'images/ajax-loader.gif';
	$config['clinic_image'] 	 = 'clinic_images/';
	$config['encryption_key'] 	 = 'kYR0J2D26knmiF81m9x8s09qFm49MlcL';

	$now_time=time();
	$now_time+=(330*60);
	$config['now_time'] 	 = $now_time;
	
	date_default_timezone_set("Africa/Bamako"); 
	
	$config['MERCHANT_KEY'] 	 = 'JBZaLc';
	$config['SALT'] 			 = 'GQs7yium';
?>