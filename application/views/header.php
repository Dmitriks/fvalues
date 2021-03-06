<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>fvalues.com - <?php echo $title ?></title>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>css/styles.css"></link>
    </head>
    <body>
        <div id="container">
            <div class="menu">
                <a href="<?php echo base_url() ?>">Home</a>
                <a href="<?php echo base_url() ?>chart/last_hour">Last hour</a>
                <a href="<?php echo base_url() ?>chart/last_day">Last day</a>
                <a href="<?php echo base_url() ?>chart/last_month">Last month</a>
                <a href="<?php echo base_url() ?>chart/symbol/EURUSD">EURUSD</a>
                <a href="<?php echo base_url() ?>chart/symbol/GBPUSD">GBPUSD</a>
                <a href="<?php echo base_url() ?>chart/symbol/USDUAH">USDUAH</a>
                <a href="<?php echo base_url() ?>chart/symbol/USDRUR">USDRUB</a>
                <a href="<?php echo base_url() ?>chart/symbol/GOLD">Gold</a>
                <a href="<?php echo base_url() ?>chart/symbol/SILVER">Silver</a>
                <a href="<?php echo base_url() ?>chart/symbol/CL">#CL</a>
                <a href="<?php echo base_url() ?>chart/symbol/USDX">#USDX</a>
                <a href="<?php echo base_url() ?>chart/ratio/GOLD/SILVER">Gold / Silver</a>
                <a href="<?php echo base_url() ?>chart/ratio/GOLD/CL">Gold / #CL</a>
                <a href="<?php echo base_url() ?>analysis">Analysis</a>
            </div>
            <h1><?php echo $title ?></h1>