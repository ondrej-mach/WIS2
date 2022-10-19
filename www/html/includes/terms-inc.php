<?php

require_once 'includes/courses-inc.php';


function getEmptyTerm() {
    $term = (object) [
        'termID' => NULL,
        'courseID' => NULL,
        'termName' => '',
        'termDate' => NULL,
        'termMaxPoints' => 0,
        'termAutoregistered' => true,
    ];
    return $term;
}

function getTerms($courseID) {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Term WHERE courseID = ?");
    $stmt->execute([$courseID]);
    return $stmt->fetchAll(PDO::FETCH_CLASS);
}

function getTermByID($termID) {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Term WHERE termID = ?");
    $stmt->execute([$termID]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function addTerm($courseID) {
    $conn = $GLOBALS['conn'];
    $conn->beginTransaction();
    
    $stmt = $conn->prepare("INSERT INTO Term (courseID) VALUES (?)");
    $stmt->execute([$courseID]);
    $newTermID = $conn->lastInsertId();
    
    $conn->commit();
    return $newTermID;
}

function modifyTerm($termID, $attributes) {
    $conn = $GLOBALS['conn'];
    
    $possibleAttr = [ 
        "termName",
        "termDate",
        "termMaxPoints",
        "termAutoregistered",
    ];
    
    foreach($attributes as $key => $value) {
        if (!in_array($key, $possibleAttr)) {
            throw new Exception("Attribute $key does not exist.");
        }
        
        $sql = "UPDATE Term SET $key = ? WHERE termID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$value, $termID]);
    }
}

function delTerm($termID) {
    //TODO cascade constraints
    $stmt = $GLOBALS['conn']->prepare("DELETE FROM Term WHERE termID = ?");
    $stmt->execute([$termID]);
}
