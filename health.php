<?php
// Health check endpoint for Railway
header('Content-Type: application/json');

$health = [
    'status' => 'healthy',
    'timestamp' => date('Y-m-d H:i:s'),
    'service' => 'iNotes CRUD',
    'version' => '1.0.0'
];

// Check if we can connect to the database
try {
    require_once 'config.php';
    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if ($conn) {
        $health['database'] = 'connected';
        $health['db_server'] = mysqli_get_server_info($conn);
        mysqli_close($conn);
    } else {
        $health['database'] = 'disconnected';
        $health['status'] = 'degraded';
    }
} catch (Exception $e) {
    $health['database'] = 'error';
    $health['status'] = 'unhealthy';
    $health['error'] = $e->getMessage();
}

// Check if required files exist
$required_files = ['index.php', 'process.php', 'db.php', 'config.php'];
$health['files'] = [];
foreach ($required_files as $file) {
    $health['files'][$file] = file_exists($file) ? 'exists' : 'missing';
}

// Set HTTP status code
if ($health['status'] === 'healthy') {
    http_response_code(200);
} elseif ($health['status'] === 'degraded') {
    http_response_code(200); // Still operational
} else {
    http_response_code(503); // Service unavailable
}

echo json_encode($health, JSON_PRETTY_PRINT);
?>
