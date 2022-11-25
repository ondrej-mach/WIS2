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

<?php
    require_once 'includes/courses-inc.php';
    require_once 'includes/terms-inc.php';
    require_once 'includes/student-inc.php';
	require_once 'includes/users-inc.php';
    require_once 'includes/rooms-inc.php';

    if (!isset($_GET['courseID'])) {
        exit('Wrong parameters');
    }

    if (!doesStudentAttend($_GET['courseID'], getUID())) {
        dieForbidden();
    }

    $course = getCourseByID($_GET['courseID']);
?>

<div id="button_back" ><a href=studentcourses.php>Back to courses</a></div><br/>
</section>

<div id="manage_course_s">

<h3><?php echo $course->courseFullName; ?></h3>

<section class="section_table">
<h4>My terms</h4>

<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Date</th>
			<th>Max points</th>
			<th>Points</th>
            <th>Graded by</th>
            <th>
		</tr>
	</thead>
	<tbody>
	<?php
		$terms = getRegisteredTermsByStudent($course->courseID, getUID());
		foreach ($terms as $term) {
			if(isset($term->lecturerID)){
				$lecturerName = getUserByID($term->lecturerID)->accountUsername;
			} else {
				$lecturerName = "";
			}

            $termDetailURL = 'studentterm.php?termID='.$term->termID;

			echo "<tr>";
			echo "<td>" . $term->termName . "</td>";
			echo "<td>" . $term->termDate . "</td>";
            echo "<td>" . $term->termMaxPoints . "</td>";
            echo "<td>" . $term->points . "</td>";
            echo "<td>" . $lecturerName . "</td>";
            echo "<td><a href=\"" . $termDetailURL . "\">Details</a></td>";
			echo "</tr>";
		}
  	?>
  	</tbody>
</table>

</section>
<section class="section_table">
<h4>Unregistered terms</h4>

<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Date</th>
			<th>Max points</th>
            <th>Register</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$terms = getUnregisteredTermsByStudent($course->courseID, getUID());
		foreach ($terms as $term) {

			echo "<tr>";
			echo "<td>" . $term->termName . "</td>";
			echo "<td>" . $term->termDate . "</td>";
            echo "<td>" . $term->termMaxPoints . "</td>";
            echo "<td><a href=\"registerterm.php?termID=" . $term->termID . "\">Register</a></td>";
			echo "</tr>";
		}
  	?>
  	</tbody>
</table>

</section>
<section class="section_table">
<h4>Schedule</h4>

<table>
	<thead>
		<tr>
			<th>Date</th>
            <th>Time</th>
            <th>Room</th>
			<th>Name</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$terms = getFutureTerms($course->courseID, getUID());
		foreach ($terms as $term) {
            $time = strtotime($term->termDate);
			echo "<tr>";
			echo "<td>" . date("Y-m-d", $time) . "</td>";
			echo "<td>" . date("H:i", $time) . " - " . date("H:i", $time + intval($term->termLength) * 60) . "</td>";
            echo "<td>" . $term->roomName . "</td>";
            echo "<td>" . $term->termName . "</td>";
			echo "</tr>";
		}
  	?>
  	</tbody>
</table>

</section>

</div>

<?php include_once 'templates/footer.php' ?>

</html> 
