<?php

$servername = "localhost";
$username = "root";
$password = "abc123";
$dbname = "personafi";

// connect to db
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failes: " . $conn->connect_error);
}

// open file
$file = fopen("faculty.csv", "r");

$row = 1;
while (! feof($file)) {
    $line = fgetcsv($file);
    if (empty($line)) continue;

    $num = count($line);
    $name = $line[0];
    $url = $line[1];
    $sql = "INSERT INTO Contact (name, linkedin_url) VALUES ('$name', '$url')";
    if ($conn->query($sql) === TRUE) {
        echo "$name saved successfully\n";
    } else {
        echo "Error: $sql \n";
        echo $conn->error; 
    }
    $row++;
}

echo "Total $row records saved.\n";
fclose($file);



?>
