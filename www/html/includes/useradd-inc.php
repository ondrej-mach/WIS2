<?php

require_once 'includes/dbh-inc.php';

function userAdd($username, $password) {
    $sql = "INSERT INTO Account (accountUsername, accountPassword) VALUES (?, ?)";
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute([$username, password_hash($password, NULL)]);
}

function username2uid($username) {
    $stmt = $GLOBALS['conn']->prepare('SELECT accountID FROM Account WHERE accountUsername = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    return $user->accountID;
}

function uid2username($uid) {
    $stmt = $GLOBALS['conn']->prepare('SELECT accountUsername FROM Account WHERE accountUsername = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    return $user->accountUsername;
}
    
function userMod($uid, $attr) {
    $conn = $GLOBALS['conn'];
    
    # TODO
    if (isset($attr["username"])) {
        
    }
    
    if (isset($attr["pasword"])) {
        
    }
    
    if (isset($attr["is_admin"])) {
        if ($attr["is_admin"]) {
            $sql = "INSERT INTO Admin (accountID) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$uid]);
        } else {
            # TODO remove admin privileges from user
        }
    }
}

function userDel($username) {
    # TODO

}
