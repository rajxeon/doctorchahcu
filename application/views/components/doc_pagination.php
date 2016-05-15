<?php $number_of_page=$doc_count/$number_of_results;?>
<style>.pagination>.active>a{background:#00BDF7 !important}
.disabled i{ color:#CCC}
</style>
<?php 
$prev=$current_page-1;
$next=$current_page+1;
?>
<nav>
  <ul class="pagination" style="margin:0">
<?php if($prev>0)  	echo '<li onclick="event.preventDefault();apply('.($prev-1).')"><a ><i class="fa fa-fw fa-chevron-circle-left"></i></a></li>'; 
else echo  '<li class="disabled"><a ><i class="fa fa-fw fa-chevron-circle-left"></i></a></li>';
?>
    
<?php 
	$number_of_page=ceil($number_of_page);
	for($i=1;$i<=($number_of_page);$i++){
		if($current_page==$i) 
		echo '<li class="active" onclick="event.preventDefault();apply('.($i-1).')"><a href="#">'.$i.'</a></li>';
		else 
		echo '<li onclick="event.preventDefault();apply('.($i-1).')"><a href="#">'.$i.'</a></li>';
		}
	//Click event on app_btn is attached in views/components/doc_filter.php
?>
<?php if($next<=$number_of_page)  	echo '<li onclick="event.preventDefault();apply('.($next-1).')"><a ><i class="fa fa-fw fa-chevron-circle-right"></i></a></li>'; 
else echo  '<li class="disabled"><a ><i class="fa fa-fw fa-chevron-circle-right"></i></a></li>';
?>

 
      
     
    </li>
  </ul>
</nav>