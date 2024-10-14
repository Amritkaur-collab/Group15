<div id = 'dbsidebar'>
    <a href="home.php"><button id = 'dbsidebar-home'><span class = 'sidebar-button'></button></a><br/>
    <?php require_once "auth/permissioncheck.php";
        if(requireRoleBtn(array('Administrator', 'Auditor', 'Factory Manager')))
        {
            echo "<a href='search.php'><button id = 'dbsidebar-search' class = 'sidebar-button'></button></a><br/>";
        }
    ?>
</div>
<script src='./scripts/sidebar.js'></script>