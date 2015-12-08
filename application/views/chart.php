<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="body">
    <?php foreach ($charts as $chart) : ?>
        <div class="chart">
            <img class="chart" src="<?php echo base_url() ?><?php echo $chart ?>"/>
        </div>
    <?php endforeach; ?>

</div>