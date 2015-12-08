<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
