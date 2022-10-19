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
  
  <h3>Course info</h3>
  
  <form method="POST" 
    action="<?php echo 'modifycourse.php'; ?>" 
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
            
        if (is_admin()) {
            require_once 'includes/users-inc.php';
            require_once 'includes/teachers-inc.php';
            
            # Course guarantor selector
            echo '<label>Guarantor
            <select name="courseGuarantor">
            <optgroup label="Current guarantor">';
            
            $gid = getGuarantorID($courseID);
            echo '<option value="'.$gid.'">'.getUserByID($gid)->accountRealName.'</option>';
            
            echo '</optgroup><optgroup label="Lecturers">';
            
            $lecturerIDs = getLecturerIDs($courseID);
            foreach ($lecturerIDs as $id) {
                echo '<option value="'.$id.'">'.getUserByID($id)->accountRealName.'</option>';
            }
            
            echo '</optgroup><optgroup label="Others">';
            
            $teacherIDs = getTeacherIDs($courseID);
            $displayed = array_diff($teacherIDs, $lecturerIDs);
            $displayed = array_diff($displayed, [$gid]);
            foreach ($displayed as $id) {
                echo '<option value="'.$id.'">'.getUserByID($id)->accountRealName.'</option>';
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
  
  
  <h3>Lecturers</h3>
  
  <!-- TABLE OF LECTURERS -->
  <table style='border: solid 1px black;'>
  <tr>
    <th>Username</th>
    <th>Name</th>
    <th>Remove</th>
  </tr>
    <?php
        require_once 'includes/users-inc.php';
        $lecturers = getLecturerIDs($courseID);
        foreach ($lecturers as $id) {
            $user = getUserByID($id);
            
            $removeURL = "removelecturer.php?courseID=$courseID&lecturerID=$id";
            echo "<tr>";
            echo "<td>" . $user->accountUsername . "</td>";
            echo "<td>" . $user->accountRealName . "</td>";
            echo "<td><a href=\"$removeURL\">Remove</a></td>";
            echo "</tr>";
        }
    ?>
  </table>
  
  <!-- SELECTOR FOR NEW LECTURERS -->
  <form method="GET" action="addlecturer.php" >
    <?php
        require_once 'includes/courses-inc.php';
        $course = $new ? getEmptyCourse() : getCourseByID($courseID);
        
        echo '<input type="hidden" name="courseID" value="'.$courseID.'" />';
        
        require_once 'includes/users-inc.php';
        require_once 'includes/teachers-inc.php';
        
        # Course lecturer selector
        echo '<label>Lecturer<select name="lecturerID">';
        $teacherIDs = getTeacherIDs($courseID);
        $displayed = array_diff($teacherIDs, getLecturerIDs($courseID));
        $displayed = array_diff($displayed, [getGuarantorID($courseID)]);
        foreach ($displayed as $id) {
            echo '<option value="'.$id.'">'.getUserByID($id)->accountRealName.
            '</option>';
        }
        echo '</select></label>';
    ?>
    <button type="submit" name="submit">Add</button>
  </form>
  
  
  <h3>Terms</h3>
  
  <!-- TABLE OF TERMS -->
  <table style='border: solid 1px black;'>
  <tr>
    <th>Username</th>
    <th>Name</th>
    <th>Remove</th>
  </tr>
    <?php
        require_once 'includes/users-inc.php';
        $lecturers = getLecturerIDs($courseID);
        foreach ($lecturers as $id) {
            $user = getUserByID($id);
            
            $removeURL = "removelecturer.php?courseID=$courseID&lecturerID=$id";
            echo "<tr>";
            echo "<td>" . $user->accountUsername . "</td>";
            echo "<td>" . $user->accountRealName . "</td>";
            echo "<td><a href=\"$removeURL\">Remove</a></td>";
            echo "</tr>";
        }
    ?>
  </table>
  

  <?php include_once 'templates/footer.php' ?>

</html>
