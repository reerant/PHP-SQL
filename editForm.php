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

//if user clicks save-button, code below will be executed.
//takes string values from the form and places them into variables that are used with sql query.
//FILTER_SANITIZE_STRING removes HTML tags 
if (isset($_POST['save'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
    $task = filter_var($_POST['task'], FILTER_SANITIZE_STRING);
    $date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
    $priority = filter_var($_POST['priority'], FILTER_SANITIZE_STRING);

    //makes sql query with prepared statements 
    $sql = $conn->prepare("UPDATE task SET description=?, date=?, priority=? WHERE taskID=? AND userID=?");
    $sql->bind_param("sssss", $task, $date, $priority, $id, $userID);
    $status = $sql->execute();

    //if updating data into the DB succeeds, user is directed back to the task page.
    //if not, an error message is shown.
    if ($status === true) {
        header("Location: todos.php");
    } else {
        trigger_error("Update not successful");
    }

    $conn->close();
}
?>

<?php
//includes database details and connection
include 'DBconn.php';

//when user clicks edit icon on a specific task row on the task page, it will send taskID to this page.
$id = $_GET['id'];

//creates sql query with prepared statements to select data to show task details on UI.
$sql = $conn->prepare("SELECT * FROM task WHERE taskID=?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $task = $row['description'];
        $date = $row['date'];
        $priority = $row['priority'];
    }
}
$conn->close();
?>

<!--includes html head section and jumbotron -->
<?php include 'head.php'; ?>

<!--HTML/ page structure  -->
<div id="myTodos">
    <!-- validateForm checks if there are any empty fields in the form when submitting -->
    <form action="editForm.php" name="addForm" method="post" id="addForm" onsubmit="return validateForm()">
        <!-- shows task's data selected from DB -->
        <div class="form-group col-md-6">
            <label for="task">Edit task</label>
            <input type="text" class="form-control" name="task" id="task" value="<?php echo $task; ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="date">Edit deadline</label>
            <input type="date" class="form-control" name="date" id="date" value="<?php echo $date; ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="priority">Edit priority</label>
            <select name="priority" id="priority">
                <!--shows task's selected priority level-->
                <option value="High" <?php if ($priority == "High") echo "selected"; ?>>High</option>
                <option value="Medium" <?php if ($priority == "Medium") echo "selected"; ?>>Medium</option>
                <option value="Low" <?php if ($priority == "Low") echo "selected"; ?>>Low</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $id; ?>">
        </div>
        <div class="form-group col-md-6">
            <button type="submit" class="btn btn-secondary" name="save">Save</button>
            <a class="btn btn-secondary" href="todos.php" role="button">Cancel</a>
        </div>
    </form>
</div>
<!--includes footer info -->
<?php include 'footer.php'; ?>