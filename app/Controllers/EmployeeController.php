<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../Models/Employee.php';

class EmployeeController {
    private $db;
    private $employee;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->employee = new Employee($this->db);
    }

    // Get all employees
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $employees = $this->employee->getAll($page, 10);
        $total = $this->employee->getTotalCount();
        $totalPages = ceil($total / 10);

        return [
            'employees' => $employees,
            'total' => $total,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ];
    }

    // Search employees
    public function search() {
        if (isset($_GET['q'])) {
            $keyword = sanitize($_GET['q']);
            return $this->employee->search($keyword);
        }
        return [];
    }

    // Get single employee
    public function show($id) {
        return $this->employee->getById($id);
    }

    // Create new employee
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->employee->employee_id = sanitize($_POST['employee_id'] ?? '');
            $this->employee->punch_id = sanitize($_POST['punch_id'] ?? '');
            $this->employee->employee_name = sanitize($_POST['employee_name'] ?? '');
            $this->employee->iqama_id = sanitize($_POST['iqama_id'] ?? '');
            $this->employee->nationality = sanitize($_POST['nationality'] ?? '');
            $this->employee->email = sanitize($_POST['email'] ?? '');
            $this->employee->phone = sanitize($_POST['phone'] ?? '');
            $this->employee->department = sanitize($_POST['department'] ?? '');
            $this->employee->position = sanitize($_POST['position'] ?? '');
            $this->employee->hire_date = sanitize($_POST['hire_date'] ?? null);
            $this->employee->salary = sanitize($_POST['salary'] ?? 0);

            if ($this->employee->create()) {
                return ['success' => true, 'message' => 'Employee added successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to add employee'];
            }
        }
    }

    // Update employee (inline edit)
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->employee->id = sanitize($_POST['id'] ?? '');
            $this->employee->employee_id = sanitize($_POST['employee_id'] ?? '');
            $this->employee->punch_id = sanitize($_POST['punch_id'] ?? '');
            $this->employee->employee_name = sanitize($_POST['employee_name'] ?? '');
            $this->employee->iqama_id = sanitize($_POST['iqama_id'] ?? '');
            $this->employee->nationality = sanitize($_POST['nationality'] ?? '');
            $this->employee->email = sanitize($_POST['email'] ?? '');
            $this->employee->phone = sanitize($_POST['phone'] ?? '');
            $this->employee->department = sanitize($_POST['department'] ?? '');
            $this->employee->position = sanitize($_POST['position'] ?? '');
            $this->employee->hire_date = sanitize($_POST['hire_date'] ?? null);
            $this->employee->salary = sanitize($_POST['salary'] ?? 0);

            if ($this->employee->update()) {
                return ['success' => true, 'message' => 'Employee updated successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to update employee'];
            }
        }
    }

    // Delete employee (soft delete)
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = sanitize($_POST['id'] ?? '');
            try {
                if ($this->employee->softDelete($id)) {
                    return ['success' => true, 'message' => 'Employee deleted successfully'];
                }
                return ['success' => false, 'message' => 'Query failed to execute'];
            } catch (Exception $e) {
                return ['success' => false, 'message' => 'Database Error: ' . $e->getMessage()];
            }
        }
    }

    // Restore employee
    public function restore() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = sanitize($_POST['id'] ?? '');
            if ($this->employee->restore($id)) {
                return ['success' => true, 'message' => 'Employee restored successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to restore employee'];
            }
        }
    }
}

// Helper function to sanitize input
if (!function_exists('sanitize')) {
    function sanitize($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}
?>
