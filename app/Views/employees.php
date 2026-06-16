<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row mb-4 align-items-end">
        <div class="col-md-8">
            <h2 class="fw-bold tracking-tight">Employees</h2>
            <p class="text-muted">Manage your workforce and view detailed records.</p>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                <i class="bi bi-plus-lg"></i> Add Employee
            </button>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-12">
            <input type="text" id="searchInput" class="form-control shadow-sm" placeholder="Search for anything...">
        </div>
    </div>

    <!-- Employees Table -->
    <div class="card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="employeesTable">
                <thead>
                    <tr>

                        <th>Name</th>
                        <th>Punch ID</th>
                        <th>Iqama ID</th>
                        <th>Nationality</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="employeesList">
                    
                </tbody>
            </table>
        </div>
    </div>

    <nav aria-label="Page navigation" id="paginationContainer">
        <ul class="pagination" id="pagination">
        
        </ul>
    </nav>
</div>

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addEmployeeForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="employee_id" class="form-label">Employee ID</label>
                            <input type="text" class="form-control" id="employee_id" name="employee_id" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="punch_id" class="form-label">Punch ID</label>
                            <input type="text" class="form-control" id="punch_id" name="punch_id" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="employee_name" class="form-label">Employee Name</label>
                            <input type="text" class="form-control" id="employee_name" name="employee_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="iqama_id" class="form-label">Iqama ID</label>
                            <input type="text" class="form-control" id="iqama_id" name="iqama_id" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" class="form-control" id="nationality" name="nationality" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="department" name="department">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hire_date" class="form-label">Hire Date</label>
                            <input type="date" class="form-control" id="hire_date" name="hire_date">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="number" class="form-control" id="salary" name="salary" step="0.01">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addEmployee()">Add Employee</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Employee Modal (Inline) -->




<?php include 'footer.php'; ?>
