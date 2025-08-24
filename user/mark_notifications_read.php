<?php
session_start();
include "../connection.php";

if (!isset($_SESSION['user_id'])) exit();

$user_id = $_SESSION['user_id'];

// Mark all replied notifications as read
mysqli_query($con, "UPDATE chat_feedback SET is_read = 1 WHERE user_id = $user_id AND reply IS NOT NULL");
