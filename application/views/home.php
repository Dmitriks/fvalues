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
        <?php $timeDiff = date('Z'); ?>
        <?php foreach ($quotes as $quote): ?>
            <?php if (isset($symbols[$quote->symbol])) : ?>
                <tr>
                    <td><?php echo $symbols[$quote->symbol] ?></td>
                    <td><?php echo $quote->bid ?></td>
                    <td><?php echo $quote->ask ?></td>
                    <td <?php if ($quote->change > 0): ?>class="green"<?php elseif ($quote->change < 0): ?>class="red"<?php endif; ?>><?php echo $quote->change ?></td>
                    <td <?php if ($quote->change24h > 0): ?>class="green"<?php elseif ($quote->change24h < 0): ?>class="red"<?php endif; ?>><?php echo $quote->change24h ?></td>
                    <td class="centered"><?php echo date('Y-m-d H:i:s', strtotime("-$timeDiff second", $quote->lasttime)) ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</div>
