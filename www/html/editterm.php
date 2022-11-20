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
<div>
    <form method="POST" action="<?php echo 'modifyterm.php'; ?>" >
    <?php
        echo '<input type="hidden" name="termID" value="'.$termID.'" />';
        echo '<input type="hidden" name="courseID" value="'.$term->courseID.'" />';
        
        echo '<label>Name
            <input name="termName" type="text"
            value="'.$term->termName.'">
            </label><br/>';
            
        echo '<label>Date
            <input name="termDate" type="date"
            value="'.$term->termDate.'">
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
 
