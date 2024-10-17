<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles/style.css" />
    <?php   
        require_once "auth/sessioncheck.php";
    ?>
    <?php require_once "auth/permissioncheck.php";
        requireRole(array('Administrator', 'Auditor', 'Factory Manager'));
    ?>

</head>

<body>
    <?php require_once "inc/dbheader.inc.php"; ?>
    <?php require_once "inc/dbsidebar.inc.php"; ?>

    <div id = "pagetitle">
        <h1>Dashboard</h1>
    </div>

    <div id = "db-content">
    <div id = 'db-home'>
        <?php require_once "inc/avgproductivitygraph.inc.php";?>
    </div>
    </div>


    <footer>
        <p>Dashboard Footer</p>
        <?php mysqli_close($conn)?>
    </footer>

</body>

</html>