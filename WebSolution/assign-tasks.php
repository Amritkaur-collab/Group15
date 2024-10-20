<?php
    if(isset($_POST["job_id"])){
        $job_id = $_POST["job_id"];
        $job_desc = $_POST["job_desc"];
        $machine = $_POST["machine_name"];
        $role = $_POST["role"];
        $operator = $_POST["operator"];

        require_once "inc/dbconn.inc.php";
        
        $sql = "UPDATE jobs_assign 
                SET job_desc=?, machine=?, role=?, assigned_to=?
                WHERE job_id=?;";

        $test_entry = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($test_entry, $sql);
        mysqli_stmt_bind_param($test_entry, 'sssss', $job_desc, $machine, $role, $operator, $job_id);

        if(mysqli_stmt_execute($test_entry)){
            header("location: prod-operator-tasks.php");
        }else{
            echo mysqli_errno($conn);
        }        
        
    mysqli_close($conn);  
    }

?>