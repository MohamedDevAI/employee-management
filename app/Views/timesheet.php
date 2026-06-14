<?php include 'header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-main">Monthly Timesheet</h2>
        <div class="d-flex gap-2">
            <input type="month" id="timesheetMonth" class="form-control" value="<?php echo date('Y-m'); ?>" style="max-width: 200px;">
            <button class="btn btn-primary" onclick="loadTimesheet()">Filter</button>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="text-muted">Working Hours Summary</span>
            <button class="btn btn-sm btn-outline-success" onclick="exportTimesheet()">
                <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 border-0">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Days Worked</th>
                            <th>Total Hours</th>
                            <th>Avg/Day</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="timesheetList">
                        <!-- Loaded via JS -->
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="../js/timesheet.js"></script>
<?php include 'footer.php'; ?>