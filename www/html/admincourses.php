<?php
    require_once 'includes/authorization-inc.php';
    assert_admin();
?>

<!DOCTYPE html>
<html>
  
<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>

<div id="button_back" ><a href=index.php>Back to index</a></div><br/>
</section>

<div id="manage_courses_a">

<section class="section_table">
<h3>Manage Courses</h3>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Full name</th>
            <th>Guarantor</th>
            <th>Credits</th>
            <th>Capacity</th>
            <th>State</th>
            <th>Terms</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php
        require_once 'includes/courses-inc.php';
        require_once 'includes/users-inc.php';

        $courses = getCourses();

        foreach ($courses as $course) {
            # don't care about concepts
            if ($course->courseState == 0) {
                continue;
            }
            $editCourseURL = 'editcourse.php?courseID=' . $course->courseID;
            $summaryCourseURL = 'coursesummary.php?courseID=' . $course->courseID;
            $guarantor = getUserByID(getGuarantorID($course->courseID));
          
            echo "<tr>";
            echo "<td>" . $course->courseName . "</td>";
            echo "<td>" . $course->courseFullName . "</td>";
            echo "<td>" . $guarantor->accountRealName . "</td>";
            echo "<td>" . $course->courseCredits . "</td>";
            $students = getStudents($course->courseID);
            echo "<td>" . count($students) ."/". $course->courseCapacity ."</td>";
            echo "<td>" . courseStateToString($course->courseState) . "</td>";
            echo "<td><a href=\"$summaryCourseURL\">Summary</a></td>";
            echo "<td><a href=\"$editCourseURL\">Edit</a></td>";
            echo "</tr>";
        }

    ?>
    </tbody>
</table>
<?php
if (!is_admin()) {
echo '<form action=createcourse.php method="POST">
  <label>Add course with ID
    <input name="courseName" type="text">
  </label>
  <button type="submit" name="submit">Add</button>
</form>';
}
?>
</section>
</div>

<?php include_once 'templates/footer.php' ?>

</html>
