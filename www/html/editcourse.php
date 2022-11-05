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
    <section class="section_form">

    <?php
    if (is_admin()) {
        echo "<a class=\"button_back\" href=admincourses.php>Back to courses</a><br/>";
    }
    ?>

    <div>
    <form method="POST" action="<?php echo 'modifycourse.php'; ?>">
    
    <?php
        require_once 'includes/courses-inc.php';
        $course = $new ? getEmptyCourse() : getCourseByID($courseID);
        
        echo '<input type="hidden" name="courseID" value="'.$courseID.'" />';
        
        $courseName = isset($course->courseName) ? $course->courseName : '';
        echo '<label>Name
            <input name="courseName" type="text"
            value="'.$courseName.'">
            </label><br/>';
            
        $courseFullName = isset($course->courseFullName) ? $course->courseFullName : '';
        echo '<label>Full name
            <input name="courseFullName" type="text"
            value="'.$courseFullName.'">
            </label><br/>';
            
        $courseDescription = isset($course->courseDescription) ? $course->courseDescription : '';
        echo '<label>Description
            <input name="courseDescription" type="text"
            value="'.$courseDescription.'">
            </label><br/>';

        $courseCredits = isset($course->courseCredits) ? $course->courseCredits : '';
        echo '<label>Credits
            <input name="courseCredits" type="number"
            value="'.$courseCredits.'">
            </label><br/>';

        $courseCapacity = isset($course->courseCapacity) ? $course->courseCapacity : '';
        echo '<label>Capacity
            <input name="courseCapacity" type="number"
            value="'.$courseCapacity.'">
            </label><br/>';
            
        if (is_admin()) {
            require_once 'includes/users-inc.php';
            require_once 'includes/teachers-inc.php';
            
            # Course guarantor selector
            
            echo '<label>Guarantor <select name="courseGuarantor">';
            echo '<optgroup label="Current guarantor">';
            
            $gid = getGuarantorID($courseID);
            echo '  <option value="'.$gid.'">'.getUserByID($gid)->accountRealName.'</option>';
            echo '</optgroup>';
            echo '<optgroup label="Lecturers">';
                            
            $lecturerIDs = getLecturerIDs($courseID);
            foreach ($lecturerIDs as $id) {
                echo '<option value="'.$id.'">'.getUserByID($id)->accountRealName.'</option>';
            }
            
            echo '</optgroup>';
        
            echo '<optgroup label="Others">';
            
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
    </div>
  
  
        <h3>Lecturers</h3>
        <section class="section_table">
        <!-- TABLE OF LECTURERS -->
            <table>
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
    </section>
  
    <!-- SELECTOR FOR NEW LECTURERS -->
    <section class="section_form">
        <div>
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
        </div>
    </section>
  
  
  <h3>Terms</h3>
  
    <!-- TABLE OF TERMS -->
    <section class="section_table">
        <table>
            <thead>
                <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Max points</th>
                <th>Auto registration</th>
                <th>Remove</th>
                <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require_once 'includes/terms-inc.php';
                    $terms = getTerms($courseID);
                    foreach ($terms as $term) {
                        $removeURL = "removeterm.php?courseID=$term->termID";
                        $editURL = "editterm.php?termID=$term->termID&courseID=$courseID";
                        echo "<tr>";
                        echo "<td>" . $term->termName . "</td>";
                        echo "<td>" . $term->termDate . "</td>";
                        echo "<td>" . $term->termMaxPoints . "</td>";
                        echo "<td>" . $term->termAutoregistered . "</td>";
                        echo "<td><a href=\"$removeURL\">Remove</a></td>";
                        echo "<td><a href=\"$editURL\">Edit</a></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    

    <?php 
        echo "<a href=\"editterm.php?termID=new&courseID=$courseID\">Add term</a>";
        include_once 'templates/footer.php'
    ?>
    </section>
    </html>
