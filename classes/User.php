<?php
    #include -> if missing, the program will run but get an error.
    #require_once -> if missing, the program will halt, and will
    #an error and will run the program below it (Strict)
    require_once "Database.php";

    # Note: the logic of our application e.g ( CRUD - CREATE - READ - UPDATE - DELETE) will be in this class
    
    class User extends Database{

        public function store($request){
            $first_name = $request['first_name'];
            $last_name  = $request['last_name'];
            $username   = $request['username'];
            $password   = $request['password'];

            # Apply hashing algorithm
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            # SQL Query string
            $sql = "INSERT INTO users(`first_name`, `last_name`, `username`, `password`) VALUES ('$first_name', '$last_name', '$username', '$hashed_password')";

            # Execute the query string
            # $this->conn is coming from the Database class
            if ($this->conn->query($sql)){
                header('location: ../views'); // go to index.php or login page ..will create later on
                exit;
            } else {
                die('Error in creating the user: ' . $this->conn->error);
            }
        }

        public function login($request){ #username and password
            $username = $request['username'];
            $password = $request['password'];
            
            # Query string
            $sql = "SELECT * FROM users WHERE username = '$username'";

            $result = $this->conn->query($sql);

            # Check the username
            if($result->num_rows == 1) {
                # Check the password
                $user = $result->fetch_assoc();
                # $user = ['id' => 1, 'username' => 'john', 'password' => '$2yghnjmk..'];

                if(password_verify($password, $user['password'])) { #if the password is matched
                    # create a session variables for future use
                    session_start();
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['fullname'] = $user['first_name'].' '.$user['last_name'];

                    header('location:../views/dashboard.php');
                    exit;
                } else {
                    die('password is incorrect');
                } 
            } else {
                die('username does not exist');
            }
            
        } 
        function logout(){
            session_start(); //start this to use session variables --- this can be removed actually
            session_unset(); //execute this to unset the session variables set in the login method
            session_destroy(); //destroy removed the session variables from the memory

            header("location: ../views/"); #redirect the user to the login page
            exit;
        }

        # Retrieve all the users in the users table
        public function getAllUsers(){
            $sql = "SELECT id, first_name, last_name, username, photo FROM users";

            if($result = $this->conn->query($sql)) {
                return $result;
            } else {
                die("Error in retrieving users." . $this ->conn->error);
            }
        }

        # Retrieved one user
        # Note; The id is the id of the user we want to retrieve
        public function getUser($id){
            $sql = "SELECT * FROM users WHERE id = $id";

            if($result = $this->conn->query($sql)){
                return $result->fetch_assoc();
            } else {
                die("Error in retrieving one user. ". $this->conn->error);
            }
        }


        # $_POST($request), $_FILES ($files)
        public function update($request, $files)
        {
            session_start();
            $id = $_SESSION['id'];
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $username = $request['username'];

            # Note: The file is handled differently
            // The 'photo' is the name of tje input field from the form
            // The 'name' -- the name of the file
            $photo = $files['photo']['name'];
            
            // The 'photo' is the name of the input field from the form
            // The 'tmp_photo' refers to the temporary storage of our computer where the images temporarily saved
            $tmp_photo = $files['photo']['tmp_name'];
            
            // Query string to update the first_name, last_name username
            $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username' WHERE id = $id";

            // Execute the query string above
            if ($this->conn->query($sql)){
                $_SESSION['username'] = $username;
                $_SESSION['fullname'] = "$first_name $last_name";

                #if there is an uploaded photo, save it to the Db and save the file to the images folder 
                if($photo) { // is it true that the user uploaded a photo?
                    #then execute this
                    $sql = "UPDATE users SET photo = '$photo' WHERE id = $id";
                    # file destination folder
                    $destination = "../assets/images/$photo";

                    //  Execute the query above to save the image to the Db, and move the uploaded file
                    if($this->conn->query($sql)) {
                        if(move_uploaded_file($tmp_photo, $destination)) {
                            header("location: ../views/dashboard.php");
                            exit;
                        } else {
                            die("Error in moving the photo");
                        }
                    } else {
                        die("Error in uploading photo: " . $this->conn->error);
                    }
                }
                header('location: ../views/dashboard.php');
                exit;
            } else {
                die("Error in updating the user. " . $this->conn->error);
            }
        }

        public function delete()
        {
            session_start();
            $id = $_SESSION['id'];

            # Query string
            $sql = "DELETE FROM users WHERE id = $id";

            if ($this->conn->query($sql)) {
                $this->logout(); // Call logout, contains header('location: ../views')--login page
            } else {
                die("Error in deleting your account." . $this->conn->error);
            }
        }
    }
    
    
?>