<?php
    require_once 'includes/authorization-inc.php';
    if (!is_student()) {
        dieForbidden();
    }
?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>

<div id="manage_courses_s">

<h3>My courses</h3>

<section class="section_table">

<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Full name</th>
			<th>Credits</th>
			<th>Points</th>

			<th>Details</th>
		</tr>
	</thead>
	<tbody>
	<?php

		require_once 'includes/courses-inc.php';
		require_once 'includes/users-inc.php';
		require_once 'includes/student-inc.php';

		$courses = getCoursesForStudent(getUID());
		$courseIDs = [];
		foreach ($courses as $course) {
			#TODO can be done better by modifying SQL query
			if (in_array($course->courseID, $courseIDs)) {
				continue;
			}
			else {
				array_push($courseIDs, $course->courseID);
			}

			$courseDetailURL = 'studentcourse.php?courseID='.$course->courseID;

			echo "<tr>";
			echo "<td>" . $course->courseName . "</td>";
			echo "<td>" . $course->courseFullName . "</td>";
            echo "<td>" . $course->courseCredits . "</td>";
			echo "<td>" . getCourseTotalPoints($course->courseID, getUID()) . "</td>";
            echo "<td><a href=\"" . $courseDetailURL . "\">Details</a></td>";
			echo "</tr>";
		}
  	?>
  	</tbody>
</table>

</section>
</div>

<?php include_once 'templates/footer.php' ?>

</html> 
