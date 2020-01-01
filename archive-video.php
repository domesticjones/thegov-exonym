<?php
  function gov_color() {
    $memberColor = gov_member('Videos')['color'];
    include('modules/govcolors.php');
  }
  add_action('wp_head', 'gov_color', 100);
    get_header();
    echo '<article id="performance-archive" class="page-content">';

    // Query and compose for Sinema Videos
    if(have_posts()): while(have_posts()): the_post();
        $name = get_the_title();
        $video = parse_url(get_field('video', $post->ID, false)); parse_str($video['query'], $videoData);
        $videoId = $videoData['v'];
        var_dump($videoId);


        //echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $videoId . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    endwhile; endif;
    echo '</article>';

    echo '<aside class="page-sidebar">';
      $memberVid = gov_member('Videos')['long_video'];
      include('modules/govmembervid.php');
    echo '</aside>';



    // Query than compose for Live Videos (Events -> Extract Videos)


    // Query then compose for Music Videos (WC -> Albums -> Extract Videos)


    // TODO: Construct objects for each of the 3 query types
    // TODO: Have page look at URL query string on page load to auto-load video
    // TODO: Just one frame for player that gets populated with the YT ID.
    // TODO: 4 Columns/Sections for "Recent, Sinema, Music Videos, Live Performance"

    // TV Expand Effect: https://codepen.io/anatravas/pen/vyOwOZ?css-preprocessor=less

    get_footer();
?>