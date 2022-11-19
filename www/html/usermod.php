<?php

require_once 'includes/authorization-inc.php';
assert_logged_in();



if (isset($_REQUEST["accountID"])) {
    assert_admin();
    $uid = $_REQUEST["accountID"];
}
else {
    $uid = $GLOBALS['user']->accountID;
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
    require_once 'includes/users-inc.php';
    userMod($uid, $attributes);
}

?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>

<section class="section_form">
    <?php
        require_once 'includes/users-inc.php';

        if (is_admin()) {
            echo "<a class=\"button_back\" href=manageusers.php>Back to user management</a><br/>";
        }

        echo "<div><form method=\"POST\">";
        $disabled = is_admin() ? '' : 'disabled';
        
        // !!! for some reason, this cannot be called $user !!!
        $user_to_process = getUserByID($uid);
        
        echo "<label>Username<input name=\"accountUsername\" type=\"text\" 
        $disabled value=\"$user_to_process->accountUsername\"></label><br/>";
        
        echo '<label>Name<input name="accountRealName" type="text" value="'.
        $user_to_process->accountRealName.'"></label><br/>';
        
        echo '<label>Address<input name="accountAddress" type="text" value="'.
        $user_to_process->accountAddress.'"></label><br/>';

        echo '<label>Date of birth<input name="accountDateOfBirth" type="date" value="'.
        $user_to_process->accountDateOfBirth.'"></label><br/>';
    
        echo '<label>Email<input name="accountEmail" type="text" value="'.
        $user_to_process->accountEmail.'"></label><br/>';
        
        #TODO uncheck user not working properly
        $checked_a = $user_to_process->accountAdmin ? "checked" : "";
        $checked_t = $user_to_process->accountTeacher ? "checked" : "";
        $checked_s = $user_to_process->accountStudent ? "checked" : "";
        if (is_admin()) {
            echo '  <label>Admin
                        <input type="hidden" name="accountAdmin" value="off">
                        <input type="checkbox" name="accountAdmin" '.$checked_a.'>
                    </label><br/>';

            echo '  <label>Teacher
                        <input type="hidden" name="accountTeacher" value="off">
                        <input type="checkbox" name="accountTeacher" '.$checked_t.'>
                    </label><br/>';

            echo '  <label>Student
                        <input type="hidden" name="accountStudent" value="off">
                        <input type="checkbox" name="accountStudent" '.$checked_s.'>
                    </label><br/>';
        }
    ?>
        <button type="submit" name="submit">Update</button>
    </form>
</div>
</section>

<?php include_once 'templates/footer.php' ?>

</html>