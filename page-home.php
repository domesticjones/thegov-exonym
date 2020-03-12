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
					$pre = '.acc' . $mo[0];
					$color = $mo[1];
					foreach($mAttrs as $ma) {
						echo $pre . ' .acc' . $ma[0] . '{' . $ma[1] . ': ' . $color . ';}';
					}
				}
			}
		echo '</style>';
	}
	add_action('wp_head', 'gov_color', 100);

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
