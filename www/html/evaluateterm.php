<?php 
    require_once 'includes/authorization-inc.php';
    if (!isset($_GET['termID'])) {
        exit('Wrong parameters');
    }
    include_once 'includes/courses-inc.php';
    include_once 'includes/terms-inc.php';
    $termID = $_GET['termID'];
    $term = getTermByID($termID);
    $courseID = $term->courseID;
    $uid = getUID();
    
    $lecturers = getLecturerIDs($courseID);
    if (!(is_teacher() && (in_array($uid, $lecturers) || $uid == getGuarantorID($courseID)))) {
        dieForbidden();
    }
?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php'; ?>
<?php include_once 'templates/navbar.php'; ?>

<?php
    echo "<div id=\"button_back\" ><a href=evaluatecourse.php?courseID=".$courseID.">Back to courses</a></div><br/>";
?>

</section>

<section class="section_table">
<h3> Evaluate term </h3>
<form method="GET" action="evaluate.php">
    <?php #TODO: Add a form to accept students to the course ?>
<table>
    <thead>
        <tr>
            <th>Login</th>
            <th>Name</th>
            <th>Points</th>
            <th>
            <th>
        </tr>
    </thead>
    <tbody>
        <?php
            require_once 'includes/courses-inc.php';
            require_once 'includes/users-inc.php';
            require_once 'includes/student-inc.php';

            $students = getStudents($courseID);

            foreach ($students as $student) {
                
                $check_approved = $student->approved ? "checked" : "";
                $student = getUserByID($student->accountID);
                $points = getStudentPoints($termID, $student->accountID);

                if (!isset($points)) {
                    evaluateTerm($termID, $student->accountID, $uid, 0);
                }
                
                echo '<tr>';
                echo '<td>' . $student->accountUsername . '</td>';
                echo '<td>' . $student->accountRealName . '</td>';
                echo '<td><input type="number" name="points[' . $student->accountID . ']" 
                    value="' . $points . '" min="0" max="'.$term->termMaxPoints.'"/></td>';
                echo '<td><input type="hidden" name="courseID" value="' . $courseID . '"/></td>';
                echo '<td><input type="hidden" name="termID" value="' . $termID . '"/></td>';
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
    <button type="submit" name="submit">Evaluate</button>
</form>

</section>

<?php include_once 'templates/footer.php'; ?>

</html>