<?php
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get the username and password from the form data
    $login = $_POST['username'];
    $loginPassword = $_POST['password'];


    //Check if the username and password are valid

    //Connect to database
    $servername = "localhost";
    $databaseName = "PollingSystemDatabase";
    $username = "root";
    $password = "root";
    $database = createConnection($servername, $username, $password, $databaseName);

    //set the db properties as session variables.
    $_SESSION['serverName'] = $servername;
    $_SESSION['dbUsername'] = $username;
    $_SESSION['dbPassword'] = $password;
    $_SESSION['dbName'] = $databaseName;



    //Query the database(return the id so we can use it as a session token).
    $databaseQuery = $database->prepare("SELECT VoterID, hasVoted FROM voters WHERE Login = ? AND Password = ?");
    $databaseQuery->bind_param("ss", $login, $loginPassword);
    $databaseQuery->execute();


    $queryResult = $databaseQuery->get_result();


    //check if the query was successful
    if ($queryResult->num_rows > 0){

        //grab the query result as its own object
        $data = $queryResult->fetch_assoc();
        //store the id and the login as session variables.
        $_SESSION['id'] = $data['VoterID'];
        $_SESSION['login'] = $login;
        $_SESSION['database'] = $database;

        if (!$data['hasVoted']){
            header("Location: ../html/votingScreen.html");
        }

        echo " <h1>Vote has already been casted!!</h1>";
    }
    else{
        echo " <h1>Incorrect username or password.</h1>";
    }



}



function createConnection($serverName,  $userName, $password, $databaseName){
    $database = new mysqli($serverName, $userName, $password, $databaseName);

    if ($database->connect_error){
        die("Connection to " . $databaseName . " failed." . $database->connect_error);
    }
    return $database;
}
