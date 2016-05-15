<div id="header" role="navigation">
<nav>
  <div id="logo"><a href="<?php echo bu('');?>"><img src="<?php echo base_url();?>images/dcdlogo2.png" alt="Doctor chachu logo" title="Doctor Chachu" height="100"></a></div>
  <div id="menu">
  	<?php 
		$menu_json	=file_get_contents('json/menu.json');
		$json		=json_decode($menu_json,true);
		foreach($json as $a=>$b){
			echo '<a href="'.$b['link'].'" class="'.$b['class'].'" id="'.$b['id'].'" title="'.$a.'" data-page_name="'.$b['name'].'">'.$a.'</a>';
			}
	?>
  </div>
</nav>
</div>

<div id="tablet_header"><nav>
	<div id="logo"><a href="index.php"><img src="<?php echo base_url();?>images/dcdlogo2.png" alt="Doctor chachu logo" title="Doctor Chachu" height="70"></a></div>
    <div id="doc_chachu_holder"><a href="index.php"><h2>DOCTOR CHACHU</h2></a></div>
    <div id="menu_expand" class="animate_2 noselect"><i class="fa fa-bars"></i></div>
    <br clear="all">
    <div id="menu_item_holder">
    <?php 
		$temp=0;
		$menu_json	=file_get_contents('json/menu.json');
		$json		=json_decode($menu_json,true);
		foreach($json as $a=>$b){			
			if(strpos($b['class'],'highlight_on_hover')!== false and $temp==0){ echo '<br clear="all">'; $temp=1;}
			echo '<a href="'.$b['link'].'" class="'.$b['class'].'" id="'.$b['id'].'" title="'.$a.'" data-page_name="'.$b['name'].'">'.$a.'</a>';
			}
			
	?>
    </div>
    </nav>
</div>
