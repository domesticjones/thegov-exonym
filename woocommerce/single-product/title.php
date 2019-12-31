<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
echo ex_wrap('start', 'product-header');
if(has_term('music', 'product_cat', $product->ID)) {
  $tracks   = get_field('track_list');
  $release  = get_field('release_date');
  the_title( '<h1 class="product_title entry-title">', '</h1>' );
	echo '<p class="music-header-meta">Released on ' . $release . ' &bull; ' . count($tracks) . ' Tracks</p>';
} else {
  the_title( '<h1 class="product_title entry-title">', '</h1>' );
}
echo ex_wrap('end');
