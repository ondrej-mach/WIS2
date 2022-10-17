<?php
    require_once 'includes/authorization-inc.php';
    assert_logged_in();
    
    if (!isset($_GET['courseID'])) {
        exit('Wrong parameters');
    }
    
    $courseID = $_GET['courseID'];
    $new = ($courseID == 'new');
    
    $permitted = false;
    
    if (is_admin()) {
        $permitted = true;
        
    } elseif (is_teacher()) {
        require_once 'includes/courses-inc.php';
        
        if ($new) {
            $permitted = true;
            
        } elseif (getUID() == getGuarantorID($courseID)) {
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
  
  <form method="POST" 
    action="<?php echo $new ? 'addcourse.php' : 'modifycourse.php'; ?>" 
    >
    
    <?php
        require_once 'includes/courses-inc.php';
        $course = $new ? getEmptyCourse() : getCourseByID($courseID);
        
        echo '<input type="hidden" name="courseID" value="'.$courseID.'" />';
        
        echo '<label>Name
            <input name="courseName" type="text"
            value="'.$course->courseName.'">
            </label><br/>';
            
        echo '<label>Full name
            <input name="courseFullName" type="text"
            value="'.$course->courseFullName.'">
            </label><br/>';
            
        echo '<label>Description
            <input name="courseDescription" type="text"
            value="'.$course->courseDescription.'">
            </label><br/>';
        
        # TODO
        echo '<label>Lecturers TODO
            </label><br/>';
            
        if (is_admin()) {
            # TODO drop down list of teachers
            require_once 'includes/useradd-inc.php';
            require_once 'includes/teachers-inc.php';
            
            echo '<label>Guarantor
            <select name="guarantorID">
            <optgroup label="Current guarantor">';
            
            $gid = getGuarantorID($courseID);
            echo '<option value="">'.getUserByID($gid)->accountRealName.'</option>';
            
            echo '</optgroup><optgroup label="Lectors">';
            
            $lectorIDs = getLectorIDs($courseID);
            $displayed = array_diff($lectorIDs, [$gid]);
            foreach ($displayed as $lectorID) {
                echo '<option value="">'.getUserByID($lectorID)->accountRealName.'</option>';
            }
            
            echo '</optgroup><optgroup label="Others">';
            
            $teacherIDs = getTeacherIDs($courseID);
            $displayed = array_diff($teacherIDs, $lectorIDs);
            foreach ($displayed as $lectorID) {
                echo '<option value="">'.getUserByID($lectorID)->accountRealName.'</option>';
            }
            
            echo '</optgroup></select></label><br/>';
            
            
        }
        
        if ($new) {
            echo '<button type="submit" name="submit">Create</button>';
        } else {
            echo '<button type="submit" name="submit">Update</button>';
        }
    ?>
    
    
    </form>

  <?php include_once 'templates/footer.php' ?>

</html>
