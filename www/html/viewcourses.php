<?php 
    require_once 'includes/authorization-inc.php'; 
?>

<!DOCTYPE html>
<html>
  
<?php 
include_once 'templates/header.php';
include_once 'templates/navbar.php';
require_once 'includes/courses-inc.php';
?>

<div id="button_back" ><a href=index.php>Back to index</a></div><br/>
</section>

<div id="courses_unregistered">

<section class="section_table">
<h3>Available courses</h3>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Full name</th>
            <th>Credits</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php
        $courses = getApprovedCourses();

        foreach ($courses as $course) {
            $courseURL = 'detailcourse.php?courseID='.$course->courseID;
          
            echo "<tr>";
            echo "<td>" . $course->courseName . "</td>";
            echo "<td>" . $course->courseFullName . "</td>";
            echo "<td>" . $course->courseCredits . "</td>";
            echo "<td><a href=\"$courseURL\">Course details</a></td>";
            echo "</tr>";
        }

    ?>
    </tbody>
</table>
</section>

</div>

<?php include_once 'templates/footer.php' ?>

</html> 
