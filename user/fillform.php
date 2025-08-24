<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fill Form | NCCS College</title>
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
            max-width: 700px;
            margin: 40px auto 0;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(9, 60, 115, 0.07);
            padding: 36px 30px;
        }

        h1 {
            color: #093c73;
            text-align: center;
            font-size: 2.1rem;
        }

        fieldset {
            border: none;
            margin-bottom: 22px;
        }

        legend {
            font-weight: bold;
            color: #093c73;
            font-size: 1.1rem;
        }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 4px;
            font-weight: 500;
        }

        input[type="text"],
        input[type="number"],
        select,
        input[type="file"] {
            width: 97%;
            padding: 8px;
            border: 1px solid #d2d7e3;
            border-radius: 7px;
            font-size: 1rem;
            background: #f4f8fb;
        }

        input[type="radio"] {
            margin-left: 12px;
        }

        input[type="submit"],
        input[type="reset"] {
            background: #093c73;
            color: #fff;
            border: none;
            border-radius: 7px;
            font-size: 1rem;
            padding: 8px 28px;
            margin-top: 20px;
            margin-right: 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        input[type="reset"]:hover {
            background: #ffd600;
            color: #093c73;
        }

        p {
            margin: 16px 0 28px 0;
            text-align: center;
        }

        @media (max-width: 700px) {
            .main-content {
                padding: 16px 3vw;
            }

            .project {
                flex-direction: column;
                gap: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <h1>Connect with NCCS</h1>
    <p>Students are requested to fill the form with accurate data. The provided information will be reviewed by college administration. Selected students will be contacted soon.</p>
    <form id="studentForm" method="POST" action="submit_form.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Personal Details</legend>
            <label for="fname">First Name</label>
            <input type="text" name="fname" id="fname" placeholder="Enter your first name" required>

            <label for="lname">Last Name</label>
            <input type="text" name="lname" id="lname" placeholder="Enter your last name">

            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" id="dob">

            <label for="number">Contact Number</label>
            <input type="text" name="contact_number" id="number" placeholder="98XXXXXXXX"
                pattern="98[0-9]{8}" title="Phone number must start with 98 and be 10 digits" required>


            <label>Gender</label>
            <input type="radio" name="gender" value="M" checked> Male
            <input type="radio" name="gender" value="F"> Female
            <input type="radio" name="gender" value="Others"> Others

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </fieldset>

        <fieldset>
            <legend>Academic Details</legend>
            <label for="school">School Name</label>
            <input type="text" name="school_name" id="school">

            <label for="see">SEE GPA</label>
            <input type="number" step="0.01" name="see_gpa" id="see">

            <label for="college">College Name</label>
            <input type="text" name="college_name" id="college">

            <label for="plus2gpa">Aggregate GPA in +2</label>
            <input type="number" step="0.01" name="plus2_gpa" id="plus2gpa">

            <label for="iost">Marks obtained in IOST</label>
            <input type="number" name="iost_marks" id="iost">

            <label for="faculty">Select the Faculty</label>
            <select name="faculty" id="faculty">
                <option value="BSc.CSIT">BSc.CSIT</option>
                <option value="BIT">BIT</option>
                <option value="BBM">BBM</option>
                <option value="BHM">BHM</option>
                <option value="BCA">BCA</option>
            </select>

            <label for="file">Upload Photo/Document</label>
            <input type="file" name="file" id="file">
        </fieldset>

        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
    </form>


</body>

</html>