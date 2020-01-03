<?php
    function gov_color() {
        $memberColor = gov_member('Videos')['color'];
        include('modules/govcolors.php');
    }
    add_action('wp_head', 'gov_color', 100);
    get_header();
    echo '<article id="performance-archive" class="page-content">';

        $vidsSinema = [];
        $vidsMusic  = [];
        $vidsLive   = [];

        // Sinema
        if(have_posts()): while(have_posts()): the_post();
            $name           = get_the_title();
            $added          = get_the_date('Ymd');
            $releaseRaw     = get_field('release_date');
            $releaseMake    = DateTime::createFromFormat('F j, Y', $releaseRaw);
            $release        = $releaseMake->format('Ymd');
            $video          = parse_url(get_field('video', $post->ID, false)); parse_str($video['query'], $videoData);
            $videoId        = $videoData['v'];
            if($videoId) {
                array_push($vidsSinema, array(
                    'id'        => $videoId,
                    'name'      => $name,
                    'added'     => $added,
                    'release'   => $release,
                ));
            }
            //echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $videoId . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        endwhile; endif;

        // Music Videos
        $musicvidsArgs = array(
            'posts_per_page'    => -1,
            'post_type'         => 'product',
        );
        $musicVidsQuery = new WP_Query($musicvidsArgs);
        if($musicVidsQuery->have_posts()): while($musicVidsQuery->have_posts()): $musicVidsQuery->the_post();
            $tracks = get_field('track_list');
            if($tracks) {
                $added = get_the_date('Ymd');
                foreach($tracks as $t) {
                    if($t['video']) {
                        $name       = $t['name'];
                        $release    = get_field('release_date');
                        $video      = parse_url(get_field('video', $post->ID, false)); parse_str($video['query'], $videoData);
                        $video      = parse_url($t['video']); parse_str($video['query'], $videoData);
                        $videoId    = $videoData['v'];
                        if($videoId) {
                            array_push($vidsMusic, array(
                                'id'        => $videoId,
                                'name'      => $name,
                                'added'     => $added,
                                'release'   => $release,
                            ));
                        }
                    }
                }
            }
        endwhile; endif;
        wp_reset_query();


        // Live Videos
        $livevidsArgs = array(
            'posts_per_page'    => -1,
            'post_type'         => 'performance',
        );
        $liveVidsQuery = new WP_Query($livevidsArgs);
        if($liveVidsQuery->have_posts()): while($liveVidsQuery->have_posts()): $liveVidsQuery->the_post();
            $videos = get_field('videos');
            if($videos) {
                $added = get_the_date('Ymd');
                $i = 0;
                foreach($videos as $v) {
                    if($v['video']) {
                        $name       = $v['info']['song'];
                        $videoRaw   = get_post_meta($post->ID, 'videos_' . $i . '_video', false);
                        $video      = parse_url($videoRaw[0]); parse_str($video['query'], $videoData);
                        $videoId    = $videoData['v'];
                        if($videoId) {
                            array_push($vidsLive, array(
                                'id'        => $videoId,
                                'name'      => $name,
                                'added'     => $added,
                                'release'   => $release,
                            ));
                        }
                    }
                    $i++;
                }
            }
        endwhile; endif;
        wp_reset_query();


        var_dump($vidsMusic);


        echo '</article>';

        echo '<aside class="page-sidebar">';
            $memberVid = gov_member('Videos')['long_video'];
            include('modules/govmembervid.php');
        echo '</aside>';



    // TODO: Construct objects for each of the 3 query types
    // TODO: Have page look at URL query string on page load to auto-load video
    // TODO: Just one frame for player that gets populated with the YT ID.
    // TODO: 4 Columns/Sections for "Recent, Sinema, Music Videos, Live Performance"

    // TV Expand Effect: https://codepen.io/anatravas/pen/vyOwOZ?css-preprocessor=less

    get_footer();
?>