<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Welcome to Fvalues</title>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/styles.css"></link>
    </head>
    <body>

        <div id="container">
            <h1>Welcome to Fvalues!</h1>
            <div id="body">
                <table class="quotes">
                    <tr>
                        <th>Symbol</th>
                        <th>Bid</th>
                        <th>Ask</th>
                        <th>Change</th>
                        <th>Change 24h</th>
                        <th>Last time</th>
                    </tr>
                    <?php foreach ($quotes as $key => $elem): ?>
                        <tr>
                            <td><?php echo $symbols[$key] ?></td>
                            <td><?php echo $elem['bid'] ?></td>
                            <td><?php echo $elem['ask'] ?></td>
                            <td><?php echo $elem['change'] ?></td>
                            <td><?php echo $elem['change24h'] ?></td>
                            <td><?php echo $elem['lasttime'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
        </div>

    </body>
</html>