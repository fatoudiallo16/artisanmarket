/**
 * ArtisanMarket - Main JavaScript
 * Version Simplifiée
 */

(function ($) {
"use strict";

	var windowOn = $(window);
	// ====== 01. PreLoader Js ======
	windowOn.on('load', function() {
		$("#loading").fadeOut(500);
	});

	// ====== 02. Sidebar Menu Toggle ======
	$(".sidebar-toggle").on("click", function () {
		$(".canvas__area").addClass("opened");
		$(".body-overlay").addClass("opened");
	});

	$(".canvas__close-btn").on("click", function () {
		$(".canvas__area").removeClass("opened");
		$(".body-overlay").removeClass("opened");
	});

	// ====== 03. Cart Mini Toggle ======
	$(".cart-toggle-btn").on("click", function(e) {
		e.preventDefault();
		$(".cartmini__area").addClass("opened");
		$(".body-overlay").addClass("opened");
	});

	$(".cartmini__close-btn").on("click", function() {
		$(".cartmini__area").removeClass("opened");
		$(".body-overlay").removeClass("opened");
	});

	// ====== 04. Body Overlay Click ======
	$(".body-overlay").on("click", function() {
		$(".cartmini__area").removeClass("opened");
		$(".canvas__area").removeClass("opened");
		$(".body-overlay").removeClass("opened");
	});

	// ====== 05. Sticky Header ======
	windowOn.on('scroll', function () {
		var scroll = $(window).scrollTop();
		if (scroll < 100) {
			$("#header-sticky").removeClass("sticky");
		} else {
			$("#header-sticky").addClass("sticky");
		}
	});

	// ====== 06. Data Background Image ======
	$("[data-background]").each(function () {
		$(this).css("background-image", "url( " + $(this).attr("data-background") + " )");
	});

	// ====== 07. Cart Quantity Change ======
	$(".cart-plus").on("click", function() {
		var input = $(this).closest(".product-quantity-form").find(".cart-input");
		var value = parseInt(input.val()) || 1;
		input.val(value + 1);
	});

	$(".cart-minus").on("click", function() {
		var input = $(this).closest(".product-quantity-form").find(".cart-input");
		var value = parseInt(input.val()) || 1;
		if(value > 1) {
			input.val(value - 1);
		}
	});

	// ====== 08. Product Add to Cart ======
	$(".product-add").on("click", function(e) {
		e.preventDefault();
		// À intégrer avec le backend Laravel
		var productId = $(this).attr("data-product-id") || "produit";
		var quantity = $(this).closest(".product__item").find(".cart-input").val() || 1;
		console.log("Produit " + productId + " x" + quantity + " ajouté au panier");
	});

	// ====== 09. Back to Top Button ======
	$(".progress-wrap").on("click", function(e) {
		e.preventDefault();
		$("html, body").animate({scrollTop: 0}, 800);
	});

	windowOn.on('scroll', function () {
		var scrollPercent = ($(window).scrollTop() / ($(document).height() - $(window).height())) * 100;
		var opacity = Math.min(scrollPercent / 100, 1);
		$(".progress-circle svg").css("opacity", opacity);
		
		if (scrollPercent > 20) {
			$(".progress-wrap").addClass("show");
		} else {
			$(".progress-wrap").removeClass("show");
		}
	});

	// ====== 10. Show/Hide Toggle for Login & Checkout ======
	$('#showlogin').on('click', function () {
		$('#checkout-login').slideToggle(900);
	});

	$('#showcoupon').on('click', function () {
		$('#checkout_coupon').slideToggle(900);
	});

	$('#cbox').on('click', function () {
		$('#cbox_info').slideToggle(900);
	});

	$('#ship-box').on('click', function () {
		$('#ship-box-info').slideToggle(1000);
	});

	// ====== 11. Hover Effects ======
	$('.hover__active').on('mouseenter', function () {
		$(this).addClass('active').parent().siblings().find('.hover__active').removeClass('active');
	});

})(jQuery);