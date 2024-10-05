<?php
            require_once "inc/dbconn.inc.php";

            $sql = "SELECT * FROM Machines";

            if($result = mysqli_query($conn, $sql))
            {   
                if($rowcount=mysqli_num_rows($result) >= 1)
                {
                    echo "<ul id = \"machine-list\">";
                    $count = 0;
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo "<li>$row[machine_name] <input id = \"machine$count\" type=\"checkbox\" name = \"machine[$count]\" value = \"$row[machine_name]\"";
                        if(isset($_POST["machine"]))
                        {
                            foreach($_POST["machine"] as &$value)
                            {
                                if($value == $row["machine_name"]) 
                                {
                                    echo " checked = true";
                                }
                            }
                            
                        }
                        echo "></li>";

                        $count++;
                    }
                    echo "</ul>";
                    mysqli_free_result($result);
                }
            }
        ?>