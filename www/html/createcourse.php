<?php
require_once 'includes/authorization-inc.php';
    
if (!(is_teacher() || is_admin())) {
    dieForbidden();
}

$courseName = '';
$badCourseName = false;

if (isset($_POST['courseName'])) {
        if ($_POST['courseName'] == '') {
            $badCourseName = true;
        }
        else {
            require_once 'includes/courses-inc.php';

            $courseName = $_POST["courseName"];
            $courseID = addCourse($courseName, getUID());
            addLecturer($courseID, getUID());
        }
    }

?>

<!DOCTYPE html>
<html>

<?php 
include_once 'templates/header.php';
include_once 'templates/navbar.php';

if (is_admin()) {
    echo "<a class=\"button_back\" href=admincourses.php>Back to courses</a><br/>";
}
?>
<section class="section_form">
    <div>
        <h1>Add new course</h1>

        <form method="POST" action="<?php echo 'modifycourse.php?courseID='.$courseID; ?>" >
            <label <?php if ($badCourseName) echo 'style="color:red"'; ?>>
                <p>Course Name</p>
                <input name="courseName" value="<?php echo $courseName; ?>" type="text">
            </label><br />

            <button type="submit" name="submit">Add course</button>
        </form>
    </div>
</section>

<?php include_once 'templates/footer.php' ?>

</html>