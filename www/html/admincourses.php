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
    <th>Name</th>
    <th>Modify</th>
  </tr>
  
<?php

require_once 'includes/rooms-inc.php';

$courses = getCourses();
foreach ($coures as $course) {
    $modifyCourseURL = 'modifycourse.php?courseID=' . $room->roomID;
  
    echo "<tr>";
    echo "<td>" . $room->roomName . "</td>";
    echo "<td><a href=\"$modifyRoomURL\">Modify</a></td>";
    echo "</tr>";
}


echo "</table>";
?>

<h3>Add new room</h3>
  
  <form action=addroom.php>
    <label>New room name
      <input name="roomName" type="text">
    </label><br/>
    <button type="submit" name="submit">Add room</button>
  </form>

  <?php include_once 'templates/footer.php' ?>

</html>
