<?php
require_once "inc/dbconn.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="./styles/loginstyle.css">
</head>

<body>
    <h1>Sign Up Page</h1>

    <div class="centred-form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-row">
                <label class="form-label">Username</label>
                <input class="form-input" type="text" name="username" required>
            </div>
            <div class="form-row">
                <label class="form-label">Employee ID</label>
                <input class="form-input" type="number" name="employeeID" required>
            </div>
            <div class="form-row">
                <label class="form-label">Password</label>
                <input class="form-input" type="password" name="password" required>
            </div>
            <div class="form-row">
                <label class="form-label">Role</label>
                <select class="form-input" name="userRole">
                    <option>Select...</option>
                    <option>Administrator</option>
                    <option>Factory Manager</option>
                    <option>Production Operator</option>
                    <option>Auditor</option>
                </select>
            </div>
        </div>
        <div class="centred-btn-container">
            <input class="submit-btn" type="submit" name="submit" value="Register">
        </div>
        </form>
</body>

</html>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $employeeID = filter_input(INPUT_POST, "employeeID", FILTER_SANITIZE_NUMBER_INT);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $userRole = $_POST["userRole"];

    if (empty($username)) {
        echo "<p style=\"text-align: center; margin-top: 10px;\">Please enter a username</p>";
    } elseif (empty($password)) {
        echo "<p style=\"text-align: center; margin-top: 10px;\">Please enter a password</p>";
    } elseif (empty($employeeID)) {
        echo "<p style=\"text-align: center; margin-top: 10px;\">Please enter employee ID</p>";
    } elseif ($userRole == "Select...") {
        echo "<p style=\"text-align: center; margin-top: 10px;\">Please select a valid user role</p>";
    } else {
        // Check if the user already exists
        $check_sql = "SELECT * FROM users WHERE username = '$username' OR employeeID = '$employeeID';";
        $result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert(\"That user already exists!\");</script>";
        } else {
            $hash_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user directly into the database
            $sql = "INSERT INTO users(username, employeeID, password, userRole) VALUES ('$username', '$employeeID', '$hash_password', '$userRole');";
            
            if (mysqli_query($conn, $sql)) {
                echo "<h3 style=\"text-align: center; margin-top: 10px;\">Thank you $username. Registration complete</h3>";
            } else {
                echo "<script>alert(\"Registration failed: " . mysqli_error($conn) . "\");</script>";
            }
        }
    }
}

mysqli_close($conn);
?>
