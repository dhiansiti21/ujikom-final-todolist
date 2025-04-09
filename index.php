<?php
include 'database.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];

if (isset($_POST['add'])) {
    $task = $_POST['task'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];

    // Insert task dengan user_id
    $q_insert = "INSERT INTO tasks (user_id, tasklabel, taskstatus, priority, deadline) VALUES ('$user_id', '$task', 'open', '$priority', '$deadline')";
    $run_q_insert = mysqli_query($conn, $q_insert);

    if ($run_q_insert) {
        header('Refresh:0; url=index.php');
    }
}

if (isset($_POST['add_subtask'])) {
    $taskid = $_POST['taskid'];
    $subtasklabel = $_POST['subtasklabel'];

    // Insert subtask (pastikan taskid milik user)
    $q_check_task = "SELECT * FROM tasks WHERE taskid = '$taskid' AND user_id = '$user_id'";
    $run_q_check = mysqli_query($conn, $q_check_task);

    if (mysqli_num_rows($run_q_check) > 0) {
        $q_insert_subtask = "INSERT INTO subtasks (taskid, subtasklabel, subtaskstatus) VALUES ('$taskid', '$subtasklabel', 'open')";
        $run_q_insert_subtask = mysqli_query($conn, $q_insert_subtask);
    }

    header('Refresh:0; url=index.php');
}

// Ambil hanya tasks milik user yang login
$q_select = "SELECT * FROM tasks WHERE user_id = '$user_id' ORDER BY taskid DESC";
$run_q_select = mysqli_query($conn, $q_select);

// Hapus task hanya jika milik user
if (isset($_GET['delete'])) {
    $taskid = $_GET['delete'];
    $q_delete = "DELETE FROM tasks WHERE taskid = '$taskid' AND user_id = '$user_id'";
    $run_q_delete = mysqli_query($conn, $q_delete);
    header('Refresh:0; url=index.php');
}

// Update status task hanya jika milik user
if (isset($_GET['done'])) {
    $task_id = $_GET['done'];

    // Cek apakah task milik user
    $q_check_task = "SELECT tasklabel, taskstatus FROM tasks WHERE taskid = '$task_id' AND user_id = '$user_id'";
    $run_q_check = mysqli_query($conn, $q_check_task);
    
    if (mysqli_num_rows($run_q_check) > 0) {
        $task = mysqli_fetch_assoc($run_q_check);
        $previous_status = $task['taskstatus'];
        $new_status = ($previous_status == 'open') ? 'close' : 'open';

        // Update status
        $q_update = "UPDATE tasks SET taskstatus = '$new_status' WHERE taskid = '$task_id'";
        mysqli_query($conn, $q_update);

        // Simpan riwayat perubahan
        $q_insert_history = "INSERT INTO history (task_id, task_label, previous_status, new_status) 
                             VALUES ('$task_id', '".$task['tasklabel']."', '$previous_status', '$new_status')";
        mysqli_query($conn, $q_insert_history);
    }

    header('Refresh:0; url=index.php');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="woy1.css">
</head>
<body>

<div class="container">
<div class="header">
    <div class="title">
        <i class='bx bxs-book'></i>
        <i class='bx bx-pencil'></i>
        <span>To Do List</span>
    </div>

    <div class="description">
        <?= date("l, d M Y") ?>
    </div>

    <div class="logout-form">
        <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Logout</button>
        </form>
        <a href="history.php">
            <button class="logout-button">History</button>
        </a>
    </div>
</div>


    <div class="content">
        <div class="card">
            <form action="" method="post">
                <div class="input-box">
                    <input type="text" name="task" class="input-control" placeholder="Add task" required>
                </div>

                <div class="input-box">
                    <select name="priority" class="input-control" required>
                        <option value="rendah">Rendah</option>
                        <option value="tinggi">Tinggi</option>
                    </select>
                </div>

                <div class="input-box">
                    <input type="date" name="deadline" class="input-control" required>
                </div>

                <div class="text-right">
                    <button type="submit" name="add">Add</button>
                </div>
            </form>
        </div>

        <?php
        if (mysqli_num_rows($run_q_select) > 0) {
            while ($r = mysqli_fetch_array($run_q_select)) {
                $priorityClass = ($r['priority'] == 'tinggi') ? 'high-priority' : 'low-priority';
        ?>
            <div class="card <?= $priorityClass ?>">
                <div class="task-item <?= $r['taskstatus'] == 'close' ? 'done' : '' ?>">
                    <div>
                        <input type="checkbox" onclick="window.location.href = '?done=<?= $r['taskid'] ?>&status=<?= $r['taskstatus'] ?>'" <?= $r['taskstatus'] == 'close' ? 'checked' : '' ?>>
                        <a href="subtasks.php?taskid=<?= $r['taskid'] ?>" style="text-decoration: none;"><span><?= htmlspecialchars($r['tasklabel'], ENT_QUOTES, 'UTF-8') ?></span></a>
                    </div>
                    <div>
                        <?php
                        $priorityClass = ($r['priority'] == 'tinggi') ? 'high-priority-text' : 'low-priority-text';
                        ?>
                        <span class="priority-label <?= $priorityClass ?>"><?= ucfirst($r['priority']) ?></span> 
                        <span class="deadline"><?= $r['deadline'] ? date("d M Y", strtotime($r['deadline'])) : 'No Deadline' ?></span>
                        <a href="edit.php?id=<?= $r['taskid'] ?>" class="text-orange" title="Edit"><i class="bx bx-edit"></i></a>
                        <a href="?delete=<?= $r['taskid'] ?>" class="text-red" title="Remove" onclick="return confirm('Are you sure?')"><i class="bx bx-trash"></i></a>
                    </div>
                </div>
            </div>
        <?php 
            }
        } else { 
        ?>
            <div>Belum ada task</div>
        <?php 
        }
        ?>
    </div>
</div>

</body>
</html>
