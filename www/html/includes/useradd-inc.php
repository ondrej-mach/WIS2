<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/dbh-inc.php';

function userAdd($username, $password) {
    $sql = "INSERT INTO Account (accountUsername, accountPassword) VALUES (?, ?)";
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute([$username, password_hash($password,  NULL)]);
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
    
function userMod($uid, $attributes) {
    $conn = $GLOBALS['conn'];
    
    $possibleAttr = [ 
        "accountRealName",
        "accountPassword",
        "accountAddress",
        "accountDateOfBirth",
        "accountEmail",
        "accountUsername", 
        "accountStudent", 
        "accountTeacher", 
        "accountAdmin",
    ];
    
    $values = [];
    $keys = '';
    
    foreach($attributes as $key => $value) {
        if (!in_array($key, $possibleAttr)) {
            throw new Exception("Attribute $key does not exist.");
        }
        if ($key == "accountPassword") {
            $value = password_hash($value, NULL);
        }
        
        $sql = "UPDATE Account SET $key = ? WHERE accountID = ?";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->execute([$value, $uid]);
    }
}

function userDel($uid) {
    # TODO cascade all foreign keys
    $sql = "DELETE FROM Account WHERE accountID = ?";
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute([$uid]);
}
