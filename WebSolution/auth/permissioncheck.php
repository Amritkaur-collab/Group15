<?php

function requireRoleBtn($role)
{
    foreach($role as &$val)
    {
        if ($_SESSION['user_type'] == $val) return true;
    }
    return false;
}

function requireRole($role)
{
    foreach($role as &$val)
    {
        if ($_SESSION['user_type'] == $val) return;
    }

    error_log(['User - '.$_SESSION['user_id']].' does not have permission to access this.');
    header('Location: auth/invalidpermission.php');
}
?>