<?php

require_once 'includes/dbh-inc.php';

function signStudentToTerm($termID, $studentID, $uid) {
    $conn = $GLOBALS['conn'];
    
    $sql = "INSERT INTO SignedUp (termID, studentID, lecturerID) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$termID, $studentID, $uid]);

    return $conn->lastInsertId();
}

function removeStudentFromTerm($termID, $studentID) {
    $conn = $GLOBALS['conn'];

    $sql = "DELETE FROM SignedUp WHERE termID = ? AND studentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$termID, $studentID]);
}
?>