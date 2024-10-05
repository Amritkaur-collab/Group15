<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>User Session Test</p>

    <?php 
    session_start();
    echo $_SESSION['user_id'].'<br/>';
    echo $_SESSION['first_name'].' ';
    echo $_SESSION['last_name'].'<br/>';
    echo $_SESSION['user_type'].'<br/>';
    ?>
    
</body>
</html>