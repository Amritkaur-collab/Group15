<?php
require_once 'C:\xampp\htdocs\Group15\WebSolution\inc\dbconn.inc.php'; // Include database connection

$data = json_decode(file_get_contents('php://input'), true);
$jobId = $data['job_id'] ?? null;

if (!$jobId) {
    echo json_encode(['status' => 'error', 'message' => 'Job ID is required']);
    exit;
}

$sql = "DELETE FROM jobs WHERE job_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $jobId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>