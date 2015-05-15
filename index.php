<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Personafi</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- Custom styles for this template -->
        <link href="jumbotron-narrow.css" rel="stylesheet">
        <style>
        .searchResult {
            margin: 10px 0 40px 0;
        }
        .searchFor {
            margin-bottom: 40px;
        }
        .tags, .names, .relevances {
            font-size: 15px;
            padding: 5px;
            border: solid 1px #B2B2B2;
            background: #E6E6E6;
            border-radius: 3px;
        }
        .tags:hover, .names:hover {
            background: #CCCCCC;
            cursor: pointer;
        }
        .title {
            background: #337ab7;
            font-size: 15px;
            padding: 5px;
            border: solid 1px #B2B2B2;
            border-radius: 3px;
            color: #ffffff;
            font-weight: bold;
        }
        </style>
        <script>
        jQuery(document).ready(function() {
            $(".tags").click(function() {
                window.location.href = "index.php?tag="+$(this).html();
            });
            $(".names").click(function() {
                window.location.href = "index.php?name="+$(this).html();
            });
        });
        </script>
    <head>

    <body>
        <div class="container">
            <div class="header clearfix">
                <nav>
                    <ul class="nav nav-pills pull-right">
                        <li role="presentation" class="active"><a href="#">Home</a></li>
                        <li role="presentation"><a href="#">About</a></li>
                        <li role="presentation"><a href="#">Contact</a></li>
                    </ul>
                </nav>
                <h3 class="text-muted">Personafi</h3>
            </div>
            <div class="jumbotron">
            <h1>Personafi</h1>
                <p class="lead"></p>
            </div>
            <div class="row searchContainer">
                <div class="col-lg-6">
                    <form id="nameSearch" action="index.php" method="GET">
                        <label class="searchLabel"> Name: </label>
                        <input type="text" name="name" class="inputBox" />
                        <input class="btn btn-lg btn-success" type="submit" value="Search" />
                    </form>
                </div>
                <div class="col-lg-6">
                    <form id="tagSearch" action="index.php" method="GET">
                        <label class="searchLabel"> Keyword: </label>
                        <input type="text" name="tag" class="inputBox" />
                        <input class="btn btn-lg btn-success" type="submit" value="Search" />
                    </form>
                </div>
            </div>
            <div class="row searchResult">
<?php

if (isset($_GET["name"]) || isset($_GET["tag"])) {

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
        echo "<h3 class='col-lg-12 searchFor'>$name</h3>";
        $sql = "SELECT DISTINCT tag, relevance FROM Tag INNER JOIN Contact ON Contact.id = Tag.c_id WHERE name LIKE '%$name%' GROUP BY tag ORDER BY relevance DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='col-lg-8'><p class='title'>Tags</p></div>";
            echo "<div class='col-lg-4'><p class='title'>Relevance</p></div>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-8'><p class='tags'>" . $row["tag"] . "</p></div>";
                echo "<div class='col-lg-4'><p class='relevances'>" . $row["relevance"] . "</p></div>";
            }
        }
    } 

    if (isset($_GET["tag"])) {
        $tag = $_GET["tag"];
        echo "<h3 class='col-lg-12 searchFor'>$tag</h3>";
        $sql = "SELECT DISTINCT name FROM Contact INNER JOIN Tag ON Tag.c_id = Contact.id WHERE Tag.tag LIKE '%$tag%' GROUP BY name";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='col-lg-6'><p class='title'>Names</p></div>";
            echo "<div class='col-lg-6'><p class='title'>Names</p></div>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-6'><p class='names'>" . $row["name"] . "</p></div>";
            }
        }
    }

}
?>
            </div>
            <footer class="footer">
                <p>&copy; Personafi 2014</p>
            </footer>
        </div>
    </body>
</html>
