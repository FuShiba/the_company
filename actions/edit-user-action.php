<?php
    include "../classes/User.php";

    //  Instantiate an object
    $user = new User;

    //  Call the update method
    # Note the update is doing the actual update
    $user->update($_POST, $_FILES)
    # The $_POST --- holds tje like the first_name, last_name and users
    # The $_FILES --- holds the file (image file) uploading from the form
?>