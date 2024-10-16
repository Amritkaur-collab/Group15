<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Group 15" />
    <meta name="description" content="Assign roles, jobs and machines to operators " />
    <title>Operator Tasks - Roles, Jobs, Machines</title>
    <link rel="stylesheet" href="ci.css">

   <!--Assign roles/machines/jobs to specific Production Operators-->

</head>
<body>
        <?php require_once "dbsidebar.inc.php"; ?>
  
        <h1>Operator Tasks-Jobs, Roles, Machines</h1>

        <h2>Jobs to be Assigned</h2>
        <div class="container">
            <div class="grid-container">
                <div class="table-container">
                    <table>
                        <tr>
                            <th>JobID</th>
                            <th>Machine</th>
                            <th>Description</th>
                            <th>Assigned To</th>
                        </tr>
                        <!--TESTING PURPOSES HARD CODING JOBS IN GRID-->
                        <tr>
                            <td>TestJob01</td>
                            <td>TestMachine01</td>
                            <td>TestDescription01</td>
                            <td>
                                <select>
                                    <option value="Operator 1">Operator 1</option>
                                    <option value="Operator 2">Operator 2</option>
                                    <option value="Operator 3">Operator 3</option>
                                    <option value="Operator 4">Operator 4</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>TestJob02</td>
                            <td>TestMachine02</td>
                            <td>TestDescription02</td>
                            <td>
                                <select>
                                    <option value="Operator 1">Operator 1</option>
                                    <option value="Operator 2">Operator 2</option>
                                    <option value="Operator 3">Operator 3</option>
                                    <option value="Operator 4">Operator 4</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>TestJob03</td>
                            <td>TestMachine03</td>
                            <td>TestDescription03</td>
                            <td>
                                <select>
                                    <option value="Operator 1">Operator 1</option>
                                    <option value="Operator 2">Operator 2</option>
                                    <option value="Operator 3">Operator 3</option>
                                    <option value="Operator 4">Operator 4</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>TestJob04</td>
                            <td>TestMachine04</td>
                            <td>TestDescription04</td>
                            <td>
                                <select>
                                    <option value="Operator 1">Operator 1</option>
                                    <option value="Operator 2">Operator 2</option>
                                    <option value="Operator 3">Operator 3</option>
                                    <option value="Operator 4">Operator 4</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <button class="submit-button" type="submit">Update</button>
                </div>
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

        <?php
            //require_once "../inc/dbconn.inc.php";

        /* $sql = "SELECT name FROM users WHERE user_type = Operator;";
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    echo "<ul>";
                        while ($row = mysqli_fetch_assoc($result)){
                            echo "<li><p>" . $row["name"] . "</p></li>";
                        }
                    echo "</ul>";

                    mysqli_free_result($result);
                }
            }


            mysqli_close($conn); */
                

        ?>



    
</body>
<footer>
    @FactorieWorks Co.
</footer>
</html>