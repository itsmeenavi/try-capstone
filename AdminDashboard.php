<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    echo "<script>alert('You must be logged in to view this page.'); window.location.href = 'index.php';</script>";
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

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
$stmt = $conn->prepare("SELECT Fullname FROM tblusers WHERE username = ? AND role = ?");
$stmt->bind_param("ss", $username, $role);

// Execute the query
$stmt->execute();
$stmt->bind_result($fullname);
$stmt->fetch();

// Close connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Evaluation System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body class="Dashboard--body">
    <div class="sidebar">
        <div class="logo2">
            <ul class="menu">
            <Span class="admin"><img src="images/LoaLogo.png"></Span>
            <hr>
                <li class="active">
                    <a>
                        <i class="material-symbols-outlined">empty_dashboard</i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="AdminSubjects.php">
                        <i class="material-symbols-outlined">library_books</i>
                        <span>Subjects</span>
                    </a>
                </li>
                <li>
                    <a href="http://">
                        <i class="material-symbols-outlined">cast_for_education</i>
                        <span>Classes</span>
                    </a>
                </li>
                <li>
                    <a href="http://">
                        <i class="material-symbols-outlined">calendar_month</i>
                        <span>Academic Year</span>
                    </a>
                </li>
                <li>
                    <a href="http://">
                        <i class="material-symbols-outlined">article</i>
                        <span>Questionnaires</span>
                    </a>
                </li>
                <li>
                    <a href="http://">
                        <i class="material-symbols-outlined">fact_check</i>
                        <span>Evaluation Criteria</span>
                    </a>
                </li>
                <li>
                    <a href="http://">
                        <i class="material-symbols-outlined">Diversity_3</i>
                        <span>Faculties</span>
                    </a>
                </li>
                <li>
                    <a href="http://">
                        <i class="material-symbols-outlined">School</i>
                        <span>Students</span>
                    </a>
                </li>
                <li>
                    <a href="http://">
                        <i class="material-symbols-outlined">Report</i>
                        <span>Evaluation Reports</span>
                    </a>
                </li>
                <li>
                    <a href="http://">
                        <i class="material-symbols-outlined">Group</i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="main--content">
    <div class="header--wrapper">
        <div class="header--title">
        </div>
        <div class="user--info">
            <div class="paste-button2">
                <button class="button2">
                    <i class="material-symbols-outlined">account_circle</i>
                    <?php echo htmlspecialchars($fullname); ?> &nbsp; ▼
                </button>
                <div class="dropdown-content2">
                    <a id="top2" href="#" onclick="openPopup()">Manage Account</a>
                    <a id="middle2" href="logout.php" onclick="confirmLogout(event)">Logout</a>
                </div>
            </div>
        </div>
</div>
        <div class="card--container">
            <h3 class="main--title">Todays Data</h3>
            <div class="card--wrapper">
                <div class="Faculty--card">
                    <div class="card--header">
                        <div class="amount">
                            <span class="DataFaculty">1</span>
                            <span class="Faculty--name">Total Faculties</span>
                        </div>
                        <img src="images/diversity3.png" alt="Diversity Icon" class="icon">
                    </div>
                </div>
                <div class="Students--card">
                    <div class="card--header">
                        <div class="amount">
                            <span class="DataStudents">44</span>
                            <span class="Students--name">Total Students</span>
                        </div>
                        <img src="images/school.png" alt="Diversity Icon" class="icon">
                    </div>
                </div>
                <div class="Classes--card">
                    <div class="card--header">
                        <div class="amount">
                            <span class="DataClasses">1</span>
                            <span class="Students--name">Total Classes</span>
                        </div>
                        <img src="images/classes.png" alt="Diversity Icon" class="icon">
                    </div>
                </div>
                <div class="Users--card">
                    <div class="card--header">
                        <div class="amount">
                            <span class="DataClasses">1</span>
                            <span class="Students--name">Total Users</span>
                        </div>
                        <img src="images/group.png" alt="Diversity Icon" class="icon">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main--content">
    <div class="header--wrapper">
        <div class="header--title">
            <h1>DASHBOARD</h1>
        </div>
        <div class="user--info">
            <div class="paste-button2">
                <button class="button2">
                    <i class="material-symbols-outlined">face_6</i>
                    <?php echo htmlspecialchars($fullname); ?> &nbsp; ▼
                </button>
                <div class="dropdown-content2">
                    <a id="top2" href="#" onclick="openPopup()">Manage Account</a>
                    <a id="middle2" href="logout.php" onclick="confirmLogout(event)">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="popup">
        <div class="heading">Manage Account</div>
        <form class="form" action="">
            <div class="input-field">
                <input
                    required=""
                    autocomplete="off"
                    type="text"
                    name="text"
                    id="username"
                />
                <label for="username">Change Username</label>
            </div>
            <div class="input-field">
                <input
                    required=""
                    autocomplete="off"
                    type="email"
                    name="email"
                    id="email"
                />
                <label for="Password">Change Password</label>
            </div>
            <div class="input-field">
                <input
                    required=""
                    autocomplete="off"
                    type="password"
                    name="text"
                    id="password"
                />
                <label for="ConfirmPass">Confirm Password</label>
            </div>
            <div class="input-field">
                <input
                    required=""
                    autocomplete="off"
                    type="password"
                    name="text"
                    id="password"
                />
                <label for="Fullname">Change Full name</label>
            </div>
            <div class="btn-container">
                <button class="btn" id="Savebtn">Save</button>
                <button class="btn" id="Cancelbtn" onclick="closePopup()">Cancel</button>
            </div>
        </form>
    </div>
</div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('middle2').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior
        var userConfirmation = confirm("Do you want to logout?");
        if (userConfirmation) {
            window.location.href = "logout.php";
        }
    });
});

let popup = document.getElementById("popup");
let manageAccountLink = document.getElementById("top2");
let cancelButton = document.getElementById("Cancelbtn");

function openPopup() {
    popup.classList.add("open-popup");
}

function closePopup() {
    popup.classList.remove("open-popup");
}

manageAccountLink.addEventListener("click", function(event) {
    event.preventDefault();
    openPopup();
});

cancelButton.addEventListener("click", function() {
    closePopup();
});

function confirmLogout(event) {
            event.preventDefault(); // Prevent the default link action
            if (confirm("Are you sure you want to log out?")) {
                // If user clicks "Yes", proceed with logout
                window.location.href = "logout.php"; // Redirect to the PHP logout script
            }
        }
</script>
</body>
</html>