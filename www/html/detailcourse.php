<?php 
    require_once 'includes/authorization-inc.php'; 
    if (!is_student()) {
        dieForbidden();
    }
    if (!isset($_GET['courseID'])) {
        exit('Wrong parameters');
    }
    $courseID = $_GET['courseID'];
    $uid = getUID();
?>

<!DOCTYPE html>
<html>
  
<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>

<div id="button_back" ><a href=studentcourses.php>Back to courses</a></div><br/>
</section>

<section class="section_table">
<?php
    include_once 'includes/courses-inc.php';
    $course = getCourseByID($courseID);
    echo '<h3>'.$course->courseName.' - '.$course->courseFullName.'</h3>';
?>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Term</th>
            <th>Points</th>
        </tr>
    </thead>
    <tbody>
        <?php
            require_once 'includes/terms-inc.php';
            require_once 'includes/student-inc.php';

            $terms = getTerms($courseID);
            $points_sum = 0;
            $max_sum = 0;
            foreach ($terms as $term) {
                echo "<tr>";
                echo "<td>".$term->termDate."</td>";
                echo "<td>".$term->termName."</td>";
                $points = getStudentPoints($term->termID, $uid);
                $points = $points ? $points : 0;
                $points_sum += $points;
                $max_sum += $term->termMaxPoints;
                echo "<td>".$points."/".$term->termMaxPoints."</td>";
                echo "</tr>";
            }
            echo "<tr>";
            echo "<td></td>";
            echo "<td>Summary</td>";
            echo "<td>".$points_sum."/".$max_sum."</td>";
            echo "</tr>";
        ?>
    </tbody>
</table>

</section>

<?php include_once 'templates/footer.php' ?>

</html>