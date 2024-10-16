<div id="machine-view-window">
<?php 



    $c = $conn;
    $machine = 'CNC Machine';
    $timestamps = getMostRecentTimestamps($c, 6, $machine);

    $status = getMachineLogValue('operational_status', $timestamps[1], $machine, $c);








?>


<h2><?php echo $machine ?></h2>
<tr><td>Status</td><td><?php echo $status ?></td></tr>
<br/>

<label for = "db-machine-view-productivity">Production Count</label>
<canvas id="db-machine-view-productivity" width="600" height="300"></canvas>

<label for = "db-machine-view-productivity">Power Consumption</label>
<canvas id="db-machine-view-powerconsumption" width="600" height="300"></canvas>

<script type="module">
    import {
        drawLineGraph
    } from "./scripts/dbgraph.js";
<?php
createGraph("db-machine-view-productivity",'blue', 'production_count', $timestamps[0], $timestamps[1], $machine, $c);
createGraph("db-machine-view-powerconsumption",'green', 'power_consumption', $timestamps[0], $timestamps[1], $machine, $c);
?>
</script>
</div>
