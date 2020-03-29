<?php
  echo '
    <style>
      a,
      .accent,
      h1.accent,
      h2.accent,
      address,
      time,
      .upcoming-data li.button,
      .module-music-archive .button,
      blockquote:before,
      .module-merch-category a:hover p,
      .contact-buttons a,
      #video-tabs a.is-active,
      #video-tabs.accent,
      .video-control:hover .release {
        border-color: ' . $memberColor . ';
        color: ' . $memberColor . ';
      }

      .button,
      .contact-buttons a {
        box-shadow: 0 0 1em ' . $memberColor . ';
      }

      #header,
      #video-tabs a.is-active,
      .nav-responsive {
        background-color: ' . $memberColor . ';
        box-shadow: 0 0 1rem ' . $memberColor . ';
      }

      #header .social-info,
      .module-video-current .video-close:before {
        background-color: ' . $memberColor . ';
      }

      .bagoshit-accent {
        fill: ' . $memberColor . ' !important;
      }
    </style>
  ';
