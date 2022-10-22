<?php


require_once 'includes/authorization-inc.php';

if (is_logged_in()) {
    $sql = 'DELETE FROM Login WHERE sessionID = ?';
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute([session_id()]);
}

header("location: /index.php");

