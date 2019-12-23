<?php
	get_header();
		if(have_posts()) { while(have_posts()) { the_post();
	    $dateNow    = date('Y-m-d H:i:s');
	    $date       = get_field('date');
	    $dateEnd    = ($date['end'] ? $date['end'] : $date['start']);
	    $dateText   = ($dateEnd <= $dateNow ? 'Past' : 'Upcoming');
	    $perfArch   = array('link' => get_post_type_archive_link('performance'), 'text' => 'Back to All Performances');
	    $poster     = get_the_post_thumbnail($post->ID, 'large');
	    $posterUrl  = get_the_post_thumbnail_url($post->ID, 'large');
			$location   = get_field('location');

	    echo '<article id="performance-single" class="page-content perf">';
        echo '<nav class="perf-breadcrumb"><a href="' . $perfArch['link'] . '">' . $perfArch['text'] . '</a><h3>' . $dateText . ' Performance</h3></nav>';
        echo ex_wrap('start', 'perf-header');
            echo '<h1 class="perf-title">' . get_the_title() . '</h1>';
            echo '<p><strong>' . performanceLocation($location)->name . '</strong>' . performanceLocation($location, 'city') . '</p>';
						echo '<time datetime="' . $date['start'] . '">';
							if($date['start'] != $dateEnd) {
								$dateStartFormat = DateTime::createFromFormat('Y-m-d H:i:s', $date['start']);
								$dateEndFormat = DateTime::createFromFormat('Y-m-d H:i:s', $dateEnd);
								echo '<strong>Start: </strong>' . $dateStartFormat->format('g:ia - D, M j, Y') . ' <strong>End: </strong>' . $dateEndFormat->format('g:ia - D, M j, Y');
							} else {
								$datePretty = DateTime::createFromFormat('Y-m-d H:i:s', $dateEnd);
								echo $datePretty->format('g:ia - l, F jS, Y');
							}
						echo '</time>';
						echo '<address>';
							echo $location['address'];
						echo '</address>';
        echo ex_wrap('end');
				$admit      	= get_field('admittance');
				$admitPrivate	= $admit['private'];
				$admitAges		= $admit['ages'];
				$admitTickets	= $admit['tickets'];
				$admitAdv			= $admit['cost']['advance'];
				$admitDoors		= $admit['cost']['doors'];
				if($admitPrivate || !empty($admitAges) || !empty($admitTickets) || $admitAdv || $admitDoors) {
	        echo ex_wrap('start', 'perf-data');
						if($admitPrivate) {
							echo '<p class="private">How fancy, this is a <strong>private event</strong>.<br />But probably not an event with privates.</p>';
						} else {
							if(!empty($admitAges)) { echo '<p class="ages"><strong>Ages: </strong>' . $admitAges . '</p>'; }
							if($admitAdv || $admitDoors) {
								if($admitAdv === (string) '0') { $admitAdv = 'Free'; }
								if($admitDoors === (string) '0') { $admitDoors = 'Free'; }
								echo '<p class="cost"><strong>Cost: </strong>' . ($admitAdv ? $admitAdv . '/adv &bull; ' .$admitDoors . '/door' : $admitDoors) . '</p>';
							}
							if(!empty($admitTickets)) {
								echo '<a href="' . $admitTickets['url'] . '" class="tickets" target="' . $admitTickets['target'] . '">' . $admitTickets['title'] . '</a>';
							}
						}
					echo ex_wrap('end');
				}
	      $name		= get_field('event_name');
	      $acts		= get_field('acts');
	      $desc		= get_field('description');
	      $links	= get_field('links');
				if($acts || $desc || $links) {
					echo ex_wrap('start', 'perf-desc');
						if($acts) {
							echo '<p class="label">' . ex_brand() . ($dateText == 'Past' ? ' performed ' : ' will be performing ') . ($name ? $name . ' ' : '') . 'with:</p>';
							echo '<nav class="acts"><ul>';
							foreach ($acts as $act) {
								$actLink = '';
								if($act['url']) {
									$actLink = '<a href="' . $act['url'] . '" target="_blank">' . $act['name'] . '</a>';
								} else {
									$actLink = '<span>' . $act['name'] . '</span>';
								}
								echo '<li>' . $actLink . '</li>';
							}
							echo '</ul></nav>';
						}
						if($desc) { echo '<p class="desc">' . $desc . '</p>'; }
						if($links) {
							echo '<nav class="links"><ul>';
							foreach ($links as $link) {
								echo '<li><a href="' . $link['links']['url'] . '" target="' . $link['links']['target'] . '">' . $link['links']['title'] . '</a></li>';
							}
							echo '</ul></nav>';
						}
					echo ex_wrap('end');
				}
				$photos	= get_field('photos');
				$videos	= get_field('videos');
				echo ex_wrap('start', 'perf-media');
					if($photos || $videos) {
						echo '<ul class="gallery">';
							if($videos) { foreach($videos as $video) {
								echo '<li class="video">' . $video['video'] . '</li>';
							}}
							if($photos) { foreach($photos as $photo) {
								echo '<li class="photo"><a href="' . $photo['sizes']['jumbo'] . '">' . wp_get_attachment_image($photo['id'], 'sizes-thumbnail') . '</a></li>';
							}}
						echo '</ul>';
					}
				echo ex_wrap('end');
        echo '<nav class="perf-breadcrumb bottom"><h3>' . $dateText . ' Performance</h3><a href="' . $perfArch['link'] . '">' . $perfArch['text'] . '</a></nav>';

      echo '</article>';
      echo '<aside class="page-sidebar perf">';
          echo '<div class="perf-bg" style="background-image: url(' . $posterUrl . ')"></div>';
          echo $poster;
      echo '</aside>';
		}}
	get_footer();
?>
