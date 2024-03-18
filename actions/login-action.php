<?php
    include "../classes/User.php";

    
    # Create an object
    $user = new User;

    # Call the login method
    $user->login($_POST);
?>