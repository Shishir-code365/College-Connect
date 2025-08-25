<?php
session_start();
include "../connection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    // Delete related student_forms
    mysqli_query($con, "DELETE FROM student_forms WHERE user_id = $user_id");

    // Delete related feedback
    mysqli_query($con, "DELETE FROM chat_feedback WHERE user_id = $user_id");

    // Delete user
    $delete = mysqli_query($con, "DELETE FROM user WHERE id = $user_id");

    if ($delete) {
        $_SESSION['status_msg'] = "User and related data deleted successfully!";
    } else {
        $_SESSION['status_msg'] = "Error deleting user.";
    }
} else {
    $_SESSION['status_msg'] = "Invalid request.";
}

header("Location: admin_panel.php");
exit();
