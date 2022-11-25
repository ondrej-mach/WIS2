<?php
    require_once 'includes/authorization-inc.php';
    require_once 'includes/terms-inc.php';
    require_once 'includes/courses-inc.php';

    assert_logged_in();
    
    if (!isset($_GET['termID']) || !isset($_GET['courseID'])) {
        exit('Wrong parameters');
    }
    
    $courseID = $_GET['courseID'];
    $termID = $_GET['termID'];
    $new = ($termID == 'new');
    $permitted = false;

    if (is_admin()) {
        $permitted = true;
        
    } elseif (is_teacher()) {
        if ($new) {
            $permitted = true;
            
        } elseif (getUID() == getGuarantorID($courseID)) {
            $permitted = true;
        }
    }
    
    if (!$permitted) {
        dieForbidden();
    }
?>


<!DOCTYPE html>
<html>
  
<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>

<?php
    require_once 'includes/terms-inc.php';
    $term = $new ? getEmptyTerm() : getTermByID($termID);
    if ($new) {
        $term->courseID = $_GET['courseID'];
    }
    if (is_admin() || is_teacher()) {
        echo "<div id=\"button_back\" ><a href=editcourse.php?courseID=$term->courseID>Back to edit course</a></div><br/>";
    }
?>

</section>

<section class="section_form">
<h3>Term info</h3>
<?php 
    if (isset($_GET["error"])) 
        echo '<p style="color: red;">Error updating</p>';
?>
<div>
    <form method="POST" action="<?php echo 'modifyterm.php'; ?>" >
    <?php
        echo '<input type="hidden" name="termID" value="'.$termID.'" />';
        echo '<input type="hidden" name="courseID" value="'.$term->courseID.'" />';
        
        echo '<label>Name*
            <input name="termName" type="text"
            value="'.$term->termName.'" required>
            </label><br/>';

        echo '<label>Description
            <input name="termDescription" type="text"
            value="'.$term->termDescription.'">
            </label><br/>';

        $type = $term->termType ?? "Other";
        echo '<label>Type*
            <select name="termType">
                <option '.($type == "Lecture" ? "selected " : "").'value="Lecture">Lecture</option>
                <option '.($type == "Exercise" ? "selected " : "").'value="Exercise">Exercise</option>
                <option '.($type == "Project" ? "selected " : "").'value="Project">Project</option>
                <option '.($type == "Exam" ? "selected " : "").'value="Exam">Exam</option>
                <option '.($type == "Other" ? "selected " : "").'value="Other">Other</option>
            </select>
            </label><br/>';
            
        echo '<label>Date*
            <input name="termDate" type="datetime-local"
            value="'.date("Y-m-d\TH:i", strtotime($term->termDate ?? time())).'" required>
            </label><br/>';

        echo '<label>Length (minutes)
            <input name="termLength" type="number"
            value="'.$term->termLength.'">
            </label><br/>';

        require_once 'includes/rooms-inc.php';
        $rooms = getRooms();
        echo '<label>Room
            <select name="roomID">
                <option '.($new ? "selected" : "").' value="">None</option>';
        foreach ($rooms as $room) {
            echo '<option '.($room->roomID == $term->roomID ? "selected " : "").'value="'.$room->roomID.'">'.$room->roomName.'</option>';
        }
        echo '</select>
            </label><br/>';
        
            $terms = getTerms($term->courseID);
            $max = 100;
            foreach ($terms as $t) {
                if ($t->termID != $termID) {
                    $max -= $t->termMaxPoints;
                }
            }
        echo '<label>Max points*
            <input name="termMaxPoints" type="number"
            min = "0" max = "'.$max.'"
            value="'.$term->termMaxPoints.'" required>
            </label><br/>';

        echo '<label>Auto register
            <input name="termAutoregistered" type="hidden" value="off" >
            <input name="termAutoregistered" type="checkbox" '.($term->termAutoregistered ? "checked" : "").'>
            </label><br/>';
        if ($new) {
            echo '<button type="submit" name="submit">Create</button>';
        } else {
            echo '<button type="submit" name="submit">Update</button>';
        }
    ?>
    </form>
</div>
</section>

<?php include_once 'templates/footer.php' ?>

</html>
 
