<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Attendance Tracking</h2>
        </div>
    </div>

    <!-- Employee Info (Visible when viewing specific employee) -->
    <div id="employeeInfoContainer" style="display: none;" class="mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary">Employee Record: <span id="info_name_title"></span></h5>
                <a href="attendance.php" class="btn btn-sm btn-outline-secondary">View All Logs</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="text-muted d-block small text-uppercase">Public ID</label>
                        <span id="info_id" class="fw-bold"></span>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted d-block small text-uppercase">Punch ID</label>
                        <span id="info_punch" class="fw-bold"></span>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted d-block small text-uppercase">Department</label>
                        <span id="info_dept" class="fw-bold"></span>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted d-block small text-uppercase">Position</label>
                        <span id="info_pos" class="fw-bold"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Check-in/out -->
    <div class="row mb-4" id="quickCheckInRow">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Quick Check-in/out</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" id="quickEmployeeId" class="form-control" placeholder="Enter Employee ID">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success btn-block" onclick="quickCheckIn()">Check In</button>
                            <button class="btn btn-warning btn-block mt-2" onclick="quickCheckOut()">Check Out</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Attendance Records -->
    <div class="row">
        <div class="col-md-12">
            <h4>Recent Attendance Records</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Employee Name</th>
                            <th>Employee ID</th>
                            <th>Punch ID</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Work Hours</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceList">
                        <!-- Populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="../../public/js/attendance.js"></script>

<?php include 'footer.php'; ?>
