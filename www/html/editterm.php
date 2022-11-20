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

<section class="section_form">

<h3>Term info</h3>

<?php
    require_once 'includes/terms-inc.php';
    $term = $new ? getEmptyTerm() : getTermByID($termID);
    if ($new) {
        $term->courseID = $_GET['courseID'];
    }
    if (is_admin() || is_teacher()) {
        echo "<a class=\"button_back\" href=editcourse.php?courseID=$term->courseID>Back to edit course</a><br/>";
    }
?>
<div>
    <form method="POST" action="<?php echo 'modifyterm.php'; ?>" >
    <?php
        echo '<input type="hidden" name="termID" value="'.$termID.'" />';
        echo '<input type="hidden" name="courseID" value="'.$term->courseID.'" />';
        
        echo '<label>Name
            <input name="termName" type="text"
            value="'.$term->termName.'">
            </label><br/>';

        echo '<label>Description
            <input name="termDescription" type="text"
            value="'.$term->termDescription.'">
            </label><br/>';

        echo '<label>Type
            <select name="termType">
                <option value="Lecture">Lecture</option>
                <option value="Exercise">Exercise</option>
                <option value="Project">Project</option>
                <option value="Exam">Exam</option>
                <option value="Other">Other</option>
            </select>
            </label><br/>';
            
        echo '<label>Date
            <input name="termDate" type="datetime-local"
            value="'.date("Y-m-dTH:i", strtotime($term->termDate)) ?? date("Y-m-dT00:00", time()).'">
            </label><br/>';

        echo '<label>Length (in minutes, not for projects)
            <input name="termLength" type="number"
            value="'.$term->termLength.'">
            </label><br/>';
        
            $terms = getTerms($term->courseID);
            $max = 100;
            foreach ($terms as $t) {
                $max -= $t->termMaxPoints;
            }
        echo '<label>Max points
            <input name="termMaxPoints" type="number"
            min = "0" max = "'.$max.'"
            value="'.$term->termMaxPoints.'">
            </label><br/>';

        echo '<label>Auto register
            <input name="termAutoregistered" type="text"
            value="'.$term->termAutoregistered.'">
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
 
