<?php
include 'util.php';


// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    // Get the username and password from the form data
    $login = $_POST['username'];
    $loginPassword = $_POST['password'];


    //Check if the username and password are valid

    //Connect to database
    $servername = "localhost";
    $dbName = "PollingSystemDatabase";
    $dbUsername = "root";
    $dbPassword = "root";
    $database = createConnection($servername, $dbUsername, $dbPassword, $dbName);

    //set the db properties as session variables.
    $_SESSION['serverName'] = $servername;
    $_SESSION['dbUsername'] = $dbUsername;
    $_SESSION['dbPassword'] = $dbPassword;
    $_SESSION['dbName']     = $dbName;



    //Query the database(return the id so we can use it as a session token).
    $sqlText = "SELECT VoterID, hasVoted FROM voters WHERE Login = ? AND Password = ?";
    $queryResult = checkLogin($database, $sqlText, $login, $loginPassword);

    //check if the query was successful
    if ($queryResult->num_rows > 0){

        $data = $queryResult->fetch_assoc();
        //store the id and the login as session variables.
        $_SESSION['id'] = $data['VoterID'];
        $_SESSION['login'] = $login;



        if (!$data['hasVoted']){
            header("Location: ../html/votingScreen.html");
        }
        else{
            echo " <h1>Vote has already been casted!!</h1>";
            echo "<button id='mainMenuButton' onclick=\"location.href='./loginPage.php'\">Return</button>";
        }

    }
    else{
        //check if they're an admin.
        $sqlText = "SELECT Login FROM admins WHERE Login = ? AND Password = ?";
        $queryResult = checkLogin($database, $sqlText, $login, $loginPassword);

        if ($queryResult->num_rows > 0){
            $data = $queryResult->fetch_assoc();
            $_SESSION['id'] = $data['AdminID'];
            $_SESSION['login'] = $login;
            header("Location: ./adminScreen.php");
        }
        else{
            //if they are neither voter or admin, they have inputted incorrectly.
            $_SESSION['error'] = "Incorrect username or password.";
            header("Location: ./loginPage.php");
            exit();


        }
    }
}




