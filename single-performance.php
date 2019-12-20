<?php
	get_header();
	    echo '<article id="wrap-">';
		if(have_posts()) { while(have_posts()) { the_post();
		    $date       = get_field('date');
            $admit      = get_field('admittance');
            $location   = get_field('location');
            $name       = get_field('event_name');
            $acts       = get_field('acts');
            $desc       = get_field('description');
            $links      = get_field('links');
            $photos     = get_field('photos');
            $videos     = get_field('videos');
            $postId = get_post($post->ID);

            the_title();
		}}
	get_footer();
?>