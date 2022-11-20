<?php 
    require_once 'includes/authorization-inc.php';
    if (!isset($_GET['courseID'])) {
        exit('Wrong parameters');
    }
    
    $courseID = $_GET['courseID'];
    include_once 'includes/courses-inc.php';
    if (!(is_teacher() && (getUID() == getGuarantorID($courseID)))) {
        dieForbidden();
    }

?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php'; ?>
<?php include_once 'templates/navbar.php'; ?>
<div id="button_back" ><a href=admincourses.php>Back to courses</a></div><br/>

<?php
    if (is_admin()) {
        echo "<div id=\"button_back\" ><a href=admincourses.php>Back to courses</a></div><br/>";
    }
    if (is_teacher()) {
        echo "<div id=\"button_back\" ><a href=teachercourses.php>Back to courses</a></div><br/>";
    }
?>
</section>

<h3>Accepts students to course</h3>

<section class="section_table">

<?php #TODO: Add a form to accept students to the course ?>

<form method="GET" action="accept.php">
<table>
    <thead>
        <tr>
            <th>Login</th>
            <th>Name</th>
            <th>Approved</th>
        </tr>
    </thead>
    <tbody>
        <?php
            require_once 'includes/courses-inc.php';
            require_once 'includes/users-inc.php';

            $students = getStudents($courseID);

            foreach ($students as $student) {
                
                $check_approved = $student->approved ? "checked" : "";
                $student = getUserByID($student->accountID);
                echo '<tr>';
                echo '<td>' . $student->accountUsername . '</td>';
                echo '<td>' . $student->accountRealName . '</td>';
                echo '<input type="hidden" name="courseID" value="'.$courseID.'" />';
                echo "<input type=\"hidden\" name=\"approved[$student->accountID]\" value=\"off\" />";
                echo "<td><input type=\"checkbox\" name=\"approved[$student->accountID]\" $check_approved></input></td>";
                echo '</tr>';
            }
        ?>
        <tr>
            <td>
            <td>
            <td><button type="submit" name="submit">Add</button></td>
            </form>
        </tr>
    </tbody>
</table>
</section>

<?php include_once 'templates/footer.php'; ?>

</html>