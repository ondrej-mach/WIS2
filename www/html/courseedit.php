<?php
    require_once 'includes/authorization-inc.php';
    
    if (!isset($_GET['courseID'])) {
        exit 'Wrong parameters';
    }
    
    $courseID = $_GET['courseID'];
    $new = ($courseID == 'new');
    
    $permitted = false;
    
    if (is_admin()) {
        $permitted = true;
        
    } elseif (is_teacher()) {
        if ($new) {
            $permitted = true;
            
        } elseif ($GLOBALS['user']->accouuntID == getGuarantor($courseID)) {
            $permitted = true;
        }
    }
    
    if (!$permitted) {
        http_response_code(403);
        die('Forbidden');
    }
?>


<!DOCTYPE html>
<html>
  
  <?php include_once 'templates/header.php' ?>
  <?php include_once 'templates/navbar.php' ?>
  
  <form method="POST" action="<?php echo $new ? 'addcourse.php' : 'modifycourse.php'; ?>" >
    
    <?php
        require_once 'includes/courses-inc.php';
        $course = $new ? getEmptyCourse() : getCourseByID($courseID);
        
        echo '<input type="hidden" name="courseID" value="'.$courseID.'" />';
        
        echo '<label>Name
            <input name="accountUsername" type="text"
            value="'.$course->courseName.'">
            </label><br/>';
        
    ?>
    
    <button type="submit" name="submit"><?php echo $courseID == 'new' ? >Update</button>
    </form>

  <?php include_once 'templates/footer.php' ?>

</html>
