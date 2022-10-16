<?php
require_once 'includes/authorization-inc.php';

assert_logged_in();

$uid = $GLOBALS['user']->accountID;
if (isset($_REQUEST["accountID"])) {
    assert_admin();
    $uid = $_REQUEST["accountID"];
}

$userParams = [ 
    "accountRealName",
    "accountPassword",
    "accountAddress",
    "accountDateOfBirth",
    "accountEmail",
];

// when accountID is not set, it changes info for the logged in user.
// user cannot change these attributes, only admin can
$adminParams = [ 
    "accountUsername", 
    "accountStudent", 
    "accountTeacher", 
    "accountAdmin",
];

$attributes = [];

foreach ($_POST as $key => $value) {
    if (in_array($key, $userParams)) {
        $attributes[$key] = $value;
        
    } elseif (in_array($key, $adminParams)) {
        assert_admin();
        $attributes[$key] = $value;
    }
}

# if we need to change any data, access the database
if (!empty($attributes)) {
    require_once 'includes/useradd-inc.php';
    userMod($uid, $attributes);
}


?>

<!DOCTYPE html>
<html>
  
  <?php include_once 'templates/header.php' ?>
  <?php include_once 'templates/navbar.php' ?>
  
  <form method="POST">
  
    <?php
        $disabled = is_admin() ? '' : 'disabled';
        
        require_once 'includes/useradd-inc.php';
        $user = getUserByID($uid);
        
        if (is_admin()) {
            echo "<a href=manageusers.php>Back to user management</a><br/>";
        }
        
        echo "<label>Username<input name=\"accountUsername\" type=\"text\" 
        $disabled value=\"$user->accountUsername\"></label><br/>";
        
        echo '<label>Name<input name="accountRealName" type="text" value="' .
        $user->accountRealName . '"></label><br/>';
        
        echo '<label>Address<input name="accountAddress" type="text" value="'.
        $user->accountAddress.'"></label><br/>';
        
    ?>
    
    <button type="submit" name="submit">Update</button>
    </form>

  <?php include_once 'templates/footer.php' ?>

</html>
