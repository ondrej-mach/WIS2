<?php 
    require_once 'includes/authorization-inc.php'; 
    if (!is_student()) {
        dieForbidden();
    }
    $uid = getUID();
?>

<!DOCTYPE html>
<html>
  
<?php 
include_once 'templates/header.php';
include_once 'templates/navbar.php';
require_once 'includes/courses-inc.php';
require_once 'includes/users-inc.php';
require_once 'includes/student-inc.php';

$stud_courses = getStudentCourses($uid);
?>

<div id="button_back" ><a href=index.php>Back to index</a></div><br/>
</section>

<div id="courses_student">

<section class="section_table">
<h3>My Courses</h3>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Full name</th>
            <th>Guarantor</th>
            <th>Credits</th>
            <th>Capacity</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($stud_courses as $course) {
            if ($course->approved == 0) {
                continue;
            }

            # don't care about bot currently running courses
            $course = getCourseByID($course->courseID);
            if (!($course->courseState == 10)) {
                continue;
            }

            $guarantor = getUserByID(getGuarantorID($course->courseID));
            $detailURL = 'resultscourse.php?courseID='.$course->courseID.'&studentID='.$uid;
            $courseURL = 'studentcourse.php?courseID='.$course->courseID;
          
            echo "<tr>";
            echo "<td>" . $course->courseName . "</td>";
            echo "<td>" . $course->courseFullName . "</td>";
            echo "<td>" . $guarantor->accountRealName . "</td>";
            echo "<td>" . $course->courseCredits . "</td>";
            $students = getStudents($course->courseID);
            echo "<td>" . count($students) ."/". $course->courseCapacity ."</td>";
            echo "<td><a href=\"$detailURL\">My results</a></td>";
            echo "<td><a href=\"$courseURL\">Course details</a></td>";
            echo "</tr>";
        }

    ?>
    </tbody>
</table>
</section>

<?php
    # hide if all courses are approved
    $display = 0;
    foreach ($stud_courses as $course) {
        if ($course->approved == 1) {
            continue;
        }
        else {
            $display++;
        }
    }
    $display = $display ? ';' : 'none;';
?>
<section class="section_table" style="display:<?php echo $display?>">
<h3>Waiting for approval</h3>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Full name</th>
            <th>Guarantor</th>
            <th>Credits</th>
            <th>Capacity</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php

        foreach ($stud_courses as $course) {
            if ($course->approved == 1) {
                continue;
            }
            $course = getCourseByID($course->courseID);
            if (!($course->courseState == 10)) {
                continue;
            }
            
            $removeCourseURL = 'registercourse.php?courseID='.$course->courseID.'&studentID='.$uid.'&action=remove';
            
            echo "<tr>";
            echo "<td>" . $course->courseName . "</td>";
            echo "<td>" . $course->courseFullName . "</td>";
            echo "<td>" . $guarantor->accountRealName . "</td>";
            echo "<td>" . $course->courseCredits . "</td>";
            $students = getStudents($course->courseID);
            echo "<td>" . count($students) ."/". $course->courseCapacity ."</td>";
            echo "<td><a href=\"$removeCourseURL\">Remove</a></td>";
            echo "</tr>";
        }

    ?>
    </tbody>
</table>
</section>

<?php
    # hide if no courses are available
    $display = 0;
    $courses = getCourses();
    $stud_courses = getStudentCourses($uid);
    $stud_coursesID = array();
    foreach ($stud_courses as $attend) {
        $stud_coursesID[] = $attend->courseID;
    }
    foreach ($courses as $course) {            
        if (in_array($course->courseID, $stud_coursesID)) {
            continue;
        }
        else {
            $display++;
        }
    }
    $display = $display ? ';' : 'none;';
?>
<section class="section_table" style="display:<?php echo $display?>">
<h3>Other courses</h3>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Full name</th>
            <th>Guarantor</th>
            <th>Credits</th>
            <th>Capacity</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php

        foreach ($stud_courses as $attend) {
            $stud_coursesID[] = $attend->courseID;
        }
        foreach ($courses as $course) {            
            if (in_array($course->courseID, $stud_coursesID)) {
                continue;
            }
            $course = getCourseByID($course->courseID);
            if (!($course->courseState == 10)) {
                continue;
            }
            $guarantor = getUserByID(getGuarantorID($course->courseID));
            $addCourseURL = 'registercourse.php?courseID='.$course->courseID.'&studentID='.$uid.'&action=add';
            
            echo "<tr>";
            echo "<td>" . $course->courseName . "</td>";
            echo "<td>" . $course->courseFullName . "</td>";
            echo "<td>" . $guarantor->accountRealName . "</td>";
            echo "<td>" . $course->courseCredits . "</td>";
            $students = getStudents($course->courseID);
            echo "<td>" . count($students) ."/". $course->courseCapacity ."</td>";
            echo "<td><a href=\"$addCourseURL\">Register</a></td>";
            echo "</tr>";
        }

    ?>
    </tbody>
</table>
</section>
</div>

<?php include_once 'templates/footer.php' ?>

</html> 
