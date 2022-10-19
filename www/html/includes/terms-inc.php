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
    
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO Term VALUES (?, ?)");
    $stmt->execute([$name, CourseState::CONCEPT->value]);
    $newTermID = $conn->lastInsertId();
    
    $conn->commit();
    return $newTermID;
}
