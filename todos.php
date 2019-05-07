<?php

//including html head section and jumbotron
include 'head.php';

// Starts the session. if false, directs back to login page.
session_start();
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
} else {
    header('Location: index.php');
}
?>
<!-- basic structure for ToDos list -->
<div id="myTodos">
    <div class="row">
        <div class="col-sm-12">
            <img data-toggle="tooltip" data-placement="bottom" title="<?php echo $fname . " " . $lname; ?>" src="pics/user.png" alt="userIcon" style="width:40px;height:40px;">
            <a onClick="return logout()" style="float:right" href="logout.php" data-toggle="tooltip" data-placement="bottom" title="Logout"><img src="pics/logout.png" alt="logoutIcon" style="width:35px;height:35px;"></a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <a href="addForm.php" data-toggle="tooltip" data-placement="bottom" title="Add new task"><img src="pics/addtask.png" alt="add new task" style="width:45px;height:45px;"></a>
        </div>
    </div>
    <br>

    <?php include 'DBconn.php';
    //DB details and connection included
    //Creates SQL query to get task data from database
    $sql = "SELECT * FROM task WHERE userID='$userID'";

    // user can sort tasks by deadline or priority
    if (isset($_GET['sort'])) {

        if ($_GET['sort'] == 'date') {
            $sql .= " ORDER BY date";
        } elseif ($_GET['sort'] == 'priority') {
            $sql .= " ORDER BY CASE priority  when 'High' then '0' when 'Medium' then '1' when 'Low' then '2' END";
        }
    }
    $result = $conn->query($sql);

    //displays results in a table
    if ($result->num_rows > 0) {
        echo " 
        <div style='overflow-x:auto;'>
          <table class='table table-striped'>
            <thead>
                <tr>
                <th>Task</th>
                <th><a class='sort' href='todos.php?sort=date'>Deadline</a></th>
                <th><a class='sort' href='todos.php?sort=priority'>Priority</a></th>
                <th style='width: 170px;'>Tools</th>
                </tr>
            </thead>
            <tbody>";
        while ($row = $result->fetch_assoc()) {
            //if task is marked as done, the task will have a strike through
            //otherwise shown as normal
            if ($row["completed"] == 1) {
                echo "
                <tr>
                    <td class= 'completed'>" . $row["description"] . "</td>
                    <td class='completed'>" . date('d-m-Y', strtotime($row['date'])) . "</td>
                    <td class= 'completed'>" . $row["priority"] . "</td>
                    <td>";
            } else {

                echo "
                <tr>
                    <td>" . $row["description"] . "</td>
                    <td>" . date('d-m-Y', strtotime($row['date'])) . "</td>
                    <td>" . $row["priority"] . "</td>
                    <td>";
            }
            echo "  <a href='completed.php?id=" . $row["taskID"] . "&status=" . $row["completed"] . "' data-toggle='tooltip' data-placement='bottom' title='Mark as done'><img src='pics/check.png' width='30' height='30' alt='delete'></a>
                    <a href='editForm.php?id=" . $row["taskID"] . "' data-toggle='tooltip' data-placement='bottom' title='Edit'><img src='pics/edit.png' width='30' height='30' alt='edit'></a>
                    <a onClick='return confirmation()' href='delete.php?id=" . $row["taskID"] . "' data-toggle='tooltip' data-placement='bottom' title='Delete' ><img src='pics/delete.png' width='30' height='30' alt='delete'></a>
                    </td>
            </tr>";
        }
        echo
            "</tbody>
         </table></div>";
    } else {
        // if there are no tasks in database, this message shows on the site     
        echo "Your ToDo-list is empty. Start adding new tasks by clicking the plus sign.";
    }

    $conn->close();
    ?>
</div>
<br>
<br>
<!--shows little infotext when hoovering over tool-icon  -->
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<!-- includes footer details -->
<?php include 'footer.php'; ?>