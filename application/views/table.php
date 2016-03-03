<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="body">
    <?php if (empty($waves)) : ?>
        Off-time
    <?php else: ?>
        <table class="table">
            <tr>
                <th>Date</th>
                <th>Bid</th>
                <th>Wave</th>
            </tr>
            <?php foreach ($waves as $wave) : ?>
                <?php foreach ($wave['values'] as $value) : ?>
                    <tr>
                        <?php $dateFormat = ($period == 'month' || $period == 'year') ? 'Y-m-d' : 'H:i'; ?>
                        <td><?php echo date($dateFormat, $value['time']) ?></td>
                        <td <?php if ($wave['direction'] == 1) : ?>class="green"<?php elseif ($wave['direction'] == -1) : ?>class="red"<?php endif; ?>><?php echo $value['bid'] ?></td>
                        <td class="centered"><?php echo $wave['marker'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </table>
        <table class="table">
            <tr>
                <?php foreach (array('year', 'month', 'day', 'hour') as $period) : ?>
                    <td>
                        <a href="<?php echo base_url() ?>analysis/symbol/<?php echo $symbol ?>/<?php echo $period ?>"><?php echo ucfirst($period) ?></a>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
    <?php endif; ?>
</div>