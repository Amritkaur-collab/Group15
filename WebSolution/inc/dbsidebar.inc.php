<div id = 'dbsidebar'>
    <a href="home.php"><button id = 'dbsidebar-home'><span class = 'sidebar-button'></button></a><br/>
    <?php require_once "auth/permissioncheck.php";
        if(requireRoleBtn(array('Administrator', 'Auditor', 'Factory Manager')))
        {
            echo "<a href='search.php'><button id = 'dbsidebar-search' class = 'sidebar-button'></button></a><br/>";
        }
        if(requireRoleBtn(array('Production Operator')))
        {
            echo "<a href='updatemachine.php'><button id = 'dbsidebar-updatemachine' class = 'sidebar-button'></button></a><br/>";
            echo "<a href='updatejobs.php'><button id = 'dbsidebar-updatejobs' class = 'sidebar-button'></button></a><br/>";
            echo "<a href='tasknotes.php'><button id = 'dbsidebar-tasknotes' class = 'sidebar-button'></button></a><br/>";
            echo "<a><button id = 'dbsidebar-print' class = 'sidebar-button'></button></a><br/>";
            echo "<a><button id = 'dbsidebar-settings' class = 'sidebar-button'></button></a><br/>";
        }
    ?>
</div>
<script src='./scripts/sidebar.js'></script>