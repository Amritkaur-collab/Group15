<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Group 15" />
    <meta name="description" content="Assign roles, jobs and machines to operators " />
    <title>Operator Tasks - Roles, Jobs, Machines</title>
    <link rel="stylesheet" href="styles/ci.css">

   <!--Assign roles/machines/jobs to specific Production Operators-->

</head>
<body>
        <?php require_once "inc/dbsidebar.inc.php"; ?>
  
        <h1>Assigning of Operator Tasks</h1>
        <form method="POST" action="assign-tasks.php">
        
            <div class="grid-container">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 17%;">JobID</th>
                                <th style="width: 30%;">Description</th>
                                <th style="width: 23%;">Machine</th>
                                <th style="width: 15%;">Role</th>
                                <th style="width: 15%;">Assigned To</th>
                            </tr>
                        </thead>
                        <tbody>
               
                        <?php
                        require_once "inc/dbconn.inc.php";

                        $sql = "SELECT job_id, job_desc, machine, role, assigned_to FROM jobs_assign;";
                        if ($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                          echo "<tr>
                                            <td>" . $row["job_id"] . "</td>
                                            <td>" . $row["job_desc"] . "</td>
                                            <td>" . $row["machine"] . "</td>
                                            <td>" . $row["role"] . "</td>
                                            <td>" . $row["assigned_to"] . "</td>
                                          </tr>"; 
                               
                                
                                }
                            } else {
                                echo "<tr><td>Zero jobs waiting assignment</td></tr>";
                            }    
                        }    
                        //mysqli_free_result($result);
                        //mysqli_close($conn);
                        ?>
                        </tbody>
                    </table>
                  
                </div>
                                    
                                             
           
                <div class="form-container">
                    <h2>Jobs to be Assigned</h2>

                    <label for="job_id">Select a Job ID for assignment tasks:</label>
                    <select id="job-id" name="job_id" required><br><br> 
                        <?php
                            require_once "inc/dbconn.inc.php";
                        
                            $sql = "SELECT job_id FROM jobs_assign;";
                            if ($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {  
                                        echo "<option value=\"" .
                                        $row["job_id"] .
                                        "\" >" .
                                        $row["job_id"] . 
                                        "</option>";                                  
                                    }
                                }
                            }    
                        ?>
                     </select>  
                    
                     <br>
                     <label for="job_desc">Enter a Job Description:</label>
                     <input type="text" name="job_desc" id="job_desc" required>
                    
                     <br>
                     <label for="machines">Assign Machine:</label>
                     <select id="machine_name" name="machine_name" required><br><br> 
                     <option value=""></option>
                        <?php
                            $sql = "SELECT machine_name FROM machines;";
                            if ($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {  
                                        echo "<option value=\"" .
                                        $row["machine_name"] .
                                        "\" >" .
                                        $row["machine_name"] . 
                                        "</option>";                                  
                                    }   
                                }    
                            }
                        ?>
                     </select>
                        
                    <br> 
                    <label for="role">Enter Role:</label>
                    <input type="text" name="role" id="role" required>
                        
                    <br>
                    <label for="operator">Assign Operator:</label>
                    <select id="operator" name="operator" required><br><br> 
                    <option value=""></option>
                    <?php
                        $sql = "SELECT CONCAT(first_name, ' ', last_name) as operator FROM users WHERE user_type ='Production Operator';";
                        if ($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {  
                                    echo "<option value=\"" .
                                    $row["operator"] .
                                    "\" >" .
                                    $row["operator"] . 
                                    "</option>";                                  
                                }   
                                
                            }    
                        }
                        mysqli_free_result($result);
                        mysqli_close($conn);   
                    ?>
                    </select>  
               

                        
                    <button class="submit-button" type="submit">Submit</button>
                </div> 
        </div>

  
        <!-- STEP 1 
            -connect to db 
            -get user details who are production operators 
            -load into drop down list
         --> 

         
        <!-- STEP 2
            -get machine details [machines]
            -load into drop down list
        --> 

        <!-- STEP 3
            -tba]
            -load into drop down list
            require_once "../inc/dbconn.inc.php";
        --> 

        </form>
</body>

<footer>
    @FactoryWorks Co.
</footer>

</html>