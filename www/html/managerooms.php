<?php
    require_once 'includes/authorization-inc.php';
    assert_admin();
?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>

<div id="manage_rooms">
    
<h3>Manage Rooms</h3>

<section class="section_table">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Desc</th>
                <th></th>
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
    <form action=addroom.php>
        <label>Add room
            <input name="roomName" type="text">
        </label>
        <button type="submit" name="submit">Add</button>
    </form>
</section>

<?php include_once 'templates/footer.php' ?>

</html>