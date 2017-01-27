$(function() {
	/* sticky header */
	$(window).scroll(stick_header).resize(stick_header);
	
	function stick_header() {
		if (document.body.scrollWidth > document.body.clientWidth) {
			$('body').removeClass('header-fixed');
			$('header').css("width", "auto");
			return;
		}

//	   $(".header-menu-submenu").removeClass("active");
		if ($(window).scrollTop() > 178) {
		   $('body').addClass('header-fixed');
		   setTimeout("$('.header').addClass('active')", 0);
		}
		else {
		   $('body').removeClass('header-fixed');
		   $('.header').removeClass('active');
		}
	   $('header').css("width", $('header').parent().width() + "px");
	}

	/* menu */
	$(".header-menu-item.w-submenu").children("a").click(function(event) {
		var $submenu = $(this).next(".header-menu-submenu");
		if ($submenu.is(".active")) {
			$submenu.removeClass("active");
		} else {
			$(".header-menu-submenu").removeClass("active");
			$submenu.toggleClass("active");
		}
		event.stopPropagation()
		return false;
	});
	$(".header-menu-submenu").click(function(event) {
		event.stopPropagation()
	});
	$(document).click(function() {
		$(".header-menu-submenu").removeClass("active");
	});
	
	/* property details bookmarks */
	$("#bookmarks_gallery").click(function() {
		$("#detail_gallery_gallery").show();
		if ($("#detail_gallery_video iframe").length) {
			$("#detail_gallery_video iframe").attr("src", "");
		} else {
			try {$("#detail_gallery_video video")[0].pause()} catch(e) {}
		}
		$("#detail_gallery_video").hide();

		$(".detail-gallery-bookmarks-item").removeClass("detail-gallery-bookmarks-item-active");
		$(this).addClass("detail-gallery-bookmarks-item-active");
	});
	$("#bookmarks_video").click(function() {
		$("#detail_gallery_gallery").hide();
		if ($("#detail_gallery_video iframe").length) {
			$iframe = $("#detail_gallery_video iframe");
			$iframe.attr("src", $iframe.attr("data-src"));
		}
		$("#detail_gallery_video").show();

		$(".detail-gallery-bookmarks-item").removeClass("detail-gallery-bookmarks-item-active");
		$(this).addClass("detail-gallery-bookmarks-item-active");
	});

	$(".detail-gallery-zoom").click(function() {
		$.fancybox($('.flex-active-slide img').data('src-big'), {helpers: {
			overlay: {
				locked: false
			}
		}});
		return false;	
	});

	/* misc */
	var hm_html = '<a href="maxxyyiltxxyyo:inxxyyfxxyyo_atmsxxyykkeyxxyy.rxxyyu">inxxyyfxxyyo_atmsxxyykkeyxxyy.rxxyyu</a>';
	$("#hm").html(hm_html.split('xxyy').join('').split('_at').join('@'));

	$(".form-validate").submit(function() {
		var res = true;
		$(".required", this).each(function() {
			if ("" == $(this).val()) {
				res = false;
				$(this).addClass("form-input-invalid");
			} else {
				$(this).removeClass("form-input-invalid");
			}
		});
		return res;
	});
	
	/* flex slider */
	$('.detail-gallery-thumbs').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 173,
		itemMargin: 5,
		asNavFor: '.detail-gallery-view'
	});
	$('.detail-gallery-view').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		sync: ".detail-gallery-thumbs"
	});
	$(".detail-gallery-view img").on("load error", function() {
		$(this).parent().addClass("loaded");
	});
});
