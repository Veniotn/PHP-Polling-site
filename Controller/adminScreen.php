<?php
//says it doesnt work in autofill but works on the webpage
include '../../Model/util.php';

session_start();

//connect to the db
$databaseConnection = createConnection($_SESSION['serverName'], $_SESSION['dbUsername'], $_SESSION['dbPassword'], $_SESSION['dbName']);

//check if they're trying to fix an issue.
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    fixIssues($databaseConnection);
}

//query the results of the pole
$sqlText = "SELECT Name, votes FROM candidates ORDER BY votes DESC";
$queryResult = selectQuery($databaseConnection, $sqlText);

//display the top two Candidates
echo "<div class='section-container'>";
echo "<h1 id='prompt'> Top two candidates:</h1>";
for ($i = 0; $i< 2; $i++){
    $dataRow = fetchRow($queryResult);
    printCandidateInfo($dataRow);
}
echo "</div>";

//reset the dataset
$queryResult= resetDataScan($queryResult);

//move the pointer to the last index of the dataset, which will be  lowest voted candidate
$dataRow = lastDataRow($queryResult);

//print the result.
echo "<div class='section-container'>";
echo "<h1 id='prompt'>Lowest voted candidate: </h1>";
printCandidateInfo($dataRow);
echo "</div>";

//reset the dataset again
$queryResult = resetDataScan($queryResult);

//display the entire result.
echo "<div class='section-container'>";
echo "<h1 id='prompt'>Full Results:</h1><br>";
while ($dataRow = fetchRow($queryResult)){
    printCandidateInfo($dataRow);
}
echo "</div>";

//reset one more time and show the winner.
$queryResult = resetDataScan($queryResult);
echo "<div class='section-container'>";
echo "<h1 id='prompt'>Winner: </h1>";
//grab the first row, it will be the winner since it's sorted in descending order.
$dataRow = fetchRow($queryResult);
printCandidateInfo($dataRow);
echo "</div>";
?>
