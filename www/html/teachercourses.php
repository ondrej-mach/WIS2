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

<div id="manage_courses_t">

<h3>My courses</h3>

<section class="section_table">

<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Full name</th>
			<th>State</th>
			<th>Summary</th>
			<th>Evaluate</th>
			<th>Accept</th>
			<th>Edit</th>
			<th>
		</tr>
	</thead>
	<tbody>
	<?php

		require_once 'includes/courses-inc.php';
		require_once 'includes/users-inc.php';
		require_once 'includes/teachers-inc.php';

		$courses = getCoursesForTeacher(getUID());
		$courseIDs = [];
		foreach ($courses as $course) {
			#TODO can be done better by modifying SQL query
			if (in_array($course->courseID, $courseIDs)) {
				continue;
			}
			else {
				array_push($courseIDs, $course->courseID);
			}

			$editCourseURL = 'editcourse.php?courseID='.$course->courseID;
			$acceptStudentsURL = 'acceptstudents.php?courseID='.$course->courseID;
			$deleteCourseURL = 'deletecourse.php?courseID='.$course->courseID;
			$evaluateStudentsURL = 'evaluatecourse.php?courseID='.$course->courseID;
			$courseSummaryURL = 'coursesummary.php?courseID='.$course->courseID;

			echo "<tr>";
			echo "<td>" . $course->courseName . "</td>";
			echo "<td>" . $course->courseFullName . "</td>";
			echo "<td>" . courseStateToString($course->courseState) . "</td>";

			$is_teacher = in_array(getUID(), getLecturerIDs($course->courseID));
			$is_guarantor = (getUID() == getGuarantorID($course->courseID));

			if ($course->courseState == 10) {
				echo "<td><a href=\"$courseSummaryURL\">Summary</a></td>";
				echo "<td><a href=\"$evaluateStudentsURL\">Evaluate</a></td>";
			}
			else {
				echo "<td>";
				echo "<td>";
			}

			if ($is_guarantor && $course->courseState == 10) {
				echo "<td><a href=\"$acceptStudentsURL\">Accept</a></td>";
			}
			else {
				echo "<td>";
			}

			if ($is_guarantor) {

				echo "<td><a href=\"$editCourseURL\">Edit</a></td>";
				echo "<td><a href=\"$deleteCourseURL\">Delete</a></td>";
			} else {
				echo "<td><td>";
			}
			
			echo "</tr>";
		}
  	?>
  	</tbody>
</table>

<a href="editcourse.php?courseID=new" >Create new course</a><br/>
</section>
</div>

<?php include_once 'templates/footer.php' ?>

</html> 
