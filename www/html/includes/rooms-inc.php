<?php

require_once 'includes/dbh-inc.php';

function getRooms() {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Room");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_CLASS);
}

function addRoom($name) {
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO Room (roomName) VALUES (?)");
    $stmt->execute([$name]);
    return $GLOBALS['conn']->lastInsertId();
}

function roomMod($rid, $attributes) {
    $conn = $GLOBALS['conn'];
    
    $possibleAttr = [
        "roomName",
        "roomDescription",
    ];
    
    foreach($attributes as $key => $value) {
        if (!in_array($key, $possibleAttr)) {
            throw new Exception("Attribute $key does not exist.");
        }
        
        $sql = "UPDATE Room SET $key = ? WHERE roomID = ?";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->execute([$value, $rid]);
    }
}

function delRoom($rid) {
    $sql = "DELETE FROM Room WHERE roomID = ?";
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute([$rid]);
}

function getRoomByID($rid) {
    $conn = $GLOBALS['conn'];
    
    $stmt = $conn->prepare("SELECT * FROM Room WHERE roomID = ?");
    $stmt->execute([$rid]);
    $room = $stmt->fetch(PDO::FETCH_OBJ);
    
    return $room;
}
?>
