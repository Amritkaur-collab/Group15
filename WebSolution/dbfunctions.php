<?php

function getMachineLogValue($valueType, $timestamp, $machine, $c)
{
    $params = array($timestamp, $machine);

    $sql = "SELECT * FROM MachineLogs WHERE timestamp = ? AND machine_name = ?";

    $statement = mysqli_stmt_init($c);
    mysqli_stmt_prepare($statement, $sql);

    mysqli_stmt_bind_param($statement, 'ss', ...$params);
    mysqli_stmt_execute($statement);

    if ($result = mysqli_stmt_get_result($statement)) {
        if (mysqli_num_rows($result) >= 1) {
            $value = mysqli_fetch_assoc($result);
            return $value[$valueType];

            mysqli_free_result($result);
        }
    }
}

function getMachineLogValues($valueType, $timeFrom, $timeTo, $machine, $c)
{
    $params = array($timeFrom, $timeTo, $machine);

    $arr = array();

    $sql = "SELECT * FROM MachineLogs WHERE timestamp >= ? AND timestamp <= ? AND machine_name = ?";

    $statement = mysqli_stmt_init($c);
    mysqli_stmt_prepare($statement, $sql);

    mysqli_stmt_bind_param($statement, 'sss', ...$params);
    mysqli_stmt_execute($statement);

    if ($result = mysqli_stmt_get_result($statement)) {
        if (mysqli_num_rows($result) >= 1) 
        {
            while ($value = mysqli_fetch_assoc($result)) 
            {
                array_push($arr, array(explode(' ', $value['timestamp'])[1], $value[$valueType]));
            }
            mysqli_free_result($result);
        }
    }
    return $arr;
}

function getMostRecentTimestamps($c, $num, $machine)
{
    $params = array($machine, $num);
    $sql = "SELECT * FROM MachineLogs WHERE machine_name = ? ORDER BY timestamp DESC LIMIT ?;";

    $statement = mysqli_stmt_init($c);
    mysqli_stmt_prepare($statement, $sql);

    mysqli_stmt_bind_param($statement, 'ss', ...$params);
    mysqli_stmt_execute($statement);

    if($result = mysqli_stmt_get_result($statement))
    { 
        $i = 1;
        $from = "";
        $to = "";

        while($row = mysqli_fetch_assoc($result))
        {
            if($i == 1) $to = $row['timestamp'];

            $i++;

            if($i == $num)
            {
                $from = $row['timestamp'];
            }
        }
        return [$from, $to];
    }
}


function createGraph($canvas, $color, $valueType, $timeFrom, $timeTo, $machine, $c)
{
    echo 'var t = Array();';
    $t = getMachineLogValues($valueType, $timeFrom, $timeTo, $machine, $c);

    for ($i = 0; $i < count($t); $i++) {
        $str = $t[$i][0];
        $str = substr($str, 0, -3);

        echo 't.push( ["' . $str . '",' . $t[$i][1] . ']);';
    }


    echo 'drawLineGraph(t, "' . $canvas .'" , "' . $color . '");';
}

function createAvgGraph($canvas, $color, $points)
{
    echo 'var t = Array();';
    $t = $points;

    for ($i = 0; $i < count($t); $i++) {
        $str = $t[$i][0];
        $str = substr($str, 0, -3);

        echo 't.push( ["' . $str . '",' . $t[$i][1] . ']);';
    }


    echo 'drawLineGraph(t, "' . $canvas .'" , "' . $color . '");';
}

// Binding does not work with AVG
function getAverageProductionValues($timeFrom, $timeTo, $c)
{
    $params = array($timeFrom, $timeTo);
    $sql = "SELECT timestamp, AVG(production_count) AS avg
            FROM MachineLogs
            WHERE timestamp >= ? AND timestamp <= ?
            GROUP BY timestamp;
            ";

    $statement = mysqli_stmt_init($c);
    mysqli_stmt_prepare($statement, $sql);

    mysqli_stmt_bind_param($statement, 'ss', ...$params);
    mysqli_stmt_execute($statement);

    $arr = array();

    if($result = mysqli_stmt_get_result($statement))
    {   
        while($row = mysqli_fetch_assoc($result))
        {
            array_push($arr, array(explode(' ', $row['timestamp'])[1], $row['avg']));
        }
    }


    return $arr;
}




?>
