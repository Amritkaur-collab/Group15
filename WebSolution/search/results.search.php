<?php
require_once "inc/dbconn.inc.php";
$params = array();
$machine_names = "";
if (isset($_POST["machine"]) && isset($_POST["timeto"]) && isset($_POST["timefrom"])) {
    array_push($params, $_POST["timeto"]);
    array_push($params, $_POST["timefrom"]);
    $machine_names = implode(", ", array_fill(0, count($_POST["machine"]), "?"));
    array_push($params, ...$_POST["machine"]);

    $sql = "SELECT * FROM MachineLogs WHERE timestamp <= ? AND timestamp >= ? AND machine_name IN ($machine_names)";

    if (!empty($_POST["error-code"]) | strlen($_POST["error-code"]) != 0) {
        $sql = $sql . " AND error_code = ?";
        array_push($params, $_POST["error-code"]);
    }
    if (!empty($_POST["operational-status"]) | strlen($_POST["operational-status"]) != 0) {
        $sql = $sql . " AND operational_status = ?";
        array_push($params, $_POST["operational-status"]);
    }

    $sql = $sql . ";";

    $statement = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($statement, $sql);

    $s = str_repeat("s", count($params));

    mysqli_stmt_bind_param($statement, $s, ...$params);
    mysqli_stmt_execute($statement);

    if ($result = mysqli_stmt_get_result($statement)) {
        if ($rowcount = mysqli_num_rows($result) >= 1) {
            $count = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $str = "odd";
                if ($count % 2 == 0) $str = "even";
                echo "<tr id = $str>";
                echo "<td>$row[timestamp]</td>";
                echo "<td>$row[machine_name]</td>";
                echo "<td>$row[temperature]</td>";
                echo "<td>$row[pressure]</td>";
                echo "<td>$row[vibration]</td>";
                echo "<td>$row[humidity]</td>";
                echo "<td>$row[power_consumption]</td>";
                echo "<td>$row[operational_status]</td>";
                echo "<td>$row[error_code]</td>";
                echo "<td>$row[production_count]</td>";
                echo "<td>$row[maintenance_log]</td>";
                echo "<td>$row[speed]</td>";
                echo "</tr>";
                $count++;
            }
            mysqli_free_result($result);
        }
    }
    mysqli_close($conn);
} else {
}
