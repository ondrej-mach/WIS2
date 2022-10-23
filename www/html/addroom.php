<?php
    require_once 'includes/authorization-inc.php';
    assert_admin();
    
    if (isset($_REQUEST['roomName'])) {
        require_once 'includes/rooms-inc.php';
        
        $newRoomID = addRoom($_REQUEST['roomName']);
        header("location: modifyroom.php?roomID=$newRoomID");
        
    } 
