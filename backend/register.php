<!-- register.php -->

<?php
session_start(); // Start the session
$_SESSION['error_message'] = "";
include "../connection.php";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $hashedPassword = md5($password);

    $checkUserSql = "SELECT * FROM user WHERE email = ?";
    $stmt = $con->prepare($checkUserSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Same email already exists";
        echo "<script>alert('Same email already exists!!')</script>";
    } else {
        $sql = "INSERT INTO user (username, password, email) VALUES (?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sss", $username, $hashedPassword, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $sqlUser = "SELECT * FROM user WHERE username = ?";
            $stmtUser = $con->prepare($sqlUser);

            if (!$stmtUser) {
                die("Prepare failed: " . $con->error);
            }

            $stmtUser->bind_param("s", $username);
            $stmtUser->execute();
            $resultUser = $stmtUser->get_result();

            if ($resultUser->num_rows == 1) {
                $row = $resultUser->fetch_assoc();

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['password'] = $row['original_password'];
                $_SESSION['redirect'] = true;

                header("Location: ../user/main.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Error inserting data: " . $stmt->error;
        }
    }
    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>
    <style>
        /* (your CSS unchanged, omitted for brevity) */
        /* Reset some defaults */
        * {
            box-sizing: border-box;
        }

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

        .register-container {
            background: white;
            padding: 40px 40px 40px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 350px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .register-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #555;
            text-align: left;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 20px;
            border: 1.8px solid #764ba2;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #667eea;
            box-shadow: 0 0 5px #667eea;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #764ba2;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background: #5a3580;
        }

        .error,
        .success {
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 14px;
            text-align: left;
        }

        .error {
            color: #d64545;
        }

        .success {
            color: #4bb543;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <h2>Create an Account</h2>
        <?php
        if (isset($_SESSION['register_error'])) {
            echo '<p class="error">' . $_SESSION['register_error'] . '</p>';
            unset($_SESSION['register_error']);
        }
        if (isset($_SESSION['register_success'])) {
            echo '<p class="success">' . $_SESSION['register_success'] . '</p>';
            unset($_SESSION['register_success']);
        }
        ?>
        <form id="registerForm" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" autocomplete="off" onsubmit="return validatePasswords()">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required />

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required />

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required />

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" required />

            <button type="submit" name="register">Register</button>
            <a href="../frontend/main.html">Go to Home Page</a>
        </form>
    </div>

    <script>
        function validatePasswords() {
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirm_password').value.trim();

            if (password !== confirmPassword) {
                alert("Passwords do not match. Please try again.");
                return false; // prevent form submission
            }
            return true; // allow form submission
        }
    </script>
</body>

</html>