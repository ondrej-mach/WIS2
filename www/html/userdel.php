<?php
    require_once 'includes/authorization-inc.php';
    assert_admin();
    
    if (isset($_GET['accountID'])) {
        require_once 'includes/users-inc.php';
        userDel($_GET['accountID']);
    }

    header("location: manageusers.php");

?>