<?php
    require_once 'includes/authorization-inc.php';
    assert_logged_in();
    
    if (!isset($_GET['courseID'])) {
        exit('Wrong parameters');
    }
    
    require_once 'includes/courses-inc.php';

    $courseID = $_GET['courseID'];
    $new = ($courseID == 'new');
    $permitted = false;
    $is_admin = is_admin();
    $is_guarantor = ($new) ? true : (getUID() == getGuarantorID($courseID));
    
    if ($is_admin) {
        $permitted = true;
        
    } elseif (is_teacher()) {
        if ($new) {
            $permitted = true;
            
        } elseif ($is_guarantor) {
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
    if ($is_admin) {
        echo "<div id=\"button_back\" ><a href=admincourses.php>Back to courses</a></div><br/>";
    }
    if (is_teacher()) {
        echo "<div id=\"button_back\"><a href=teachercourses.php>Back to courses</a></div><br/>";
    }
?>
</section>

<!-- TABLE OF LECTURERS -->

<div id="edit_course">

<section class="section_form">

<h3>Edit course info</h3>
<?php 
    if (isset($_GET["success"])) 
        echo '<p style="color: green;">Successfully updated</p>';
    if (isset($_GET["error"])) 
        echo '<p style="color: red;">Error updating</p>';
?>
<div>
    <form method="POST" action="<?php echo 'modifycourse.php'; ?>">
    <?php
        require_once 'includes/courses-inc.php';
        $course = $new ? getEmptyCourse() : getCourseByID($courseID);
        #TODO maybe remove this entirely? not only disable it
        $disabled = $is_admin ? 'disabled' : '';
        echo '<input type="hidden" name="courseID" value="'.$courseID.'" />';
        
        $courseName = isset($course->courseName) ? $course->courseName : 'short';
        echo "<label>Name*
            <input name=\"courseName\" type=\"text\" $disabled
            value=\"$courseName\" required>
            </label><br/>";
            
        $courseFullName = isset($course->courseFullName) ? $course->courseFullName : 'full name';
        echo "<label>Full name
            <input name=\"courseFullName\" type=\"text\" $disabled
            value=\"$courseFullName\">
            </label><br/>";
            
        $courseDescription = isset($course->courseDescription) ? $course->courseDescription : 'desc';
        echo "<label>Description
            <input name=\"courseDescription\" type=\"text\" $disabled
            value=\"$courseDescription\">
            </label><br/>";

        $courseCredits = isset($course->courseCredits) ? $course->courseCredits : 0;
        echo "<label>Credits*
            <input name=\"courseCredits\" type=\"number\"  min=\"0\" $disabled
            value=\"$courseCredits\" required>
            </label><br/>";

        $courseCapacity = isset($course->courseCapacity) ? $course->courseCapacity : 0;
        echo "<label>Capacity*
            <input name=\"courseCapacity\" type=\"number\" min=\"0\" $disabled
            value=\"$courseCapacity\" required>
            </label><br/>";
        
        $gid = ($courseID == "new") ? getUID() : getGuarantorID($courseID);
        
        if ($is_guarantor) {
            require_once 'includes/users-inc.php';
            require_once 'includes/teachers-inc.php';
            
            # Course guarantor selector
            echo '<label>Guarantor* <select name="courseGuarantor">';
            echo '<optgroup label="Current guarantor">';
            
            
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

        $courseState = isset($course->courseState) ? courseStateToInt($course->courseState) : 0;
        $disp = array($courseState);

        if ($is_admin && ($courseState != 0)) {
            $states = array(5, 10);
            $not_disp = array_diff($states, $disp);
            echo '
            <label>State
            <select name="courseState" value='.$courseState.'>
            <option value='.$courseState.'>'.courseStateToString($courseState).'</option>';

            foreach($not_disp as $value) {
                echo '<option value='.$value.'>'.courseStateToString($value).'</option>';
            }
            echo '</select></label><br/>';
        }

        $uid = getUID();
        # display if user is the course guatantor

        if ($is_guarantor && ($courseState != 10)) {
            $states = array(0, 5);
            $not_disp = array_diff($states, $disp);
            echo '<label>State
                    <select name="courseState" value='.$courseState.'>
                        <option value='.$courseState.'>'.courseStateToString($courseState).'</option>';

            foreach($not_disp as $value) {
                echo '<option value='.$value.'>'.courseStateToString($value).'</option>';
            }
            echo '</select></label><br/>';
        }
        
        if ($is_guarantor) {
            $disabled = (count(getStudents($courseID)) >= $course->courseCapacity) ? "disabled" : "";
            $checked = ($course->courseOpen) ? "checked" : "";
            echo '<label>Open for enrollment
                    <input name="courseOpen" type="hidden" value="off" >
                    <input name="courseOpen" type="checkbox" ' . $checked . $disabled . '>
                </label><br/>';
        }
        
        if ($new) {
            echo '<button type="submit" name="submit">Create</button>';
        } else {
            echo '<button type="submit" name="submit">Update</button>';
        }
    ?>
    </form>
</div>
</section>

<div>
<!-- TABLE OF LECTURERS -->
<section class="section_table">
    <h3>Lecturers</h3>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Contact</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                require_once 'includes/users-inc.php';
                $lecturers = getLecturerIDs($courseID);
                foreach ($lecturers as $id) {
                    $user = getUserByID($id);
                    $removeURL = "removelecturer.php?courseID=$courseID&lecturerID=$id";

                    echo "<tr>";
                    echo "<td>" . $user->accountUsername . "</td>";
                    echo "<td>" . $user->accountRealName . "</td>";
                    echo "<td>" . $user->accountEmail . "</td>";
                    if ($is_guarantor && !$is_admin) {
                        if (($id != getGuarantorID($courseID))) {
                            echo "<td><a href='$removeURL'>Remove</a></td>";
                        } else {
                            echo "<td></td>";
                        }
                    }
                    else {
                        echo "<td></td>";
                    }
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</section>

<!-- SELECTOR FOR NEW LECTURERS -->
<section class="section_form">
    <div>
        <?php
            require_once 'includes/users-inc.php';
            require_once 'includes/teachers-inc.php';
            require_once 'includes/courses-inc.php';
            
            $course = $new ? getEmptyCourse() : getCourseByID($courseID);
            
            # Course lecturer selector
            $teacherIDs = getTeacherIDs($courseID);
            $displayed = array_diff($teacherIDs, getLecturerIDs($courseID));
            $gid = ($courseID == "new") ? getUID() : getGuarantorID($courseID);
            $displayed = array_diff($displayed, [$gid]);
            $displayed_empty = (count($displayed) == 0);

            $display = ($displayed_empty || is_admin()) ? 'style="display: none;"' : '';

            echo '<form method="GET" action="addlecturer.php" ' .$display.'>';

            echo '<input type="hidden" name="courseID" value="'.$courseID.'" />';
            echo '<label>Lecturer<select name="lecturerID">';

            foreach ($displayed as $id) {
                echo '<option value="'.$id.'">'.getUserByID($id)->accountRealName.'</option>';
            } 
            echo '</select>';
            echo '</label>';
            echo '<button type="submit" name="submit"'.($courseID == "new" ? " disabled" : "").'>Add</button>';
            echo '</form>';
        ?>
    </div>
</section>
</div>

<!-- TABLE OF TERMS -->
<section class="section_table">
    <h3>Terms</h3>
    <table>
        <thead>
            <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Max points</th>
            <th>Auto</th>
            <?php
                if (!$is_admin) {
                    echo '<th></th><th></th><th></th>';
                }
            ?>
            </tr>
        </thead>
        <tbody>
            <?php
                require_once 'includes/terms-inc.php';
                $terms = getTerms($courseID);
                foreach ($terms as $term) {
                    $removeURL = "removeterm.php?termID=$term->termID&courseID=$course->courseID";
                    $editURL = "editterm.php?termID=$term->termID&courseID=$courseID";
                    $evaluateURL = "evaluateterm.php?termID=$term->termID";

                    echo "<tr>";
                    echo "<td>" . $term->termName . "</td>";
                    echo "<td>" . $term->termDate . "</td>";
                    echo "<td>" . $term->termMaxPoints . "</td>";
                    echo "<td>" . ($term->termAutoregistered ? "yes" : "no") . "</td>";
                    if (!$is_admin) {
                        echo "<td><a href=\"$evaluateURL\">Evaluate</a></td>";
                        echo "<td><a href=\"$editURL\">Edit</a></td>";
                        echo "<td><a href=\"$removeURL\">Remove</a></td>";
                    }
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
    <?php
    if (!$is_admin && $courseID != "new") {
        echo "<a href=\"editterm.php?termID=new&courseID=$courseID\">Add term</a>";  
    }
    ?>

</section>
</div>

<?php include_once 'templates/footer.php'; ?>

</html>
