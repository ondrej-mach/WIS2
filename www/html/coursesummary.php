<?php 
    require_once 'includes/authorization-inc.php';
    if (!isset($_GET['courseID'])) {
        exit('Wrong parameters');
    }
    
    include_once 'includes/courses-inc.php';

    $courseID = $_GET['courseID'];
    $lecturers = getLecturerIDs($courseID);
    $uid = getUID();

    if (!is_admin() && !(is_teacher() && (in_array($uid, $lecturers) || $uid == getGuarantorID($courseID)))) {
        dieForbidden();
    }
?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php'; ?>
<?php include_once 'templates/navbar.php'; ?>

<?php
    if (is_admin()) {
        echo "<a class=\"button_back\" href=admincourses.php>Back to courses</a><br/>";
    }
    if (is_teacher()) {
        echo "<a class=\"button_back\" href=teachercourses.php>Back to courses</a><br/>";
    }
?>

<h3>Course summary</h3>

<section class="section_table">

<table>
    <thead>
        <tr>
        <?php
            require_once 'includes/courses-inc.php';
            require_once 'includes/terms-inc.php';
            
            echo "<th>Student \ Term</th>";
            $terms = getTerms($courseID);
            foreach ($terms as $term) {
                echo "<th>" . $term->termName . "</th>";
            }
            echo "<th>Summary</th>";
        ?>
        </tr>
    </thead>
    <tbody>
        <?php
        
            require_once 'includes/student-inc.php';
            require_once 'includes/users-inc.php';
            require_once 'includes/courses-inc.php';
            
            $students = getStudents($courseID);
            foreach ($students as $student) {
                echo "<tr>"; 
                echo "<td>".getUserByID($student->accountID)->accountUsername."</td>";
                $summary = 0;
                foreach ($terms as $term) {
                    $points = getStudentPoints($term->termID, $student->accountID);
                    $summary += $points;
                    echo "<td>" . $points . "</td>";
                }
                echo "<td>" . $summary . "</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
</section>

<?php include_once 'templates/footer.php'; ?>

</html>