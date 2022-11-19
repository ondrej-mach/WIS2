<?php
function dbh_init() {
    if (!isset($GLOBALS['conn'])) {
        if(is_readable(__DIR__.'/secrets.php')) {
            require_once 'secrets.php';
        } else {
            $servername = $_ENV['MYSQL_SERVER_NAME'];
            $username = $_ENV['MYSQL_USER'];
            $password = $_ENV['MYSQL_PASSWORD'];
            $dbname = $_ENV['MYSQL_DATABASE'];
        }

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=UTF8", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
        $GLOBALS['conn'] = $conn;
    }
}
dbh_init();

