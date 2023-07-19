<?php
include 'database_connect.php';
include 'CAL-logger.php';


print_r($_POST); 

// Retrieve the submitted data and ID
$judge_name = $_POST['judge_name'];
$judge_nick = $_POST['judge_nickname'];

// Insert the data into the database
$sql = "INSERT INTO judges (judge_name, judge_nickname) VALUES ('$judge_name', '$judge_nick')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
echo 'Judges inserted successfully!';



?>