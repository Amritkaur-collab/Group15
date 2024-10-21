<div id = 'dbsidebar'>
    <style>
        button {
            cursor: pointer;
        }
    </style>

        
<div id='dbsidebar'>
    <a href="home.php"><button id='dbsidebar-home' class='sidebar-button'></button></a><br />

    <?php require_once "auth/permissioncheck.php";

    if(requireRoleBtn(role: array('Administrator')))
    {
        echo "<a href='admin-homepage.php'><button id = 'dbsidebar-admin' class = 'sidebar-button'></button></a><br/>";
    }
    if (requireRoleBtn(array('Auditor'))) {
        echo "<a href='search.php'><button id = 'dbsidebar-search' class = 'sidebar-button'></button></a><br/>";
    }
    if (requireRoleBtn(array('Factory Manager'))) {
        echo "<a href='prod-operator-tasks.php'><button id = 'dbsidebar-assign-jobs' class = 'sidebar-button'></button></a><br/>";
    }
    if (requireRoleBtn(array('Factory Manager'))) {
        echo "<a href='Add-Update-Remove-Machines.php'><button id = 'dbsidebar-manage-machines' class = 'sidebar-button'></button></a><br/>";
    }
    if (requireRoleBtn(array('Factory Manager'))) {
        echo "<a href='Add-Update-Remove-Jobs.php'><button id = 'dbsidebar-manage-jobs' class = 'sidebar-button'></button></a><br/>";
    }
    ?>

</div>
<script src='./scripts/sidebar.js'></script>