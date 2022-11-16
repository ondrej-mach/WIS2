<?php
    require_once 'includes/authorization-inc.php';
    
    if (isset($_GET['courseID'])) {
        require_once 'includes/courses-inc.php';
        $courseID = $_GET['courseID'];
        if (!is_admin() && (getUID() != getGuarantorID($courseID))) {
            dieForbidden();
        }
        removeAllTermsfromCourse($courseID);
        removeGuarantor($courseID);
        deleteCourse($courseID);
    }
    if (is_admin()) {
        header("location: admincourses.php");
    }

    if (is_teacher()) {
        header("location: teachercourses.php");
    }

?>