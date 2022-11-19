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

    if (!isset($_GET['courseID'])) {
        exit('Wrong parameters');
    }

    if (!doesStudentAttend($_GET['courseID'], getUID())) {
        dieForbidden();
    }

    $course = getCourseByID($_GET['courseID']);
?>

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

			echo "<tr>";
			echo "<td>" . $term->termName . "</td>";
			echo "<td>" . $term->termDate . "</td>";
            echo "<td>" . $term->termMaxPoints . "</td>";
            echo "<td>" . $term->points . "</td>";
            echo "<td>" . $lecturerName . "</td>";
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
			echo "<td>" . $term->date . "</td>";
            echo "<td>" . $term->termMaxPoints . "</td>";
            echo "<td><a href=\"registerterm.php?termID=" . $term->termID . "\">Register</a></td>";
			echo "</tr>";
		}
  	?>
  	</tbody>
</table>

</section>
</div>

<?php include_once 'templates/footer.php' ?>

</html> 
