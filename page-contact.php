<?php
    /* TEMPLATE NAME: Contact */
    function gov_color() {
        $memberColor = gov_member('Contact')['color'];
        include('modules/govcolors.php');
    }
    add_action('wp_head', 'gov_color', 100);
    get_header();
    echo '<article id="contact-template" class="page-content">';
        $fancyWords4hi = ['Getting to Know', 'Gettin\' Intimate wit', 'Showers of Words from'];

        if(have_posts()): while(have_posts()): the_post();
            echo ex_wrap('start', 'contact-head');
                echo '<h1>' . $fancyWords4hi[array_rand($fancyWords4hi)] . ' <span class="accent">' . ex_brand() . '</span></h1>';
                the_field('bio');
            echo ex_wrap('end');
            $promo = get_field('promo_docs');
            if($promo) {
                echo ex_wrap('start', 'contact-promo');
                    echo '<h2 class="accent">Promo <span>Assets & Docs</span></h2>';
                    echo '<nav>';
                        foreach($promo as $p) {
                            $type = $p['type'];
                            echo '<a href="' . $p['url'] . '">';
                                echo '<div class="promo-' . $type . '">';
                                    if($type === 'image') { echo wp_get_attachment_image($p['ID'], 'small'); }
                                echo '</div>';
                                echo '<p class="promo-data">';
                                    echo '<strong>' . $p['title']. '</strong>';
                                    echo '<em>' . $p['filename'] . '</em>';
                                echo '</p>';
                            echo '</a>';
                        }
                    echo '</nav>';
                echo ex_wrap('end');
            }
            $press = get_field('press_links');
            $quotes = get_field('quotes');
            if($quotes || $press) {
                echo ex_wrap('start', 'contact-press');
                    echo '<h2 class="accent"><strong>Press &amp; Stuff </strong><span class="accent"><i>feat.</i>' . ex_brand() . '</span></h2>';
                    echo '<div class="contact-press-data">';
                        if($quotes) {
                            echo '<div id="contact-quotes">';
                                foreach($quotes as $q) {
                                    echo '<blockquote><q>&ldquo;' . $q['quote'] . '&rdquo;</q><cite>&nwarr; ' . $q['author'] . '</cite></blockquote>';
                                }
                            echo '</div>';
                        }
                        if($quotes && $press) { echo '<hr class="accent" />'; }
                        if($press) {
                            echo '<nav>';
                                foreach($press as $pr) {
                                    $pr = $pr['link'];
                                    $domain = parse_url($pr['url']);
                                    echo '<a href="' . $pr['url'] . '" target="_blank"><strong>' . $pr['title'] . '</strong><em class="accent">' . $domain['host'] . '</em></a>';
                                }
                            echo '</nav>';
                        }
                    echo '</div>';
                echo ex_wrap('end');
            }
            echo ex_wrap('start', 'contact-photos');
                echo '<h2 class="accent"><span>' . ex_brand() . '</span>: for your Viewing Pleasure</h2>';
            echo ex_wrap('end');
        endwhile; endif;
    echo '</article>';

    echo '<aside class="page-sidebar">';
        $memberVid = gov_member('Contact')['long_video'];
        include('modules/govmembervid.php');
    echo '</aside>';

    get_footer();
?>