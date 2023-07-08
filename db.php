<?php



// Establish database connection
$conn = mysqli_connect("localhost","root","","mysql");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else{
    echo('success');
}
?>