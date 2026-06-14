<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../Models/Attendance.php';
require_once __DIR__ . '/../Models/Employee.php';

class AttendanceController {
    private $db;
    private $attendance;
    private $employee;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->attendance = new Attendance($this->db);
        $this->employee = new Employee($this->db);
    }

    // Get all attendance records
    public function index() {
        return $this->attendance->getAll(100);
    }

    // Get employee attendance
    public function getByEmployee($employee_id) {
        return $this->attendance->getByEmployeeId($employee_id, 30);
    }

    // Check in
    public function checkIn() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $public_id = sanitize($_POST['employee_id'] ?? '');
            
            if (!$public_id) {
                return ['success' => false, 'message' => 'Employee ID is required'];
            }

            // Resolve public Employee ID (e.g. 'EMP001') to database PK (e.g. 1)
            $emp = $this->employee->getByEmployeeId($public_id);
            
            if (!$emp) {
                return ['success' => false, 'message' => "Employee with ID '$public_id' not found"];
            }

            $this->attendance->employee_id = $emp['id'];
            
            if ($this->attendance->checkIn()) {
                return ['success' => true, 'message' => 'Check-in recorded successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to record check-in'];
            }
        }
    }

    // Check out
    public function checkOut() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = sanitize($_POST['attendance_id'] ?? '');
            
            if (!$id) {
                return ['success' => false, 'message' => 'Attendance ID is required'];
            }

            if ($this->attendance->checkOut($id)) {
                return ['success' => true, 'message' => 'Check-out recorded successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to record check-out'];
            }
        }
    }

    // Get today's attendance
    public function getTodayStatus() {
        if (isset($_GET['employee_id'])) {
            $public_id = sanitize($_GET['employee_id']);
            
            $emp = $this->employee->getByEmployeeId($public_id);
            if (!$emp) {
                return null;
            }

            return $this->attendance->getTodayAttendance($emp['id']);
        }
        return null;
    }

    // Get attendance by date range
    public function getByDateRange() {
        if ($_GET['employee_id'] && $_GET['start_date'] && $_GET['end_date']) {
            $employee_id = sanitize($_GET['employee_id']);
            $start_date = sanitize($_GET['start_date']);
            $end_date = sanitize($_GET['end_date']);
            
            return $this->attendance->getByDateRange($employee_id, $start_date, $end_date);
        }
        return [];
    }

    // Get monthly summary for timesheet
    public function getMonthlyTimesheet($month, $employee_id = null) {
        $query = "SELECT 
                    e.employee_id, 
                    e.employee_name, 
                    e.department,
                    COUNT(a.id) as total_days,
                    SUM(a.work_hours) as total_hours
                  FROM employees e
                  LEFT JOIN attendance a ON e.id = a.employee_id 
                  AND DATE_FORMAT(a.check_in_time, '%Y-%m') = :month
                  WHERE e.is_deleted = FALSE";
        
        if ($employee_id) {
            $query .= " AND e.id = :emp_id";
        }
        
        $query .= " GROUP BY e.id ORDER BY e.employee_name ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':month', $month);
        if ($employee_id) $stmt->bindParam(':emp_id', $employee_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('sanitize')) {
    function sanitize($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}
?>
