<?php


function createConnection($serverName,  $userName, $password, $databaseName){
    $database = new mysqli($serverName, $userName, $password, $databaseName);

    if ($database->connect_error){
        die("Connection to " . $databaseName . " failed." . $database->connect_error);
    }
    return $database;
}

function checkLogin($db, $sqlText, $login, $password){
    $databaseQuery = $db->prepare($sqlText);
    $databaseQuery->bind_param("ss", $login, $password);
    $databaseQuery->execute();
    return $databaseQuery->get_result();
}

function printCandidateInfo($dataRow){
    $candidateMessage = $dataRow['Name'] . " Votes: " .$dataRow['votes'];
    echo "<h1> $candidateMessage </h1><br>";
}

function selectQuery($db, $query){
    $dbQuery = $db->prepare($query);
    $dbQuery->execute();
    return $dbQuery->get_result();
}
function selectQueryOneParam($db, $query, $param){
    $dbQuery = $db->prepare($query);
    $dbQuery->bind_param("s", $param);
    $dbQuery->execute();
    return $dbQuery->get_result();
}

function insertQueryTwoParam($db, $query){

}

function updateQueryOneParam($db, $query, $param){
    $sqlQuery = $db->prepare($query);
    $sqlQuery->bind_param("s", $param);
    $sqlQuery->execute();

}
?>
