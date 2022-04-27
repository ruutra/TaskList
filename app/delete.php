<?php

function deleteTask ($conn, $id)
{
    $sql = "delete from `tasks`.`tasks` where `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
}

function removeAllTasks ($conn, $userId)
{
    $sql = "delete from `tasks`.`tasks` where `user_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId]);
}
