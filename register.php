<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #222; /* Dark background */
            color: #fff; /* White text */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            animation: fadeIn 1s ease-out;
        }
        h1 {
            font-size: 48px;
            color: #4CAF50; /* Green color */
            margin-bottom: 20px;
            animation: moveUp 1s ease-out;
        }
        @keyframes moveUp {
            0% { transform: translateY(100px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="container">
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

        // Form submission handling
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $email = $_POST["email"];
            $password = $_POST["password"];

            // Check if all fields are filled
            if (empty($email) || empty($password)) {
                echo "Email and password are required.";
            } else {
                // Check if email already exists in the database
                $check_email_query = "SELECT * FROM customers WHERE email = ?";
                $stmt = $conn->prepare($check_email_query);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "Email already exists.";
                } else {
                    // Insert new user into the database
                    $insert_query = "INSERT INTO customers (email, password) VALUES (?, ?)";
                    $stmt = $conn->prepare($insert_query);
                    $stmt->bind_param("ss", $email, $password);
                    
                    if ($stmt->execute()) {
                        echo "<h1>Registration successful. Please login.</h1>";
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }
                // Close statement
                $stmt->close();
            }
        }

        // Close database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
