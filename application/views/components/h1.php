<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]--><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Here you can search for doctors in your city and fix an appointment online.">
<meta name="keywords" content="doctor, chachu, search, online,appointment,health,emmergency,medical">
<meta property="og:title" content="Doctor Chachu:Your health advisor">
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
<meta name="mobile-web-app-capable" content="yes">


<meta name="robots" content="index, follow">
<?php 
//Get the liberaries according to the DEV mode

if(ENVIRONMENT=='development'){
	echo '<script src="'.base_url().'js/respond.min.js" async ></script>
		<script src="'.base_url().'js/jquery.js"></script>
		<script src="'.base_url().'js/custom.js" async ></script>';
	
	//Bootstrap Libs
	echo '<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>';
	
	//For offline mode. 
	echo '<link rel="stylesheet" href="'.bu('style/bootstrap.min.css').'">';
	
	//End of vootstrap Libs
	
	echo '<link href="'.base_url().'style/boilerplate.css" rel="stylesheet" type="text/css" >
		<!--<link href="'.base_url().'style/fluid.css" rel="stylesheet" type="text/css">-->
		<link href="'.base_url().'style/style.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="'.base_url().'images/fav.png">
		<link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
		<link href="'.base_url().'style/font-awesome.min.css" rel="stylesheet">';
		
		
	
	
	}
	
	
elseif (ENVIRONMENT=='production'){  //Changes required while deploying to the server

	echo '<script src="'.base_url().'js/respond.min.js" async ></script>
		<script src="'.base_url().'js/jquery.js"></script>
		<script src="'.base_url().'js/custom.js" async ></script>';
		
	//Bootstrap Libs
	echo '<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>';
	
	//End of vootstrap Libs
	
	echo '<link href="'.base_url().'style/boilerplate.css" rel="stylesheet" type="text/css" >
		<!-- <link href="'.base_url().'style/fluid.css" rel="stylesheet" type="text/css">-->
		<link href="'.base_url().'style/style.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="'.base_url().'images/fav.png">
		<link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
		<link href="'.base_url().'style/font-awesome.min.css" rel="stylesheet">
		
		
		<script src="'.base_url().'js/respond.min.js" async ></script>
		<script src="'.base_url().'js/jquery.js"></script>
		<script src="'.base_url().'js/custom.js" async ></script>';
	
	}
?>


<title><?php if(!isset($title) or empty($title))echo  config_item('site_name');else echo  $title;?></title>

</head>

<body style="min-width:350px">
<div class="fixed_bg"></div>
