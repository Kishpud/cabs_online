<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Outcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #222;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
            padding: 40px 30px;
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #fff;
            margin-bottom: 30px;
        }
        p {
            color: #fff;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Booking Outcome</h2>
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

        // Check if form data exists
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            $email = $_POST["email"];

            // Generate booking reference number using timestamp and UUID
            $booking_reference_number = time() . '_' . uniqid();

            // Insert booking into database
            $sql = "INSERT INTO booking_table (email, passenger_name, passenger_phone, unit_number, street_number, street_name, pickup_suburb, destination_suburb, pickup_date, pickup_time, booking_reference_number, status)
            VALUES ('$email', '$passenger_name', '$passenger_phone', '$unit_number', '$street_number', '$street_name', '$pickup_suburb', '$destination_suburb', '$pickup_date', '$pickup_time', '$booking_reference_number', 'unassigned')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<p>Passenger Name: $passenger_name</p>";
                echo "<p>Passenger Phone: $passenger_phone</p>";
                echo "<p>Unit Number: $unit_number</p>";
                echo "<p>Street Number: $street_number</p>";
                echo "<p>Street Name: $street_name</p>";
                echo "<p>Pickup Suburb: $pickup_suburb</p>";
                echo "<p>Destination Suburb: $destination_suburb</p>";
                echo "<p>Pickup Date: $pickup_date</p>";
                echo "<p>Pickup Time: $pickup_time</p>";
                echo "<p>Email: $email</p>";
                echo "<p>Booking Reference Number: $booking_reference_number</p>";
                echo "<p>Thank you! Your booking has been successfully submitted.</p>";
            } else {
                echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }
        } else {
            echo "<p>Error: Unable to process your booking. Please try again later.</p>";
        }

        // Close database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
