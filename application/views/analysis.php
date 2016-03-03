<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="body">
    <table class="analysis">
        <tr>
            <td>EURUSD</td>
            <td>GBPUSD</td>
            <td>USDUAH</td>
            <td>USDRUB</td>
            <td>Gold</td>
            <td>Silver</td>
            <td>#CL</td>
            <td>#USDX</td>
        </tr>
        <?php foreach (array('month', 'day', 'hour') as $period) : ?>
            <tr>
                <?php foreach (array('EURUSD', 'GBPUSD', 'USDUAH', 'USDRUR', 'GOLD', 'SILVER', 'CL', 'USDX') as $symbol) : ?>
                    <td>
                        <a href="<?php echo base_url() ?>analysis/symbol/<?php echo $symbol ?>/<?php echo $period ?>"><?php echo ucfirst($period) ?></a>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>