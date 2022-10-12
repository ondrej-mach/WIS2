<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/authorization-inc.php';
assert_admin();
?>

<!DOCTYPE html>
<html>
  
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php' ?>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/navbar.php' ?>
  
   <?php
   
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Username</th><th>Name</th><th>Email</th><th>Student</th><th>Teacher</th><th>Admin</th></tr>";

function printBool($x) {
    $text = $x ? 'yes' : 'no';
    $color = $x ? 'green' : 'red';
    return "<td style=\"color:$color\">$text</td>";
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/dbh-inc.php';

$conn = $GLOBALS['conn'];
$stmt = $conn->prepare("SELECT * FROM Account");
$stmt->execute();

while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $user['accountUsername'] . "</td>";
    echo "<td>" . $user['accountRealname'] . "</td>";
    echo "<td>" . $user['accountEmail'] . "</td>";
    echo "<td>" . $user['accountStudent'] . "</td>";
    echo "<td>" . $user['accountTeacher'] . "</td>";
    echo printBool($user['accountAdmin']);
    echo "</tr>";
}


echo "</table>";
?>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php' ?>

</html>

