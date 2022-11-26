<?php
    require_once 'includes/authorization-inc.php';
    require_once 'includes/courses-inc.php';
    require_once 'includes/users-inc.php';

    if (!isset($_GET['courseID'])) {
        exit('Wrong parameters');
    }
    $courseID = $_GET['courseID'];

    $course = getCourseByID($courseID);
?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>

<div id="button_back" ><a href=viewcourses.php>Back to courses</a></div><br/>
</section>

<section class="view_term">

<span>
<h1><?php echo $course->courseName . " - " . $course->courseFullName ?></h1>
</span>

<span>
<h5>Description</h5>
<?php echo $course->courseDescription ?>
</span>
<span>
<h5>Credits</h5>
<?php echo $course->courseCredits ?>
</span>

<span>
<h5>Capacity</h5>
<?php echo getCourseSignedUpNumber($courseID) . "/" . $course->courseCapacity?>
</span>

<span>
<h5>Guarantor</h5>
<?php
    $guarantor = getUserByID(getGuarantorID($course->courseID));
    echo $guarantor->accountRealName . " (" . $guarantor->accountUsername . ")";
?>
</span>
</section>

<?php include_once 'templates/footer.php' ?>

</html> 
