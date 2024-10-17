<header id="dbheader">
    <div id='dbheader-info'>
        <img src='images/dashboard/header/logo.png' id='dbheader-icon'/>
        <p>FactorieWorks Co.</p>
    </div>

    <div id='dbheader-user'>
        <div id='dbheader-user-text'>
            <p id='dbheader-name'>
                <?php
                echo htmlspecialchars($_SESSION['first_name']) . ' ';
                echo htmlspecialchars($_SESSION['last_name']) . '<br/>';
                ?>
            </p>
            <p id='dbheader-role'>
                <?php
                echo htmlspecialchars($_SESSION['user_type']);
                ?>
            </p>
        </div>

        <?php
        // Construct the image path
        $user_image_path = "images/users/" . htmlspecialchars($_SESSION['user_id']) . ".png";
        
        // Check if the image file exists; if not, use a default image
        if (file_exists($user_image_path)) {
            echo "<img src='$user_image_path' id='dbheader-user-icon'/>";
        } else {
            // Fallback image if user-specific image doesn't exist
            echo "<img src='images/users/default.png' id='dbheader-user-icon'/>";
        }
        ?>

        <a href='inc/signout.inc.php'><button>Sign Out</button></a>
    </div>
</header>
