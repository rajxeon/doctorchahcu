<?php 
	$this->load->view('components/h1');
	
	?>
<?php $this->load->view('components/h1.php',$this->data);?>
<link rel="stylesheet" href="<?php echo bu('style/index_style.css');?>">
<script src="<?php echo  bu('js/jquery.lazyload.min.js');?>" type="text/javascript"></script>

<?php $this->load->view('components/index_navigation',$this->data);?>
    
	<?php $this->load->view('sub_view/'.$sub_view);
?>