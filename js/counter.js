// JavaScript Document
$(document).on('click','.tooth_numbers,.multiply',function(){
	$(this).toggleClass('btn-info');
	main_parent=$(this).closest('.tabber');
	multiply_element=main_parent.find('.multiply');
	if($(multiply_element).is(':checked')){ 
		main_parent.find('.qty').val(main_parent.find('.tooth_numbers.btn-info').length);
		}
	calculate_total(main_parent.find('.mokal'),1);
	text='Teeth:';
	main_parent.find('.tooth_numbers.btn-info').each(function(index, element) {
        text+=$(this).text()+'|';
    	});
	if(main_parent.find('.tooth_numbers.btn-info').length>5)
			main_parent.find('.counter_invoker').text((text.substr(0,20))+'...');
	else main_parent.find('.counter_invoker').text(text);
	
	main_parent.find('.special_note').val(text); 
	te=text.replace('Teeth:','');
	main_parent.find('.counter_invoker').attr('data-vig',te);
	
	});

$(document).on('click','.select_all_teeth',function(){
	parent=$(this).parent();
	main_parent=$(this).closest('.tabber');
	multiply_element=main_parent.find('.multiply');
	if($(this).is(":checked")){
		main_parent.find('.counter_invoker').text('Teeth: Full Mouth');
		parent.find('.tooth_numbers').addClass('btn-info');
		if($(multiply_element).is(':checked'))
		main_parent.find('.qty').val(main_parent.find('.tooth_numbers.btn-info').length);
		main_parent.find('.special_note').val('Full Mouth');
		main_parent.find('.counter_invoker').attr('data-vig','Full Mouth');
		}
	else{
		main_parent.find('.counter_invoker').text('');
		parent.find('.tooth_numbers').removeClass('btn-info');
		if($(multiply_element).is(':checked'))
		main_parent.find('.qty').val(main_parent.find('.tooth_numbers.btn-info').length);
		main_parent.find('.counter_invoker').attr('data-vig','');
		}
	
	calculate_total(main_parent.find('.mokal'),1);
	});
	
function close_holder(){ $('.counter_holder').slideUp(200); }



 