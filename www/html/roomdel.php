<?php
    require_once 'includes/authorization-inc.php';
    assert_admin();
    
    if (isset($_GET['roomID'])) {
        require_once 'includes/rooms-inc.php';
        try{
            delRoom($_GET['roomID']);
        } catch (Exception $e) {
            header("location: managerooms.php?error=1");
            exit;
        }
    }

    header("location: managerooms.php");

?>
