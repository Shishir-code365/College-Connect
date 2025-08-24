<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | NCCS College</title>
    <link rel="shortcut icon" href="https://www.nccs.edu.np/images/college.png" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', Arial, sans-serif;
            background: #f4f8fb;
            color: #232b38;
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

        .main-content {
            max-width: 900px;
            margin: 40px auto 0;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(9, 60, 115, 0.07);
            padding: 38px 30px;
        }

        h1 {
            color: #093c73;
            text-align: center;
            font-size: 2.1rem;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .contact-block {
            background: #f9fafc;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(9, 60, 115, 0.06);
            padding: 28px;
        }

        label {
            display: block;
            margin: 12px 0 3px 0;
            font-weight: 500;
        }

        input[type="text"],
        input[type="name"],
        textarea {
            width: 96%;
            padding: 9px;
            border: 1px solid #d2d7e3;
            border-radius: 8px;
            font-size: 1rem;
            background: #f4f8fb;
        }

        input[type="submit"] {
            background: #093c73;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            padding: 10px 28px;
            margin-top: 12px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #ffd600;
            color: #093c73;
        }

        .map-container {
            margin: 38px 0 10px 0;
        }

        @media (max-width: 900px) {
            .main-content {
                padding: 14px 2vw;
            }

            .project {
                flex-direction: column;
                gap: 1.2rem;
            }

            .contact-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <h1>Contact Us</h1>
    <div class="contact-grid">
        <div class="contact-block">
            <h2>Get in Touch</h2>
            <form>
                <label for="name">Full Name</label>
                <input type="name" id="name" placeholder="Enter your full name" required>
                <label for="email">Email</label>
                <input type="text" id="email" placeholder="Enter your email">
                <label for="message">Message</label>
                <textarea id="message" rows="4" placeholder="Your message"></textarea>
                <input type="submit" value="Send Message">
            </form>
        </div>
        <div class="contact-block">
            <h2>National College of Computer Studies</h2>
            <p>Paknajol, Kathmandu</p>
            <pre>
Tel: 4251711, 4228807, 4267866, 4268221
Fax: 4269807
                </pre>
            <p>Email: info@nccs.edu.np</p>
        </div>
    </div>
    <div class="map-container">
        <h3 style="margin-top:28px; color:#093c73;">You can also locate us here:</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d56513.33447537253!2d85.2327902486328!3d27.714710999999983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb18fc9a83c0cd%3A0xc0495456663927d4!2sNational%20College%20of%20Computer%20Studies!5e0!3m2!1sen!2snp!4v1689388002885!5m2!1sen!2snp" width="100%" height="400" style="border:0; border-radius:12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</body>

</html>