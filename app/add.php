<?php

function addTask ($conn, $text, $userId)
{
    if (!$text) {
        echo '<script>alert("Введите описание задачи!")</script>';
        return;
    }

    $sql = "insert into `tasks`.`tasks` (`user_id`, `description`,`status`,`created_at`) values (?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId, $text,0]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        echo '<script>alert("Запись успешно добавлена!")</script>';
    }
}

