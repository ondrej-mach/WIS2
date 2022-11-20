<?php 
    require_once 'includes/authorization-inc.php';
    if (!isset($_GET['courseID'])) {
        exit('Wrong parameters');
    }

    include_once 'includes/courses-inc.php';

    $courseID = $_GET['courseID'];
    $lecturers = getLecturerIDs($courseID);
    $uid = getUID();
    
    if (!(is_teacher() && (in_array($uid, $lecturers) || $uid == getGuarantorID($courseID)))) {
        dieForbidden();
    }
?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php'; ?>
<?php include_once 'templates/navbar.php'; ?>

<?php
    if (is_admin()) {
        echo "<div id=\"button_back\" ><a href=admincourses.php>Back to courses</a></div><br/>";
    }
    if (is_teacher()) {
        echo "<div id=\"button_back\" ><a href=teachercourses.php>Back to courses</a></div><br/>";
    }
?>
</section>

<section class="section_table">
    <h3>Evaluate term</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Points</th>
                <th>Auto</th>
                <th>
            </tr>
        </thead>
        <tbody>
            <?php
                require_once 'includes/courses-inc.php';
                require_once 'includes/terms-inc.php';

                $terms = getTerms($courseID);
                foreach ($terms as $term) {
                    $evaluateURL = "evaluateterm.php?termID=$term->termID";
                    
                        echo "<tr>";
                        echo "<td>" . $term->termName . "</td>";
                        echo "<td>" . $term->termDate . "</td>";
                        echo "<td>" . $term->termMaxPoints . "</td>";
                        echo "<td>" . $term->termAutoregistered . "</td>";
                        echo "<td><a href=\"$evaluateURL\">Evaluate</a></td>";
                        echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</section>

<?php include_once 'templates/footer.php'; ?>

</html>