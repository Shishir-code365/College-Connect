<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCA | NCCS College</title>
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
            max-width: 1100px;
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
            margin-top: 28px;
            margin-bottom: 10px;
        }

        .program-flex {
            display: flex;
            gap: 42px;
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .program-side {
            flex: 1;
            min-width: 240px;
        }

        .program-img {
            max-width: 100%;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(9, 60, 115, 0.10);
            margin-bottom: 24px;
        }

        .program-desc {
            flex: 2;
        }

        table {
            border-collapse: collapse;
            margin: 15px 0 26px 0;
            width: 98%;
        }

        th,
        td {
            border: 1px solid #e1e6ee;
            padding: 10px 14px;
            text-align: left;
        }

        th {
            background: #eaf0fb;
            color: #093c73;
        }

        .grid-tables {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        ul {
            margin: 10px 0 10px 25px;
        }

        @media (max-width: 900px) {
            .main-content {
                padding: 18px 3vw;
            }

            .project {
                flex-direction: column;
                gap: 1.2rem;
            }

            .program-flex {
                flex-direction: column;
                gap: 12px;
            }

            .grid-tables {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <h1>Bachelor of Computer Application (BCA)</h1>
    <div class="program-flex">
        <div class="program-side">
            <img src="https://nccs.edu.np/images/college/bca.jpg" class="program-img" alt="BCA NCCS">
        </div>
        <div class="program-desc">
            <p>
                Bachelors in Computer Application (BCA) is an Information Technology-based program that provides a strong academic foundation for a career in computer applications and software development. This 4-year (8 semesters) program aims to produce qualified software developers with practical and theoretical knowledge to solve problems in business, industry, and government.
            </p>
            <h2>Program's Objectives</h2>
            <ul>
                <li>To produce professionals in computer application as programmers and software developers.</li>
                <li>To provide knowledge about various tools and techniques used in software development.</li>
                <li>To deliver practical and theoretical understanding of computer applications.</li>
                <li>To enhance skills for solving technical problems in industries and organizations.</li>
                <li>To provide a strong base for further studies like MIT, MBA, MCA, etc.</li>
            </ul>
            <h2>Eligibility Condition for Admission</h2>
            <p>Students from all faculties with PCL or 10+2 and a minimum 2 CGPA (not less than D+ in any subject) are eligible for admission to the BCA program.</p>
        </div>
    </div>
    <h2>Course Cycle</h2>
    <div class="grid-tables">
        <!-- You can break up the tables further or keep grouped as below -->
        <table>
            <tr>
                <th>First Semester</th>
                <th>Credit Hours</th>
            </tr>
            <tr>
                <td>CACS101 - Computer Fundamentals & Applications</td>
                <td>4</td>
            </tr>
            <tr>
                <td>CASO102 - Society & Technology</td>
                <td>3</td>
            </tr>
            <tr>
                <td>COEN103 - English I</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CAMT104 - Mathematics I</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS105 - Digital Logic</td>
                <td>3</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>16</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Second Semester</th>
                <th>Credit Hours</th>
            </tr>
            <tr>
                <td>CACS151 - C Programming</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CAAC152 - Financial Accounting</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CAEN153 - English II</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CAMT154 - Mathematics II</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS155 - Micro Processor and Computer Architecture</td>
                <td>3</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>16</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Third Semester</th>
                <th>Credit Hours</th>
            </tr>
            <tr>
                <td>CACS201 - Data Structures & Algorithms</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CAST202 - Probability and Statistics</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS203 - System Analysis and Design</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS204 - OOP in Java</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS205 - Web Technology</td>
                <td>3</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>15</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Fourth Semester</th>
                <th>Credit Hours</th>
            </tr>
            <tr>
                <td>CACS251- Operating System</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS252 - Numerical Methods</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS253 - Software Engineering</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS254 - Scripting Language</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS255 - Database Management System</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CAPJ256 - Project I</td>
                <td>2</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>17</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Fifth Semester</th>
                <th>Credit Hours</th>
            </tr>
            <tr>
                <td>CACS301 - MIS and e-Business</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS302- DotNet Technology</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS303 - Computer Networking</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CAMG304 - Introduction to Management</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS305 - Computer Graphics and Animation</td>
                <td>3</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>15</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Sixth Semester</th>
                <th>Credit Hours</th>
            </tr>
            <tr>
                <td>CACS351 - Mobile Programming</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CAEC352 - Distributed System</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CAEC353 - Applied Economics</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS354 - Advanced Java Programming</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS355 - Network Programming</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CAPJ356 - Project II</td>
                <td>2</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>17</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Seventh Semester</th>
                <th>Credit Hours</th>
            </tr>
            <tr>
                <td>CACS401 - Cyber Law & Professional Ethics</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CACS402 - Cloud Computing</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CAIN403 - Internships</td>
                <td>3</td>
            </tr>
            <tr>
                <td>Elective I</td>
                <td>3</td>
            </tr>
            <tr>
                <td>Elective II</td>
                <td>3</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>15</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Eight Semester</th>
                <th>Credit Hours</th>
            </tr>
            <tr>
                <td>CAOR451 - Operations Research</td>
                <td>3</td>
            </tr>
            <tr>
                <td>CAPJ452 - Project III</td>
                <td>6</td>
            </tr>
            <tr>
                <td>Elective III</td>
                <td>3</td>
            </tr>
            <tr>
                <td>Elective IV</td>
                <td>3</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>15</td>
            </tr>
        </table>
    </div>
</body>

</html>