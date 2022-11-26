<?php
    require_once 'includes/authorization-inc.php';
    
    if (isset($_GET['courseID'])) {
        require_once 'includes/courses-inc.php';
        $courseID = $_GET['courseID'];
        if (!is_admin() && (getUID() != getGuarantorID($courseID))) {
            dieForbidden();
        }

        try {
            deleteCourse($courseID);
        } catch (Exception $e) {
            if (is_admin()) {
                header("location: admincourses.php?error=" . $e->getMessage());
            } else {
                header("location: teachercourses.php?error=" . $e->getMessage());
            }
            exit;
        }
    }
    if (is_admin()) {
        header("location: admincourses.php");
    }

    if (is_teacher()) {
        header("location: teachercourses.php");
    }

?>
