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

<section class="view_term">
<span>
<h1><?php echo $term->termName ?></h1>
</span>

<span>
<h5>Description</h5>
<p><?php echo $term->termDescription ?></p>
</span>

<span>
<h5>Type</h5>
<p><?php echo $term->termType ?></p>
</span>

<span>
<h5>Date</h5>
<p>
<?php
    $time = strtotime($term->termDate);
    if (isset($term->termLength)) {
        echo date('Y-m-d H:i', $time) . " - " . date('H:i', $time + intval($term->termLength) * 60);
    } else {
        echo date('Y-m-d H:i', $time);
    }
?>
</p>
</span>

<?php
    if (isset($term->roomID)){
        require_once 'includes/rooms-inc.php';
        $room = getRoomByID($term->roomID);

        echo "<span><h5>Room</h5>";
        echo '<p>'.$room->roomName.'</p></span>';
    }
?>

<span>
<h5>Max Points</h5>
<p><?php echo $term->termMaxPoints ?></p>
</span>

<?php
    if (isset($term->points)) {
        echo "<span><h5>Points</h5>";
        echo '<p>'.$term->points . " (graded by " . $term->lecturerRealName . ")</p></span>";
    }
?>

<span>
<h5>Automatically registered</h5>
<?php echo $term->termAutoregistered ? "<p>yes</p>" : "<p>no</p>" ?>
</span>

</section>

<?php include_once 'templates/footer.php' ?>

</html> 
