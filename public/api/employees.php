<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/Controllers/EmployeeController.php';

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$controller = new EmployeeController();

try {
    switch ($action) {
        case 'list':
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $data = $controller->index();
            echo json_encode([
                'success' => true,
                'employees' => $data['employees'],
                'total' => $data['total'],
                'currentPage' => $data['currentPage'],
                'totalPages' => $data['totalPages']
            ]);
            break;

        case 'show':
            $id = sanitize($_GET['id'] ?? '');
            $employee = $controller->show($id);
            if ($employee) {
                echo json_encode([
                    'success' => true,
                    'employee' => $employee
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Employee not found'
                ]);
            }
            break;

        case 'search':
            $results = $controller->search();
            echo json_encode([
                'success' => true,
                'employees' => $results
            ]);
            break;

        case 'create':
            $result = $controller->store();
            echo json_encode($result);
            break;

        case 'update':
            $result = $controller->update();
            echo json_encode($result);
            break;

        case 'delete':
            $result = $controller->delete();
            echo json_encode($result);
            break;

        case 'restore':
            $result = $controller->restore();
            echo json_encode($result);
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

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>
