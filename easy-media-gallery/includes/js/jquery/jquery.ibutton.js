(function($) {
		
	$("input[type=checkbox].switch").each(function() {
		// Insert switch
		$(this).before('<span class="switch"><span class="background" /><span class="mask" /></span>');
		//Hide checkbox
		$(this).hide();
		if (!$(this)[0].checked) $(this).prev().find(".background").css({
			left: "-49px"
		});
		if ($(this)[0].checked) $(this).prev().find(".background").css({
			left: "-2px"
		});
	});
	// Toggle switch when clicked
	$(".easymediagallery_page_emg_settings span.switch, .post-type-easymediagallery span.switch").click(function() {
		// Slide switch off
		if ($(this).next()[0].checked) {
			$(this).find(".background").animate({
				left: "-49px"
			}, 200);
			// Slide switch on
		} else {
			$(this).find(".background").animate({
				left: "-2px"
			}, 200);
		}
		// Toggle state of checkbox
		//$('#').attr('checked', true);
		$(this).next()[0].checked = !$(this).next()[0].checked;
	
		if ($("#easmedia_metabox_media_video_size").is(':checked')) {
			$('#vidcustomsize').hide("slow");
		} else {
			$('#vidcustomsize').show("slow");
		}
	
	});

})(jQuery);