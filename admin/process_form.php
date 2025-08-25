<?php
session_start();
include "../connection.php";

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/PHPMailer-master/src/SMTP.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_id'], $_POST['action'])) {
    $form_id = intval($_POST['form_id']);
    $action = $_POST['action'];

    // Fetch form info
    $form = mysqli_fetch_assoc(mysqli_query($con, "SELECT email, fname, lname FROM student_forms WHERE id = $form_id"));

    if ($form) {
        $mail = new PHPMailer(true);
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = ''; // your Gmail
            $mail->Password   = '';   // Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('collegeadmin@gmail.com', 'NCCS College Admin');
            $mail->addAddress($form['email'], $form['fname'] . ' ' . $form['lname']);
            $mail->isHTML(true);

            if ($action == 'accept') {
                mysqli_query($con, "UPDATE student_forms SET status='Accepted' WHERE id=$form_id");
                $mail->Subject = "Application Status: Accepted | NCCS College";
                $mail->Body = "
                <html>
                <head>
                <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .container { border: 1px solid #ddd; padding: 20px; border-radius: 8px; background: #f9f9f9; }
                .header { background: #004080; color: white; padding: 10px; border-radius: 8px 8px 0 0; }
                .footer { font-size: 12px; color: #555; margin-top: 20px; }
                </style>
                </head>
                <body>
                <div class='container'>
                <div class='header'><h2>NCCS College - Admission Office</h2></div>
                <p>Dear <b>{$form['fname']} {$form['lname']}</b>,</p>
                <p>Your application has been <b style='color:green;'>ACCEPTED</b>.</p>
                <p>We will contact you shortly with further instructions.</p>
                <div class='footer'>
                Regards,<br>NCCS College<br>Basundhara, Kathmandu<br>
                <a href='mailto:info@nccs.edu.np'>info@nccs.edu.np</a>
                </div>
                </div>
                </body>
                </html>";
            } elseif ($action == 'reject') {
                mysqli_query($con, "UPDATE student_forms SET status='Rejected' WHERE id=$form_id");
                $mail->Subject = "Application Status: Rejected | NCCS College";
                $mail->Body = "
                <html>
                <head>
                <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .container { border: 1px solid #ddd; padding: 20px; border-radius: 8px; background: #f9f9f9; }
                .header { background: #800000; color: white; padding: 10px; border-radius: 8px 8px 0 0; }
                .footer { font-size: 12px; color: #555; margin-top: 20px; }
                </style>
                </head>
                <body>
                <div class='container'>
                <div class='header'><h2>NCCS College - Admission Office</h2></div>
                <p>Dear <b>{$form['fname']} {$form['lname']}</b>,</p>
                <p>Your application has been <b style='color:red;'>REJECTED</b>.</p>
                <p>Please contact our admission office for further details.</p>
                <div class='footer'>
                Regards,<br>NCCS College<br>Basundhara, Kathmandu<br>
                <a href='mailto:info@nccs.edu.np'>info@nccs.edu.np</a>
                </div>
                </div>
                </body>
                </html>";
            }

            // Send email
            $mail->send();
            $_SESSION['form_action_status'] = "✅ Email sent to student and form status updated.";
        } catch (Exception $e) {
            $_SESSION['form_action_status'] = "❌ Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

header("Location: admin_panel.php");
exit();
