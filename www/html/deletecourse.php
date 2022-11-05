<?php
    require_once 'includes/authorization-inc.php';
    assert_admin();
    
    if (isset($_GET['courseID'])) {
        require_once 'includes/courses-inc.php';
        deleteCourse($_GET['courseID']);
    }

    header("location: admincourses.php");

?>