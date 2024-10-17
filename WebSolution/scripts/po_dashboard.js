document.addEventListener('DOMContentLoaded', function() {
    // File path on the server
    const filePath = 'http://localhost/websoln/Group15/WebSolution/factory_logs.csv'; // This is the relative path from where the file is served

    // Fetch the CSV file
    fetch(filePath)
        .then(response => response.text())
        .then(data => {
            processCSV(data);
        })
        .catch(error => console.error('Error fetching the CSV file:', error));
});

function processCSV(data) {
    const rows = data.split('\n').slice(1); // Ignore the header
    let temperatureSum = 0;
    let pressureSum = 0;
    let totalProduction = 0;
    let operationalCount = 0;
    const tableBody = document.querySelector('#table-body');
    tableBody.innerHTML = ''; // Clear previous data

    rows.forEach(row => {
        const columns = row.split(',');
        if (columns.length === 5) {
            const timestamp = columns[0];
            const temperature = parseFloat(columns[1]);
            const pressure = parseFloat(columns[2]);
            const productionCount = parseInt(columns[3]);
            const operationalStatus = columns[4].trim();

            // Update metrics
            temperatureSum += temperature;
            pressureSum += pressure;
            totalProduction += productionCount;
            if (operationalStatus === 'active') operationalCount++;

            // Append data to table
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${timestamp}</td>
                <td>${temperature}</td>
                <td>${pressure}</td>
                <td>${productionCount}</td>
                <td>${operationalStatus}</td>
            `;
            tableBody.appendChild(newRow);
        }
    });

    // Calculate averages
    const averageTemperature = temperatureSum / rows.length;
    const averagePressure = pressureSum / rows.length;

    // Display metrics
    document.getElementById('avg-temperature').querySelector('span').textContent = averageTemperature.toFixed(2);
    document.getElementById('avg-pressure').querySelector('span').textContent = averagePressure.toFixed(2);
    document.getElementById('total-production').querySelector('span').textContent = totalProduction;
    document.getElementById('operational-status').querySelector('span').textContent = operationalCount;
}
