let jobs = [];
let editJobMode = false; // Track if we're in edit mode for jobs
let currentEditJobIndex = null; // Store the index of the job being edited

function fetchJobs() {
    fetch('fetch_jobs.php') // Ensure you create this PHP script to fetch jobs
        .then(response => response.json())
        .then(data => {
            jobs = data; // Set the jobs array to the fetched data
            updateJobTable(); // Update the displayed table
        })
        .catch(error => console.error('Error fetching jobs:', error));
}

function fetchMachines() {
    fetch('fetch_machines.php') // Make sure this PHP file exists and returns the correct JSON data
        .then(response => response.json())
        .then(data => {
            // Handle the fetched machines data here
            console.log(data);
        })
        .catch(error => console.error('Error fetching machines:', error));
}

function addJob() {
    const jobName = document.getElementById("job-name").value;
    const jobDuration = document.getElementById("job-duration").value;
    const machineName = document.getElementById("machine-select").value; // Use machine_name

    if (!jobName || !jobDuration || !machineName) {
        alert("Please provide job name, duration, and assigned machine.");
        return;
    }

    const jobData = {
        job_name: jobName,
        job_duration: jobDuration,
        machine_name: machineName // Send machine_name
    };

    if (editJobMode) {
        // Update existing job
        const jobId = jobs[currentEditJobIndex].job_id; // Get the job ID of the current job being edited
        fetch('edit_job.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ job_id: jobId, ...jobData }), // Include job ID in the request
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log(`Updated job: ${JSON.stringify(jobData)}`);
                fetchJobs(); // Refresh the job list
            } else {
                console.error('Error updating job:', data.message);
            }
            resetJobForm(); // Reset the form after editing
        })
        .catch(error => console.error('Fetch error:', error));
    } else {
        // Add new job
        fetch('add_job.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(jobData),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log(`Added job: ${JSON.stringify(jobData)}`);
                fetchJobs(); // Refresh the job list
            } else {
                console.error('Error adding job:', data.message);
            }
        })
        .catch(error => console.error('Fetch error:', error));
    }

    resetJobForm();
}

function updateJobTable() {
    const jobTableBody = document.getElementById("job-table").querySelector("tbody");
    jobTableBody.innerHTML = ""; // Clear the table

    jobs.forEach((job) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${job.job_id}</td>
            <td>${job.job_name}</td>
            <td>${job.assigned_machine}</td>
            <td>
                <button onclick="editJob(${job.job_id})">Edit</button>
                <button onclick="removeJob(${job.job_id})">Remove</button>
            </td>
        `;

        jobTableBody.appendChild(row);
    });
}

function editJob(jobId) {
    const job = jobs.find(j => j.job_id === jobId);
    if (job) {
        document.getElementById("job-name").value = job.job_name;
        document.getElementById("job-duration").value = job.job_duration;
        document.getElementById("machine-select").value = job.machine_id; // Update machine select

        editJobMode = true; // Set edit mode
        currentEditJobIndex = jobs.findIndex(j => j.job_id === jobId); // Store the index of the job being edited
    }
}

function removeJob(jobId) {
    const confirmed = confirm(`Are you sure you want to remove job ID ${jobId}?`);
    if (confirmed) {
        fetch('remove_job.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ job_id: jobId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                jobs = jobs.filter(job => job.job_id !== jobId); // Remove from local jobs array
                updateJobTable(); // Update the displayed table
                console.log(`Removed job ID: ${jobId}`);
            } else {
                console.error('Error removing job:', data.message);
            }
        });
    }
}

function resetJobForm() {
    document.getElementById("job-name").value = "";
    document.getElementById("job-duration").value = "";
    document.getElementById("machine-select").value = ""; // Reset machine selection
    editJobMode = false; // Reset edit mode
    currentEditJobIndex = null; // Reset current edit index
}

// Call fetchJobs to load data when the page loads
window.onload = function() {
    fetchMachines(); // Load machines for machine dropdown
    fetchJobs(); // Load jobs for the jobs table
};