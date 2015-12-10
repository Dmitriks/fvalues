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
                <a href="<?php echo base_url() ?>chart/symbol/GOLD">Gold</a>
                <a href="<?php echo base_url() ?>chart/symbol/SILVER">Silver</a>
                <a href="<?php echo base_url() ?>chart/symbol/CL">#CL</a>
                <a href="<?php echo base_url() ?>chart/symbol/NG">#NG</a>
                <a href="<?php echo base_url() ?>chart/ratio/GOLD/EURUSD">Gold / EURUSD</a>
                <a href="<?php echo base_url() ?>chart/ratio/GOLD/SILVER">Gold / Silver</a>
                <a href="<?php echo base_url() ?>chart/ratio/GOLD/CL">Gold / #CL</a>
                <a href="<?php echo base_url() ?>chart/ratio/GOLD/NG">Gold / #NG</a>
                <a href="<?php echo base_url() ?>chart/ratio/CL/NG">#CL / #NG</a>
            </div>
            <h1><?php echo $title ?></h1>