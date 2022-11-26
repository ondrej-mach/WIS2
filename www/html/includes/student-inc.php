<?php

require_once 'includes/dbh-inc.php';

function signStudentToTerm($termID, $studentID, $autoregistered) {
    $conn = $GLOBALS['conn'];
    $sql = "INSERT INTO SignedUp (termID, studentID, autoregistered) 
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$termID, $studentID, $autoregistered]);

    return $conn->lastInsertId();
}

function updatePoints($points, $lecturerID, $termID, $studentID) {
    require_once 'includes/users-inc.php';
    $userName = getUserByID($lecturerID)->accountRealName;
    $conn = $GLOBALS['conn'];
    $sql = "UPDATE SignedUp 
            SET points = ?, lecturerRealName = ?
            WHERE termID = ? AND studentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$points, $userName, $termID, $studentID]);
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

    require_once 'includes/courses-inc.php';
    require_once 'includes/terms-inc.php';

    $terms = getTerms($courseID);
    foreach ($terms as $term) {
        if ($term->termAutoregistered && !isRegisteredToTerm($termID, $accountID)) {
            signStudentToTerm($term->termID, $accountID, 1);
        }
    }
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
