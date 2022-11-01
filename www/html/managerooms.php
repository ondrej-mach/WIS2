<?php
    require_once 'includes/authorization-inc.php';
    assert_admin();
?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>

<section id="section_manage_rooms">
    <table style='border: solid 1px black;'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Desc</th>
                <th>
                <th>
            </tr>
        </thead>
        <tbody>
            <?php

require_once 'includes/rooms-inc.php';

$rooms = getRooms();
foreach ($rooms as $room) {
  $modifyRoomURL = 'roommod.php?roomID=' . $room->roomID;
  $deleteRoomURL = 'roomdel.php?roomID=' . $room->roomID;

  echo "<tr>";
  echo "<td>" . $room->roomID . "</td>";
  echo "<td>" . $room->roomName . "</td>";
  echo "<td>" . $room->roomDescription . "</td>";
  echo "<td><a href=\"$modifyRoomURL\">Edit</a></td>";
  echo "<td><a href=\"$deleteRoomURL\">Delete</a></td>";
  echo "</tr>";
}
?>
        </tbody>
    </table>
</section>

<h2>Add new room</h2>

<form action=addroom.php>
    <label>New room name
        <input name="roomName" type="text">
    </label><br />
    <button type="submit" name="submit">Add room</button>
</form>

<?php include_once 'templates/footer.php' ?>

</html>