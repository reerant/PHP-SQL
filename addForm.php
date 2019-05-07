<?php
//starts session and checks userID 
session_start();
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
}

//includes database details and connection 
include 'DBconn.php';

//if user clicks add-button, code below will be executed.
//takes string values from the form and places them into variables that are used with sql query.
//FILTER_SANITIZE_STRING removes HTML tags 
if (isset($_POST['add'])) {
    $task = filter_var($_POST['task'], FILTER_SANITIZE_STRING);
    $date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
    $priority = filter_var($_POST['priority'], FILTER_SANITIZE_STRING);

    //makes sql query with prepared statements  
    $sql = $conn->prepare("INSERT INTO task(description,date,priority,userID) VALUES(?, ?, ?, ?)");
    $sql->bind_param("ssss", $task, $date, $priority, $userID);
    $status = $sql->execute();

    //if adding data into the DB succeeds, user is directed back to the task page.
    //if not, an error message is shown.
    if ($status === true) {
        header("Location: todos.php");
    } else {
        trigger_error("Adding not successful");
    }

    $conn->close();
}
?>
<!--includes html head section and jumbotron -->
<?php include 'head.php'; ?>

<!--HTML/ page structure  -->
<div id="myTodos">
    <!-- validateForm checks if there are any empty fields in the form when submitting -->
    <form action="addForm.php" name="addForm" method="post" id="addForm" onsubmit="return validateForm()">
        <div class="form-group col-md-6">
            <label for="task">New task</label>
            <input type="text" class="form-control" name="task" id="task" placeholder="Enter task">
        </div>
        <div class="form-group col-md-6">
            <label for="date">Set deadline</label>
            <input type="date" class="form-control" name="date" id="date">
        </div>
        <div class="form-group col-md-6">
            <label for="priority">Set priority for the task</label>
            <select name="priority" id="priority">
                <option value="choose" disabled selected hidden>Choose level</option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <button type="submit" class="btn btn-secondary" name="add">Add</button>
            <a class="btn btn-secondary" href="todos.php" role="button">Cancel</a>
        </div>
    </form>
</div>
<!--includes footer info -->
<?php include 'footer.php'; ?>