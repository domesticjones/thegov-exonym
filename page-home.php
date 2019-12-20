<?php
	/* TEMPLATE NAME: Home */
	get_header();
    echo '<article id="wrap-home">';
  		if(have_posts()) { while(have_posts()) { the_post();

        // Landing Section
        get_template_part('modules/landing');

        // Merch Section
  		}}
    echo '</article>';
	get_footer();
?>
