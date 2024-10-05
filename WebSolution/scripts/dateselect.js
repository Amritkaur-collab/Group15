/*
    Date/Time Select Window Instructions
    1. Insert " <?php require_once "inc/dateselect.inc.php"; ?> " in html document
    2. Create a button with its 'onclick' as buttonDTS() with the parameter set to 
       the id of the text input you want it to return a value to.
       eg.  
       <input id = 'dt-input' type = 'text'/>
       <button type = 'button' onclick = buttonDTS('dt-input')/>
*/

const dtswindow = document.getElementById("dtswindow");
const hourInput = document.getElementById("hour");
const minuteInput = document.getElementById("minutes");

const month = ["January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
const day = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
const date = new Date();

var curr_month;
var curr_year;
var isOpen;
var output;

const ym_label = document.getElementById("ym-label");
const days_table = document.getElementById("days-table");

init();

function init()
{
    closeDTS();
    date.setHours(0,0,0,0);
    getCurrentDate();
    ym_label.textContent = month[curr_month]+" "+curr_year;
    createDays();
}

//Handles the opening and closing of the date/time select window, also sets the output location to the set element id (this must be text input)
function buttonDTS(textInputId)
{
    output = document.getElementById(textInputId);

    if(isOpen)
    {
        closeDTS();
    }
    else
    {
        openDTS();
    }
}

function openDTS()
{
    dtswindow.style.display = 'block';
    isOpen = true;
}
function closeDTS()
{
    dtswindow.style.display = 'none';
    isOpen = false;
}
function setDT() // Set button
{
    output.value = (date.getFullYear() +"/"+ (date.getMonth()+1) +"/"+ date.getDate() + " " + hourInput.value + ":" + minuteInput.value);
    closeDTS();
}

function getCurrentDate()
{
    curr_year = date.getFullYear();
    curr_month = date.getMonth();
}

// Could combine the functions for the month change buttons, but seperating them feels better for readability and abstraction purposes
function getPreviousMonth() // Previous Month Button
{
    date.setMonth(date.getMonth()-1, 1);
    curr_year = date.getFullYear();
    curr_month = date.getMonth();
    ym_label.textContent = month[curr_month]+" "+curr_year;

    clearDays();
    createDays();
}
function getNextMonth() // Next Month Button
{
    date.setMonth(date.getMonth()+1, 1);
    curr_year = date.getFullYear();
    curr_month = date.getMonth();
    ym_label.textContent = month[curr_month]+" "+curr_year;

    clearDays();
    createDays();
}

function dayButton() // Date selection button
{
    date.setDate(this.value);
}

function createDays() //Sets up the days for the currently selected month
{
    var days = new Date(curr_year, curr_month+1, 0).getDate();

    var rowCount = 0;
    var lastDay;
    row = days_table.getElementsByTagName('tbody')[0].insertRow(rowCount);
    for(let i = 1; i <= days; i++)
    {
        var currentDay = new Date(curr_year, curr_month, i).getDay();

        // Fills out the start of the week with days from the previous month
        if(i == 1 && day[currentDay] != "Sun")
        {
            for(let j = 0; j < currentDay; j++)
            {
                var cell = row.insertCell(j);
                var currentDate = new Date(curr_year, curr_month, 0-j).getDate();
                cell.value = currentDate;
                cell.textContent = currentDate;
            }
        }

        var cell = row.insertCell(currentDay);
        var button = document.createElement("button");
        button.onclick = dayButton;
        button.value = i;
        button.textContent = i;

        cell.appendChild(button);

        // Begins a new row if it is the end of the week
        if(day[currentDay] == "Sat")
        {
            rowCount++;
            row = days_table.getElementsByTagName('tbody')[0].insertRow(rowCount);
        } 

        lastDay = currentDay;
    }

    // Fills out the end of the week with days from the next month
    if(day[lastDay] != "SAT")
        {
            for(let j = lastDay+1; j < 7; j++)
            {
                var cell = row.insertCell(j);
                var currentDate = new Date(curr_year, curr_month, j).getDate();
                cell.value = currentDate;
                cell.textContent = currentDate;
            }
        }

}
function clearDays() // Deletes all non-header rows in the 'days-table' element
{
    while(days_table.getElementsByTagName('tbody')[0].rows.length > 0)
        {
            days_table.getElementsByTagName('tbody')[0].deleteRow(0);
        }
}
