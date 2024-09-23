(function ($) {

	if (typeof (emgallery) == 'undefined')
		window.emgallery = {};

	window.emgallery = $.extend({
		ver: '0',
		auth: 'ghozylab.com',
		model: 1,
		data: {},
	}, window.emgallery);

})(jQuery);

(function ($) {

	if (typeof (emgallery) == 'undefined')
		window.emgallery = {};

	$().extend(emgallery.data, {
		that: null,
		thickbox: window.tb_remove
	});

})(jQuery);

jQuery(document).ready(function ($) {

	var sortcdtype, sctype, isBlock = false,
		old_tb_remove = window.tb_remove;

	// Multiselect initiate
	setmultiselect();

	// LOAD GENERATOR
	$("body").delegate("#emg_gut_shorcode-button, .emg-sc-generator, #emgicons_gut_shorcode", "click", function () {

		isBlock = false;
		if ($(this).hasClass('emg-sc-generator')) isBlock = true;

		setTimeout(function () {
			tb_show('<img class="emg_sc_ttl_ico" src="' + emg_tinymce_vars.sc_icon + '" alt="Easy Media Gallery">Gallery Shortcode<span class="emg_cp_version">v' + emg_tinymce_vars.sc_version + "</span>", "#TB_inline?inlineId=emgmodal");

			$("#TB_window").addClass("TB_emg_window");
			$("#TB_overlay").addClass("TB_emg_overlay");

			$("#emgtinymce_select_cat_div, #emgtinymce_select_sing_media_div, #mediacustomsize, #customcolumns, #customalign, #mediacustomstyle").hide();
			$("#defgallery").prop("checked", true);
			$('.setaspro').prop("disabled", true);
			$('#thisresult, #thisgallresult').val('');

			$('#horizontalTab').responsiveTabs({
				active: 0,
				rotate: false,
				startCollapsed: 'accordion',
				collapsible: 'accordion',
				setHash: false,
				animation: 'slide',
				duration: 100,
				activate: function (event, tab) {

					if (tab.id == 0) sortcdtype = 'gallery';
					else sortcdtype = 'others';

				},

			});

			$("#TB_closeWindowButton").replaceWith($("<div class='closetb' id='TB_closeWindowButton'><span class='screen-reader-text'>Close</span><span class='tb-close-icon'></span></div>"));
			$(".TB_emg_overlay").bind("click", tb_remove);
			// Set default tab
			$('#emgfirsttab a').trigger('click');

			emgtbReposition();
			fillDefaultFormData();

		}, 300);

	});

	function fillDefaultFormData() {

		$(".background").animate({
			left: "-49px"
		}, 200);
		$("input[type=checkbox].switch").val(false);
		$("input[type=checkbox].switch").prop("checked", false);

		var formParams = {
			'emg-shortcode-basic': {
				"emgtinymce_select_method": "Select",
				"emgtinymce_select_cat": "",
				"emgtinymce_select_sing_media": "",
				"emgtinymce_custom_columns": false,
				"emgtinymce_custom_align": false,
				"singlemedia_value": ""
			},
			'emg-shortcode-advanced': {
				"listgallery": "",
				"gallery_value": ""
			}
		};

		var radioVal = ["easymedia-gallery", "easy-media-album", "easymedia-slider-one", "easymedia-slider-two", "easymedia-fotorama", "easymedia-carousel"];

		$.each(['emg-shortcode-basic', 'emg-shortcode-advanced'], function (index, element) {

			$('#' + element).emgFormRestore(formParams[element]);

		});

		$('.emgradiogalltype').each(function (index, element) {

			$(this).val(radioVal[index]);

		});

		if (isBlock) emgFillForm();
		else {
			refreshMultiselect(true);
			populateCheckBox();
		}

	}

	function setmultiselect() {

		$("#listcustomgallery").multiselect({
			multiple: true,
			header: "Select Gallery",
			noneSelectedText: "Select Gallery",
			selectedList: 1,
			header: true
		});

		$("#emgtinymce_select_method").multiselect({
			multiple: false,
			header: "Order Media by",
			noneSelectedText: "Select an Option",
			selectedList: 1,
			header: false
		});

		$("#emgtinymce_select_cat").multiselect({
			multiple: false,
			header: "Choose a category",
			noneSelectedText: "Select Category",
			selectedList: 1,
			header: false
		});

		$("#emgtinymce_select_sing_media").multiselect({
			multiple: true,
			header: "Choose Media",
			noneSelectedText: "Select Media",
			selectedList: 1,
			header: true
		});

		$("#select_custom_col").multiselect({
			multiple: false,
			header: "Select Columns",
			noneSelectedText: "Select Columns",
			selectedList: 1,
			header: false
		});

		$("#select_cus_align").multiselect({
			multiple: false,
			header: "Select Align",
			noneSelectedText: "Select Align",
			selectedList: 1,
			header: false
		});

		$("#select_cus_style").multiselect({
			multiple: false,
			header: "Select Style",
			noneSelectedText: "Select Style",
			selectedList: 1,
			header: false
		});

		refreshMultiselect(true);

	}

	function refreshMultiselect(uncheck) {

		if (uncheck) $("#listcustomgallery").multiselect("uncheckAll");

		$("#select_custom_col").multiselect('refresh');
		$("#emgtinymce_select_method").multiselect('refresh');
		$("#select_cus_align").multiselect('refresh');
		$("#listcustomgallery").multiselect("refresh");

	}

	function emgFillForm() {

		if (emgallery.data.that.props.attributes.data != '') {

			var scAttr = JSON.parse(emgallery.data.that.props.attributes.data),
				data = {};

			$('#' + scAttr.params.sc_form).emgFormRestore(scAttr.params.sc_params);
			// Set Tab
			$('[data-formid=' + scAttr.params.sc_form + ']').trigger('click');

			var mltslct = ['gallery_value', 'singlemedia_value'];
			var singslct = ['emgtinymce_select_method', 'emgtinymce_select_cat', 'select_cus_align', 'select_cus_style', 'select_cus_style_sprd'];

			setTimeout(function () {

				$.each(scAttr.params.sc_params, function (k, v) {

					if ($.inArray(k, singslct) > -1) {

						var selectNameSing = $('[name=' + k + ']');

						$(selectNameSing).multiselect("widget").find(":radio").each(function () {

							var that = this;
							if ($(that).val() == v) {
								$(that).trigger('click');
								$(selectNameSing).val(v).trigger('change');
							}

						});

					}

					if ($.inArray(k, mltslct) > -1) {

						var id = v.split(",").map(function (item) {
							return item.trim();
						});

						var selectName = $('[name=' + k + ']').data('select');

						$('#' + selectName).multiselect('uncheckAll');

						$.each(id, function (i, vl) {

							$('#' + selectName).multiselect("widget").find(":checkbox").each(function () {

								var that = this;
								if ($(that).val() == vl) $(that).trigger('click');

							});

						});
						// OMG :p
						$('#' + selectName).next('button').eq(0).trigger('click').trigger('click');

					}

				});

				// Checkbox populate
				populateCheckBox();

			}, 100);

		} else {

			$('#emgfirsttab a').trigger('click');
			populateCheckBox();

		}

		refreshMultiselect();

	}

	function populateCheckBox() {

		$('input.switch:checkbox').each(function (index, element) {

			var that = $(this);

			if (that.val() == 'true' || that.val() === true) {

				that.val(false);
				that.prop('checked', false);
				that.parent().find('span.switch').trigger('click');

			}

		});

	}

	// Resizing thickbox window dynamically	
	function emgtbReposition() {

		var wTop = ($(window).height() - $('.TB_emg_window').outerHeight()) / 16,
			wLeft = ($(window).width() - $('.TB_emg_window').outerWidth()) / 4;

		$('.TB_emg_window').css({
			"top": wTop + 26 + 'px',
			"left": wLeft + 'px',
			"margin-left": wLeft + 'px'
		});

	}

	$(window).resize(function () {

		if ($('#TB_window').is(':visible')) {
			emgtbReposition();
		}

	});

	// Close Thickbox
	$("body").delegate(".closetb, .TB_emg_overlay", "click", function () {
		tb_remove();
	});

	var tb_remove = function () {
		old_tb_remove(); // calls the tb_remove() of the Thickbox plugin
	};


	// Show/Hide element
	$("#emgtinymce_select_method").change(function () {
		var listidx = $("#emgtinymce_select_method").prop('selectedIndex');

		if (listidx == '1') {
			$("#emgtinymce_select_cat_div").fadeIn(500);
			$("#emgtinymce_select_sing_media_div").hide();

		} else if (listidx == '2') {
			$("#emgtinymce_select_cat_div").hide();
			$("#emgtinymce_select_sing_media_div").fadeIn(500);

		} else {
			$("#emgtinymce_select_cat_div").fadeOut(500);
			$("#emgtinymce_select_sing_media_div").hide();
		}

	});

	// Toggle switch when clicked
	$('#emg-shortcode-basic span.switch').on("click", function () {
		// Slide switch off
		if ($(this).next()[0].checked) {
			$(this).parent().find('input').eq(0).val(false).trigger('change');
			$(this).find(".background").animate({
				left: "-49px"
			}, 200);
			// Slide switch on
		} else {
			$(this).parent().find('input').eq(0).val(true).trigger('change');
			$(this).find(".background").animate({
				left: "-2px"
			}, 200);
		}
		// Toggle state of checkbox
		$(this).next()[0].checked = !$(this).next()[0].checked;

		if ($("#emgtinymce_custom_columns").is(':checked')) {
			$('#customcolumns').show("slow");
		} else {
			$('#customcolumns').hide("slow");
		}

		if ($("#emgtinymce_custom_align").is(':checked')) {
			$('#customalign').show("slow");
		} else {
			$('#customalign').hide("slow");
		}

	});

	//Get all selected values from the drop down list
	$(function () {

		$("#emgtinymce_select_method").multiselect({
			click: function () {
				$("#emgtinymce_select_sing_media").multiselect("uncheckAll");
				$("#emgtinymce_select_cat").multiselect("uncheckAll");
				$('#thisresult').val('');
			}
		});

	});

	$(function () {

		$("#emgtinymce_select_sing_media").multiselect({
			close: function (event) {

				var array_of_checked_values = $(this).multiselect("getChecked").map(function () {
					return this.value;
				}).get().toString();
				$('#thisresult').val(array_of_checked_values).trigger('change');
				$('[name=singlemedia_value]').val(array_of_checked_values);
				sellval = null;
			},
		});

	});

	$(function () {

		$("#listcustomgallery").multiselect({
			close: function (event) {

				var array_of_checked_values = $(this).multiselect("getChecked").map(function () {
					return this.value;
				}).get().toString();
				$('#thisgallresult').val(array_of_checked_values).trigger('change');
				$('[name=gallery_value]').val(array_of_checked_values);
				sellval = null;
			},
		});

	});

	function isEmpty(val) {

		if (val == 0 || val == '' || val == null) return true;

		return false;

	}

	// FOR SINGLE MEDIA / CATEGORY SHORTCODE ---------------------------------------------------------------------------------------------
	$('#emg_insert_media').on("click", function () {

		if (emgallery.data.that == null && isBlock) {

			alert('Oops! There is an error with this shortcode editor. Click OK to reload.');
			tb_remove();
			setTimeout(function () {
				$('.emg-sc-generator').trigger('click');
			}, 200);
			return false;

		}

		sctype = $("#emgtinymce_select_method").prop('selectedIndex');

		if (!isEmpty($("#emgtinymce_select_method").val())) {

			if ($("#emgtinymce_select_method").prop('selectedIndex') == 1 && isEmpty($("#emgtinymce_select_cat").val())) {

				alert('Please select category first!');
				return false;
			}

			if ($("#emgtinymce_select_method").prop('selectedIndex') == 2 && $('#thisresult').val() == '') {

				alert('Please select media first!');
				return false;
			}

			var custcol = custalgn = '';

			if ($("#emgtinymce_custom_columns").is(':checked') && $("#select_custom_col").val() > 0)
				custcol = ' col="' + $("#select_custom_col").val() + '"';

			if ($("#emgtinymce_custom_align").is(':checked') && !isEmpty($("#select_cus_align").val()))
				custalgn = ' align="' + $("#select_cus_align").val().toLowerCase() + '"';

			var medcat = $('#emgtinymce_select_cat').val(),
				catcode = '[easy-media cat="' + medcat + '"' + custcol + custalgn + ']',
				tmedid = $('#thisresult').val(),
				medid = '[easy-media med="' + tmedid + '"' + custcol + custalgn + ']';

			if (isBlock) {

				var data = JSON.stringify({
					native_shortcode: (sctype == 1 ? catcode : medid),
					params: {
						type: (sctype == 1 ? catcode : medid),
						sc_form: 'emg-shortcode-basic',
						sc_params: $('#emg-shortcode-basic').serializeJSON({
							parseBooleans: true,
							checkboxUncheckedValue: false
						})
					}
				});

				emgallery.data.that.save(data);

			} else {

				if (sctype == 1 && medcat != 0) {
					if ($('#wp-content-editor-container > textarea').is(':visible')) {
						var val = $('#wp-content-editor-container > textarea').val() + catcode;
						$('#wp-content-editor-container > textarea').val(val);
					} else {
						tinyMCE.activeEditor.execCommand('mceInsertContent', 0, catcode);
					}
				} else if (sctype == 2 && tmedid != '') {
					if ($('#wp-content-editor-container > textarea').is(':visible')) {
						var val = $('#wp-content-editor-container > textarea').val() + medid;
						$('#wp-content-editor-container > textarea').val(val);
					} else {
						tinyMCE.activeEditor.execCommand('mceInsertContent', 0, medid);
					}
				}

				tb_remove();

			}

		} else {
			alert('No media order selected!');
		}

	});

	// FOR GALLERY SHORTCODE -------------------------------------------------------------------------------------------------
	$('#emg_insert_gallery').on("click", function () {

		if (emgallery.data.that == null && isBlock) {

			alert('Oops! There is an error with this shortcode editor. Click OK to reload.');
			tb_remove();
			setTimeout(function () {
				$('.emg-sc-generator').trigger('click');
			}, 200);
			return false;

		}

		if (sortcdtype == 'gallery' && $('#thisgallresult').val() != '') {

			var galleryval = '[easymedia-gallery med="' + $('#thisgallresult').val() + '" filter="1"]';

			if (isBlock) {

				var data = JSON.stringify({
					native_shortcode: galleryval,
					params: {
						type: galleryval,
						sc_form: 'emg-shortcode-advanced',
						sc_params: $('#emg-shortcode-advanced').serializeJSON({
							parseBooleans: true,
							checkboxUncheckedValue: false
						})
					}
				});

				emgallery.data.that.save(data);

			} else {

				if ($('#wp-content-editor-container > textarea').is(':visible')) {
					var val = $('#wp-content-editor-container > textarea').val() + galleryval;
					$('#wp-content-editor-container > textarea').val(val);
				} else {
					tinyMCE.activeEditor.execCommand('mceInsertContent', 0, galleryval);
				}

				tb_remove();

			}

		} else {
			alert('No gallery selected!');
		}

	});

});

/* $.formRestore: get or set all of the name/value pairs from child input controls   
 * @argument data {array} If included, will populate all child controls.
 * @returns element if data was provided, or array of values if not
 */
(function ($) {

	var $ = window.jQuery;

	$.fn.emgFormRestore = function (data) {
		var els = this.find(':input').get();

		if (typeof data != 'object') {
			// return all data
			data = {};

			$.each(els, function () {
				if (this.name && !this.disabled && (this.checked ||
						/select|textarea/i.test(this.nodeName) ||
						/text|hidden|password/i.test(this.type))) {
					if (data[this.name] == undefined) {
						data[this.name] = [];
					}
					data[this.name].push($(this).val());
				}
			});
			return data;
		} else {
			$.each(els, function () {

				if (this.name) {

					var names = data[this.name];
					var $this = $(this);
					if (Object.prototype.toString.call(names) !== '[object Array]') {
						names = [names]; //backwards compat to old version of this code
					}

					if (this.type == 'radio') {
						var val = $this.val();
						for (var i = 0; i < names.length; i++) {
							if (names[i] == val) {
								if (!$this.closest('.emg-multiselect-checkboxes').length) $this.trigger('click');
								break;
							}
						}
					} else {
						$this.val(names[0]);
					}

				}

			});

			return this;
		}
	};

})(jQuery);

/*!
  SerializeJSON jQuery plugin.
  https://github.com/marioizquierdo/jquery.serializeJSON
  version 2.9.0 (Jan, 2018)

  Copyright (c) 2012-2018 Mario Izquierdo
  Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
  and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
*/

!function(e){if("function"==typeof define&&define.amd)define(["jquery"],e);else if("object"==typeof exports){var n=require("jquery");module.exports=e(n)}else e(window.jQuery||window.Zepto||window.$)}(function(e){"use strict";e.fn.serializeJSON=function(n){var r,s,t,i,a,u,l,o,p,c,d,f,y;return r=e.serializeJSON,s=this,t=r.setupOpts(n),i=s.serializeArray(),r.readCheckboxUncheckedValues(i,t,s),a={},e.each(i,function(e,n){u=n.name,l=n.value,p=r.extractTypeAndNameWithNoType(u),c=p.nameWithNoType,(d=p.type)||(d=r.attrFromInputWithName(s,u,"data-value-type")),r.validateType(u,d,t),"skip"!==d&&(f=r.splitInputNameIntoKeysArray(c),o=r.parseValue(l,u,d,t),(y=!o&&r.shouldSkipFalsy(s,u,c,d,t))||r.deepSet(a,f,o,t))}),a},e.serializeJSON={defaultOptions:{checkboxUncheckedValue:void 0,parseNumbers:!1,parseBooleans:!1,parseNulls:!1,parseAll:!1,parseWithFunction:null,skipFalsyValuesForTypes:[],skipFalsyValuesForFields:[],customTypes:{},defaultTypes:{string:function(e){return String(e)},number:function(e){return Number(e)},boolean:function(e){return-1===["false","null","undefined","","0"].indexOf(e)},null:function(e){return-1===["false","null","undefined","","0"].indexOf(e)?e:null},array:function(e){return JSON.parse(e)},object:function(e){return JSON.parse(e)},auto:function(n){return e.serializeJSON.parseValue(n,null,null,{parseNumbers:!0,parseBooleans:!0,parseNulls:!0})},skip:null},useIntKeysAsArrayIndex:!1},setupOpts:function(n){var r,s,t,i,a,u;u=e.serializeJSON,null==n&&(n={}),t=u.defaultOptions||{},s=["checkboxUncheckedValue","parseNumbers","parseBooleans","parseNulls","parseAll","parseWithFunction","skipFalsyValuesForTypes","skipFalsyValuesForFields","customTypes","defaultTypes","useIntKeysAsArrayIndex"];for(r in n)if(-1===s.indexOf(r))throw new Error("serializeJSON ERROR: invalid option '"+r+"'. Please use one of "+s.join(", "));return i=function(e){return!1!==n[e]&&""!==n[e]&&(n[e]||t[e])},a=i("parseAll"),{checkboxUncheckedValue:i("checkboxUncheckedValue"),parseNumbers:a||i("parseNumbers"),parseBooleans:a||i("parseBooleans"),parseNulls:a||i("parseNulls"),parseWithFunction:i("parseWithFunction"),skipFalsyValuesForTypes:i("skipFalsyValuesForTypes"),skipFalsyValuesForFields:i("skipFalsyValuesForFields"),typeFunctions:e.extend({},i("defaultTypes"),i("customTypes")),useIntKeysAsArrayIndex:i("useIntKeysAsArrayIndex")}},parseValue:function(n,r,s,t){var i,a;return i=e.serializeJSON,a=n,t.typeFunctions&&s&&t.typeFunctions[s]?a=t.typeFunctions[s](n):t.parseNumbers&&i.isNumeric(n)?a=Number(n):!t.parseBooleans||"true"!==n&&"false"!==n?t.parseNulls&&"null"==n?a=null:t.typeFunctions&&t.typeFunctions.string&&(a=t.typeFunctions.string(n)):a="true"===n,t.parseWithFunction&&!s&&(a=t.parseWithFunction(a,r)),a},isObject:function(e){return e===Object(e)},isUndefined:function(e){return void 0===e},isValidArrayIndex:function(e){return/^[0-9]+$/.test(String(e))},isNumeric:function(e){return e-parseFloat(e)>=0},optionKeys:function(e){if(Object.keys)return Object.keys(e);var n,r=[];for(n in e)r.push(n);return r},readCheckboxUncheckedValues:function(n,r,s){var t,i,a;null==r&&(r={}),e.serializeJSON,t="input[type=checkbox][name]:not(:checked):not([disabled])",s.find(t).add(s.filter(t)).each(function(s,t){if(i=e(t),null==(a=i.attr("data-unchecked-value"))&&(a=r.checkboxUncheckedValue),null!=a){if(t.name&&-1!==t.name.indexOf("[]["))throw new Error("serializeJSON ERROR: checkbox unchecked values are not supported on nested arrays of objects like '"+t.name+"'. See https://github.com/marioizquierdo/jquery.serializeJSON/issues/67");n.push({name:t.name,value:a})}})},extractTypeAndNameWithNoType:function(e){var n;return(n=e.match(/(.*):([^:]+)$/))?{nameWithNoType:n[1],type:n[2]}:{nameWithNoType:e,type:null}},shouldSkipFalsy:function(n,r,s,t,i){var a=e.serializeJSON.attrFromInputWithName(n,r,"data-skip-falsy");if(null!=a)return"false"!==a;var u=i.skipFalsyValuesForFields;if(u&&(-1!==u.indexOf(s)||-1!==u.indexOf(r)))return!0;var l=i.skipFalsyValuesForTypes;return null==t&&(t="string"),!(!l||-1===l.indexOf(t))},attrFromInputWithName:function(e,n,r){var s,t;return s=n.replace(/(:|\.|\[|\]|\s)/g,"\\$1"),t='[name="'+s+'"]',e.find(t).add(e.filter(t)).attr(r)},validateType:function(n,r,s){var t,i;if(i=e.serializeJSON,t=i.optionKeys(s?s.typeFunctions:i.defaultOptions.defaultTypes),r&&-1===t.indexOf(r))throw new Error("serializeJSON ERROR: Invalid type "+r+" found in input name '"+n+"', please use one of "+t.join(", "));return!0},splitInputNameIntoKeysArray:function(n){var r;return e.serializeJSON,r=n.split("["),""===(r=e.map(r,function(e){return e.replace(/\]/g,"")}))[0]&&r.shift(),r},deepSet:function(n,r,s,t){var i,a,u,l,o,p;if(null==t&&(t={}),(p=e.serializeJSON).isUndefined(n))throw new Error("ArgumentError: param 'o' expected to be an object or array, found undefined");if(!r||0===r.length)throw new Error("ArgumentError: param 'keys' expected to be an array with least one element");i=r[0],1===r.length?""===i?n.push(s):n[i]=s:(a=r[1],""===i&&(o=n[l=n.length-1],i=p.isObject(o)&&(p.isUndefined(o[a])||r.length>2)?l:l+1),""===a?!p.isUndefined(n[i])&&e.isArray(n[i])||(n[i]=[]):t.useIntKeysAsArrayIndex&&p.isValidArrayIndex(a)?!p.isUndefined(n[i])&&e.isArray(n[i])||(n[i]=[]):!p.isUndefined(n[i])&&p.isObject(n[i])||(n[i]={}),u=r.slice(1),p.deepSet(n[i],u,s,t))}}});