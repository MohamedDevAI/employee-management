<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Attendance Tracking</h2>
        </div>
    </div>

    <!-- Quick Check-in/out -->
    <div class="row mb-4">
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

<script src="js/attendance.js"></script>

<?php include 'footer.php'; ?>
