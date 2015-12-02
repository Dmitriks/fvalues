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
    'GOLD'   => 'Gold',
    'SILVER' => 'Silver',
    '#CL'    => 'Crude Oil Light Sweet',
    '#NG'    => 'Natural Gas',
);
