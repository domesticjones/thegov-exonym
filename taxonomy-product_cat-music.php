<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
    function gov_color() {
        $memberColor = gov_member('Albums')['color'];
        include('modules/govcolors.php');
    }
    add_action('wp_head', 'gov_color', 100);
    get_header();

    $fancyWords4albums = ['Releases', 'Compendiums', 'Tomes', 'Disseminations', 'Promulgations', 'Expressions'];
    $fancyWords4info = ['Get This', 'Pick it Up', 'Get this Shit', 'Give a Listen', 'Learn More'];
    $fancyWords4Swell = ['swell', 'beautiful', 'ambidextrous', 'potentially Shaquille O\'Neal approved', 'monstrous', 'harmonically perfect', 'gainfully employed'];

    $musicQueryArgs = array(
        'post_type'         => array( 'product' ),
        'posts_per_page'    => -1,
        'tax_query'         => array(
            array (
                'taxonomy'  => 'product_cat',
                'field'     => 'slug',
                'terms'     => 'music',
            )
        ),
        'orderby'   => 'meta_value_num',
        'meta_key'  => 'release_date',
        'order'     => 'DESC',
    );
    $musicQuery = new WP_Query($musicQueryArgs);
    if($musicQuery->have_posts()) {
        echo '<article id="music-template" class="page-content">';
            echo ex_wrap('start', 'music-heading');
                echo '<h1>' . $fancyWords4albums[array_rand($fancyWords4albums)] . ' by <span class="accent">' . ex_brand() . '</span></h1>';
            echo ex_wrap('end');
            while($musicQuery->have_posts()) {
                $musicQuery->the_post();
                $cover      = get_the_post_thumbnail($post->ID, 'medium');
                $coverUrl   = get_the_post_thumbnail_url($post->ID, 'medium');
                $name = get_the_title();
                $release = get_field('release_date');
                $releaseDate = DateTime::createFromFormat('Ymd', $release);
			    $tracks = get_field('tracks');
			    $trackCount = count($tracks);
			    sort($featured);
                echo ex_wrap('start', 'music-archive');
                    echo '<a href="' . get_the_permalink($post->ID) . '">';
                        echo '<div class="photo">';
                            echo '<div class="photo-bg" style="background-image: url(' . $coverUrl . ')"></div>';
                            echo $cover;
                        echo '</div>';
                        echo '<div class="data">';
                            echo '<h2>' . $name . '</h2>';
                            echo '<p class="accent">Released:<br />' . $releaseDate->format('F j, Y') . '</p>';
                            if($trackCount > 1) {
                                echo '<p>' . $trackCount . ' ' . $fancyWords4Swell[array_rand($fancyWords4Swell)] . ' tracks!</p>';
                            }
                            echo '<button class="button" type="button">' . $fancyWords4info[array_rand($fancyWords4info)] . '</button>';
                        echo '</div>';
                    echo '</a>';
                echo ex_wrap('end');
            }
        echo '</article>';
    }
    wp_reset_postdata();

    echo '<aside class="page-sidebar">';
        $memberVid = gov_member('Albums')['long_video'];
        include('modules/govmembervid.php');
    echo '</aside>';

    get_footer();