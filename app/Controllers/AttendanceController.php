<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../Models/Attendance.php';

class AttendanceController {
    private $db;
    private $attendance;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->attendance = new Attendance($this->db);
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
            $employee_id = sanitize($_POST['employee_id'] ?? '');
            
            if (!$employee_id) {
                return ['success' => false, 'message' => 'Employee ID is required'];
            }

            $this->attendance->employee_id = $employee_id;
            
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
            $employee_id = sanitize($_GET['employee_id']);
            return $this->attendance->getTodayAttendance($employee_id);
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
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>
