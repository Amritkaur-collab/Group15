<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles/searchstyle.css" />
    <?php require_once "auth/sessioncheck.php"; ?>
</head>

<body>
    <?php require_once "inc/dbsidebar.inc.php"; ?>
    <?php require_once "inc/dbheader.inc.php"; ?>
    <p>User Session Test</p>

    <?php
    echo $_SESSION['user_id'] . '<br/>';
    echo $_SESSION['first_name'] . ' ';
    echo $_SESSION['last_name'] . '<br/>';
    echo $_SESSION['user_type'] . '<br/>';
    ?>
    <footer>
        <p>Dashboard Footer</p>
    </footer>

</body>

</html>