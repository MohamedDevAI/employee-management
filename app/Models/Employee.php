<?php

class Employee {
    private $conn;
    private $table = 'employees';

    public $id;
    public $employee_id;
    public $punch_id;
    public $employee_name;
    public $iqama_id;
    public $nationality;
    public $email;
    public $phone;
    public $department;
    public $position;
    public $hire_date;
    public $salary;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all employees (excluding soft deleted)
    public function getAll($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE is_deleted = FALSE 
                  ORDER BY created_at DESC 
                  LIMIT :offset, :limit";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get total count of non-deleted employees
    public function getTotalCount() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE is_deleted = FALSE";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Get single employee
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id AND is_deleted = FALSE";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get employee by public Employee ID (e.g., EMP001)
    public function getByEmployeeId($employee_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE employee_id = :employee_id AND is_deleted = FALSE";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Search employees
    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE is_deleted = FALSE AND (
                    employee_name LIKE :keyword OR 
                    employee_id LIKE :keyword OR 
                    punch_id LIKE :keyword OR 
                    iqama_id LIKE :keyword OR 
                    email LIKE :keyword
                  ) 
                  ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $search_term = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $search_term);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create new employee
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (employee_id, punch_id, employee_name, iqama_id, nationality, email, phone, department, position, hire_date, salary)
                  VALUES 
                  (:employee_id, :punch_id, :employee_name, :iqama_id, :nationality, :email, :phone, :department, :position, :hire_date, :salary)";

        $stmt = $this->conn->prepare($query);

        // Sanitize and bind values
        $stmt->bindParam(':employee_id', $this->employee_id);
        $stmt->bindParam(':punch_id', $this->punch_id);
        $stmt->bindParam(':employee_name', $this->employee_name);
        $stmt->bindParam(':iqama_id', $this->iqama_id);
        $stmt->bindParam(':nationality', $this->nationality);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':department', $this->department);
        $stmt->bindParam(':position', $this->position);
        $stmt->bindParam(':hire_date', $this->hire_date);
        $stmt->bindParam(':salary', $this->salary);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Update employee (inline editing)
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET employee_name = :employee_name, 
                      email = :email, 
                      phone = :phone, 
                      department = :department, 
                      position = :position,
                      salary = :salary,
                      updated_at = NOW()
                  WHERE id = :id AND is_deleted = FALSE";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':employee_name', $this->employee_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':department', $this->department);
        $stmt->bindParam(':position', $this->position);
        $stmt->bindParam(':salary', $this->salary);

        return $stmt->execute();
    }

    // Soft delete employee
    public function softDelete($id) {
        $query = "UPDATE " . $this->table . " 
                  SET is_deleted = TRUE, deleted_at = NOW() 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Restore soft deleted employee
    public function restore($id) {
        $query = "UPDATE " . $this->table . " 
                  SET is_deleted = FALSE, deleted_at = NULL 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Get all employees including deleted
    public function getAllWithDeleted() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
