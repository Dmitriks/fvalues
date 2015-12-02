<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Foreign exchange and commodity values</title>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>css/styles.css"></link>
    </head>
    <body>

        <div id="container">
            <h1>Foreign exchange and commodity values</h1>
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
                            <td <?php if ($elem['change'] > 0): ?>class="green"<?php elseif ($elem['change'] < 0): ?>class="red"<?php endif; ?>><?php echo $elem['change'] ?></td>
                            <td <?php if ($elem['change24h'] > 0): ?>class="green"<?php elseif ($elem['change24h'] < 0): ?>class="red"<?php endif; ?>><?php echo $elem['change24h'] ?></td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime('-2 hours', $elem['lasttime'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="footer"><div class="source">Source: <a href="https://www.instaforex.com">https://www.instaforex.com</a></div>Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></div>
        </div>
    </body>
</html>