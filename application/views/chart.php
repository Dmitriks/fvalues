<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title ?></title>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>css/styles.css"></link>
    </head>
    <body>

        <div id="container">
            <h1><?php echo $title ?></h1>
            <div id="body">

                <?php foreach ($charts as $chart) : ?>
                    <div class="chart">
                        <img class="chart" src="<?php echo base_url() ?><?php echo $chart ?>"/>
                    </div>
                <?php endforeach; ?>

            </div>
            <div class="footer"><div class="source">Source: <a href="https://www.instaforex.com">https://www.instaforex.com</a></div>Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></div>
        </div>
    </body>
</html>