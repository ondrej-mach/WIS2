<?php
require_once 'includes/authorization-inc.php';
assert_admin();
?>

<!DOCTYPE html>
<html>
  
  <?php include_once 'templates/header.php' ?>
  <?php include_once 'templates/navbar.php' ?>
  
  <table style='border: solid 1px black;'>
  <tr>
    <th>Username</th>
    <th>Name</th>
    <th>Email</th>
    <th>Student</th>
    <th>Teacher</th>
    <th>Admin</th>
    <th>Modify</th>
    <th>Delete</th>
  </tr>
  
<?php

function printBool($x) {
    $text = $x ? 'yes' : 'no';
    $color = $x ? 'green' : 'red';
    return "<td style=\"color:$color\">$text</td>";
}

require_once 'includes/dbh-inc.php';

$conn = $GLOBALS['conn'];
$stmt = $conn->prepare("SELECT * FROM Account");
$stmt->execute();

while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $usermodURL = 'usermod.php?accountID=' . $user['accountID'];
    $userdelURL = 'userdel.php?accountID=' . $user['accountID'];
  
    echo "<tr>";
    echo "<td>" . $user['accountUsername'] . "</td>";
    echo "<td>" . $user['accountRealName'] . "</td>";
    echo "<td>" . $user['accountEmail'] . "</td>";
    echo printBool($user['accountStudent']);
    echo printBool($user['accountTeacher']);
    echo printBool($user['accountAdmin']);
    echo "<td><a href=\"$usermodURL\">Modify</a></td>";
    echo "<td><a href=\"$userdelURL\">Delete</a></td>";
    echo "</tr>";
}


echo "</table>";
?>

<a href=useradd.php>Add user</a><br/>

  <?php include_once 'templates/footer.php' ?>

</html>

