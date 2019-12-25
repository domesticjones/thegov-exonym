<?php
    get_header();

    // Query and compose for Sinema Videos
    if(have_posts()): while(have_posts()): the_post();
        $name = get_the_title();
        $video = parse_url(get_field('video', $post->ID, false)); parse_str($video['query'], $videoData);
        $videoId = $videoData['v'];
        var_dump($videoId);


        //echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $videoId . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    endwhile; endif;

    // Query than compose for Live Videos (Events -> Extract Videos)


    // Query then compose for Music Videos (WC -> Albums -> Extract Videos)


    // TODO: Construct objects for each of the 3 query types
    // TODO: Have page look at URL query string on page load to auto-load video
    // TODO: Just one frame for player that gets populated with the YT ID.
    // TODO: Three Columns/Sections for "Music Videos, Sinema, Live Performance"

    get_footer();
?>