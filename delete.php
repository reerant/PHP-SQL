<?php
//starts session and checks userID. if false, directs back to login page.
session_start();
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
} else {
    header('Location: index.php');
}

//includes database details and connection 
include 'DBconn.php';

//when user clicks delete icon on a specific task row on the task page it will send taskID to this page.
$taskID = $_GET['id'];

//makes sql query with prepared statements  
$sql = $conn->prepare("DELETE FROM task WHERE taskID=? AND userID=?");
$sql->bind_param("ss", $taskID, $userID);
$status = $sql->execute();

//if deleting data from the DB succeeds, user is directed back to the task page.
//if not, an error message is shown.
if ($status === true) {
    header("Location: todos.php");
} else {
    trigger_error("Delete not successful");
}

$conn->close();
