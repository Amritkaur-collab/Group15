let machines = [];
let machineCounter = 1;
let editMode = false; // New variable to track edit mode
let currentEditId = null; // Store the ID of the machine being edited

function addMachine() {
    const machineName = document.getElementById("machine-name").value;
    const machineLocation = document.getElementById("machine-location").value;
    const machineDate = document.getElementById("machine-date").value;
    const machineSerial = document.getElementById("machine-serial").value;

    if (!machineName || !machineLocation || !machineDate || !machineSerial) {
        alert("Please fill in all fields");
        return;
    }

    if (editMode) {
        // Update existing machine
        const machineIndex = machines.findIndex(machine => machine.id === currentEditId);
        if (machineIndex !== -1) {
            machines[machineIndex] = {
                id: currentEditId,
                name: machineName,
                location: machineLocation,
                dateAcquired: machineDate,
                serialNumber: machineSerial
            };
            console.log(`Updated machine: ${JSON.stringify(machines[machineIndex])}`);
        }
        editMode = false; // Reset edit mode
        currentEditId = null; // Reset current edit ID
    } else {
        // Add new machine
        const machineId = "M-" + machineCounter++;
        const newMachine = {
            id: machineId,
            name: machineName,
            location: machineLocation,
            dateAcquired: machineDate,
            serialNumber: machineSerial
        };
        machines.push(newMachine);
        console.log(`Added machine: ${JSON.stringify(newMachine)}`);
    }

    updateMachineTable();
    resetForm();
}

function updateMachineTable() {
    const machineTableBody = document.getElementById("machine-table").querySelector("tbody");
    machineTableBody.innerHTML = ""; // Clear the table

    machines.forEach(machine => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${machine.id}</td>
            <td>${machine.name}</td>
            <td>${machine.location}</td>
            <td>${machine.dateAcquired}</td>
            <td>${machine.serialNumber}</td>
            <td>
                <button onclick="editMachine('${machine.id}')">Edit</button>
                <button onclick="removeMachine('${machine.id}')">Remove</button>
            </td>
        `;

        machineTableBody.appendChild(row);
    });
}

function editMachine(machineId) {
    const machine = machines.find(m => m.id === machineId);
    if (machine) {
        document.getElementById("machine-name").value = machine.name;
        document.getElementById("machine-location").value = machine.location;
        document.getElementById("machine-date").value = machine.dateAcquired;
        document.getElementById("machine-serial").value = machine.serialNumber;

        editMode = true; // Set edit mode
        currentEditId = machineId; // Store the ID of the machine being edited
    }
}

function removeMachine(machineId) {
    machines = machines.filter(machine => machine.id !== machineId);
    console.log(`Removed machine with ID: ${machineId}`);
    updateMachineTable();
}

function resetForm() {
    document.getElementById("machine-name").value = "";
    document.getElementById("machine-location").value = "";
    document.getElementById("machine-date").value = "";
    document.getElementById("machine-serial").value = "";
}