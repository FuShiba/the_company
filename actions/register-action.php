<?php
    include "../classes/User.php";

    #Create/Instantiate an object
    $user = new User;

    # Call the method
    $user->store($_POST);
    # The $_POST -> will hold the data coming from the registration form

?>