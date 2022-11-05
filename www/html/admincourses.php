<?php
    require_once 'includes/authorization-inc.php';
    assert_admin();
?>

<!DOCTYPE html>
<html>
  
  <?php include_once 'templates/header.php' ?>
  <?php include_once 'templates/navbar.php' ?>
  <section class="section_table">
  <table>
  <tr>
    <th>Name</th>
    <th>Full name</th>
    <th>Guarantor</th>
    <th>State</th>
    <th>Edit</th>
  </tr>
  
<?php

require_once 'includes/courses-inc.php';
require_once 'includes/users-inc.php';

$courses = getCourses();

foreach ($courses as $course) {
    $editCourseURL = 'editcourse.php?courseID=' . $course->courseID;
    $guarantor = getUserByID(getGuarantorID($course->courseID));
  
    echo "<tr>";
    echo "<td>" . $course->courseName . "</td>";
    echo "<td>" . $course->courseFullName . "</td>";
    echo "<td>" . $guarantor->accountRealName . "</td>";
    echo "<td>" . courseStateToString($course->courseState) . "</td>";
    echo "<td><a href=\"$editCourseURL\">Edit</a></td>";
    echo "</tr>";
}

?>
  </table></section>

  <?php include_once 'templates/footer.php' ?>

</html>
