<?php
function insertTag($name, $tag, $r) {
    $servername = "127.0.0.1";
    $username = "root";
    $password = "abc123";
    $dbname = "personafi";

    // connect to db
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failes: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Tag (tag, relevance, c_id) VALUES ('$tag', $r, (SELECT id FROM Contact WHERE name = '$name'))"
    if ($conn->query($sql) === TRUE) {
        echo "$name with $tag saved successfully\n";
    } else {
        echo "Error: $sql \n";
        echo $conn->error; 
    }
    
}
?>
