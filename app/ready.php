<?php

function taskReadyToggle ($conn, $id)
{
    $sql = "SELECT status FROM `tasks`.`tasks` WHERE `id` = ?";;
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $status = $stmt->fetch(PDO::FETCH_COLUMN);

    $sql = "update `tasks`.`tasks` set `status` = ? where `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([(int)!$status, $id]);
}

function taskReadyAll ($conn, $userId)
{
    $sql = "update `tasks`.`tasks` set `status` = ? where `user_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([1, $userId]);
}
