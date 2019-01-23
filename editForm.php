<?php
session_start();
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
}

include 'DBconn.php';
if (isset($_POST['save'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
    $task = filter_var($_POST['task'], FILTER_SANITIZE_STRING);
    $date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
    $priority = filter_var($_POST['priority'], FILTER_SANITIZE_STRING);

    $sql = $conn->prepare("UPDATE task SET description=?, date=?, priority=? WHERE taskID=? AND userID=?");
    $sql->bind_param("sssss", $task, $date, $priority, $id, $userID);
    $status = $sql->execute();

    if ($status === true) {
        header("Location: todos.php");
    } else {
        trigger_error("Update not successful");
    }


    $conn->close();
}
?>

<?php
include 'DBconn.php';
$id = $_GET['id'];
$sql = $conn->query("SELECT * FROM task WHERE taskID=$id");

if ($sql->num_rows > 0) {

    while ($row = $sql->fetch_assoc()) {
        $task = $row['description'];
        $date = $row['date'];
        $priority = $row['priority'];
    }
}
$conn->close();
?>

<?php include 'head.php'; ?>
<div id="myTodos">
    <form action="editForm.php" name="addForm" method="post" id="addForm" onsubmit="return validateForm()">
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
<?php include 'footer.php'; ?>