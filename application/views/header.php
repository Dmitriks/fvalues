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
                <a href="<?php echo base_url() ?>chart/symbol/EURUSD">Euro vs US Dollar</a>
                <a href="<?php echo base_url() ?>chart/symbol/GOLD">Gold</a>
                <a href="<?php echo base_url() ?>chart/symbol/SILVER">Silver</a>
                <a href="<?php echo base_url() ?>chart/symbol/CL">Crude Oil Light Sweet</a>
                <a href="<?php echo base_url() ?>chart/symbol/NG">Natural Gas</a>
            </div>
            <h1><?php echo $title ?></h1>