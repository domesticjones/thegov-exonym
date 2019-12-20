<?php
if (!defined('WPINC')) { die; }
/*
===============================
  [[[  Woocommerce Settings ]]]
===============================
*/

function exonym_add_woocommerce_support() {
	add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'exonym_add_woocommerce_support');
