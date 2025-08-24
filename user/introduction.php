<?php
session_start();
include "../connection.php";
// $name = $_SESSION["name"];
// $email = $_SESSION["email"];
$userid = $_SESSION['user_id'];
if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/main.html");
}
$getinfo = "SELECT * from user where id = '$userid'";
$query  = mysqli_query($con, $getinfo);
if ($query) {
    $user_row = mysqli_fetch_array($query);
} ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introduction | NCCS College</title>
    <link rel="shortcut icon" href="https://www.nccs.edu.np/images/college.png" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', Arial, sans-serif;
            background: #f4f8fb;
            color: #232b38;
        }

        .main-content {
            max-width: 1000px;
            margin: 40px auto 0;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(9, 60, 115, 0.07);
            padding: 38px 30px;
        }

        h1,
        h2 {
            color: #093c73;
        }

        h1 {
            font-size: 2.1rem;
            margin-bottom: 18px;
            text-align: center;
        }

        h2 {
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .intro-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 34px;
            margin-bottom: 26px;
            align-items: center;
        }

        .intro-img {
            width: 100%;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(9, 60, 115, 0.10);
        }

        .project {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.2rem 4vw;
            background: #093c73;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .logo img {
            height: 60px;
        }

        .navbar,
        .navbar2 {
            display: flex;
            list-style: none;
            gap: 2.5rem;
        }

        .navbar li,
        .navbar2 li {
            position: relative;
        }

        .navbar a,
        .navbar2 a {
            text-decoration: none;
            color: #f9fafb;
            font-size: 1.08rem;
            font-weight: 500;
            padding: 8px 16px;
            transition: color .2s;
        }

        .navbar a:hover,
        .navbar2 a:hover {
            color: #ffd600;
        }

        .sub-drop,
        .drop-faculty {
            position: absolute;
            left: 0;
            top: 110%;
            background: #fff;
            color: #093c73;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 6px 24px rgba(9, 60, 115, 0.15);
            display: none;
            min-width: 180px;
            z-index: 100;
        }

        .about-drop:hover .sub-drop,
        .academic-drop:hover .drop-faculty {
            display: block;
        }

        .sub-drop li,
        .drop-faculty li {
            padding: 10px 20px;
        }

        .sub-drop li a,
        .drop-faculty li a {
            color: #093c73;
            font-weight: 400;
            font-size: 1rem;
        }

        .sub-drop li a:hover,
        .drop-faculty li a:hover {
            color: #ffd600;
        }

        @media (max-width: 900px) {
            .main-content {
                padding: 16px 3vw;
            }

            .project {
                flex-direction: column;
                gap: 1.2rem;
            }

            .intro-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="project">
        <div class="logo">
            <img src="https://www.nccs.edu.np/images/college.png" alt="NCCS Logo">
        </div>
        <ul class="navbar">
            <li class="about-drop"><a href="#">About</a>
                <ul class="sub-drop">
                    <li><a href="#">Introduction</a></li>
                    <li><a href="message.php">Message from Principal</a></li>
                </ul>
            </li>
            <li><a href="user_dash.php">Dashboard</a></li>
            <li><a href="../backend/logout.php">Logout</a></li>

        </ul>

    </div>
    <div class="main-content">
        <h1><i><u>Introduction</u></i></h1>
        <div class="intro-grid">
            <img class="intro-img" src="https://nccs.edu.np/images/college/building.jpg" alt="">
            <div>
                <p>
                    National College of Computer Studies (NCCS), college of IT and Management, is a highly professional and experienced college based in Kathmandu, established in 1999. It comprises multitalented professionals considered among the best in the industry. It educates students to face industry challenges and perform exceedingly well. NCCS is dedicated to providing university curriculum to students and is affiliated with Nepal's prestigious Tribhuvan University.<br><br>
                    NCCS is truly an institution on the move, committed to educational excellence. Focusing on IT & Management, NCCS provides the best opportunities for all-round student development. Its extracurricular activities, games, and inter-college events help students take on the challenges of the century and stand out in every aspect of life.
                </p>
            </div>
        </div>
        <div class="intro-grid">
            <img class="intro-img" src="https://nccs.edu.np/images/college/slide/21.jpg" alt="">
            <div>
                <h2>Vision & Mission</h2>
                <p>
                    A literate society with a purpose, a progressive society with ideas, and a conscious society working towards a better and brighter future for all.<br>
                    To achieve this, NCCS works diligently to provide eager minds with the tools, skills, knowledge, and solutions required for visible and rapid progress.
                </p>
                <h2>Objectives</h2>
                <p>
                    NCCS aims to be a center of learning for young students determined to meet the challenges of science and mobilization. The college focuses on self-confidence, self-discipline, value education, social work, career guidance, leadership, and extracurricular activities.
                </p>
            </div>
        </div>
        <h2>Location</h2>
        <p>
            NCCS is situated in its own land in the heart of Kathmandu, easily reachable from any part of the valley, in an area growing as an educational hub. The College Management Committee is committed to expanding the college further in the future.
        </p>
        <h2>Infrastructure & Environment</h2>
        <p>
            The NCCS complex is equipped for quality education and student growth, with separate blocks for administration, education, sports, and hostels. All complexes are furnished and equipped with modern services for teaching and learning.
        </p>
    </div>
</body>

</html>