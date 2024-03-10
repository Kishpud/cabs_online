<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    echo "You need to log in first. Login";
    exit();
}

// Generate booking reference number using timestamp and UUID
$booking_reference_number = time() . '_' . uniqid();

// Store the booking reference number in session
$_SESSION['booking_reference_number'] = $booking_reference_number;

// Retrieve the email from session
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
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
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #ccc;
            text-align: left;
        }
        input[type="text"],
        input[type="date"],
        input[type="time"],
        input[type="submit"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #666;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #333;
            color: #fff;
        }
        input[type="submit"] {
            background-color: #007bff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        echo "<h2>Welcome to the Booking Page</h2>";
        echo "<p>Logged in as: $email</p>";
        ?>
        <h2>Booking Request Form</h2>
        <form action="booking_submit.php" method="post">
            <!-- Other form fields -->
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="booking_reference_number" value="<?php echo $booking_reference_number; ?>">
            <label for="passenger_name">Passenger Name:</label>
            <input type="text" id="passenger_name" name="passenger_name" required><br>

            <label for="passenger_phone">Passenger Phone:</label>
            <input type="text" id="passenger_phone" name="passenger_phone" required><br>

            <label for="unit_number">Unit Number:</label>
            <input type="text" id="unit_number" name="unit_number"><br>

            <label for="street_number">Street Number:</label>
            <input type="text" id="street_number" name="street_number" required><br>

            <label for="street_name">Street Name:</label>
            <input type="text" id="street_name" name="street_name" required><br>

            <label for="pickup_suburb">Pickup Suburb:</label>
            <input type="text" id="pickup_suburb" name="pickup_suburb" required><br>

            <label for="destination_suburb">Destination Suburb:</label>
            <input type="text" id="destination_suburb" name="destination_suburb" required><br>

            <label for="pickup_date">Pickup Date:</label>
            <input type="date" id="pickup_date" name="pickup_date" required><br>

            <label for="pickup_time">Pickup Time:</label>
            <input type="time" id="pickup_time" name="pickup_time" required><br>

            <input type="submit" value="Submit Booking">
        </form>
    </div>
</body>
</html>
