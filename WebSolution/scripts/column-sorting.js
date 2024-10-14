function sortTable(n, isDateColumn = false) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    // n = 0 for "waiting to be assigned", 1 for "in progress", 2 for "complete"
    let tableName = "sortedTable" + n.toString();
    table = document.getElementById(tableName);
    switching = true;
    dir = "asc"; 
  
    while (switching) {
      switching = false;
      rows = table.rows;
  
      for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
  
        if (isDateColumn) {
          // Convert the string to Date objects
          let dateX = new Date(x.innerHTML);
          let dateY = new Date(y.innerHTML);
  
          if (dir === "asc") {
            if (dateX.getTime() > dateY.getTime()) {
              shouldSwitch = true;
              break;
            }
          } else if (dir === "desc") {
            if (dateX.getTime() < dateY.getTime()) {
              shouldSwitch = true;
              break;
            }
          }
        } else {
          // Regular string comparison
          if (dir === "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              shouldSwitch = true;
              break;
            }
          } else if (dir === "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              shouldSwitch = true;
              break;
            }
          }
        }
      }
  
      if (shouldSwitch) {
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        switchcount++;
      } else {
        if (switchcount === 0 && dir === "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
  }
  