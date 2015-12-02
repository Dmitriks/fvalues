<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------
  | Trade symbolss
  | -------------------------------------------------------------------
 */
$config['api_url'] = 'https://quotes.instaforex.com/get_quotes.php?m=arr';
$config['symbols'] = array(
//  symbol      Trading instrument						
    'EURUSD' => 'Euro vs US Dollar',
    'GOLD'   => 'Spot Gold',
    'SILVER' => 'Silver',
    '#NG'    => 'Natural Gas'
);
