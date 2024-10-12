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
            echo $value[$valueType];

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
?>
