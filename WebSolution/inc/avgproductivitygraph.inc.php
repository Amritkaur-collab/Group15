
<?php
$timestamps = ['', ''];
if (isset($_POST['timefrom']) && isset($_POST['timeto'])) {
    $timestamps[0] = $_POST['timefrom'];
    $timestamps[1] = $_POST['timeto'];
} else {
    $timestamps = getMostRecentTimestamps($c, 6, 'CNC Machine');
}
?>

<div id="avg-productivity">
    <h2>Average Productivity</h2>

    <form action="" method="POST">
        <div id='graph-input'>
            <input id="timefrom" type="text" name="timefrom" required value="<?php echo $timestamps[0]?>">
            <button id="timefrom-open" type="button" onclick="buttonDTS('timefrom')">O</button>
            </input>
            -
            <input id="timeto" type="text" name="timeto" required value="<?php echo $timestamps[1]?>">
            <button id="timeto-open" type="button" onclick="buttonDTS('timeto')">O</button>
            </input>
            <br /><input id="submit" type="submit" value="Apply">
        </div>
    </form>
    <canvas id="avg_productivity" width="600" height="300"></canvas>
</div>


<script type="module">
    import {
        drawLineGraph
    } from "./scripts/dbgraph.js";
    <?php createAvgGraph('avg_productivity', 'blue', getAverageProductionValues($timestamps[0], $timestamps[1], $c)); ?>
</script>
