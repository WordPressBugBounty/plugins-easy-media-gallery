jQuery(document).ready(function($){
	
	setTimeout(function(){
		
		$.confirm({
				'title'         : emg_popup.content,
				'acceptTitle'   : 'OKAY',
				'rejectTitle'	: '',
				'acceptBtnCol'  : 'confirm-blue',
				'rejectBtnCol'  : '',
				'acceptAction'  : function() {
					
					$.post( ajaxurl, {
						action: 'emg_hide_block_notify'
					});
					
				}
		});
	
	}, 1500);
	
});

!function(t){t.confirm=function(c){if(t(".emg-popup").length)return t(".emg-popup").addClass("is-visible"),!1;var i=['<div class="emg-popup" role="alert">','<div class="emg-popup-container">',"<p>",c.title,"</p>",'<ul class="emg-buttons">','<li><a class="accept_notify accept ',c.acceptBtnCol,'">',c.acceptTitle,"</a></li>",'<li><a class="reject ',c.rejectBtnCol,'">',c.rejectTitle,"</a></li>","</ul>","</div>","</div>"].join("");t(i).appendTo("body"),c.rejectTitle||(t(".emg-popup .emg-buttons li:last-child").hide(),t(".emg-popup .emg-buttons li:first-child").css("width","100%")),setTimeout(function(){t(".emg-popup").addClass("is-visible")},10),t(".accept").click(function(){return c.acceptAction(),t.confirm.hide(),!1}),t(".reject").click(function(){return c.rejectAction(),t.confirm.hide(),!1})},t.confirm.hide=function(){t(".emg-popup").removeClass("is-visible"),setTimeout(function(){t(".emg-popup").remove()},200)}}(jQuery);