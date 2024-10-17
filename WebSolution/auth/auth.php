<?php
// The login form should have this as its action
// 

authenticate();

function authenticate()
{
    if(isset($_POST['user_id']) && isset($_POST['password']))
    {
        require_once "../inc/dbconn.inc.php";

        $sql = "SELECT * FROM Users WHERE user_id = ?";
        $statement = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($statement, $sql);

        mysqli_stmt_bind_param($statement, 's', $_POST['user_id']);
        mysqli_stmt_execute($statement);

        if($result = mysqli_stmt_get_result($statement))
        {
            if(mysqli_num_rows($result) >= 1)
            {
                $user = mysqli_fetch_assoc($result);

                if(password_verify($_POST['password'], $user['password_hash']))
                {
                    session_start();
                    $_SESSION['exists'] = true;
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['user_type'] = $user['user_type'];
                    if ($_SESSION['user_type'] === 'Production Operator') {
                        header('Location: ../po_dashboard.php'); // Redirect to production operator dashboard
                    } else {
                        header('Location: ../home.php'); // Redirect to a general home page for other roles
                    }
                }
                else
                {
                    passwordIncorrect();
                }
            }
            else
            {
                userNotFound();
            }

        }

    }
    mysqli_close($conn);
}

function userNotFound()
{
    session_start();
    $_SESSION['error-msg'] = "User not found";
    header('Location: ../login.php');

}
function passwordIncorrect()
{
    session_start();
    $_SESSION['error-msg'] = "Incorrect password";
    header('Location: ../login.php');
}
?>
