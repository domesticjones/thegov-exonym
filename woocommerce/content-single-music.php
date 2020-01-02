<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<article id="music-<?php the_ID(); ?>" <?php wc_product_class('page-content music', $product); ?>>
	<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		//do_action( 'woocommerce_single_product_summary' );

		woocommerce_template_single_title();

		echo ex_wrap('start', 'product-album-left');
			the_content();
			$credits = get_field('credits');
			if(!empty($credits)) {
				echo '<ul class="product-single-list">';
					$prod   = ($credits['producer'] ? '<li><i>Produced by:</i><span>' . $credits['producer'] . '</span></li>' : '');
					$mix    = ($credits['mix'] ? '<li><i>Mixed by:</i><span>' . $credits['mix'] . '</span></li>' : '');
					$master	= ($credits['master'] ? '<li><i>Mastered by:</i><span>' . $credits['master'] . '</span></li>' : '');
					echo $prod . $mix . $master;
				echo '</ul>';
			}
			$stream = get_field('streaming_services');
			if($stream) {
				echo '<ul class="product-single-list">';
					echo '<li class="product-single-list-heading">Streaming Services</li>';
					foreach($stream as $s) {
						echo '<li><a href="' . $s['link']['url'] . '" target="' . $s['link']['target'] . '" class="product-single-stream"><img src="' . $s['icon']['url'] . '" alt="' . $s['icon']['alt'] . '" />' . $s['link']['title'] . '</a></li>';
					}
				echo '</ul>';
			}
			woocommerce_template_single_price();
			woocommerce_template_single_add_to_cart();
		echo ex_wrap('end');
		echo '<hr />';
		echo ex_wrap('start', 'product-album-right');
			$tracks = get_field('track_list');
			if($tracks) {
				echo '<ol class="tracklist">';
					foreach($tracks as $t) {
						$feat		= ($t['featured'] ? 'featured' : '');
						$desc		= ($t['descriptor'] ? '<small>' . $t['descriptor'] . '</small>' : '');
						$length	= ($t['length'] ? '<i>(' . $t['length'] . ')</i>' : '');
						$video	= ($t['video'] ? '<a href="' . $t['video'] . '"><span>Watch the Music Video!</span></a>' : '');
						echo '<li class="' . $feat . '"><p><span>' . $t['name'] . '</span>' . $length . '</p>' . $desc . $video . '</li>';
					}
				echo '</ol>';
			}
		echo ex_wrap('end');
	?>
</article>
	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	//do_action( 'woocommerce_after_single_product_summary' );

  $albumCover = get_the_post_thumbnail($product->ID, 'large');
  $albumCoverUrl = get_the_post_thumbnail_url($product->ID, 'large');
  echo '</article>';
  echo '<aside class="page-sidebar perf">';
      echo '<div class="perf-bg" style="background-image: url(' . $albumCoverUrl . ')"></div>';
      echo $albumCover;
  echo '</aside>';

  // do_action( 'woocommerce_before_single_product_summary' );
	?>

<?php do_action( 'woocommerce_after_single_product' ); ?>
