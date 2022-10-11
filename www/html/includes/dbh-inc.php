<?php
    $servername = $_ENV['MYSQL_SERVER_NAME'];
    $username = $_ENV['MYSQL_USER'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $dbname = $_ENV['MYSQL_DATABASE'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    
    $GLOBALS['conn'] = $conn;
?>
