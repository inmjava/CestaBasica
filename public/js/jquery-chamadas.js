/* Values dos Inputs */
$(function() {
	
	$('input').focus(function(){ $(this).select(); });

	$("input").each(function(){
		if($(this).attr("mask")){
			$(this).mask($(this).attr("mask"));
		}
	});
	
	$("input").each(function(){
		if($(this).attr("alt")){
			$(this).Watermark($(this).attr("alt"));
		}
	});
	
	$('.submitenter').keypress(function(e){
		if(e.which == 13){
			submit();
		}
	});
	
	$('select:not([multiple=multiple])').each(function() {
        if($(this).find('option:first').val() == $(this).find('option:selected').val()){
        	$(this).addClass('watermark');
        }else{
        	$(this).removeClass('watermark');
        }
    });
	
	$('select:not([multiple=multiple])').change(function() {
        if($(this).find('option:first').val() == $(this).find('option:selected').val()){
        	$(this).addClass('watermark');
        	$(this).removeClass('nowatermark');
        }else{
        	$(this).addClass('nowatermark');
            $(this).removeClass('watermark');
        }
    });
});