<?php

function deleteTask ($conn, $id, $user_Id)
{
    $sql = "delete from `tasks`.`tasks` where `id` = ? and `user_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id,$user_Id]);
}

function removeAllTasks ($conn, $userId)
{
    $sql = "delete from `tasks`.`tasks` where `user_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId]);
}
