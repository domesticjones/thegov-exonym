<?php
  /* TEMPLATE NAME: Builder */
  get_header();
		if(have_posts()) { while(have_posts()) { the_post();
      ex_wrap('start-body');
        ex_content();
      ex_wrap('end-body');
    }}
  get_footer();
?>
