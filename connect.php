<?php

$host = "j1r4n2ztuwm0bhh5.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";  // JawsDB host
$user = "pus4ul2z8ecrb7xr";  // JawsDB username
$pass = "lsgtt5r0qemz08as";  // JawsDB password
$db = "fty3z6xrj7wtkeko";    // JawsDB database name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Failed to connect DB: " . $conn->connect_error);
} else {
    echo "Connected successfully to JawsDB!";
}
?>
