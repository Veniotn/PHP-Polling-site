<?php
include 'util.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    // Get the username and password from the form data
    $login = $_POST['username'];
    $loginPassword = $_POST['password'];

    //Connect to database
    $serverName = "localhost";
    $dbUserName = "root";
    $dbPassword = "root";
    $dbName = "PollingSystemDatabase";

    $dataBaseConnection = createConnection($serverName, $dbUserName, $dbPassword, $dbName);

    $sqlText = "SELECT login FROM voters WHERE Login = ?";
    $sqlResult = selectQueryOneParam($dataBaseConnection, $sqlText, $login);


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
        header("Location: ./loginPage.php");
    }
    else{
        die("Insert failed.");
    }


}




