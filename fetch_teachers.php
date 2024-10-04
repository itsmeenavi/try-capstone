<?php
// Database connection
$servername = "localhost";
$username = "root"; // replace with your MySQL username
$password = ""; // replace with your MySQL password
$dbname = "fes"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT Firstname, Lastname FROM tblteachers";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data for each row
    while($row = $result->fetch_assoc()) {
        $professorName = htmlspecialchars($row["Firstname"] . ' ' . $row["Lastname"]);
        echo '<a href="StudentEvaluation.php" class="alert success" role="alert">';
        echo '<p class="text-xs font-semibold">' . $professorName . '</p>';
        echo '</a>';
    }
} else {
    echo '<a href="StudentEvaluation.php" class="alert error" role="alert">';
    echo '<p class="text-xs font-semibold">No professors found</p>';
    echo '</a>';
}

$conn->close();
?>
