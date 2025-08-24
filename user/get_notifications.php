<?php
session_start();
include "../connection.php";

if (!isset($_SESSION['user_id'])) exit();

$user_id = $_SESSION['user_id'];

// Fetch all feedbacks that have a reply
$sql = "SELECT id, feedback, reply, created_at, is_read 
        FROM chat_feedback 
        WHERE user_id = $user_id AND reply IS NOT NULL 
        ORDER BY created_at DESC";
$result = mysqli_query($con, $sql);

$notifications = [];
$unread_count = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $notifications[] = $row;
    if ($row['is_read'] == 0) $unread_count++;
}

header('Content-Type: application/json');
echo json_encode([
    'unread_count' => $unread_count,
    'notifications' => $notifications
]);
