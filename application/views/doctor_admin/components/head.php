<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <title><?php if(isset($page_title) and !empty($page_title)) echo $page_title; else echo 'Doctor Administration'?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        
        
        <!-- Morris chart -->
        <link href="<?php echo base_url().'style/';?>morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo base_url().'style/';?>jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <!--<link href="<?php echo base_url().'style/';?>datepicker/datepicker3.css" rel="stylesheet" type="text/css" />-->
        <!-- Daterange picker -->
        <link href="<?php echo base_url().'style/';?>daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo base_url().'style/';?>bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url().'style/';?>AdminLTE.css" rel="stylesheet" type="text/css" />
        <link id="page_favicon" href="<?php echo base_url().'images/fav.png';?>" rel="icon" type="image/x-icon">
        
        
        <script src=" <?php echo base_url().'js/jquery.js'; ?>"></script>

        <script>
	    $(document).ready(function(e) {
		params=(document.URL.split('/'));
		page=(params[params.length-1]);
		$('.sidebar-menu li').removeClass('active');
		$('*[data-page="'+page+'"]').addClass('active');
		});
			
	  </script>
    </head>
    <body class="skin-blue">


