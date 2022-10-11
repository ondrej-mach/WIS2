<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/dbh-inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/authorization-inc.php';

?>

<!DOCTYPE html>
<html>
  
  <?php include_once 'templates/header.php' ?>
  <?php include_once 'templates/navbar.php' ?>
  
  <?php
    $servername = $_ENV['MYSQL_SERVER_NAME'];
    $username = $_ENV['MYSQL_USER'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $dbname = $_ENV['MYSQL_DATABASE'];

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  ?> 

  <?php include_once 'templates/footer.php' ?>

</html>
