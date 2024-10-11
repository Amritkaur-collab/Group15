<?php
// Checks if the user has a valid session and redirects them to login if not.
// Should be placed in the header of every page (except pages where we do not expect a session to exist. Eg. login.php)
session_start();
if(!isset($_SESSION['exists']))
{
    session_unset();
    session_destroy();
    header('Location: login.php');
}
?>