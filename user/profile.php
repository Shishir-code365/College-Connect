<?php
include "../connection.php";

// Session is already started in dashboard.php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/main.html");
    exit();
}

$userid = $_SESSION['user_id'];

// Fetch user data
$getinfo = "SELECT * FROM user WHERE id = '$userid'";
$query  = mysqli_query($con, $getinfo);

if ($query) {
    $user_row = mysqli_fetch_array($query);
} else {
    die("Error fetching user data!");
}

// Handle update
if (isset($_POST['save'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = trim($_POST['password']); // user may leave it empty

    // Only update password if a new one is entered
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $update = "UPDATE user SET username='$username', email='$email', password='$hashedPassword' WHERE id='$userid'";
    } else {
        $update = "UPDATE user SET username='$username', email='$email' WHERE id='$userid'";
    }

    if (mysqli_query($con, $update)) {
        $_SESSION['user_name'] = $username; // update session username
        echo "<script>
            alert('Profile updated successfully!');
            window.location.href='user_dash.php'; // redirect to dashboard
        </script>";
        exit();
    } else {
        echo "<script>alert('Failed to update profile!');</script>";
    }
}

// Handle account deletion
if (isset($_POST['delete'])) {
    $deleteQuery = mysqli_query($con, "DELETE FROM user WHERE id='$userid'");
    if ($deleteQuery) {
        session_destroy();
        echo "<script>
            alert('Account deleted successfully!');
            window.location.href='../frontend/main.html';
        </script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete account!');</script>";
    }
}
?>

<div class="profile-settings">
    <form action="" method="post">
        <!-- Username -->
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user_row['username']); ?>" required>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user_row['email']); ?>" required>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label>New Password (leave empty to keep current)</label>
            <input type="password" name="password" placeholder="Enter new password">
        </div>

        <!-- Save Button -->
        <div class="form-group">
            <button type="submit" name="save">Save Changes</button>
        </div>

        <!-- Delete Button -->
        <div class="form-group">
            <button type="submit" name="delete" style="background:red;color:white;" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</button>
        </div>
    </form>
</div>

<style>
    .profile-settings {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .profile-settings .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 15px;
    }

    .profile-settings label {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .profile-settings input {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }

    .profile-settings button {
        padding: 10px 20px;
        background: #093c73;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
    }

    .profile-settings button:hover {
        background: #ffd600;
        color: #093c73;
    }
</style>