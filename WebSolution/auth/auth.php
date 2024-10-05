<?php

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
            $user = mysqli_fetch_assoc($result);

            if(password_verify($_POST['password'], $user['password_hash']))
            {
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['user_type'] = $user['user_type'];

                header('Location: ../home.php');
            }
            else
            {
                passwordIncorrect();
            }
        }
    }
    mysqli_close($conn);
}

function userNotFound()
{
    
}
function passwordIncorrect()
{

}
?>