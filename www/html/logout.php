<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/authorization-inc.php';

if (is_logged_in()) {
    $uid = $GLOBALS['user']->accountID;

    $sql = 'UPDATE Account SET accountSessionID = NULL WHERE accountID = ?';
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute([$uid]);
}

header("location: /index.php");

