<?php

include_once 'add.php';
include_once 'ready.php';
include_once 'delete.php';
include_once  __DIR__ . '/../database/DB.php';

function getTasks ($userId)
{
    $conn = (new DB())->connectDB();

    if (isset($_POST['add_task'])) {
        addTask($conn, $_POST['task_text'], $userId);
    }

    if (isset($_POST['task_ready_toggle'])) {
        taskReadyToggle($conn, $_POST['task_ready_toggle']);
    }

    if (isset($_POST['task_ready_all'])) {
        taskReadyAll($conn, $userId);
    }

    if (isset($_POST['task_delete'])) {
        deleteTask($conn,$_POST['task_delete'],$userId);
    }

    if (isset($_POST['task_remove_all'])) {
        removeAllTasks($conn, $userId);
    }

    return getUserTasks($conn, $userId);
}

function getUserTasks ($conn, $userId)
{
    $sql = "SELECT id, description as title, status as isReady FROM `tasks`.`tasks` WHERE `user_id` = ?";;

    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
