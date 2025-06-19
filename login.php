<?php
// Database connection
$server = "localhost";
$user = "root";
$password = "";
$db = "grocery_store";

// Create connection
$conn = new mysqli($server, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from POST request
    $usr = $_POST['username'];
    $pass = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Prepare the SQL query
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error in preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ss", $usr, $hashed_password); // "ss" denotes that both variables are strings

    // Execute the statement
    if ($stmt->execute()) {
        // If the user is successfully registered, redirect to the home page
        header("Location: index.html");
        exit(); // Always call exit() after header() to stop further script execution
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
