<?php
include 'database.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];

// Ambil history hanya untuk tasks milik user yang login
$q_history = "SELECT h.history_id, h.task_id, h.task_label, t.createdat AS start_time, t.deadline, h.change_at 
              FROM history h
              JOIN tasks t ON h.task_id = t.taskid 
              WHERE t.user_id = '$user_id' 
              ORDER BY h.change_at DESC";
$run_q_history = mysqli_query($conn, $q_history);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Perubahan</title>
    <link rel="stylesheet" href="woy1.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>History Perubahan Tugas</h2>
            <a href="index.php" class="back-button">Kembali</a>
        </div>

        <div class="content">
            <table border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Task</th>
                        <th>Waktu Dimulai</th>
                        <th>Waktu Deadline</th>
                        <th>Waktu Perubahan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($run_q_history) > 0) { 
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($run_q_history)) { ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= htmlspecialchars($row['task_label']) ?></td>
                                <td><?= date("d M Y, H:i", strtotime($row['start_time'])) ?></td>
                                <td><?= date("d M Y, H:i", strtotime($row['deadline'])) ?></td>
                                <td><?= date("d M Y, H:i", strtotime($row['change_at'])) ?></td>
                            </tr>
                            <?php $i++; ?>
                            
                            <?php } 
                    } else { ?>
                        <tr><td colspan="5">Belum ada riwayat perubahan.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
