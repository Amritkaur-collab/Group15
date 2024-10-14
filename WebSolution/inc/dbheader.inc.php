<header id = dbheader>
    <div id='dbheader-info'>
        <img src='images/dashboard/header/logo.png' id='dbheader-icon'/>
        <p>Factory Works Co.</p>
    </div>

    <div id='dbheader-user'>
        <div id = 'dbheader-user-text'>
        <p id='dbheader-name'>
            <?php
            echo $_SESSION['first_name'] . ' ';
            echo $_SESSION['last_name'] . '<br/>';
            ?>
        </p>
        <p id='dbheader-role'>
            <?php
            echo $_SESSION['user_type'];
            ?>
        </p>
        </div>
            <?php
             echo "<img src='images/users/$_SESSION[user_id].png' id='dbheader-user-icon'/>";
            ?>

            <a href='inc/signout.inc.php'><button>Sign Out</button></a>
    </div>
</header>