<?php

class Attendance {
    private $conn;
    private $table = 'attendance';

    public $id;
    public $employee_id;
    public $check_in_time;
    public $check_out_time;
    public $work_hours;
    public $notes;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all attendance records
    public function getAll($limit = 50) {
        $query = "SELECT a.*, e.employee_name, e.employee_id, e.punch_id 
                  FROM " . $this->table . " a
                  JOIN employees e ON a.employee_id = e.id
                  ORDER BY a.check_in_time DESC 
                  LIMIT :limit";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get attendance by employee
    public function getByEmployeeId($employee_id, $days = 30) {
        $query = "SELECT a.*, e.employee_name, e.employee_id, e.punch_id 
                  FROM " . $this->table . " a
                  JOIN employees e ON a.employee_id = e.id
                  WHERE a.employee_id = :employee_id 
                  AND a.check_in_time >= DATE_SUB(NOW(), INTERVAL :days DAY)
                  ORDER BY a.check_in_time DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->bindValue(':days', $days, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Check in employee
    public function checkIn() {
        $query = "INSERT INTO " . $this->table . " (employee_id, check_in_time)
                  VALUES (:employee_id, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employee_id', $this->employee_id);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Check out employee
    public function checkOut($id) {
        $query = "UPDATE " . $this->table . " 
                  SET check_out_time = NOW(),
                      work_hours = TIMESTAMPDIFF(HOUR, check_in_time, NOW()),
                      updated_at = NOW()
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Get today's attendance for employee
    public function getTodayAttendance($employee_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE employee_id = :employee_id 
                  AND DATE(check_in_time) = CURDATE()
                  ORDER BY check_in_time DESC LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get attendance by date range
    public function getByDateRange($employee_id, $start_date, $end_date) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE employee_id = :employee_id 
                  AND DATE(check_in_time) BETWEEN :start_date AND :end_date
                  ORDER BY check_in_time ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
