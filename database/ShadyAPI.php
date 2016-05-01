<?php
require("DemoCreds.php");
echo $_POST["method"]();
function sanitize($str, $quotes = ENT_NOQUOTES) {
    $str = htmlspecialchars($str, $quotes);
    return $str;
}
function getDatabases() {
    // retrieve and sanitize posted values.
    if (isset($_POST['server'])) {
        $server = json_decode(sanitize($_POST['server']));
    }
    if (isset($_POST['userName'])) {
        $username = json_decode(sanitize($_POST['userName']));
    }
    if (isset($_POST['password'])) {
        $password = json_decode(sanitize($_POST['password']));
    }
    $databaseNames = array();
    $dbConn = mysqli_connect($server, $username, $password);
    $query = "SHOW DATABASES";
    $result = $dbConn->query($query);
    if ($result) {
        while ($row = $result->fetch_array()) {
            array_push($databaseNames, $row[0]);
        }
    }
    $return = new stdClass;
    $return->credentials = $server + "  " + $username + "   " + $password;
    $return->success = true;
    $return->errorMessage = "";
    $return->data['database_Names'] = $databaseNames;
    $json = json_encode($return);
    return $json;
}
function insertGame() {
    // retrieve and sanitize posted values.
    if (isset($_POST['Title'])) {
        $Title = json_decode(sanitize($_POST['Title']));
    }
    if (isset($_POST['Genre'])) {
        $Genre = json_decode(sanitize($_POST['Genre']));
    }
	if (isset($_POST['Franchise'])) {
        $Franchise = json_decode(sanitize($_POST['Franchise']));
    }
	if (isset($_POST['Password'])) {
        $Password = json_decode(sanitize($_POST['Password']));
    }
    $dbConn = mysqli_connect(demoServer(), demoUsername(), $Password, demoDB());
    if ($dbConn->connect_error) {
        die("Connection failed: " . $dbConn->connect_error);
    }
    $query = "INSERT INTO games ( Title, Genre, Franchise ) " .
            "VALUES ( " .
            "'" . $Title . "', " .
            "'" . $Genre . "', " .
            "'" . $Franchise . "' );" ;
    $result = $dbConn->query($query);
    $return = new stdClass;
    $return->querystring = $query;
    if ($result) {
        //$return->connection = $dbConn;
        // $return->credentials = (string) (demoUsername() . demoPassword() . demoDB() . " on " . demoServer());
        $return->success = true;
    } else {
        $return->success = false;
    }
    return json_encode($return);
}
function updateGame() {
    // retrieve and sanitize posted values.
    if (isset($_POST['ID'])) {
      $ID = json_decode(sanitize($_POST['ID']));
    }
    if (isset($_POST['newTitle'])) {
        $newTitle = json_decode(sanitize($_POST['newTitle']));
    }
    if (isset($_POST['newGenre'])) {
        $newGenre = json_decode(sanitize($_POST['newGenre']));
    }
	if (isset($_POST['newFranchise'])) {
        $newFranchise = json_decode(sanitize($_POST['newFranchise']));
    }
	if (isset($_POST['Password'])) {
        $Password = json_decode(sanitize($_POST['Password']));
    }
    $dbConn = mysqli_connect(demoServer(), demoUsername(), $Password, demoDB());
    if ($dbConn->connect_error) {
        die("Connection failed: " . $dbConn->connect_error);
    }
    $query = "UPDATE games " + 
             "SET Franchise='" + $newFranchise + "'" + 
             "SET Title='" + $newTitle + "'" + 
             "SET Genre='" + $newGenre + "'" +          
             "WHERE ID=" + $ID;
    $result = $dbConn->query($query);
    $return = new stdClass;
    $return->querystring = $query;
    if ($result) {
        $return->success = true;
    } else {
        $return->success = false;
    }
    return json_encode($return);
}
/**
 * function getGames()
 * 
 * preconditions: a file of the form given in DemoCreds.php that contains
 *                the credentials that will be used to access the database.
 *                This is not secure -- just for demo purposes.
 * 
 * arguments: none
 *
 * action: retrieves all of the rows from table RectGames and returns
 *         them in toto in the Games property of the returned object.  
 *
 * return An object that has the following fields:
 *     connect_error: error returned from mysqli_connect but only if an error 
 *                    occured.  null otherwise
 *     success: a boolean indicating if the call was successful (true) or not
 *     Games: an array of rows as arrays of columns
 *     querystring: the query string that was executed
 *     credentials: is this a bad idea or what?
 * 
 * postconditions
 */
function getGames() {
	if (isset($_POST['Password'])) {
        $Password = json_decode(sanitize($_POST['Password']));
    }
    $dbConn = mysqli_connect(demoServer(), demoUsername(), $Password, demoDB());
    $query = "SELECT * FROM games";
    $result = $dbConn->query($query);
    if ($dbConn->connect_error) {
        $return->connect_error = "Connection failed: " . $dbConn->connect_error;
        $return->success = false;
        return json_encode($return);
    }
    $Games = array();
    if ($result) {
        while ($row = $result->fetch_array()) {
            $allColumns = array();
            for ($i = 0; $i < 4; $i++) {
                array_push($allColumns, $row[$i]);
            }
            array_push($Games, $allColumns);
        }
    }
    
    $return = new StdClass();
    $return->success = true;
    $return->Games = $Games;
    $return->querystring = $query;
    $return->credentials = 
            demoUsername() . 
            demoPassword() . 
            demoDB() . 
            " on " . 
            demoServer();
    return json_encode($return);
}

function getFranchises() {
	if (isset($_POST['Password'])) {
        $Password = json_decode(sanitize($_POST['Password']));
    }
    $dbConn = mysqli_connect(demoServer(), demoUsername(), $Password, demoDB());
    $query = "SELECT * FROM franchises";
    $result = $dbConn->query($query);
    if ($dbConn->connect_error) {
        $return->connect_error = "Connection failed: " . $dbConn->connect_error;
        $return->success = false;
        return json_encode($return);
    }
    $Games = array();
    if ($result) {
        while ($row = $result->fetch_array()) {
            $allColumns = array();
            for ($i = 0; $i < 4; $i++) {
                array_push($allColumns, $row[$i]);
            }
            array_push($Games, $allColumns);
        }
    }
    
    $return = new StdClass();
    $return->success = true;
    $return->Games = $Games;
    $return->querystring = $query;
    $return->credentials = 
            demoUsername() . 
            demoPassword() . 
            demoDB() . 
            " on " . 
            demoServer();
    return json_encode($return);
}