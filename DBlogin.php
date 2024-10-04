<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if role is set
    if (!isset($_POST['role']) || empty(trim($_POST['role']))) {
        echo "<script>alert('You need to choose a role before logging in.'); window.location.href = 'index.php';</script>";
        exit();
    }

    // Get form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Validate input
    if (empty($username) || empty($password) || empty($role)) {
        echo "<script>alert('All fields are required.'); window.location.href = 'index.php';</script>";
        exit();
    }

    // Database connection
    $servername = "localhost";
    $dbusername = "root";  
    $dbpassword = "";      
    $dbname = "fes";

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM tblusers WHERE username = ? AND password = ? AND role = ?");
    $stmt->bind_param("sss", $username, $password, $role);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // User found, set session variables
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Redirect based on role
        if ($role === 'Admin') {
            header('Location: AdminDashboard.php');
            exit();
        } elseif ($role === 'Student') {
            header('Location: StudentDashboard.php');
            exit();
        } else {
            echo "<script>alert('Invalid role selected.'); window.location.href = 'index.php';</script>";
        }
    } else {

        echo "<script>alert('Invalid username, password, or role.'); window.location.href = 'index.php';</script>";
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
