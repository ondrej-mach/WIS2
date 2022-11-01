<?php
    require_once 'includes/authorization-inc.php';
    assert_admin();
    
    if (isset($_GET['roomID'])) {
        require_once 'includes/rooms-inc.php';
        delRoom($_GET['roomID']);
    }

    header("location: managerooms.php");

?>