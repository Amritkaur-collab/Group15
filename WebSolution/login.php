<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../WebSolution/styles/style.css" />
    <meta name="author" content="Group 15" />
    <title>Login</title>
</head>

<body>
    <div id='login-background'>

        <div id='login-box'>

            <img id='login-logo' src='images/dashboard/login/logo.png' id='dbheader-icon' />

            <form id='login-form' action="../WebSolution/auth/auth.php" method="POST">
                <p id = 'login-title'>Sign In</p>

                <label for='login-user-id'>User</label>
                <input id='login-user-id' type='text' name='user_id' />
                <br />
                <label for='login-password'>Password</label>
                <input id='login-password' type='password' name='password' />
                <br />
                <?php
            // Displays any errors enountered by auth.php during login (invalid user or password)
            session_start();
            if (isset($_SESSION['error-msg'])) {
                echo "<p id = 'login-error-msg'>" . $_SESSION['error-msg'] . "</p>";
                session_unset();
                session_destroy();
            }
            ?>
                <input id='login-submit' type='submit' value="Log In" />
            </form>

        </div>
    </div>

</body>

</html>