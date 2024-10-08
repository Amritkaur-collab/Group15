<?php
require_once "inc/dbconn.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./styles/loginstyle.css">
</head>

<body>
    <h1>Login Page</h1>

    <div class="centred-form">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <!--<div class="form-row">
                <label class="form-label">Username</label><input class="form-input" type="text" name="username">
            </div>-->
            <div class="form-row">
                <label class="form-label">EmployeeID</label><input class="form-input" type="number" name="employeeID">
            </div>
            <div class="form-row">
                <label class="form-label">Password</label><input class="form-input" type="password" name="password">
            </div>
    </div>
    <div class="centred-btn-container">
        <input class="submit-btn" type="submit" name="submit" value="Login">
    </div>
    </form>
</body>

</html>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $employeeID = filter_input(INPUT_POST, "employeeID", FILTER_SANITIZE_NUMBER_INT);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($employeeID)) {
        echo "<p style=\"text-align: center; margin-top: 10px;\">Please enter employeeID</p>";
    }
    elseif (empty($password)) {
        echo "<p style=\"text-align: center; margin-top: 10px;\">Please enter a password</p>";
    } else {
        $sql = "SELECT * FROM users WHERE employeeID = '$employeeID';";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "<p style=\"text-align:center; margin-top:10px;\">ID: " . $row["id"] . "<br>";
            echo "EmployeeID: " . $row["employeeID"] . "<br>";
            if (password_verify($password, $row["password"])) {
                echo "<b>password is correct</b><br>";
                //echo "Password: " . $row["password"] . "<br>";
                echo "User role: " . $row["userRole"] . "</p>";
            } else {
                echo "<i style=\"color: red\">password incorrect</i></p><br>";
            }
        }else{
            echo "<p style=\"color: red; text-align: center; margin-top:10px;\"><i>User does not exist</i></p><br>";
        }
    }
}

mysqli_close($conn);
?>
