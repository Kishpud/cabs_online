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

// Check if form data is set
if(isset($_POST["passenger_name"], $_POST["passenger_phone"], $_POST["unit_number"], $_POST["street_number"], $_POST["street_name"], $_POST["pickup_suburb"], $_POST["destination_suburb"], $_POST["pickup_date"], $_POST["pickup_time"])) {
    // Retrieve form data
    $passenger_name = $_POST["passenger_name"];
    $passenger_phone = $_POST["passenger_phone"];
    $unit_number = $_POST["unit_number"];
    $street_number = $_POST["street_number"];
    $street_name = $_POST["street_name"];
    $pickup_suburb = $_POST["pickup_suburb"];
    $destination_suburb = $_POST["destination_suburb"];
    $pickup_date = $_POST["pickup_date"];
    $pickup_time = $_POST["pickup_time"];

    // Insert booking into database
    $insert_query = "INSERT INTO booking_table (passenger_name, passenger_phone, unit_number, street_number, street_name, pickup_suburb, destination_suburb, pickup_date, pickup_time) VALUES ('$passenger_name', '$passenger_phone', '$unit_number', '$street_number', '$street_name', '$pickup_suburb', '$destination_suburb', '$pickup_date', '$pickup_time')";

    if ($conn->query($insert_query) === TRUE) {
        // Get the auto-generated booking reference number
        $booking_reference_number = $conn->insert_id;
        echo "New record created successfully. Booking reference number: $booking_reference_number";
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
} else {
    echo "Form data is not set.";
}

// Close database connection
$conn->close();
?>
