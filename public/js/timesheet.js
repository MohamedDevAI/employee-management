document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('timesheetList')) {
        loadTimesheet();
    }
});

function loadTimesheet() {
    const month = document.getElementById('timesheetMonth').value;
    const tbody = document.getElementById('timesheetList');
    
    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></td></tr>';

    // Note: You will need to implement the 'timesheet' action in public/api/attendance.php
    fetch(`../../public/api/attendance.php?action=timesheet&month=${month}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayTimesheet(data.records);
            } else {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-danger">${data.message || 'Error loading records'}</td></tr>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-danger">Failed to connect to API</td></tr>';
        });
}

function displayTimesheet(records) {
    const tbody = document.getElementById('timesheetList');
    tbody.innerHTML = '';

    if (!records || records.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">No attendance records found for this period</td></tr>';
        return;
    }

    records.forEach(row => {
        const hours = parseFloat(row.total_hours || 0);
        const days = parseInt(row.total_days || 0);
        const avg = days > 0 ? (hours / days).toFixed(2) : 0;
        
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${row.employee_id}</td>
            <td><span class="fw-bold text-main">${row.employee_name}</span></td>
            <td><span class="badge bg-secondary">${row.department || 'General'}</span></td>
            <td>${days}</td>
            <td><span class="text-primary fw-bold">${hours.toFixed(2)} hrs</span></td>
            <td>${avg} hrs</td>
            <td>
                <span class="badge ${hours >= 160 ? 'bg-success' : 'bg-warning'}">
                    ${hours >= 160 ? 'Completed' : 'Pending'}
                </span>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function exportTimesheet() {
    const month = document.getElementById('timesheetMonth').value;
    window.location.href = `../../public/api/attendance.php?action=export&month=${month}`;
}