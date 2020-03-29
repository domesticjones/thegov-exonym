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
        $fancyWords4contact = ['Touching', 'Relations', 'Contact', 'Correspondence', 'Milk Delivery', 'Conversations'];

        if(have_posts()): while(have_posts()): the_post();
            echo ex_wrap('start', 'contact-head');
                echo '<h1>' . $fancyWords4hi[array_rand($fancyWords4hi)] . ' <span class="accent">' . ex_brand() . '</span></h1>';
                the_field('bio');
                echo '<div class="contact-buttons"><h2 class="accent"><span>Direct </span>' . $fancyWords4contact[array_rand($fancyWords4contact)] . '</h2>' . ex_contact('phone') . ex_contact('email') . '</div>';
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
            $livePhotosArgs = array(
                'posts_per_page'    => -1,
                'post_type'         => 'performance',
                'meta_query' => array(array(
                    'key' => 'photos',
                    'value' => '',
                    'compare' => '!=',
                )),
            );
            $livePhotosQuery = new WP_Query($livePhotosArgs);
            if($livePhotosQuery->have_posts()):
              echo ex_wrap('start', 'contact-photos');
                echo '<h2 class="accent">' . ex_brand() . ': <span>Ocular Titillation</span></h2>';
                echo '<ul id="photos-list">';
                  $livePics = [];
                  while($livePhotosQuery->have_posts()): $livePhotosQuery->the_post();
                    $date = get_field('date');
        						$datePretty = DateTime::createFromFormat('Y-m-d H:i:s', $date['start']);
                    $photos = get_field('photos');
                    foreach($photos as $p) {
                      $photo = '<li><a href="' . $p['sizes']['jumbo'] . '" title="Photo by: ' . ($p['description'] ? $p['description'] : 'Unknown') . ' - ' . $datePretty->format('F j, Y') . '" data-image=\'' . wp_get_attachment_image($p['ID']) . '\'></a></li>';
                      array_push($livePics, $photo);
                    }
                  endwhile;
                  shuffle($livePics);
                  echo implode('', $livePics);
                  echo '<button type="button" id="photos-list-more">Gimme More</button>';
                echo '</ul>';
              echo ex_wrap('end');
            endif;
            wp_reset_query();
        endwhile; endif;
    echo '</article>';
    echo '<aside class="page-sidebar">';
        $memberVid = gov_member('Contact')['long_video'];
        $memberImg = gov_member('Contact')['long_video_image'];
        include('modules/govmembervid.php');
    echo '</aside>';
    get_footer();
?>
