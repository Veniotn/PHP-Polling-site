<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
//Check which button they pressed.
    $candidate = $_POST['Candidate'];

    //create a new db connection
    $database = createConnection($_SESSION['serverName'], $_SESSION['dbUsername'], $_SESSION['dbPassword'],
                                                                                   $_SESSION['dbName']);

    //update the candidates vote count
    $sqlText = "UPDATE candidates SET votes = votes+1 WHERE Name = ?";
    updateQueryOneParam($database, $sqlText, $candidate);


    //set the voters has voted variable
    $sqlText = "UPDATE voters SET hasVoted = 1 WHERE Login  = ?";
    updateQueryOneParam($database, $sqlText, $_SESSION['login']);



    echo "<h1> Successfully voted for $candidate! </h1>";
    echo "<button id='mainMenuButton' onclick=\"location.href='../html/loginScreen.html'\">Main Menu!</button>";
}


function createConnection($serverName,  $userName, $password, $databaseName){
    $database = new mysqli($serverName, $userName, $password, $databaseName);

    if ($database->connect_error){
        die("Connection to " . $databaseName . " failed." . $database->connect_error);
    }
    return $database;
}

function updateQueryOneParam($db, $query, $param){
    $sqlQuery = $db->prepare($query);
    $sqlQuery->bind_param("s", $param);
    $sqlQuery->execute();

}

