<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Smart Manufacturing Dashboard: Advanced Search</title>
    <meta name="author" content="Group 15" />
    <link rel="stylesheet" href="styles/commonelements.css" />
    <link rel="stylesheet" href="styles/search.css" />
    <?php require_once "auth/sessioncheck.php"; ?>
    <?php require_once "auth/permissioncheck.php";
    requireRole(array('Auditor'));
    ?>
</head>

<body>
    <?php require_once "inc/dbheader.inc.php"; ?>
    <?php require_once "inc/dbsidebar.inc.php"; ?>

    <?php require_once "inc/dateselect.inc.php"; ?>

    <div id="pagetitle">
        <h1>Advanced Search</h1>
    </div>

    <div id="db-content">
        <div id='searchpage'>

            <div id="filters">
                <?php
                $timefrom = "";
                if (isset($_POST["timefrom"])) $timefrom = $_POST["timefrom"];
                $timeto = "";
                if (isset($_POST["timeto"])) $timeto = $_POST["timeto"];
                $errorcode = "";
                if (isset($_POST["error-code"])) $errorcode = $_POST["error-code"];
                $status = "";
                if (isset($_POST["operational-status"])) $status = $_POST["operational-status"];
                ?>
                <form action="" method="POST">
                    <h2>Filters</h2>

                    <div id='search-filter-dts'>
                        <h3>Date & Time</h3>
                        <div class='search-filter'>
                            <label for='timefrom'>From:</label>
                            <input id='timefrom' type="text" name="timefrom" required value="<?php echo $timefrom; ?>">
                            <button class="timefrom-open" type="button" onclick="buttonDTS('timefrom')">O</button>
                            </input>
                        </div>


                        <div class='search-filter'>

                            <label for='timeto'>To:</label>
                            <input id="timeto" type="text" name="timeto" required value="<?php echo $timeto; ?>">
                            <button class="timeto-open" type="button" onclick="buttonDTS('timeto')">O</button>
                            </input>

                        </div>

                    </div>
                    <br />

                    <div id='search-filter-misc'>

                        <div class='search-filter'>
                            <label for="error-code">Error:</label>
                            <div class="search-filter-input">
                                <input id="error-code" type="text" name="error-code" value="<?php echo $errorcode; ?>" />
                            </div>
                        </div>

                        <div class='search-filter'>
                            <label for="operational-status">Status:</label>
                            <div class="search-filter-input">
                                <input id="operational-status" type="text" name="operational-status" value="<?php echo $status; ?>" />

                            </div>

                        </div>
                    </div>
                    <br />

                    <div id='search-filter-machines'>
                        <h3 id=>Machines</h3>




                        <?php
                        require_once "search/machines.search.php";
                        ?>
                    </div>


                    <input id="submit" type="submit" value="Apply">
                </form>
            </div>

            <div id="results-table">
                <table>
                    <tr id="tb-header">
                        <th>Timestamp</th>
                        <th>Machine</th>
                        <th>Temperature</th>
                        <th>Pressure</th>
                        <th>Vibration</th>
                        <th>Humidity</th>
                        <th>Power Consumption</th>
                        <th>Operational Status</th>
                        <th>Error Code</th>
                        <th>Production Count</th>
                        <th>Maintenance Log</th>
                        <th>Speed</th>
                    </tr>
                    <?php require_once "search/results.search.php"; ?>
                </table>
            </div>
        </div>
    </div>
    <?php require_once "inc/footer.inc.php"; ?>
</body>

</html>