<?php
	/* TEMPLATE NAME: Home */
	function gov_color() {
		echo '<style>';
			$members = get_field('members', 'options');
			$mOutput = [];
			$mAttrs = [
				array('Border', 'border-color'),
				array('Color', 'color'),
				array('Bg', 'background-color'),
				array('Shadow', 'box-shadow')
			];
			if($members) {
				foreach($members as $m) {
					array_push($mOutput, array($m['assign'], $m['color']));
				}
				foreach($mOutput as $mo) {
					$pre = '.accActive' . $mo[0];
					$color = $mo[1];
					foreach($mAttrs as $ma) {
						echo $pre . ' .acc' . $ma[0] . '{' . $ma[1] . ': ' . $color . ';}';
					}
				}
			}
		echo '</style>';
	}
	add_action('wp_head', 'gov_color', 100);

	function govHomeVideo($video) {
		$output = '<aside class="home-bgvideo-wrap">';
			$output .= '<video class="home-bgvideo" autoplay muted playsinline loop>';
				$output .= '<source type="' . $video['mime_type'] . '" data-realvideo="' . $video['url'] . '">';
			$output .= '</video>';
		$output .= '</aside>';
		return $output;
	}

	function govHomeSection($heading, $content) {
		$output = '<div class="home-section-content">';
			$output .= '<h1 class="home-heading">' . $heading . '</h1>';
			$output .= '<div class="home-content">' . $content . '</div>';
		$output .= '</div>';
		return $output;
	}

	get_header();
    echo '<article id="wrap-home">';
  		if(have_posts()) { while(have_posts()) { the_post();
        // Landing Section
        get_template_part('modules/home', 'landing');
        // Shows Section
        get_template_part('modules/home', 'shows');
        // Videos Section
        get_template_part('modules/home', 'videos');
        // Albums Section
        get_template_part('modules/home', 'albums');
        // Merch Section
        get_template_part('modules/home', 'merch');
        // Contact Section
        get_template_part('modules/home', 'contact');
  		}}
    echo '</article>';

    // Include the comment bubble stuff here that pops up only on the home page.
	get_footer();
?>
