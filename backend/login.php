<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
$_SESSION['error_message'] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginEmail = trim($_POST['email']);
    $loginPassword = trim($_POST['password']);

    include "../connection.php";

    // --- USER LOGIN ---
    $sqlUser = "SELECT * FROM user WHERE email = ?";
    $stmtUser = $con->prepare($sqlUser);
    if (!$stmtUser) {
        die("Prepare failed: " . $con->error);
    }
    $stmtUser->bind_param("s", $loginEmail);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    // --- ADMIN LOGIN ---
    $sqlAdmin = "SELECT * FROM admin WHERE email = ?";
    $stmtAdmin = $con->prepare($sqlAdmin);
    if (!$stmtAdmin) {
        die("Prepare failed: " . $con->error);
    }
    $stmtAdmin->bind_param("s", $loginEmail);
    $stmtAdmin->execute();
    $resultAdmin = $stmtAdmin->get_result();

    // --- CHECK USER ---
    if ($resultUser->num_rows == 1) {
        $row = $resultUser->fetch_assoc();
        $hashedPassword = $row['password'];

        if (md5($loginPassword) == $hashedPassword) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            header("Location: ../user/main.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Invalid email or password";
        }

        // --- CHECK ADMIN ---
    } elseif ($resultAdmin->num_rows == 1) {
        $row = $resultAdmin->fetch_assoc();
        $adminPassword = $row['password']; // plain password

        if ($loginPassword === $adminPassword) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_password'] = $row['password'];
            $_SESSION['admin_email'] = $row['email'];

            header("Location: ../admin/admin_panel.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Invalid email or password";
        }
    } else {
        $_SESSION['error_message'] = "Invalid email or password";
    }

    // Close statements and connection
    $stmtUser->close();
    $stmtAdmin->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <style>
        /* Full-screen container to center content */
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: white;
            padding: 40px 40px 40px 40px;
            /* increased horizontal padding */
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 320px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }


        .login-container:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        }

        h2 {
            margin-bottom: 24px;
            color: #4b0082;
        }

        input[type="email"],
        input[type="password"] {
            width: 90%;
            /* reduce from 100% */
            margin-left: auto;
            margin-right: auto;
            display: block;
            /* so margins apply */
            padding: 12px 14px;
            margin: 10px 0 20px 0;
            border: 1.8px solid #764ba2;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }


        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 8px #667eea;
        }

        button {
            background-color: #764ba2;
            color: white;
            border: none;
            padding: 14px 0;
            width: 100%;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #5a378e;
        }

        .register-link {
            margin-top: 16px;
            font-size: 14px;
            color: #333;
        }

        .register-link a {
            color: #764ba2;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #667eea;
            text-decoration: underline;
        }

        .error-message {
            color: #dc3545;
            background: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>User Login</h2>
        <?php if (!empty($_SESSION['error_message'])): ?>
            <div class="error-message">
                <?php
                echo htmlspecialchars($_SESSION['error_message']);
                $_SESSION['error_message'] = ''; // Clear after showing
                ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Enter Email" required autocomplete="off"
                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
            <input type="password" name="password" placeholder="Enter Password" required autocomplete="off" />
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
        <a href="../frontend/main.html">Go to Home Page</a>
    </div>
    <script src="login.js"></script>
</body>

</html>