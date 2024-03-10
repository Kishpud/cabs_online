<?php
// Database connection parameters
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

// Function to list all unassigned pick-up requests
function listUnassignedPickupRequests($conn) {
    $sql = "SELECT * FROM booking_table WHERE status = 'unassigned'";
    $result = $conn->query($sql);

    return $result; // Return the result set
}

// Function to assign taxi for a specific booking request
function assignTaxi($conn, $bookingRefNumber) {
    $sql = "UPDATE booking_table SET status = 'assigned' WHERE booking_reference_number = '$bookingRefNumber' AND status = 'unassigned'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo "<span style='color: green;'>The booking request $bookingRefNumber has been properly assigned.</span>";
    } else {
        echo "<span style='color: red;'>Error: " . $conn->error . "</span>";
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["listAll"])) {
        $result = listUnassignedPickupRequests($conn); // Execute the query and store the result
    } elseif(isset($_POST["assignTaxi"])) {
        $bookingRefNumber = $_POST["bookingRefNumber"];
        assignTaxi($conn, $bookingRefNumber);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #222; /* Dark background */
            color: #fff; /* White text */
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #444; /* Dark gray border */
        }
        th {
            background-color: #333; /* Dark gray background */
        }
        td form {
            display: inline; /* Display form inline */
        }
        input[type="submit"] {
            background-color: #555; /* Dark gray button */
            color: #fff; /* White text */
            border: none;
            padding: 8px 12px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #777; /* Dark gray button on hover */
        }
        .confirmation {
            margin-top: 10px;
        }
        .confirmation span {
            font-weight: bold;
        }
        .confirmation span.green {
            color: #4CAF50; /* Green text */
        }
        .confirmation span.red {
            color: #F44336; /* Red text */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center;">Admin Page</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="submit" name="listAll" value="List All Unassigned Pick-up Requests">
        </form>

        <?php
        // Display unassigned pick-up requests if available
        if (isset($result) && $result->num_rows > 0) {
            echo "<h3>Unassigned Pick-up Requests</h3>";
            echo "<table>";
            echo "<tr><th>Booking Ref</th><th>Passenger Name</th><th>Contact Phone</th><th>Pick-up Suburb</th><th>Destination Suburb</th><th>Pick-up Date/Time</th><th>Action</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["booking_reference_number"]."</td><td>".$row["passenger_name"]."</td><td>".$row["passenger_phone"]."</td><td>".$row["pickup_suburb"]."</td><td>".$row["destination_suburb"]."</td><td>".$row["pickup_date"]." ".$row["pickup_time"]."</td><td><form action='".htmlspecialchars($_SERVER["PHP_SELF"])."' method='POST'><input type='hidden' name='bookingRefNumber' value='".$row["booking_reference_number"]."'><input type='submit' name='assignTaxi' value='Assign Taxi'></form></td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No unassigned pick-up requests.</p>";
        }
        ?>

    </div>
</body>
</html>
