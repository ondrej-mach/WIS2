<?php
    require_once 'includes/authorization-inc.php';
    require_once 'includes/terms-inc.php';

    if (!isset($_GET['termID'])) {
        exit('Wrong parameters');
    }
    $termID = $_GET['termID'];

    if (!is_student() || !isRegisteredToTerm($termID, getUID())) {
        dieForbidden();
    }

    $term = getTermInfo($termID, getUID());
?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>

<div id="button_back" ><a href="studentcourse.php?courseID=<?php echo $term->courseID ?>">Back to course</a></div><br/>
</section>

<div id="view_term">

<h3><?php echo $term->termName ?></h3>

<h5>Description</h5>
<?php echo $term->termDescription ?>

<h5>Type</h5>
<?php echo $term->termType ?>

<h5>Date</h5>
<?php
    $time = strtotime($term->termDate);
    if (isset($term->termLength)) {
        echo date('Y-m-d H:i', $time) . " - " . date('H:i', $time + intval($term->termLength) * 60);
    } else {
        echo date('Y-m-d H:i', $time);
    }
?>

<?php
    if (isset($term->roomID)){
        require_once 'includes/rooms-inc.php';
        $room = getRoomByID($term->roomID);

        echo "<h5>Room</h5>";
        echo $room->roomName;
    }
?>

<h5>Max Points</h5>
<?php echo $term->termMaxPoints ?>

<?php
    if (isset($term->points)) {
        echo "<h5>Points</h5>";
        echo $term->points . " (graded by " . $term->lecturerRealName . ")";
    }
?>

<h5>Automatically registered</h5>
<?php echo $term->termAutoregistered ? "yes" : "no" ?>

</div>

<?php include_once 'templates/footer.php' ?>

</html> 
