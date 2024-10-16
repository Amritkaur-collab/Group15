<div id = 'dbsidebar'>
    <style>
        button {
            cursor: pointer;
        }
    </style>
    <a href="home.php"><button id = 'dbsidebar-home'><span class = 'sidebar-button'></button></a><br/>
    <?php require_once "auth/permissioncheck.php";
        if(requireRoleBtn(role: array('Administrator', 'Auditor', 'Factory Manager')))
        {
            echo "<a href='search.php'><button id = 'dbsidebar-search' class = 'sidebar-button'></button></a><br/>";
        }
        if(requireRoleBtn(role: array('Administrator')))
        {
            echo "<a href='admin-homepage.php'><button id = 'dbsidebar-admin' class = 'sidebar-button'></button></a><br/>";
        }
    ?>
</div>
<script src='./scripts/sidebar.js'></script>