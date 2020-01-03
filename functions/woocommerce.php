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

// Change Add to Cart Text
function ex_changeAddToCart() {
	return __('Buy This!', 'woocommerce');
}
add_filter('woocommerce_product_single_add_to_cart_text', 'ex_changeAddToCart');

// Change Add to Cart Confirmation
add_filter('wc_add_to_cart_message', 'handler_function_name', 10, 2);
function handler_function_name($message, $product_id) {
	$output = get_the_post_thumbnail($product_id, 'small');
	$output .= '<p>You just added <strong>' . get_the_title($product_id) . '</strong> into your bag of shit!</p>';
	$output .= '<nav><a href="' . get_permalink(wc_get_page_id('cart')) . '">Open My Bag of Shit & Pay!</a><a href="#dismiss" class="dismiss">Close This</a></nav>';
	return $output;
}
