<?php

namespace App\Models;

use PDO;
use Exception;
use Database\DB;

class User
{
    /** @var PDO */
    private $db;

    public function __construct()
    {
        $db = new DB();
        $this->db = $db->connectDB();
    }

    /**
     * @param $login
     * @param  $password
     * @return int
     * @throws Exception
     */
    public function auth($login, $password): ?int
    {
        $sql = "SELECT * FROM `tasks`.`users` WHERE `login` = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$login]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return $this->registration($login, $password);
        }

        if(password_verify($password, $user['password'])) {
            return (int) $user['id'];
        }
        throw new Exception('Неверный пароль!');
    }

    /**
     * @param $login
     * @param $password
     * @return int|null
     * @throws Exception
     */
    public function registration($login, $password): ?int
    {
        if (mb_strlen($password) < 8) {
            throw new Exception('Недопустимая длина пароля!');
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "insert into `tasks`.`users` (`login`, `password`,`created_at`) values (?, ?, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$login, $hash]);
        $result = $stmt->execute([$login,$password]);
        if (!$result) {
            throw new Exception('Ошибка при регистрации !');
        }
        $id = $this->db->lastInsertId();
        return $id ? (int) $id : null;
    }
}