<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/dbh-inc.php';

session_start();
$sid = session_id();

if ($sid != '') {
    $sql = 'SELECT * FROM Account WHERE accountSessionID = ?';
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute([$sid]);

    if ($stmt->rowCount() != 0) {
        $GLOBALS['user'] = $stmt->fetch(PDO::FETCH_OBJ);
    }
}


function is_logged_in() {
    return isset($GLOBALS['user']);
}

function assert_logged_in() {
    if (!is_logged_in()) {
        header("location: ../login.php");
    }
}

function is_admin() {
    if (!is_logged_in()) {
        return false;
    }
    
    $uid = $GLOBALS['user']->accountID;
    $sql = 'SELECT 1 FROM Admin WHERE accountID = ?';
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute([$uid]);
    
    return $stmt->rowCount() != 0;
}




