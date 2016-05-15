<!DOCTYPE html>
<html lang="en" style="  background: #fff;>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php if(isset($page_title) and !empty($page_title)) echo $page_title; else echo 'Doctor Administration'?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'style/';?>bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url().'style/';?>sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url().'style/';?>plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link id="page_favicon" href="<?php echo base_url().'images/fav.png';?>" rel="icon" type="image/x-icon">
    
    <script src="<?php echo base_url();?>js/jquery.js"></script>
    <script>
    $(document).ready(function(e) {
      params=(document.URL.split('/'));
	page=(params[params.length-1]);
	$('.nav li').removeClass('active');
	$('*[data-page="'+page+'"]').addClass('active');
	});
    		
    </script>

</head>

<body>