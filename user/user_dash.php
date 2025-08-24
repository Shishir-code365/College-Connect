<?php
session_start(); // make sure session is started
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['feedback'])) {
    include "../connection.php"; // adjust path if needed

    $user_id  = $_SESSION['user_id']; // get logged-in user
    $feedback = trim($_POST['feedback']);
    $rating   = $_POST['rating'];
    $category = $_POST['category'];

    if (!empty($feedback)) {
        $stmt = $con->prepare("INSERT INTO chat_feedback (user_id, feedback, rating, category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $user_id, $feedback, $rating, $category); // note the "i" for user_id and rating, "s" for text
        if ($stmt->execute()) {
            $stmt->close();
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "empty";
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | NCCS College</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <style>
        .promo_card h1 {
            color: white;
        }

        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: #f4f8fb;
            color: #232b38;
        }

        .container {
            display: flex;
            max-width: 1200px;
            margin: 40px auto;
        }

        nav .side_navbar {
            width: 250px;
            background: #093c73;
            color: #fff;
            padding: 20px;
            border-radius: 12px;
        }

        nav .side_navbar span {
            display: block;
            font-size: 1.2rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        nav .side_navbar a,
        nav .side_navbar button {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            text-decoration: none;
            padding: 12px 10px;
            margin-bottom: 10px;
            border: none;
            background: none;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
        }

        nav .side_navbar a.active,
        nav .side_navbar a:hover,
        nav .side_navbar button:hover {
            background: #ffd600;
            color: #093c73;
        }

        .main-body {
            flex: 1;
            margin-left: 20px;
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        .main-content {
            background: #fff;
            border-radius: 18px;
            padding: 30px 25px;
            box-shadow: 0 8px 32px rgba(9, 60, 115, 0.07);
        }

        .fac-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 34px;
            margin-bottom: 36px;
            align-items: center;
        }

        .fac-img {
            width: 100%;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(9, 60, 115, 0.1);
        }

        .promo_card {
            background: #093c73;
            color: #fff;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .promo_card button {
            background: #ffd600;
            color: #093c73;
            border: none;
            padding: 12px 20px;
            margin-top: 20px;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
        }

        .promo_card button:hover {
            background: #ffca00;
        }

        .chatbot-wrapper {
            position: fixed;
            bottom: 30px;
            right: 30px;
            text-align: center;
            z-index: 1000;
        }

        .chatbot-wrapper p {
            margin-bottom: 10px;
            font-weight: 600;
            color: #093c73;
            background: #ffd600;
            padding: 8px 12px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .chatbot-icon {
            display: inline-block;
            width: 60px;
            height: 60px;
            animation: heartbeat 1.5s infinite;
            cursor: pointer;
        }

        .chatbot-icon img {
            width: 100%;
            height: 100%;
        }

        /* Heartbeat Animation */
        @keyframes heartbeat {
            0% {
                transform: scale(1);
            }

            14% {
                transform: scale(1.3);
            }

            28% {
                transform: scale(1);
            }

            42% {
                transform: scale(1.3);
            }

            70% {
                transform: scale(1);
            }

            100% {
                transform: scale(1);
            }
        }


        @media(max-width:900px) {
            .container {
                flex-direction: column;
            }

            nav .side_navbar {
                width: 100%;
                margin-bottom: 20px;
            }

            .main-body {
                margin-left: 0;
            }

            .fac-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Sidebar -->
        <nav>
            <div class="side_navbar">
                <span>Main Menu</span>
                <a href="#" class="active" data-target="dashboard"><i class="fas fa-home"></i> Dashboard</a>
                <a href="#" data-target="profile"><i class="fas fa-user"></i> Profile</a>
                <a href="#" data-target="feedback"><i class="fas fa-comment-alt"></i> Feedback</a>
                <a href="#" data-target="bsc"><i class="fas fa-laptop-code"></i> BSc.CSIT</a>
                <a href="#" data-target="bca"><i class="fas fa-code"></i> BCA</a>
                <a href="#" data-target="bim"><i class="fas fa-book"></i> BIM</a>
                <a href="#" data-target="facilities"><i class="fas fa-building"></i> Facilities</a>
                <a href="#" data-target="fill_form"><i class="fas fa-file-alt"></i> Fill Form</a>
                <a href="#" data-target="contact"><i class="fas fa-envelope"></i> Contact</a>
                <form action="../backend/logout.php" method="post">
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </nav>

        <!-- Main Body -->
        <div class="main-body">
            <div style="display:flex; justify-content:flex-end; margin-bottom:15px;">
                <div style="position:relative;">
                    <i class="fas fa-bell" id="notificationIcon" style="font-size:24px; cursor:pointer;"></i>
                    <span id="notificationCount"
                        style="position:absolute; top:-8px; right:-8px; background:red; color:white; border-radius:50%; padding:2px 6px; font-size:12px;">0</span>
                    <div id="notificationDropdown"
                        style="display:none; position:absolute; right:0; background:#fff; width:300px; max-height:400px; overflow:auto; box-shadow:0 4px 8px rgba(0,0,0,0.1); border-radius:8px; z-index:100;">
                        <ul id="notificationList" style="list-style:none; padding:10px; margin:0;"></ul>
                    </div>
                </div>
            </div>

            <!-- Dashboard Section -->
            <div id="dashboard" class="section active">
                <div class="promo_card">
                    <h1>Welcome <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
                    <p>Access all college resources from your dashboard</p>
                    <button onclick="showSection('fill_form')"><i class="fas fa-file-alt"></i> Fill Form</button>
                    <div class="chatbot-wrapper">
                        <p>💬 Want more info? Chat with us!</p>
                        <a href="http://localhost:5000/user" class="chatbot-icon">
                            <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png" alt="Chatbot" />
                        </a>
                    </div>
                </div>



            </div>

            <div id="profile" class="section">
                <div class="main-content">
                    <?php
                    include("profile.php");
                    ?>
                </div>
                <div class="chatbot-wrapper">
                    <p>💬 Want more info? Chat with us!</p>
                    <a href="http://localhost:5000/user" class="chatbot-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png" alt="Chatbot" />
                    </a>
                </div>
            </div>

            <!-- BSc.CSIT Section -->
            <div id="bsc" class="section">
                <div class="main-content">
                    <?php
                    include("bsc.csit.php");
                    ?>
                </div>
                <div class="chatbot-wrapper">
                    <p>💬 Want more info? Chat with us!</p>
                    <a href="http://localhost:5000/user" class="chatbot-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png" alt="Chatbot" />
                    </a>
                </div>
            </div>

            <div id="feedback" class="section">
                <div class="main-content">
                    <?php
                    include("feedback_form.php");
                    ?>
                </div>
                <div class="chatbot-wrapper">
                    <p>💬 Want more info? Chat with us!</p>
                    <a href="http://localhost:5000/user" class="chatbot-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png" alt="Chatbot" />
                    </a>
                </div>
            </div>

            <!-- BCA Section -->
            <div id="bca" class="section">
                <div class="main-content">
                    <?php
                    include("bca.php");
                    ?>
                </div>
                <div class="chatbot-wrapper">
                    <p>💬 Want more info? Chat with us!</p>
                    <a href="http://localhost:5000/user" class="chatbot-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png" alt="Chatbot" />
                    </a>
                </div>
            </div>

            <div id="bim" class="section">
                <div class="main-content">
                    <?php
                    include("bim.php");
                    ?>
                </div>
                <div class="chatbot-wrapper">
                    <p>💬 Want more info? Chat with us!</p>
                    <a href="http://localhost:5000/user" class="chatbot-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png" alt="Chatbot" />
                    </a>
                </div>
            </div>

            <!-- Facilities Section -->
            <div id="facilities" class="section">
                <div class="main-content">
                    <h1>Facilities of NCCS College</h1>
                    <div class="fac-grid">
                        <img class="fac-img" src="https://nccs.edu.np/images/college/facility/allrounder.jpg" alt="">
                        <div>
                            <h2>Be all rounder at NCCS</h2>
                            <p>NCCS believes in "all-round development makes efficient product" with indoor and outdoor games, debates, and seminars to help students excel.</p>
                        </div>
                    </div>
                    <div class="fac-grid">
                        <img class="fac-img" src="https://nccs.edu.np/images/college/facility/computerlab.jpg" alt="">
                        <div>
                            <h2>High-tech Labs</h2>
                            <p>Specialized labs for computer, bakery, housekeeping, and audio-visual learning are available for hands-on skill development.</p>
                        </div>
                    </div>
                    <div class="fac-grid">
                        <img class="fac-img" src="https://nccs.edu.np/images/college/facility/facility-file.jpg" alt="">
                        <div>
                            <h2>Library Resources</h2>
                            <p>Both online and physical libraries are accessible, providing rich resources for learning and research.</p>
                        </div>
                    </div>
                    <div class="fac-grid">
                        <img class="fac-img" src="https://nccs.edu.np/images/college/facility/inovation.jpg" alt="">
                        <div>
                            <h2>Innovation & Research</h2>
                            <p>The research wing encourages students to utilize knowledge and lead with innovative ideas.</p>
                        </div>
                    </div>
                </div>
                <div class="chatbot-wrapper">
                    <p>💬 Want more info? Chat with us!</p>
                    <a href="http://localhost:5000/user" class="chatbot-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png" alt="Chatbot" />
                    </a>
                </div>
            </div>

            <div id="fill_form" class="section">
                <div class="main-content">
                    <?php
                    include("fillform.php");
                    ?>
                </div>
                <div class="chatbot-wrapper">
                    <p>💬 Want more info? Chat with us!</p>
                    <a href="http://localhost:5000/user" class="chatbot-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png" alt="Chatbot" />
                    </a>
                </div>
            </div>

            <div id="contact" class="section">
                <div class="main-content">
                    <?php
                    include("contactus.php");
                    ?>
                </div>
                <div class="chatbot-wrapper">
                    <p>💬 Want more info? Chat with us!</p>
                    <a href="http://localhost:5000/user" class="chatbot-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png" alt="Chatbot" />
                    </a>
                </div>
            </div>


        </div>
    </div>

    <script>
        const links = document.querySelectorAll('.side_navbar a[data-target]');
        const sections = document.querySelectorAll('.section');

        // Function to show a section
        function showSection(target) {
            // Remove active from all links
            links.forEach(l => l.classList.remove('active'));

            // Highlight sidebar link if exists
            const activeLink = document.querySelector(`.side_navbar a[data-target="${target}"]`);
            if (activeLink) activeLink.classList.add('active');

            // Show target section
            sections.forEach(sec => sec.classList.remove('active'));
            const section = document.getElementById(target);
            if (section) section.classList.add('active');
        }

        // Sidebar link clicks
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = this.dataset.target;
                showSection(target);
            });
        });
        const notificationIcon = document.getElementById('notificationIcon');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const notificationList = document.getElementById('notificationList');
        const notificationCount = document.getElementById('notificationCount');

        function fetchNotifications() {
            fetch('get_notifications.php')
                .then(res => res.json())
                .then(data => {
                    notificationList.innerHTML = '';
                    if (data.notifications.length === 0) {
                        notificationList.innerHTML = '<li style="padding:10px;"><em>No notifications to show</em></li>';
                    } else {
                        data.notifications.forEach(item => {
                            const li = document.createElement('li');
                            li.style.padding = '10px';
                            li.style.borderBottom = '1px solid #eee';
                            li.innerHTML = `<strong>${item.feedback}</strong><br>Reply: ${item.reply}`;
                            notificationList.appendChild(li);
                        });
                    }
                    notificationCount.textContent = data.unread_count;
                });
        }

        notificationIcon.addEventListener('click', () => {
            const isVisible = notificationDropdown.style.display === 'block';
            notificationDropdown.style.display = isVisible ? 'none' : 'block';

            if (!isVisible && notificationCount.textContent != '0') {
                // mark all as read
                fetch('mark_notifications_read.php', {
                        method: 'POST'
                    })
                    .then(() => {
                        notificationCount.textContent = 0;
                    });
            }
        });

        fetchNotifications();
        setInterval(fetchNotifications, 5000);
    </script>


</body>

</html>