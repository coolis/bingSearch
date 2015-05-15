<?php

if (!isset($_GET["name"]) && !isset($_GET["tag"])) {
    echo "<p>Please specify the input</p>";
}

$servername = "127.0.0.1";
$username = "root";
$password = "abc123";
$dbname = "personafi";

// connect to db
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failes: " . $conn->connect_error);
}

if (isset($_GET["name"])) {
    $name = $_GET["name"];
    $sql = "SELECT tag FROM Tag INNER JOIN Contact ON Contact.id = Tag.c_id WHERE name = '$name'";
    $result = $conn->query($sql);

    $response = [
        'name' => $name,
        'tags' => []
    ];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($response["tags"], $row["tag"]);
        }
    }
    echo json_encode($response);
} 

if (isset($_GET["tag"])) {
    $tag = $_GET["tag"];
    $sql = "SELECT name FROM Contact INNER JOIN Tag ON Tag.c_id = Contact.id WHERE Tag.tag = '$tag'";

    $result = $conn->query($sql);
    $response = [
        'tag' => $tag,
        'names' => []
    ];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($response["names"], $row["name"]);
        }
    }
    echo json_encode($response);
}

?>
