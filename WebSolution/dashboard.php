<?php
// Load the factory logs CSV file
$csvFile = 'C:\xampp\htdocs\www\web soln\Group15\WebSolution\factory_logs.csv';
$csvData = [];

if (($handle = fopen($csvFile, "r")) !== false) {
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        // Ensure that the necessary array keys exist before accessing them
        $csvData[] = [
            'timestamp' => $data[0] ?? null,
            'machine_name' => $data[1] ?? null,
            'temperature' => $data[2] ?? null,
            'pressure' => $data[3] ?? null,
            'production_count' => $data[4] ?? 0, // Default to 0 if production count is missing
            'operational_status' => $data[5] ?? 'inactive' // Default to 'inactive' if missing
        ];
    }
    fclose($handle);
} else {
    echo "Error loading CSV file.";
}

// Variables to store sums for calculating averages
$totalProduction = 0;
$temperatureSum = 0;
$pressureSum = 0;
$operationalCount = 0;
$logCount = count($csvData);

// Calculate total production and averages
foreach ($csvData as $row) {
    $totalProduction += (int)$row['production_count'];
    $temperatureSum += (float)$row['temperature'];
    $pressureSum += (float)$row['pressure'];
    if ($row['operational_status'] === 'active') {
        $operationalCount++;
    }
}

$averageTemperature = $logCount > 0 ? $temperatureSum / $logCount : 0;
$averagePressure = $logCount > 0 ? $pressureSum / $logCount : 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factory Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1, h2 {
            text-align: center;
        }
        .dashboard-container {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            background-color: #f0f0f0;
        }
        .box {
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            width: 200px;
        }
        .box h3 {
            margin: 0;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .operator-actions {
            margin: 30px;
            text-align: center;
        }
        .logout {
            text-align: center;
            margin: 20px;
        }
    </style>
</head>

<body>
    <h1>Factory Performance Dashboard</h1>

    <!-- Boxes displaying operational status, production, etc. -->
    <div class="dashboard-container">
        <div class="box">
            <h3>Total Production</h3>
            <p><?php echo $totalProduction; ?></p>
        </div>
        <div class="box">
            <h3>Machines Active</h3>
            <p><?php echo $operationalCount; ?></p>
        </div>
        <div class="box">
            <h3>Average Temperature</h3>
            <p><?php echo number_format($averageTemperature, 2); ?>°C</p>
        </div>
        <div class="box">
            <h3>Average Pressure</h3>
            <p><?php echo number_format($averagePressure, 2); ?> kPa</p>
        </div>
    </div>

    <!-- Section for Production Operators to update machine status -->
    <div class="operator-actions">
        <h2>Production Operator Actions</h2>
        <p><a href="../WebSolution/updatemachines/updatemachine.php">Update Machine Status</a></p>
        <p><a href="viewlogs.php">View Logs</a></p>
        <p><a href="../WebSolution/updatejobs/updatejobs.php">Update Jobs Assigned</a></p>
        <p><a href="../WebSolution/tasknotes/tasknotes.php">Create Task Note</a></p>
    </div>

    <!-- Optional: Log out functionality -->
    <div class="logout">
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
