<?php
if (!defined('WPINC')) { die; }
/*
===============================
  [[[  Woocommerce Settings ]]]
===============================
*/

// Declare WP Support
function exonym_add_woocommerce_support() {
	add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'exonym_add_woocommerce_support');

// Disable All Styles & Scripts
function ex_cleanUpWoo() {
	if(function_exists('is_woocommerce') && !is_admin()) {

		wp_dequeue_style('woocommerce-layout');
		wp_dequeue_style('woocommerce-general');
		wp_dequeue_style('woocommerce-smallscreen');

		if(!is_cart() && !is_checkout()) {
			wp_dequeue_script('wc-cart-fragments');
			wp_dequeue_script('woocommerce');
			wp_dequeue_script('wc-add-to-cart');
			wp_deregister_script('js-cookie');
			wp_dequeue_script('js-cookie');
		}
	}
}
add_action('wp_enqueue_scripts', 'ex_cleanUpWoo');
