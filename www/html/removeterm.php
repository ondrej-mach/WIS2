<?php

    require_once 'includes/authorization-inc.php';
    
    if (isset($_GET['termID'])) {
        require_once 'includes/terms-inc.php';
        if (!is_admin() && (getUID() != getGuarantorID($_GET['courseID']))) {
            dieForbidden();
        }
        require_once 'includes/student-inc.php';

        removeAllStudentsfromTerm($_GET['termID']);
        delTerm($_GET['termID']);
    }

    header("location: editcourse.php?courseID=".$_GET['courseID']);
?>