<?php
    require_once 'includes/authorization-inc.php';
    assert_admin();

    $badUsername = false;
    $badPassword = false;
    $username = '';
    $password = '';
    
    if (isset($_POST['accountUsername']) && isset($_POST['accountPassword'])) {
        if ($_POST['accountUsername'] == '') {
            $badUsername = true;
            
        } elseif ($_POST['accountPassword'] == '') {
            $badPassword = true;
    
        } else {
            require_once 'includes/users-inc.php';
            try {
                $newuid = userAdd($_POST['accountUsername'], $_POST['accountPassword']);
                header("location: ../usermod.php?accountID=$newuid");
            } catch (Exception $e) {
                $badUsername = true;
            }
        }
    }

    

?>

<!DOCTYPE html>
<html>
  
  <?php include_once 'templates/header.php' ?>
  <?php include_once 'templates/navbar.php' ?>
  
  <h1>Add new user</h1>
  
  <form method="POST">
    <label <?php if ($badUsername) echo 'style="color:red"'; ?> >Username
      <input name="accountUsername" value="<?php echo $username; ?>" type="text">
    </label><br/>
    
    <label>Password
      <input name="accountPassword" value="<?php echo $password; ?>" type="text">
    </label><br/>
    
    <button type="submit" name="submit">Add user</button>
  </form>

  <?php include_once 'templates/footer.php' ?>

</html>

