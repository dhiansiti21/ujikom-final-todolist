<?php
include 'database.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['subtaskid'])) {
    header("Location: index.php");
    exit();
}

$subtaskid = $_GET['subtaskid'];

// Fetch subtask details
$q_subtask = "SELECT * FROM subtasks WHERE subtaskid = '$subtaskid'";
$run_q_subtask = mysqli_query($conn, $q_subtask);
$subtask = mysqli_fetch_assoc($run_q_subtask);

if (!$subtask) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['update_subtask'])) {
    $subtasklabel = $_POST['subtasklabel'];
    $subtaskstatus = $_POST['subtaskstatus'];
    $q_update_subtask = "UPDATE subtasks SET subtasklabel = '$subtasklabel', subtaskstatus = '$subtaskstatus' WHERE subtaskid = '$subtaskid'";
    mysqli_query($conn, $q_update_subtask);
    header("Location: subtasks.php?taskid=" . $subtask['taskid']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subtask</title>
    <link rel="stylesheet" href="woy.css">
</head>
<body>
<div class="container">
    <div class="header">
        <a href="subtasks.php?taskid=<?= $subtask['taskid'] ?>">⬅ Back</a>
        <span>Edit Subtask</span>
    </div>
    <div class="content">
        <div class="card">
            <form action="" method="post">
                <input type="text" name="subtasklabel" value="<?= htmlspecialchars($subtask['subtasklabel']) ?>" required>
                <select name="subtaskstatus">
                    <option value="open" <?= $subtask['subtaskstatus'] == 'open' ? 'selected' : '' ?>>Open</option>
                    <option value="close" <?= $subtask['subtaskstatus'] == 'close' ? 'selected' : '' ?>>Close</option>
                </select>
                <button type="submit" name="update_subtask">Update</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
