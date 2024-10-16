<?php
// Reused from the practicals for testing purposes.

define("DB_HOST", "localhost");
define("DB_NAME", "Websolution");
define("DB_USER", "root");
define("DB_PASS", "");

$conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    // Something went wrong...
    echo "Error: Unable to connect to database.<br>";
    echo "Debugging errno: " . mysqli_connect_errno() . "<br>";
    echo "Debugging error: " . mysqli_connect_error() . "<br>";
    exit;
}
