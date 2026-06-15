// Load employees data
function loadEmployees(page = 1) {
    fetch('../../public/api/employees.php?action=list&page=' + page)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayEmployees(data.employees);
                displayPagination(data.currentPage, data.totalPages);
            } else {
                showAlert('Error loading employees', 'danger');
            }
        })
        .catch(error => console.error('Error:', error));
}

// Display employees in table
function displayEmployees(employees) {
    const tbody = document.getElementById('employeesList');
    tbody.innerHTML = '';

    if (employees.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" class="text-center">No employees found</td></tr>';
        return;
    }

    employees.forEach(emp => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${emp.employee_id}</td>
            <td><strong>${emp.employee_name}</strong></td>
            <td>${emp.punch_id}</td>
            <td>${emp.iqama_id}</td>
            <td>${emp.nationality}</td>
            <td class="editable-cell" onclick="editField(this, ${emp.id}, 'department')">${emp.department || '-'}</td>
            <td class="editable-cell" onclick="editField(this, ${emp.id}, 'position')">${emp.position || '-'}</td>
            <td class="editable-cell" onclick="editField(this, ${emp.id}, 'email')">${emp.email || '-'}</td>
            <td class="editable-cell" onclick="editField(this, ${emp.id}, 'phone')">${emp.phone || '-'}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn btn-sm btn-warning" onclick="openEditModal(${emp.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteEmployee(${emp.id})">Delete</button>
                    <button class="btn btn-sm btn-info" onclick="viewAttendance(${emp.id})">View</button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Display pagination
function displayPagination(currentPage, totalPages) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';

    if (totalPages <= 1) return;

    // Previous button
    if (currentPage > 1) {
        const prev = document.createElement('li');
        prev.className = 'page-item';
        prev.innerHTML = `<a class="page-link" href="#" onclick="loadEmployees(${currentPage - 1}); return false;">Previous</a>`;
        pagination.appendChild(prev);
    }

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement('li');
        li.className = i === currentPage ? 'page-item active' : 'page-item';
        li.innerHTML = `<a class="page-link" href="#" onclick="loadEmployees(${i}); return false;">${i}</a>`;
        pagination.appendChild(li);
    }

    // Next button
    if (currentPage < totalPages) {
        const next = document.createElement('li');
        next.className = 'page-item';
        next.innerHTML = `<a class="page-link" href="#" onclick="loadEmployees(${currentPage + 1}); return false;">Next</a>`;
        pagination.appendChild(next);
    }
}

// Add new employee
function addEmployee() {
    const formData = new FormData(document.getElementById('addEmployeeForm'));
    
    fetch('../../public/api/employees.php?action=create', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Employee added successfully!', 'success');
            document.getElementById('addEmployeeForm').reset();
            document.querySelector('[data-bs-dismiss="modal"]').click();
            loadEmployees();
            bootstrap.Modal.getInstance(document.getElementById('addEmployeeModal')).hide();
        } else {
            showAlert(data.message || 'Error adding employee', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error adding employee', 'danger');
    });
}

// Open edit modal
function openEditModal(id) {
    fetch(`../../public/api/employees.php?action=show&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const emp = data.employee;
                document.getElementById('edit_id').value = emp.id;
                document.getElementById('edit_employee_id').value = emp.employee_id;
                document.getElementById('edit_punch_id').value = emp.punch_id;
                document.getElementById('edit_employee_name').value = emp.employee_name;
                document.getElementById('edit_iqama_id').value = emp.iqama_id;
                document.getElementById('edit_nationality').value = emp.nationality;
                document.getElementById('edit_email').value = emp.email || '';
                document.getElementById('edit_phone').value = emp.phone || '';
                document.getElementById('edit_department').value = emp.department || '';
                document.getElementById('edit_position').value = emp.position || '';
                document.getElementById('edit_hire_date').value = emp.hire_date || '';
                document.getElementById('edit_salary').value = emp.salary || '';

                const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('editEmployeeModal'));
                modal.show();
            } else {
                showAlert(data.message || 'Error fetching employee details', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error fetching employee details', 'danger');
        });
}

// Update employee
function updateEmployee() {
    const formData = new FormData(document.getElementById('editEmployeeForm'));

    fetch('../../public/api/employees.php?action=update', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Employee updated successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('editEmployeeModal')).hide();
            loadEmployees();
        } else {
            showAlert(data.message || 'Error updating employee', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error updating employee', 'danger');
    });
}

// Delete employee (soft delete)
function deleteEmployee(id) {
    if (confirm('Are you sure you want to delete this employee?')) {
        const formData = new FormData();
        formData.append('id', id);

        fetch('../../public/api/employees.php?action=delete', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('Employee deleted successfully!', 'success');
                const currentPage = document.querySelector('.page-item.active .page-link')?.textContent || 1;
                loadEmployees(currentPage);
            } else {
                showAlert('SQL Error: ' + (data.message || 'Check console for details'), 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error deleting employee', 'danger');
        });
    }
}

// Edit field inline
function editField(cell, empId, field) {
    const currentValue = cell.textContent.trim();
    const input = document.createElement('input');
    input.type = 'text';
    input.className = 'form-control form-control-sm';
    input.value = currentValue === '-' ? '' : currentValue;

    cell.innerHTML = '';
    cell.appendChild(input);
    input.focus();

    function saveChange() {
        const newValue = input.value;
        const formData = new FormData();
        formData.append('id', empId);
        formData.append(field, newValue);

        fetch('../../public/api/employees.php?action=update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cell.textContent = newValue || '-';
                showAlert('Field updated!', 'success');
            } else {
                cell.textContent = currentValue;
                showAlert('Error updating field', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            cell.textContent = currentValue;
            showAlert('Error updating field', 'danger');
        });
    }

    input.addEventListener('blur', saveChange);
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') saveChange();
        if (e.key === 'Escape') {
            cell.textContent = currentValue;
        }
    });
}

// View attendance
function viewAttendance(id) {
    // This will redirect to attendance page with employee filter
    window.location.href = `attendance.php?employee_id=${id}`;
}

// Search employees
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('keyup', function() {
        const keyword = this.value;
        if (keyword.length > 0) {
            fetch(`../../public/api/employees.php?action=search&q=${encodeURIComponent(keyword)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayEmployees(data.employees);
                        document.getElementById('pagination').innerHTML = '';
                    } else {
                        showAlert('Error searching employees', 'danger');
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            loadEmployees();
        }
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

// Load employees on page load
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('employeesList')) {
        loadEmployees();
    }
});
