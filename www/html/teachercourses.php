<?php
    require_once 'includes/authorization-inc.php';
    if (!is_teacher()) {
        dieForbidden();
    }
?>

<!DOCTYPE html>
<html>
  
  <?php include_once 'templates/header.php' ?>
  <?php include_once 'templates/navbar.php' ?>
  
  <h3>My courses</h3>
  <table style='border: solid 1px black;'>
  <tr>
    <th>Name</th>
    <th>Full name</th>
    <th>State</th>
    <th>Evaluate</th>
    <th>Edit</th>
  </tr>
  
<?php

require_once 'includes/courses-inc.php';
require_once 'includes/useradd-inc.php';
require_once 'includes/teachers-inc.php';

$courses = getCoursesForTeacher(getUID());

foreach ($courses as $course) {
    $editCourseURL = 'editcourse.php?courseID=' . $course->courseID;
    $evaluateCourseURL = 'editcourse.php?courseID=' . $course->courseID;
  
    echo "<tr>";
    echo "<td>" . $course->courseName . "</td>";
    echo "<td>" . $course->courseFullName . "</td>";
    echo "<td>" . courseStateToString($course->courseState) . "</td>";
    echo "<td><a href=\"$evaluateCourseURL\">Evaluate</a></td>";
    if ($course->is_guarantor) {
        echo "<td><a href=\"$editCourseURL\">Edit</a></td>";
        echo "<td/>";
    }
    echo "</tr>";
}

?>
  </table>

  <a href="editcourse.php?courseID=new" >Create new course</a><br/>

  <?php include_once 'templates/footer.php' ?>

</html> 
