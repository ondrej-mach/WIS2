<?php

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



