<?php
require_once 'includes/authorization-inc.php';
require_once 'includes/terms-inc.php';
require_once 'includes/courses-inc.php';

if (!isset($_REQUEST["termID"])) {
    exit('no termID');
}

if (!isset($_REQUEST["courseID"])) {
    exit('no courseID');
}

$termID = $_REQUEST['termID'];
$courseID = $_REQUEST['courseID'];

if (!is_admin() && getUID() != getGuarantorID($courseID))
    dieForbidden();

if ($termID == 'new') {
    try {
        $termID = addTerm($courseID);
    } catch (Exception $e) {
        header("location: editterm.php?termID=new&courseID=$courseID");
        exit;
    }
}

$params = [ 
    "roomID",
    "termName",
    "termDescription",
    "termType",
    "termDate",
    "termLength",
    "termMaxPoints",
    "termAutoregistered",
];

$attributes = [];
$terms = getTerms($courseID);
$max = 100;
foreach ($terms as $t) {
    if ($t->termID != $termID) {
        $max -= $t->termMaxPoints;
    }
}

foreach ($_REQUEST as $key => $value) {
    if ($key == "termDate") {
        $value = date("Y-m-d H:i:00", strtotime($value));
    }
    if ($key == "termLength" && $value == "") {
        continue;
    }
    if ($key == "roomID" && $value == "") {
        continue;
    }
    if ($key == "termAutoregistered") {
        if ($value == "on") {
            $value = 1;
        } else if ($value == "off") {
            $value = 0;
        } else {
            throw new Exception("Invalid value for termAutoregistered");
        }
    }
    if (in_array($key, $params)) {
        $attributes[$key] = $value;   
    }
    if ($key == "termMaxPoints" && ($value > $max || $value < 0)) {
        echo "Max points must be between 0 and $max";
        exit;
    }
}

# if we need to change any data, access the database
if (!empty($attributes)) {
    try{
        modifyTerm($termID, $attributes);
    } catch (Exception $e) {
        header("location: editterm.php?termID=$termID&courseID=$courseID&error=1");
        exit;
    }
}

header("location: editcourse.php?courseID=$courseID");
?>
