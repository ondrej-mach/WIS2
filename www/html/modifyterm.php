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
    "termName",
    "termDate",
    "termMaxPoints",
    "termAutoregistered",
];

$attributes = [];

foreach ($_REQUEST as $key => $value) {
    if (in_array($key, $params)) {
        $attributes[$key] = $value;   
    }
}

# if we need to change any data, access the database
if (!empty($attributes)) {
    modifyTerm($termID, $attributes);
}

header("location: editterm.php?termID=$termID&courseID=$courseID");
?>