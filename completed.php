<?php

include 'head.php';
include 'DBconn.php';

$id = $_GET['id'];
$status = $_GET['status'];

if ($status == 0) {
    $boolean = 1;
    $sql = $conn->query("UPDATE task SET completed='$boolean' WHERE taskID=$id");
} else {
    $boolean = 0;
    $sql = $conn->query("UPDATE task SET completed='$boolean' WHERE taskID=$id");
}

if ($sql === TRUE) {
    header("Location:todos.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();

include 'footer.php';
