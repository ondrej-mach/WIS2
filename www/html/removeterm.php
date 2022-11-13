<?php
    require_once 'includes/authorization-inc.php';
    assert_admin();
    
    if (isset($_GET['termID'])) {
        require_once 'includes/terms-inc.php';
        delTerm($_GET['termID']);
    }

    header("location: admincourses.php");
?>