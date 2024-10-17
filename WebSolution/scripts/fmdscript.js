let machines = [];
let machineCounter = 1
let jobs = [];

function addOrUpdateMachine() {
    const machineName = document.getElementById("machine-name").value;
    const machineLocation = document.getElementById("machine-location").value;
    const machineDate = document.getElementById("machine-date").value;

    if (!machineName || !machineLocation || !machineDate) {
        alert("Please fill in all fields");
        return;
    }

    const machineId = "M-" + machineCounter++;
    
    const newMachine = {
        id: machineId,
        name: machineName,
        location: machineLocation,
        dateAcquired: machineDate
    };

    machines.push(newMachine);

    updateMachineTable();
    
    document.getElementById("machine-name").value = "";
    document.getElementById("machine-location").value = "";
    document.getElementById("machine-date").value = "";
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
            <td>
                <button onclick="removeMachine('${machine.id}')">Remove</button>
            </td>
        `;

        machineTableBody.appendChild(row);
    });
}

function removeMachine(machineId) {
    machines = machines.filter(machine => machine.id !== machineId);
    updateMachineTable();
}

  function addOrUpdateJob() {
    const jobId = document.getElementById('job-id').value;
    const jobName = document.getElementById('job-name').value;
    const assignedMachine = document.getElementById('assigned-machine').value;
  
    if (!jobId || !jobName || !assignedMachine) {
      alert('Job ID, Name, and Machine assignment are required.');
      return;
    }
  
    const existingJob = jobs.find(job => job.id === jobId);
    if (existingJob) {
      existingJob.name = jobName;
      existingJob.machine = assignedMachine;
    } else {
      jobs.push({ id: jobId, name: jobName, machine: assignedMachine });
    }
  
    refreshJobTable();
  }

  function refreshJobTable() {
    const jobTableBody = document.querySelector('#job-table tbody');
    jobTableBody.innerHTML = ''; 
  
    jobs.forEach(job => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${job.id}</td>
        <td>${job.name}</td>
        <td>${job.machine}</td>
        <td><button onclick="deleteJob('${job.id}')">Delete</button></td>
      `;
      jobTableBody.appendChild(row);
    });
  }

  function deleteMachine(id) {
    machines = machines.filter(machine => machine.id !== id);
    refreshMachineTable();
  }
  
  function deleteJob(id) {
    jobs = jobs.filter(job => job.id !== id);
    refreshJobTable();
  }