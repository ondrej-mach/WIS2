<?php

require_once 'dbh-inc.php';

try {
    $sql = 'SELECT * FROM Account WHERE accountUsername = ?';
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute([$_POST["username"]]);
    if ($stmt->rowCount() == 0) {
        throw new Exception('Bad credentials.');
    }
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    $hashedPwd = $user->accountPassword;

    if (password_verify($_POST["password"], $hashedPwd)) {
        session_start();
        $sid = session_id();
        
        $sql = 'INSERT INTO Login (accountID, sessionID, timeout) VALUES (?, ?, ?)';
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->execute([$user->accountID, $sid, time()+3600]);
        
        header("location: ../index.php");
        
    } else {
        throw new Exception('Bad credentials.');
    }

} catch (Exception $e) {
    header("location: ../login.php?error=badcredentials");
}
?>