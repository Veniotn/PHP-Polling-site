<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin panel</title>
    <link rel="stylesheet" href="../CSS/adminScreen.css">
    <link rel="stylesheet" href="../CSS/basicStyles.css">
</head>

<body>
<div class="topSection">
    <h1 id="headerMessage">Admin Panel</h1>
    <h1 id="pollingResultsMessage">Polling results</h1>
    <button id="fixIssuesButton">Fix Issues</button>
</div>

<?php
include "util.php";
session_start();

//connect to the db
$databaseConnection = createConnection($_SESSION['serverName'], $_SESSION['dbUsername'], $_SESSION['dbPassword'], $_SESSION['dbName']);
//query the results of the pole
$sqlText = "SELECT Name, votes FROM candidates ORDER BY votes DESC";
$queryResult = selectQuery($databaseConnection, $sqlText);

//display the top two Candidates
echo "<div class='section-container'>";
echo "<h1 id='prompt'> Top two candidates:</h1>";
for ($i = 0; $i< 2; $i++){
    $dataRow = $queryResult->fetch_assoc();
    printCandidateInfo($dataRow);
}
echo "</div>";

//reset the dataset
$queryResult->data_seek(0);
//move the pointer to the last index of the dataset, which will be  lowest voted candidate
$queryResult->data_seek($queryResult->num_rows -1);
$dataRow = $queryResult->fetch_assoc();

//print the result.
echo "<div class='section-container'>";
echo "<h1 id='prompt'>Lowest voted candidate: </h1>";
printCandidateInfo($dataRow);
echo "</div>";

//reset the dataset again
$queryResult->data_seek(0);

//display the entire result.
echo "<div class='section-container'>";
echo "<h1 id='prompt'>Full Results:</h1><br>";
while ($dataRow =  $queryResult->fetch_assoc()){
    printCandidateInfo($dataRow);
}
echo "</div>";

//reset one more time and show the winner.
$queryResult->data_seek(0);
echo "<div class='section-container'>";
echo "<h1 id='prompt'>Winner: </h1>";
$dataRow = $queryResult->fetch_assoc();
printCandidateInfo($dataRow);
echo "</div>";

?>



</body>
</html>
