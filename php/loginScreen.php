<?php
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get the username and password from the form data
    $login = $_POST['username'];
    $loginPassword = $_POST['password'];


    // TODO: Check if the username and password are valid

    //Connect to database
    $servername = "localhost";
    $dataBaseName = "PollingSystemDatabase";
    $username = "root";
    $password = "root";
    $dataBase = new mysqli($servername, $username, $password, $dataBaseName);

    //Check connection
    if ($dataBase->connect_error){
        die("Connection to " . $dataBaseName . " failed." . $dataBase->connect_error);
    }

    //Query the database
    $databaseQuery = "INSERT INTO voters(Login, Password) VALUE ('" . $login . "', '" . $loginPassword . "')";

    //check if the query was successful
    if ($dataBase->query($databaseQuery) === true){
        echo "Sucessfully inserted data.";
    }
    else{
        echo "Error inserting data.";
    }

//
//    // For the purpose of this example, we'll hard-code some valid credentials
//    $valid_users = array(
//        'admin' => 'password123',
//        'user1' => 'qwerty456',
//        'user2' => 'asdfgh789'
//    );
//
//    if (array_key_exists($username, $valid_users) && $valid_users[$username] == $password) {
//        // Successful login, set session variables and redirect to dashboard page
//        $_SESSION['username'] = $username;
//        header('Location: dashboard.php');
//        exit();
//    } else {
//        // Invalid credentials, display error message
//        $error_msg = 'Invalid username or password. Please try again.';
//        echo  $error_msg;
//    }
}
