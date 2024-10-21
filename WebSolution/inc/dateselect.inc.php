<div id="dtswindow">
    <div id = "dts-header">
        <button id = "close" type ="button" onclick="closeDTS()">X</button>
        <p id = "ym-label"></p>
        <button id = "prev" type ="button" onclick="getPreviousMonth()"><</button>
        <button id = "next" type ="button" onclick="getNextMonth()">></button>
    </div>

    <table id = "days-table">
        <thead>
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>
        </thead>
        <tbody>
        </tbody>

    </table>

    <!-- 'return false' stops the form submit from reloading the page -->
    <form onsubmit="setDT(); return false">
    <div id = "time-input">
        <label for = "hour">Time:</label>
        <input id = "hour" type="number" min="0" max="23" required></input> :
        <select id = "minutes">
            <option value = "00">00</option>
            <option value = "30">30</option>
        </select>
    </div>

    <input id = "set" type ="submit" value="Set"></button>
    </form>

</div>
<script src="scripts/dateselect.js"></script>