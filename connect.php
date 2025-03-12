<?php

// Database connection details
$host = "your_db";   // MySQL Host Name from your panel
$user = "your_db";              // MySQL Username from your panel
$pass = "your_db";                 // MySQL Password from your panel
$db = "your_db";    // MySQL Database Name from your panel

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Failed to connect to DB: " . $conn->connect_error);
}


//echo "Database connection successful!";

?>
