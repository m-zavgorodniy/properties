$(function() {
	// property type
	$("[id^='tab_']").click(function() {
		$("[id^='tab_']").removeClass("active");
		$(this).addClass("active");
		$("[id^='pad_']").removeClass("active");
		var id = $(this).attr("id").split("_")[1];
		$("#pad_" + id).addClass("active");
		$("[name='type']", $(this).closest("form")).val(id);

		$(":checkbox", $("[id^='pad_']")).prop("checked", false);
		$("select", $("[id^='pad_']")).each(function() {
			this.selectedIndex = 0;
		});
	});

	// range of a number of rooms
	$("[name$='_min'], [name$='_max']", $(".form-field-range")).change(function() {
		$range_span = $(this).closest(".form-field-range");
		var value_min = $("[name$='_min']", $range_span).val().replace(/[\.,].*$/, "").replace(/\D/g, "");
		var value_max = $("[name$='_max']", $range_span).val().replace(/[\.,].*$/, "").replace(/\D/g, "");
		if ("" !== value_min || "" !== value_max) {
			$("[type='hidden']", $range_span).val((value_min?value_min:"") + "-" + (value_max?value_max:""));
		} else {
			$("[type='hidden']", $range_span).val("");
		}
	}).closest("form").submit(function() {
		$("[name$='_min'], [name$='_max']", this).prop("disabled", true);
	});
	

	$(".form-field-range select").change(function() {
		$(this).closest(".form-field").children(":checkbox").prop("checked", true);
	});

	// general direction 
	$(".property-search-direction-tabs a").click(function() {
		var tab_id = $(this).attr("id").split("direction-tab-")[1];
		if ($(this).is(".active")) {
			$(".property-search-direction-tabs a").removeClass("active");
			$("#direction-" + tab_id).slideUp();
		} else {
			$(".property-search-direction-tabs a").removeClass("active");
			$(".direction-type-box").hide();
			$(this).addClass("active");
			if (tab_id != $.data(document.body, "current_direction_tab_focus")) {
				$(".direction-type-box :checkbox").prop("checked", false);
			}
			$("#direction-" + tab_id).slideDown();
		}
		$.data(document.body, "current_direction_tab_focus", tab_id);
		return false;
	});

	// direction subtype (metro / streets)
	$(".property-search-direction-item a").click(function() {
		var $button = $(this).parent();
		if ($button.is(".active")) return false;

		$(".property-search-direction-item").removeClass("active");
		$button.addClass("active");
		var direction_id = $(this).attr("id").split("_")[1];
		$("[name='direction']").val(direction_id);
		
/*		!! ok but we did the little hack in functions.php
		$("#direction_params input").val("");
		$.each(DIRECTION_ID_PARAMS[direction_id], function(key, value) {
			$("input[name='" + key + "']").val(value);
		});*/

		$(".property-search-direction-pad").hide();
		$(".property-search-direction-pad :checkbox").prop("checked", false);
		$("#direction_area_" + direction_id).slideDown();
		return false;
	});

	// check all stations for a metro line
	$(".property-search-metroline").click(function() {
		if ($.data(this, "ckecked_all")) {
			$(":checkbox", $(this).closest(".property-search-metro-section")).prop("checked", false);
			$.data(this, "ckecked_all", false);
		} else {
			$(":checkbox", $(this).closest(".property-search-metro-section")).prop("checked", true);
			$.data(this, "ckecked_all", true);
		}
		return false;
	});
	
	// drop all metro selection 
	$(".direction-count-control").click(function() {
		$("[name='metro[]']").prop("checked", false);
		$direction_count = $(this).closest(".direction-count");
		$direction_count.animate({opacity: 0}, 200, function() {$direction_count.slideUp('fast')});
		return false;
	});

	// streets
	$("#direction-street select").change(function() {
		var $street = $(":selected", $(this));
		if ($("#direction-street-items input[value=" + $street.val() + "]").length) {
			$("#direction-street-items input[value=" + $street.val() + "]").prop("checked", true);
		} else {
			var $append_street = $('<div class="property-search-street-line" style="display: none;"><label><input type="checkbox" name="street[]" value="' + $street.val() + '" checked>' + $street.text() + ' </label></div>');
			$("#direction-street-items").append($append_street);
			$append_street.show('fast');
		}
		this.selectedIndex = 0;
		return false;
	});
	
	$("body").on("change", ".property-search-street-line :checkbox", function() {
		if (!$(this).prop("checked")) {
			var $street_line = $(this).closest(".property-search-street-line");
			$street_line.fadeOut(function() {
				$street_line.remove();
			});
		}
	});

	// new search
	$(".properties-found-search a").click(function() {
		$(".property-search").slideDown();
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});
});
