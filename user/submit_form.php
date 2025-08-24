<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start(); // make sure session is started

    include "../connection.php"; // Adjust your DB connection file

    // Collect form data
    $fname        = $_POST['fname'];
    $lname        = $_POST['lname'];
    $dob          = $_POST['dob'];
    $contact      = $_POST['contact_number'];
    $gender       = $_POST['gender'];
    $email        = $_POST['email'];
    $school       = $_POST['school_name'];
    $see_gpa      = $_POST['see_gpa'];
    $college      = $_POST['college_name'];
    $plus2_gpa    = $_POST['plus2_gpa'];
    $iost_marks   = $_POST['iost_marks'];
    $faculty      = $_POST['faculty'];
    $user_id      = $_SESSION['user_id']; // get logged-in user

    // Handle file upload
    $file_path = NULL;
    if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileName = time() . '_' . basename($_FILES['file']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            $file_path = $fileName;
        }
    }

    // Insert into DB
    $stmt = $con->prepare("INSERT INTO student_forms 
        (fname, lname, dob, contact_number, gender, school_name, see_gpa, college_name, plus2_gpa, iost_marks, faculty, file_path, email,user_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssdssisssi", $fname, $lname, $dob, $contact, $gender, $school, $see_gpa, $college, $plus2_gpa, $iost_marks, $faculty, $file_path, $email, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Form submitted successfully!'); window.location.href='user_dash.php';</script>";
    } else {
        echo "<script>alert('❌ Error submitting form. Please try again.'); window.history.back();</script>";
    }
    $stmt->close();
    $con->close();
}
