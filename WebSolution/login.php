<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="auth/auth.php" method="POST">
        <input type = 'text' name = 'user_id'/>
        <input type = 'text' name = 'password'/>
        <input type = 'submit'/>
    </form>
    
    <?php
    // Displays any errors enountered by auth.php during login (invalid user or password)
    session_start();
    if(isset($_SESSION['error-msg']))
    {
        echo $_SESSION['error-msg'];
        session_unset();
        session_destroy();
    }
    ?>
    
</body>
</html>