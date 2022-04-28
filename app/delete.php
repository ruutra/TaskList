<?php

function deleteTask ($conn, $id,$user_id)
{
    $sql = "delete from `tasks`.`tasks` where `id` = ? and `user_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id,$user_id]);
}

function removeAllTasks ($conn, $userId)
{
    $sql = "delete from `tasks`.`tasks` where `user_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId]);
}
