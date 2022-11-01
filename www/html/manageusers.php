<?php
require_once 'includes/authorization-inc.php';
assert_admin();
?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>
<section id="section_user_management">
    <table id="table_users">
        <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Address</th>
                <th>Date of birth</th>
                <th>Email</th>
                <th>Student</th>
                <th>Teacher</th>
                <th>Admin</th>
                <th>Actions</th>
                <th>
            </tr>
        </thead>
        <tbody>

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
    echo "<td>" . $user['accountAddress'] . "</td>";
    echo "<td>" . $user['accountDateOfBirth'] . "</td>";
    echo "<td>" . $user['accountEmail'] . "</td>";
    echo printBool($user['accountStudent']);
    echo printBool($user['accountTeacher']);
    echo printBool($user['accountAdmin']);
    echo "<td><a href=\"$usermodURL\">Edit</a></td>";
    echo "<td><a href=\"$userdelURL\">Delete</a></td>";
    echo "</tr>";
}
?>
        </tbody>
    </table>
    <a id="user_add" href=useradd.php>Add user</a><br />
</section>

<?php include_once 'templates/footer.php' ?>

</html>