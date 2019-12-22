<?php
	get_header();
		if(have_posts()) { while(have_posts()) { the_post();
            $dateNow    = date('Y-m-d H:i:s');
            $date       = get_field('date');
            $dateEnd    = ($date['end'] ? $date['end'] : $date['start']);
            $dateText   = ($dateEnd <= $dateNow ? 'Past Performance' : 'Upcoming Performance');
		    $perfArch   = array('link' => get_post_type_archive_link('performance'), 'text' => 'Back to All Performances');

		    $poster     = get_the_post_thumbnail($post->ID, 'large');
		    $posterUrl  = get_the_post_thumbnail_url($post->ID, 'large');

	        echo '<article id="performance-single" class="page-content perf">';

            $admit      = get_field('admittance');
            $location   = get_field('location');
            $name       = get_field('event_name');
            $acts       = get_field('acts');
            $desc       = get_field('description');
            $links      = get_field('links');
            $photos     = get_field('photos');
            $videos     = get_field('videos');

                echo '<nav class="perf-breadcrumb"><h3>' . $dateText . '</h3><a href="' . $perfArch['link'] . '">' . $perfArch['text'] . '</a></nav>';
                echo ex_wrap('start', 'perf-header');
                    echo '<h1 class="perf-title">' . get_the_title() . '</h1>';
                    echo '<p><strong>' . performanceLocation($location)->name . '</strong>' . performanceLocation($location, 'city') . '</p>';
                echo ex_wrap('end');
                echo '<nav class="perf-breadcrumb"><a href="' . $perfArch['link'] . '">' . $perfArch['text'] . '</a><h3>' . $dateText . '</h3></nav>';

            echo '</article>';
            echo '<aside class="page-sidebar perf">';
                echo '<div class="perf-bg" style="background-image: url(' . $posterUrl . ')"></div>';
                echo $poster;
            echo '</aside>';
		}}
	get_footer();
?>