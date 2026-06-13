// Load attendance records
function loadAttendance() {
    fetch('api/attendance.php?action=list')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayAttendance(data.records);
            } else {
                showAlert('Error loading attendance records', 'danger');
            }
        })
        .catch(error => console.error('Error:', error));
}

// Display attendance records
function displayAttendance(records) {
    const tbody = document.getElementById('attendanceList');
    tbody.innerHTML = '';

    if (records.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">No attendance records found</td></tr>';
        return;
    }

    records.forEach(record => {
        const checkInTime = new Date(record.check_in_time).toLocaleString();
        const checkOutTime = record.check_out_time ? new Date(record.check_out_time).toLocaleString() : '-';
        const workHours = record.work_hours ? record.work_hours.toFixed(2) + ' hrs' : '-';
        const status = record.check_out_time ? '<span class="badge badge-success">Checked Out</span>' : '<span class="badge badge-warning">Checked In</span>';

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${record.employee_name}</td>
            <td>${record.employee_id}</td>
            <td>${record.punch_id}</td>
            <td>${checkInTime}</td>
            <td>${checkOutTime}</td>
            <td>${workHours}</td>
            <td>${status}</td>
        `;
        tbody.appendChild(row);
    });
}

// Quick check-in
function quickCheckIn() {
    const employeeId = document.getElementById('quickEmployeeId').value;

    if (!employeeId) {
        showAlert('Please enter employee ID', 'warning');
        return;
    }

    const formData = new FormData();
    formData.append('employee_id', employeeId);

    fetch('api/attendance.php?action=check_in', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Check-in recorded successfully!', 'success');
            document.getElementById('quickEmployeeId').value = '';
            loadAttendance();
        } else {
            showAlert(data.message || 'Error recording check-in', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error recording check-in', 'danger');
    });
}

// Quick check-out
function quickCheckOut() {
    const employeeId = document.getElementById('quickEmployeeId').value;

    if (!employeeId) {
        showAlert('Please enter employee ID', 'warning');
        return;
    }

    // First get today's attendance
    fetch(`api/attendance.php?action=today&employee_id=${encodeURIComponent(employeeId)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.record) {
                const attendanceId = data.record.id;

                const formData = new FormData();
                formData.append('attendance_id', attendanceId);

                fetch('api/attendance.php?action=check_out', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(checkoutData => {
                    if (checkoutData.success) {
                        showAlert('Check-out recorded successfully!', 'success');
                        document.getElementById('quickEmployeeId').value = '';
                        loadAttendance();
                    } else {
                        showAlert(checkoutData.message || 'Error recording check-out', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error recording check-out', 'danger');
                });
            } else {
                showAlert('No check-in record found for today', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error retrieving check-in record', 'danger');
        });
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.role = 'alert';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    const container = document.querySelector('.container');
    container.insertBefore(alertDiv, container.firstChild);

    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Load attendance on page load
document.addEventListener('DOMContentLoaded', function() {
    loadAttendance();
});
