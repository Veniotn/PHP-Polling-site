<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    // Get the username and password from the form data
    $login = $_POST['username'];
    $loginPassword = $_POST['password'];

    //Connect to database
    $server = "localhost";
    $serverUserName = "root";
    $serverPassword = "root";
    $serverDatabaseName = "PollingSystemDatabase";

    $dataBaseConnection = new mysqli($server, $serverUserName, $serverPassword, $serverDatabaseName);
    if ($dataBaseConnection->connect_error){
        die("Connection to " . $serverDatabaseName . " failed." . $dataBaseConnection->connect_error);
    }

    //prepare the statement for security
    $sqlQuery = $dataBaseConnection->prepare("SELECT login FROM voters WHERE Login = ?");

    //bind the variable to delete special characters.
    $sqlQuery->bind_param("s", $login);

    $sqlQuery->execute();

   $sqlResult = $sqlQuery->get_result();

   //if the query comes back with records, set the session variable and redirect back to display the error
   //on the create account page.
    if ($sqlResult->num_rows > 0){
        $_SESSION['error'] = "Username already exists";
        header("Location: ./createAccountScreen.php");
        exit();
    }



    //If not, insert the user into the db and move back to login screen.
    $sqlQuery = $dataBaseConnection->prepare("INSERT INTO voters(login, password) VALUE (?, ?)");
    $sqlQuery->bind_param("ss", $login, $loginPassword);



    if ($sqlQuery->execute()){
        echo "login inserted!";
        header("Location: ../html/loginScreen.html");
    }
    else{
        die("Insert failed.");
    }


}




