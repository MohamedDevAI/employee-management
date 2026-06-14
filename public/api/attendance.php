<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../app/Controllers/AttendanceController.php';

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$controller = new AttendanceController();

try {
    switch ($action) {
        case 'list':
            $records = $controller->index();
            echo json_encode([
                'success' => true,
                'records' => $records
            ]);
            break;

        case 'today':
            $employee_id = sanitize($_GET['employee_id'] ?? '');
            $record = $controller->getTodayStatus();
            echo json_encode([
                'success' => true,
                'record' => $record
            ]);
            break;

        case 'check_in':
            $result = $controller->checkIn();
            echo json_encode($result);
            break;

        case 'check_out':
            $result = $controller->checkOut();
            echo json_encode($result);
            break;

        case 'by_employee':
            $employee_id = sanitize($_GET['employee_id'] ?? '');
            $records = $controller->getByEmployee($employee_id);
            echo json_encode([
                'success' => true,
                'records' => $records
            ]);
            break;

        case 'by_date_range':
            $records = $controller->getByDateRange();
            echo json_encode([
                'success' => true,
                'records' => $records
            ]);
            break;

        default:
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action'
            ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

if (!function_exists('sanitize')) {
    function sanitize($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}
?>
