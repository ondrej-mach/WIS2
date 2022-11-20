<?php

require_once 'includes/dbh-inc.php';

function signStudentToTerm($termID, $studentID, $uid) {
    $conn = $GLOBALS['conn'];
    $sql = "INSERT INTO SignedUp (termID, studentID, lecturerID) 
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$termID, $studentID, $uid]);

    return $conn->lastInsertId();
}

#TODO not sure this is needed
function evaluateTerm($termID, $studentID, $uid, $points) {
    $conn = $GLOBALS['conn'];
    $sql = "INSERT INTO SignedUp (termID, studentID, lecturerID, points) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$termID, $studentID, $uid, $points]);
}

function updatePoints($points, $uid, $termID, $studentID) {
    $conn = $GLOBALS['conn'];
    #is this really necessary?
    $conn->beginTransaction();
    $sql = "UPDATE SignedUp 
            SET points = ? 
            WHERE termID = ? AND studentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$points, $termID, $studentID]);

    $sql = "UPDATE SignedUp 
            SET lecturerID = ? 
            WHERE termID = ? AND studentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$uid, $termID, $studentID]);
    $conn->commit();
}

function getStudentPoints($termID, $studentID) {
    $conn = $GLOBALS['conn'];
    $sql = "SELECT * FROM SignedUp WHERE termID = ? AND studentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$termID, $studentID]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    $result = isset($result->points) ? $result->points : null;
    return $result;
}

function removeStudentFromTerm($termID, $studentID) {
    $conn = $GLOBALS['conn'];
    $sql = "DELETE FROM SignedUp WHERE termID = ? AND studentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$termID, $studentID]);
}

function setApproval($courseID, $accountID, $approved) {
    $conn = $GLOBALS['conn'];
    $sql = "UPDATE Attends 
            SET approved = ? 
            WHERE courseID = ? AND accountID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$approved, $courseID, $accountID]);
}

function setRegistration($courseID, $accountID, $value) {
    $conn = $GLOBALS['conn'];
    $sql = "INSERT INTO Attends (accountID, courseID, approved) 
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$accountID, $courseID, $value]);
}

function removeRegistration($courseID, $accountID) {
    $conn = $GLOBALS['conn'];
    $sql = "DELETE FROM Attends 
            WHERE accountID = ? AND courseID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$accountID, $courseID]);
}

function getStudentCourses($accountID) {
    $conn = $GLOBALS['conn'];
    $sql = "SELECT * FROM Attends WHERE accountID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$accountID]);
    return $stmt->fetchAll(PDO::FETCH_CLASS);
}