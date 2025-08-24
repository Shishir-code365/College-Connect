<?php
session_start();
include "../connection.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../user/main.php");
    exit();
}

// Handle feedback reply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply'], $_POST['feedback_id'])) {
    $feedback_id = intval($_POST['feedback_id']);
    $reply = trim($_POST['reply']);
    if (!empty($reply)) {
        mysqli_query($con, "UPDATE chat_feedback SET reply = '" . mysqli_real_escape_string($con, $reply) . "' WHERE id = $feedback_id");
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch analytics
$total_users = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM user"))['total'];
$total_feedback = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM chat_feedback"))['total'];
$replied_feedback = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM chat_feedback WHERE reply IS NOT NULL"))['total'];

// Fetch feedbacks
$feedbacks = mysqli_query($con, "
    SELECT cf.id, cf.feedback, cf.rating, cf.category, cf.reply, u.username, u.email
    FROM chat_feedback cf
    JOIN user u ON u.id = cf.user_id
    ORDER BY cf.created_at DESC
");

// Fetch users
$users = mysqli_query($con, "SELECT * FROM user ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | NCCS Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f8fb;
            margin: 0;
            padding: 0;
        }

        header {
            background: #093c73;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        a.logout-btn {
            background: #ff4d4d;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        a.logout-btn:hover {
            background: #e60000;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            display: grid;
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #093c73;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #093c73;
            color: white;
        }

        textarea {
            width: 100%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: none;
        }

        button {
            padding: 5px 10px;
            background: #093c73;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #ffca00;
            color: #093c73;
        }

        .status-replied {
            color: green;
            font-weight: bold;
        }

        .status-pending {
            color: red;
            font-weight: bold;
        }

        @media(max-width:900px) {
            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <header>
        <h1>Admin Panel</h1>
        <a href="?logout=true" class="logout-btn">Logout</a>
    </header>

    <div class="container">

        <!-- Analytics -->
        <!-- Dashboard Widgets -->
        <div class="card" style="display:flex;justify-content:space-between;flex-wrap:wrap;">
            <!-- Pending Applications -->
            <div style="flex:1; min-width:180px; margin:10px; background:#ff9f1a; color:white; padding:20px; border-radius:10px; text-align:center;">
                <h3>Pending Applications</h3>
                <p style="font-size:2rem; font-weight:bold;"><?php
                                                                echo mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM student_forms WHERE status='Pending'"))['total'];
                                                                ?></p>
                <a href="#form-management" style="color:white; text-decoration:underline;">Manage Forms</a>
            </div>

            <!-- Feedback Pending Reply -->
            <div style="flex:1; min-width:180px; margin:10px; background:#ff6b6b; color:white; padding:20px; border-radius:10px; text-align:center;">
                <h3>Feedback Pending</h3>
                <p style="font-size:2rem; font-weight:bold;"><?php
                                                                echo mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM chat_feedback WHERE reply IS NULL"))['total'];
                                                                ?></p>
                <a href="#feedback-management" style="color:white; text-decoration:underline;">Reply Feedback</a>
            </div>

            <!-- Recent Users -->
            <div style="flex:1; min-width:180px; margin:10px; background:#1dd1a1; color:white; padding:20px; border-radius:10px; text-align:center;">
                <h3>Recent Users</h3>
                <p style="font-size:1rem;"><?php
                                            $recent_users = mysqli_query($con, "SELECT username FROM user ORDER BY id DESC LIMIT 3");
                                            while ($u = mysqli_fetch_assoc($recent_users)) {
                                                echo htmlspecialchars($u['username']) . "<br>";
                                            }
                                            ?></p>
                <a href="#user-management" style="color:white; text-decoration:underline;">Manage Users</a>
            </div>

        </div>


        <!-- Feedback Management -->
        <div class="card">
            <section id="feedback-management">
                <h2>Feedback Management</h2>
                <table>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Feedback</th>
                        <th>Rating</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Reply</th>
                    </tr>
                    <?php while ($f = mysqli_fetch_assoc($feedbacks)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($f['username']); ?></td>
                            <td><?php echo htmlspecialchars($f['email']); ?></td>
                            <td><?php echo htmlspecialchars($f['feedback']); ?></td>
                            <td><?php echo $f['rating']; ?></td>
                            <td><?php echo htmlspecialchars($f['category']); ?></td>
                            <td>
                                <?php echo $f['reply'] ? '<span class="status-replied">Replied</span>' : '<span class="status-pending">Pending</span>'; ?>
                            </td>
                            <td>
                                <?php if (!$f['reply']) { ?>
                                    <form method="post">
                                        <input type="hidden" name="feedback_id" value="<?php echo $f['id']; ?>">
                                        <textarea name="reply" rows="2" placeholder="Write a reply..."></textarea>
                                        <button type="submit">Send</button>
                                    </form>
                                <?php } else {
                                    echo htmlspecialchars($f['reply']);
                                } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </section>
        </div>

        <!-- User Management -->
        <div class="card">
            <section id="user-management">
                <h2>User Management</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($u = mysqli_fetch_assoc($users)) { ?>
                        <tr>
                            <td><?php echo $u['id']; ?></td>
                            <td><?php echo htmlspecialchars($u['username']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td>
                                <form method="post" action="delete_user.php" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </section>
        </div>
        <!-- Form Management -->
        <!-- Form Management -->
        <div class="card">
            <section id="form-management">
                <h2>Form Management</h2>
                <table>
                    <tr>

                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                    <?php
                    $forms = mysqli_query($con, "
            SELECT sf.*, u.username
            FROM student_forms sf
            JOIN user u ON u.id = sf.user_id
            ORDER BY sf.created_at DESC
        ");
                    while ($f = mysqli_fetch_assoc($forms)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($f['email']); ?></td>
                            <td><?php echo htmlspecialchars($f['fname']); ?></td>
                            <td><?php echo htmlspecialchars($f['lname']); ?></td>
                            <td>
                                <?php
                                if ($f['status'] == 'Pending') echo '<span style="color:orange;font-weight:bold;">Pending</span>';
                                elseif ($f['status'] == 'Accepted') echo '<span style="color:green;font-weight:bold;">Accepted</span>';
                                else echo '<span style="color:red;font-weight:bold;">Rejected</span>';
                                ?>
                            </td>
                            <td>
                                <?php if ($f['status'] == 'Pending') { ?>
                                    <form method="post" action="process_form.php">
                                        <input type="hidden" name="form_id" value="<?php echo $f['id']; ?>">
                                        <button type="submit" name="action" value="accept">Accept</button>
                                        <button type="submit" name="action" value="reject">Reject</button>
                                    </form>
                                <?php } else {
                                    echo '-';
                                } ?>
                            </td>
                            <td>
                                <a href="view_form_pdf.php?form_id=<?php echo $f['id']; ?>" target="_blank">View Form</a>
                            </td>

                        </tr>
                    <?php } ?>
                </table>
            </section>
        </div>



    </div>

</body>

</html>