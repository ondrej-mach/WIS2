<?php

    require_once 'includes/authorization-inc.php';
    
    if (isset($_GET['termID'])) {
        require_once 'includes/terms-inc.php';
        if (!is_admin() && (getUID() != getGuarantorID($_GET['courseID']))) {
            dieForbidden();
        }
        require_once 'includes/student-inc.php';

        try {
            delTerm($_GET['termID']);
        } catch (Exception $e) {
            header("location: editcourse.php?courseID=".$_GET['courseID']."&error=".$e->getMessage());
            exit;
        }
    }

    header("location: editcourse.php?courseID=".$_GET['courseID']);
?>
