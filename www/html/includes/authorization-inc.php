<?php

require_once 'includes/dbh-inc.php';

session_start();
$sid = session_id();
$TIMEOUT = 3600;

if ($sid != '') {
    $sql = 'SELECT * FROM Login WHERE sessionID = ?';
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute([$sid]);

    if ($stmt->rowCount() != 0) {
        $login = $stmt->fetch(PDO::FETCH_OBJ);
        
        if (time() > $login->timeout) {
            # login is expired
            $sql = 'DELETE FROM Login WHERE sessionID = ?';
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->execute([$sid]);
        } else {
            # login is active
            $sql = 'UPDATE Login SET timeout = ? WHERE sessionID = ?';
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->execute([time() + $TIMEOUT, $sid]);
            
            $sql = 'SELECT * FROM Account WHERE accountID = ?';
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->execute([$login->accountID]);
            $GLOBALS['user'] = $stmt->fetch(PDO::FETCH_OBJ);
        }
    }
}

function dieForbidden() {
    http_response_code(403);
    die('Forbidden');
}

function getUID() {
    return $GLOBALS['user']->accountID;
}

function is_logged_in() {
    return isset($GLOBALS['user']);
}

function assert_logged_in() {
    if (!is_logged_in()) {
        header("location: ../login.php");
        exit;
    }
}

function is_admin() {
    if (!is_logged_in()) {
        return false;
    }
    return $GLOBALS['user']->accountAdmin;
}

function is_teacher() {
    if (!is_logged_in()) {
        return false;
    }
    return $GLOBALS['user']->accountTeacher;
}

function is_student() {
    if (!is_logged_in()) {
        return false;
    }
    return $GLOBALS['user']->accountStudent;
}

function assert_admin() {
    if (!is_logged_in()) {
        header("location: ../login.php");
        exit;
    }
    if (!is_admin()) {
        dieForbidden();
    }
}

?>

