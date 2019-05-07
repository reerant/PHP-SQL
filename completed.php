<?php
//includes database details and connection 
include 'DBconn.php';

//when user clicks checked icon on specific task on the task page,
//it will send taskID and status number(default is always 0 when a new task is created into DB) to this page.
$id = $_GET['id'];
$status = $_GET['status'];

//status = 0 means task is not marked as done (false)
//status = 1 means taks is marked as done (true)
//this status number is affecting whether the task will have a strike through or not in the user's task list. 
if ($status == 0) {
    $boolean = 1;
    //makes sql query with prepared statements 
    $sql = $conn->prepare("UPDATE task SET completed=? WHERE taskID=?");
    $sql->bind_param("ii", $boolean, $id);
    $sqlStatus = $sql->execute();
} else {
    $boolean = 0;
    $sql = $conn->prepare("UPDATE task SET completed=? WHERE taskID=?");
    $sql->bind_param("ii", $boolean, $id);
    $sqlStatus = $sql->execute();
}

//if updating data into the DB succeeds, user is directed back to the task page.
//if not, an error message is shown.
if ($sqlStatus === true) {
    header("Location:todos.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
