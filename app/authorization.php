<?php

require __DIR__ . '/../database/DB.php';

/**
 * @throws Exception
 */
function authorization ($login, $password)
{
    $db = new DB();
    $conn = $db->connectDB();

    $login = filter_var(trim($login),FILTER_SANITIZE_STRING);
    $password = filter_var(trim($password),FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM `tasks`.`users` WHERE `login` = ?";
    $query = $conn->prepare($sql);
    $query->execute([$login]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        register($login, $password);
        return;
    }

    if(password_verify($password, $user['password'])) {
        echo 'Авторизация прошла успешно';
        redirectToIndex($user['id']);
    }

    echo '<script>alert("Неверный пароль!")</script>';
}

/**
 * @throws Exception
 */
function register ($login, $password)
{
    $db = new DB();
    $conn = $db->connectDB();

    if ($login == '') {
        echo '<script>alert("Неверный логин!")</script>';
        return;
    }
    if ($password == '' || mb_strlen($password) < 8) {
        echo '<script>alert("Недопустимая длина пароля!")</script>';
        return;
    }
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "insert into `tasks`.`users` (`login`, `password`,`created_at`) values (?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$login, $hash]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo '<script>alert("Регистрация прошла успешно!")</script>';
    }
    redirectToIndex($conn->lastInsertId());
}

function redirectToIndex ($id)
{
    $_SESSION['userId'] = $id;
    header('HTTP/1.1 301');
    header('Location: http://localhost/index.php', true, 301);
}
