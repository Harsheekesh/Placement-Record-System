<?php
// File: post.php

// Database connection
$conn = new mysqli("localhost", "root", "basu2004", "admin");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and match with database column names
    $student_name = $_POST['student_name']; // Matches 'student_name' in DB
    $course = $_POST['course'];            // Matches 'course' in DB
    $student_email = $_POST['student_email']; // Matches 'student_email' in DB
    $company_name = $_POST['company_name']; // Matches 'company_name' in DB
    $job_role = $_POST['job_role'];        // Matches 'job_role' in DB
    $salary_package = $_POST['salary_package']; // Matches 'salary_package' in DB
    $placement_year = $_POST['placement_year']; // Matches 'placement_year' in DB

    // Handling file upload for 'student_image'
    $student_image = null;
    if (isset($_FILES['student_image']) && $_FILES['student_image']['error'] == 0) {
        $student_image = addslashes(file_get_contents($_FILES['student_image']['tmp_name']));
    } else {
        die("Error uploading image: " . $_FILES['student_image']['error']);
    }

    // SQL query to insert the data into the database
    $sql = "INSERT INTO student_placement_record (student_name, course, student_email, student_image, company_name, job_role, salary_package, placement_year)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement and bind parameters
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "ssssssds", // Data types: string, string, string, string (blob), string, string, decimal, string
            $student_name,
            $course,
            $student_email,
            $student_image,
            $company_name,
            $job_role,
            $salary_package,
            $placement_year
        );

        // Execute the statement
        if ($stmt->execute()) {
            echo "Record saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Placement Record Updation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #d32f2f;
            text-align: center;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 20px;
            color: #d32f2f;
        }

        input[type="text"],
        input[type="file"],
        input[type="number"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 2px solid #d32f2f;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #d32f2f;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #b71c1c;
        }

        .responsive-image {
            max-width: 100px;
            height: auto;
        }

        @media screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }

            input[type="submit"] {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Student Placement Record</h2>
        <form action="post.php" method="POST" enctype="multipart/form-data">
    <label for="student_name">Student Name:</label>
    <input type="text" id="student_name" name="student_name" required>

    <label for="course">Course:</label>
    <input type="text" id="course" name="course" required>

    <label for="student_email">Student Email:</label>
    <input type="email" id="student_email" name="student_email" required>

    <label for="student_image">Upload Student Image:</label>
    <input type="file" id="student_image" name="student_image" accept="image/*" required>

    <label for="company_name">Company Name:</label>
    <input type="text" id="company_name" name="company_name" required>

    <label for="job_role">Job Role:</label>
    <input type="text" id="job_role" name="job_role" required>

    <label for="salary_package">Salary Package (in Lakhs):</label>
    <input type="number" id="salary_package" name="salary_package" required min="0" step="0.01">

    <label for="placement_year">Placement Year:</label>
    <select id="placement_year" name="placement_year" required>
        <option value="2024">2024</option>
        <option value="2023">2023</option>
        <option value="2022">2022</option>
    </select>

    <input type="submit" value="Save Record">
</form>


    </div>

    <!-- JavaScript to handle form submission -->
    <!-- <script>
        document.getElementById('placementForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting the default way

            // Get form data
            const studentName = document.getElementById('studentName').value;
            const course = document.getElementById('course').value;
            const studentEmail = document.getElementById('studentEmail').value;
            const companyName = document.getElementById('companyName').value;
            const jobRole = document.getElementById('jobRole').value;
            const salaryPackage = document.getElementById('salaryPackage').value;
            const placementYear = document.getElementById('placementYear').value;

            // Validate data (optional)
            if (!studentName || !course || !studentEmail || !companyName || !jobRole || !salaryPackage || !placementYear) {
                alert("Please fill out all required fields.");
                return;
            }

            // Send the form data to the backend (for simplicity, we'll log it to the console here)
            const formData = {
                studentName,
                course,
                studentEmail,
                companyName,
                jobRole,
                salaryPackage,
                placementYear,
            };

            console.log("Form Data Submitted:", formData);

            // Simulate saving the data to a database
            alert("Student Placement Record saved successfully!");

            // You can replace the above with actual AJAX or API call to save the data to your backend/database
        });
    </script> -->
</body>
</html>
