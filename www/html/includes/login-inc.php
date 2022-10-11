<?php


require_once 'dbh-inc.php';

try {
    $sql = 'SELECT accountPassword FROM Account WHERE accountUsername = ?';
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute([$_POST["username"]]);
    if ($stmt->rowCount() == 0) {
        throw new Exception('Bad credentials.');
    }
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    $hashedPwd = $user->accountPassword;

    if (password_verify($_POST["password"], $hashedPwd)) {
        # TODO set cookie and redirect
        echo "Hello there";
    } else {
        throw new Exception('Bad credentials.');
    }

} catch (Exception $e) {
    header("location: ../login.php?error=badcredentials");
}
