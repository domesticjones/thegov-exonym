<?php
  echo '
    <style>
      a,
      .accent,
      h1.accent,
      h2.accent,
      address,
      time,
      .upcoming-data li.button {
        border-color: ' . $memberColor . ';
        color: ' . $memberColor . ';
      }

      #header,
      .nav-responsive {
        background-color: ' . $memberColor . ';
        box-shadow: 0 0 1rem ' . $memberColor . ';
      }

      #header .social-info {
        background-color: ' . $memberColor . ';
      }

      .bagoshit-accent {
        fill: ' . $memberColor . ' !important;
      }
    </style>
  ';
