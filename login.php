<?php
// Database connection details
$host = "localhost";
$user = "root";
$password = "basu2004";
$db = "admin";
$user_type="admin";

// Create connection
$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize login variables
$username = $password = $role = "";
$login_error = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username = ? AND password = ? AND user_type = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }
    
    // Bind parameters
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Successful login
        echo "Login successful!";
        // Redirect to specific role page
        if ($role === "admin") {
            header("Location: post.php");
        } elseif ($role === "faculty") {
            header("Location: faculty_dashboard.php");
        } elseif ($role === "student") {
            header("Location: student_dashboard.php");
        }
        exit();
    } else {
        // Failed login
        $login_error = "Invalid username, password, or role!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Login Page</title>
    <style>
        /* Basic styling for the login page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .announcement h2 {
            color: red;
            text-align: center;
        }

        .login-form {
            display: flex;
            flex-direction: column;
        }

        .login-form input,
        .login-form select {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .login-form button {
            padding: 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-form button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<div class="login-container">
        <div class="login-box">
            <div class="announcement">
                <h2>Placement Record</h2>
                <p>Login to manage, update and manipulate</p>
            </div>
            <form class="login-form" method="POST" action="">
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="faculty">Faculty</option>
                    <option value="student">Student</option>
                </select>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
                <button type="button" onclick="window.location.href='C:\xampp\htdocs\Placement Record Project\Placement Record Project\index.html';">Close</button>
            </form>

            <!-- Display PHP login error -->
            <?php if (!empty($login_error)): ?>
                <p style="color: red;"><?php echo $login_error; ?></p>
            <?php endif; ?>
        </div>
    </div>


</body>
</html>
