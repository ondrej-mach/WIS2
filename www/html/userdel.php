<?php
    require_once 'includes/authorization-inc.php';
    assert_admin();
    
    if (isset($_GET['accountID'])) {
        require_once 'includes/users-inc.php';
        try{
            userDel($_GET['accountID']);
        } catch (Exception $e) {
            header("location: manageusers.php?error=" . $e->getMessage());
            exit;
        }
    }

    header("location: manageusers.php");

?>
