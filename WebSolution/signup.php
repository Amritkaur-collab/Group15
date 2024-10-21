<?php
require_once "inc/dbconn.inc.php"; // Include database connection
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
                <label class="form-label">UserID</label>
                <input class="form-input" type="text" name="user_id" pattern="[A-Za-z0-9]+" title="UserID must be alphanumeric" required>
            </div>
            <div class="form-row">
                <label class="form-label">First Name</label>
                <input class="form-input" type="text" name="first_name" required>
            </div>
            <div class="form-row">
                <label class="form-label">Last Name</label>
                <input class="form-input" type="text" name="last_name" required>
            </div>
            <div class="form-row">
                <label class="form-label">Password</label>
                <input class="form-input" type="password" name="password" required>
            </div>
            <div class="form-row">
                <label class="form-label">Role</label>
                <select class="form-input" name="user_type" required>
                    <option value="">Select...</option>
                    <option value="Administrator">Administrator</option>
                    <option value="Factory Manager">Factory Manager</option>
                    <option value="Production Operator">Production Operator</option>
                    <option value="Auditor">Auditor</option>
                </select>
            </div>
            
            <div class="centred-btn-container">
                <input class="submit-btn" type="submit" name="submit" value="Register">
            </div>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate inputs
        $userID = filter_input(INPUT_POST, "user_id", FILTER_SANITIZE_SPECIAL_CHARS);
        $firstName = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $lastName = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $userRole = filter_input(INPUT_POST, "user_type", FILTER_SANITIZE_SPECIAL_CHARS);

        // Check if inputs are empty
        if (empty($userID) || empty($firstName) || empty($lastName) || empty($password) || empty($userRole)) {
            echo "<p style='text-align: center; margin-top: 10px;'>All fields are required.</p>";
        } elseif ($userRole === "") {
            echo "<p style='text-align: center; margin-top: 10px;'>Please select a valid role.</p>";
        } else {
            // Check if user already exists
            $sql = "SELECT * FROM users WHERE user_id = '$userID';";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo "<script>alert('That UserID already exists!');</script>";
            } else {
                // Hash the password for security
                $hash_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert the user into the database
                $sql = "INSERT INTO users (user_id, first_name, last_name, password_hash, user_type) 
                        VALUES ('$userID', '$firstName', '$lastName', '$hash_password', '$userRole');";
                
                if (mysqli_query($conn, $sql)) {
                    echo "<h3 style='text-align: center; margin-top: 10px;'>Thank you $firstName. Registration complete.</h3>";
                } else {
                    echo "<script>alert('Registration failed: " . mysqli_error($conn) . "');</script>";
                }
            }
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
