<?php
  if (!defined('WPINC')) { die; }

  function ex_shortcodeBusiness($atts) {
  	$a = shortcode_atts(
  		array(
  			'name' => '',
  			'contact' => '',
  		),
  		$atts,
  		'business'
  	);
    $output = '';

    // Business Name
    $name = $a['name'];
    if($name == 'legal') {
      $output = ex_brand('legal');
    } elseif($name == 'default') {
      $output = ex_brand();
    }

    // Contact Info
    $contact = $a['contact'];
    if($contact == 'email') {
      $emailList = [];
      $emails = get_field('email_addresses', 'options');
      foreach($emails as $e) {
        if($e['global']) {
          array_push($emailList, '<a href="mailto:' . $e['address'] . '" target="_blank">' . $e['address'] . ' (' . $e['name'] . ')</a>');
        }
      }
      $output = implode(', ', $emailList);
    } elseif($contact == 'phone') {
      $phoneList = [];
      $numbers = get_field('phone_numbers', 'options');
      foreach($numbers as $n) {
        if($n['global']) {
          array_push($phoneList, '<a href="tel:' . $n['number'] . '" target="_blank">' . $n['number'] . ' (' . $n['name'] . ')</a>');
        }
      }
      $output = implode(', ', $phoneList);
    } elseif($contact == 'address') {
      $output = str_replace('<br />', ', ', ex_contact('address'));
    }

    return $output;
  }
  add_shortcode('business', 'ex_shortcodeBusiness');
