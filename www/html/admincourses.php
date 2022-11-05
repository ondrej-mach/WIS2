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
  <thead>
    <tr>
      <th>Name</th>
      <th>Full name</th>
      <th>Guarantor</th>
      <th>Credits</th>
      <th>Capacity</th>
      <th>State</th>
      <th>Edit</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  
<?php

require_once 'includes/courses-inc.php';
require_once 'includes/users-inc.php';

$courses = getCourses();

foreach ($courses as $course) {
    $editCourseURL = 'editcourse.php?courseID=' . $course->courseID;
    $deleteCourseURL = 'deletecourse.php?courseID=' . $course->courseID;
    $guarantor = getUserByID(getGuarantorID($course->courseID));
  
    echo "<tr>";
    echo "<td>" . $course->courseName . "</td>";
    echo "<td>" . $course->courseFullName . "</td>";
    echo "<td>" . $guarantor->accountRealName . "</td>";
    echo "<td>" . $course->courseCredits . "</td>";
    echo "<td>" . $course->courseCapacity . "</td>";
    echo "<td>" . courseStateToString($course->courseState) . "</td>";
    echo "<td><a href=\"$editCourseURL\">Edit</a></td>";
    echo "<td><a href=\"$deleteCourseURL\">Delete</a></td>";
    echo "</tr>";
}

?>
  </tbody>
  </table>
  <form action=createcourse.php method="POST">
    <label>Add course with ID
      <input name="courseName" type="text">
    </label>
    <button type="submit" name="submit">Add</button>
  </form>
</section>

  <?php include_once 'templates/footer.php' ?>

</html>
