<?php
    /* TEMPLATE NAME: Contact */
    function gov_color() {
        $memberColor = gov_member('Contact')['color'];
        include('modules/govcolors.php');
    }
    add_action('wp_head', 'gov_color', 100);
    get_header();
    echo '<article id="performance-archive" class="page-content">';
        if(have_posts()): while(have_posts()): the_post();
            echo ex_wrap('start', 'contact-head');
                echo '<h1>Getting to Know ' . ex_brand() . '</h1>';
                the_field('bio');
            echo ex_wrap('end');
            $promo = get_field('promo_docs');
            if($promo) {
                echo ex_wrap('start', 'contact-promo');
                    echo '<ul></ul>';
                echo ex_wrap('end');
            }
            echo ex_wrap('start', 'contact-press');
            echo ex_wrap('end');
        endwhile; endif;
    echo '</article>';

    echo '<aside class="page-sidebar">';
        $memberVid = gov_member('Contact')['long_video'];
        include('modules/govmembervid.php');
    echo '</aside>';

    get_footer();
?>