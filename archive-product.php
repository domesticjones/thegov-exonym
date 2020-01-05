<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
  function gov_color() {
	  $memberColor = gov_member('Merch')['color'];
	  include('modules/govcolors.php');
  }
  add_action('wp_head', 'gov_color', 100);
  get_header();
  echo '<article id="merch-template" class="page-content">';
    $productCats = get_terms('product_cat', array('hide_empty' => false, 'exclude' => 15));
		$fancyWords4buy = [
			'Bi This Guy', 'Buy This', 'Get This', 'Do the Buy Thing',
			'Have In Your Life', 'Get for a Friend', 'Buy for Grandma',
			'Buy for Grandpa', 'Price for your Cousin', 'Have and Hold'
		];
    if(!is_wp_error($productCats)) {
      foreach ($productCats as $cat) {
        echo ex_wrap('start', 'merch-category');
          echo '<h2 class="accent"><strong>' . $cat->name . '</strong><span><i>by:</i>' . ex_brand() . '</span></h2>';
          $catPostsArgs = array(
            'post_type'         => 'product',
            'posts_per_page'    => -1,
            'tax_query'         => array(array(
              'taxonomy'  => 'product_cat',
              'field'     => 'slug',
              'terms'     => $cat->slug,
            )),
          );
          $catPosts = new WP_Query($catPostsArgs);
          if($catPosts->have_posts()) {
            echo '<nav>';
            while($catPosts->have_posts()) {
              $catPosts->the_post();
							echo '<a href="' . get_the_permalink() . '">';
								ob_start();
									woocommerce_template_loop_price();
									$price = ob_get_contents();
								ob_end_clean();
								$priceNice = (strlen($price) > 1 ? $price : '<em>Currently Unavailable</em>');
								the_post_thumbnail('small');

								the_title('<h3>', '</h3>');
								echo '<p>'. $fancyWords4buy[array_rand($fancyWords4buy)] . '&bull;' . $priceNice . '</p>';
              echo '</a>';
            }
            echo '</nav>';
          }
        echo ex_wrap('end');
      }
    }
  echo '</article>';

  echo '<aside class="page-sidebar">';
    $memberVid = gov_member('Merch')['long_video'];
    include('modules/govmembervid.php');
  echo '</aside>';

  get_footer();
