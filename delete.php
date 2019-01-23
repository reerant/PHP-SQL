<?php
session_start();
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
}

include 'DBconn.php';

$taskID = $_GET['id'];

$sql = $conn->prepare("DELETE FROM task WHERE taskID=? AND userID=?");
$sql->bind_param("ss", $taskID, $userID);
$status=$sql->execute();

if ($status === true){
    header("Location: todos.php");
}else {
    trigger_error("Delete not successful");
}

$conn->close();


