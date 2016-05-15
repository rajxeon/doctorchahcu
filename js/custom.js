// JavaScript Document

$(document).ready(function(e) {
	
	//Script to handle the selected menu
    var path	= window.location.pathname;
	var page 	= path.split("/").pop().split(".");
	page		=page[0];
	if(!page.length){ page='index';}
	$('.underline_on_hover ').each(function(index, element) { $(this).removeAttr('id');});
	$('*[data-page_name="'+page+'"]').attr('id','selected_menu');
	
	//End of script to handle the selected tab
	
	//Start of the function which controls the expansion and collapse of the menu in tablet mode
	$('#menu_expand').click(function(e) {
       $('#tablet_header').find($('#menu_item_holder')).slideToggle(200);
    });
	//End of the function which controls the expansion and collapse of the menu in tablet mode
	
	//Start of the function which controls the tabbed menu of the search bar
	$('#search_holder li').click(function(e) {
       $('#search_holder li').each(function(index, element) { $(this).removeAttr('id');  });
	    $(this).attr('id','li_selected');
		$('.tabbed').each(function(index, element) {$(this).css('display','none');});
		$('*[data-tab="'+$(this).index()+'"]').fadeIn(0);
    });
	//End of the function which controls the tabbed menu of the search bar
});

