<?php

require_once 'includes/dbh-inc.php';

function userAdd($username, $password) {
    $sql = "INSERT INTO Account (accountUsername, accountPassword) VALUES (?, ?)";
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute([$username, password_hash($password,  NULL)]);
    return $GLOBALS['conn']->lastInsertId();
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
    
    foreach($attributes as $key => $value) {
        if (!in_array($key, $possibleAttr)) {
            throw new Exception("Attribute $key does not exist.");
        }
        if ($key == "accountPassword") {
            $value = password_hash($value, NULL);
        }
        if (($key == "accountStudent" || $key == "accountTeacher" || $key == "accountAdmin")) {
            switch($value) {
                case "on":
                    $value = 1;
                    break;
                case "off":
                    $value = 0;
                    break;
                default:
                    throw new Exception("Invalid value for $key: $value");
            }
        }
        
        #TODO check if date value is valid
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

 function getUserByID($uid) {
    $conn = $GLOBALS['conn'];
    
    $stmt = $conn->prepare("SELECT * FROM Account WHERE accountID = ?");
    $stmt->execute([$uid]);
    $user_to_return = $stmt->fetch(PDO::FETCH_OBJ);
    
    return $user_to_return;
}

