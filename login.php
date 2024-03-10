<?php
// Database connection
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "cabs_online";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare and execute SQL statement to check login credentials
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row["password"] === $password) {
            // Start the session to carry forward the email address
            session_start();
            $_SESSION['email'] = $email;
            // Redirect to booking page
            header("Location: booking.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid email.";
    }

    $stmt->close();
}

// Close database connection
$conn->close();
?>
