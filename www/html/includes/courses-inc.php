<?php

require_once 'includes/dbh-inc.php';

enum CourseState: int
{
    case CONCEPT = 0;
    case FOR_APPROVAL = 5;
    case RUNNING = 10;
}

function getEmptyCourse() {
    $course = (object) [
        'courseID' => 0,
        'courseName' => '',
        'courseDescription' => '',
        'courseState' => CourseState::CONCEPT;
    ];
    return course;
}

function getCourse($courseID) {
    
}

function getCourses() {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Course");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_CLASS);
}

function addCourse($name) {
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO Course (courseName) VALUES (?)");
    $stmt->execute([$name]);
    return $GLOBALS['conn']->lastInsertId();
}
