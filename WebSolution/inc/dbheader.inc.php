<header id = dbheader>
    <div id='dbheader-info'>
        <img src='images/dashboard/header/logo.png' id='dbheader-icon'/>
        <p>FactorieWorks Co.</p>
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
            if(file_exists('images/users/$_SESSION[user_id].png'))
            {
                echo "<img src='images/users/$_SESSION[user_id].png' id='dbheader-user-icon'/>";
            }
            else
            {
                echo "<img src='images/users/no-user-icon.svg' id='dbheader-user-icon'/>";
            }
             
            ?>

        <a href='inc/signout.inc.php'><button id = 'db-sign-out'></button></a>

    </div>
</header>