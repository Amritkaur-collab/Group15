<?php

require_once "../WebSolution/inc/dbconn.inc.php"; 
require_once "../WebSolution/auth/sessioncheck.php";


if (!isset($_SESSION['logs'])) {
    $_SESSION['logs'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $jobDescription = filter_input(INPUT_POST, "job", FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_STRING);
    $employeeId = filter_input(INPUT_POST, "employee_id", FILTER_SANITIZE_NUMBER_INT);
    $employeeName = filter_input(INPUT_POST, "employee_name", FILTER_SANITIZE_STRING);
    $log = filter_input(INPUT_POST, "details", FILTER_SANITIZE_STRING);
    $timestamp = filter_input(INPUT_POST, "timestamp", FILTER_SANITIZE_STRING); 

    
    $employeeName = empty($employeeName) ? '-' : $employeeName;

    if (!empty($timestamp)) {
        
        $stmt = $conn->prepare("UPDATE JobNotes SET operational_status = ?, user_id = ?, user_name = ?, content = ? WHERE job_description = ? AND timestamp = ?");
        $stmt->bind_param("sissss", $status, $employeeId, $employeeName, $log, $jobDescription, $timestamp);

        if ($stmt->execute()) {
            echo "Job updated successfully.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error updating job: " . htmlspecialchars($stmt->error);
        }
    } else {
        
        $newLogEntry = [
            date('Y-m-d H:i:s'), 
            $jobDescription,      
            $status,            
            $employeeId,         
            $employeeName,       
            $log                 
        ];

        $_SESSION['logs'][] = $newLogEntry;

        
        if (count($_SESSION['logs']) > 5) {
            array_shift($_SESSION['logs']); 
        }

        
        $jobCheckStmt = $conn->prepare("SELECT COUNT(*) FROM JobNotes WHERE job_description = ?");
        $jobCheckStmt->bind_param("s", $jobDescription);
        $jobCheckStmt->execute();
        $jobCheckStmt->bind_result($count);
        $jobCheckStmt->fetch();
        $jobCheckStmt->close();

        if ($count > 0) {
            
            $stmt = $conn->prepare("UPDATE JobNotes SET operational_status = ?, user_id = ?, user_name = ?, content = ? WHERE job_description = ?");
            $stmt->bind_param("sisss", $status, $employeeId, $employeeName, $log, $jobDescription);

            if ($stmt->execute()) {
                echo "Updated successfully.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Error logging job: " . htmlspecialchars($stmt->error); 
            }
            $stmt->close(); 
        } else {
            echo "Error: Job '" . htmlspecialchars($jobDescription) . "' does not exist in the Jobs table.";
        }
    }
}


$logs = array_reverse($_SESSION['logs']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Manufacturing Dashboard: Update Assigned Jobs</title>
    <link rel="stylesheet" href="../WebSolution/styles/style.css" />
    <?php   
        require_once "auth/sessioncheck.php";
        require_once "auth/permissioncheck.php";
        requireRole(array('Production Operator'));
    ?>
    <style>
        .status-progress {
            background-color: yellow;
            color: black;
        }

        .status-waiting{
            background-color: red;
            color: white;
        }

        .status-completed {
            background-color: green;
            color: white;
        }

        .status-hold {
            background-color: black;
            color: white;
        }
    </style> 
    <script src="../WebSolution/scripts/po_script.js"></script>
</head>
<body>
    <?php require_once "../WebSolution/inc/dbsidebar.inc.php"; ?>
    <?php require_once "../WebSolution/inc/dbheader.inc.php"; ?>

    <div id="pagetitle">
        <h1>Job Assignment</h1>
    </div>

    <div id='updatepage'>
        <form method="POST" action="">
            <div id="filters">
                <h2>Job Update</h2>
                <ul>
                    <li>
                        <label for="job">Job Description: </label>
                        <input type="text" name="job" id="job" required>
                    </li>

                    <li>
                        <label for="status">Operational Status: </label>
                        <select name="status" id="status" required onchange="setStatusColor()">
                            <option value="">Select Status</option>
                            <option value="In Progress" class="status-progress">In Progress</option>
                            <option value="Waiting for Parts" class="status-waiting">Waiting for Parts</option>
                            <option value="Completed" class="status-completed">Completed</option>
                            <option value="On Hold" class="status-hold">On Hold</option>
                        </select>
                    </li>


                    <li>
                        <label for="employee_id">Assigned to (ID):</label>
                        <input type="number" name="employee_id" id="employee_id" required>
                    </li>

                    <li>
                        <label for="employee_name">Updated by (Name):</label>
                        <input type="text" name="employee_name" id="employee_name" required>
                    </li>

                    <li>
                        <label for="details">Additional Details:</label>
                        <textarea name="details" id="details" rows="4" cols="50"></textarea>
                    </li>

                    <input type="hidden" name="timestamp" id="timestamp" value="">
                    
                    <li>
                        <input type="submit" id="submit" value="Update">
                    </li>
                </ul>
            </div>

            <div id="latest-machine-updates">
                <h2>Recent Job Updates</h2>
                <?php if (!empty($logs)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date and Time</th>
                                <th>Job Description</th>
                                <th>Operational Status</th>
                                <th>Assigned to (ID)</th>
                                <th>Updated by (Name)</th>
                                <th>Additional Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $logEntry): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($logEntry[0]); ?></td>
                                    <td><?php echo htmlspecialchars($logEntry[1]); ?></td>
                                    <td class="<?php echo 'status-' . strtolower($logEntry[2]); ?>">
                                        <?php echo htmlspecialchars($logEntry[2]); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($logEntry[3]); ?></td>
                                    <td><?php echo htmlspecialchars($logEntry[4]); ?></td>
                                    <td><?php echo htmlspecialchars($logEntry[5]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No recent updates.</p>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <footer>
        <p>@FactorieWorks Co.</p>
    </footer>
</body>
</html>
