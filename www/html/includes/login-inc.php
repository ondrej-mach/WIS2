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
        
        $sql = 'UPDATE Account SET accountSessionID = ? WHERE accountID = ?';
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->execute([$sid, $user->accountID]);
        header("location: ../index.php");
        
    } else {
        throw new Exception('Bad credentials.');
    }

} catch (Exception $e) {
    header("location: ../login.php?error=badcredentials");
}
