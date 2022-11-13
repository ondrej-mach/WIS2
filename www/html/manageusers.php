<?php
require_once 'includes/authorization-inc.php';
assert_admin();

function printBool($x) {
    $svg = $x ? 
    '<td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
    <path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg>'
    :
    '<td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
    <path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/></svg>';
    return $svg;
}
?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>

<div id="manage_users">

<h3>Manage Users</h3>

<section class="section_table">
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
            <th></th>
            <th>
        </tr>
    </thead>
    <tbody>
        <?php
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