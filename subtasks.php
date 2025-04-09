<?php
include 'database.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['taskid'])) {
    header("Location: index.php");
    exit();
}

$taskid = $_GET['taskid'];

// Fetch task details
$q_task = "SELECT * FROM tasks WHERE taskid = '$taskid'";
$run_q_task = mysqli_query($conn, $q_task);
$task = mysqli_fetch_assoc($run_q_task);

// Handle add subtask
if (isset($_POST['add_subtask'])) {
    $subtasklabel = $_POST['subtasklabel'];
    $q_insert_subtask = "INSERT INTO subtasks (taskid, subtasklabel, subtaskstatus) VALUES ('$taskid', '$subtasklabel', 'open')";
    mysqli_query($conn, $q_insert_subtask);
    header("Refresh:0; url=subtasks.php?taskid=$taskid");
}

// Handle delete subtask
if (isset($_GET['delete'])) {
    $subtaskid = $_GET['delete'];
    $q_delete_subtask = "DELETE FROM subtasks WHERE subtaskid = '$subtaskid'";
    mysqli_query($conn, $q_delete_subtask);
    header("Refresh:0; url=subtasks.php?taskid=$taskid");
}

// Fetch subtasks
$q_subtasks = "SELECT * FROM subtasks WHERE taskid = '$taskid' ORDER BY subtaskid DESC";
$run_q_subtasks = mysqli_query($conn, $q_subtasks);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subtasks</title>
    <link rel="stylesheet" href="woy.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="header">
        <a href="index.php" class="back-button">⬅ Back</a>
        <span>Subtasks for: <?= htmlspecialchars($task['tasklabel']) ?></span>
    </div>
    <div class="content">
        <div class="card">
            <form action="" method="post">
                <input type="text" name="subtasklabel" placeholder="Add subtask" required>
                <button type="submit" name="add_subtask">Add</button>
            </form>
        </div>
        <?php while ($subtask = mysqli_fetch_array($run_q_subtasks)) { ?>
    <div class="card">
        <div class="subtask-item">
            <div class="left">
                <input type="checkbox" onclick="window.location.href='?taskid=<?= $taskid ?>&done=<?= $subtask['subtaskid'] ?>&status=<?= $subtask['subtaskstatus'] ?>'" <?= $subtask['subtaskstatus'] == 'close' ? 'checked' : '' ?>>
                <span><?= htmlspecialchars($subtask['subtasklabel']) ?></span>
            </div>
            <div class="right">
                <a href="edit_subtask.php?subtaskid=<?= $subtask['subtaskid'] ?>" title="Edit"><i class='bx bx-edit'></i></a>
                <a href="?taskid=<?= $taskid ?>&delete=<?= $subtask['subtaskid'] ?>" title="Delete" onclick="return confirm('Are you sure?')"><i class='bx bx-trash'></i></a>
            </div>
        </div>
    </div>
<?php } ?>


    </div>
</div>
</body>
</html>