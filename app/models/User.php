<?php

include_once 'database/DB.php';

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
     * @param array $request
     * @param null $userId
     * @return null|int
     * @throws Exception
     */
    public function auth(array $request, $userId): ?int
    {
        $login = filter_var(trim($request['login']),FILTER_SANITIZE_STRING);
        $password = filter_var(trim($request['password']),FILTER_SANITIZE_STRING);

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
    private function registration($login, $password): ?int
    {
        if ($login == '') {
            throw new Exception('Неверный логин!');
        }
        if ($password == '' || mb_strlen($password) < 8) {
            throw new Exception('Недопустимая длина пароля!');

        }
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "insert into `tasks`.`users` (`login`, `password`,`created_at`) values (?, ?, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$login, $hash]);
        $result = $stmt->execute([$login,$password]);
        if (!$result) {
            throw new Exception('Ошибка при регитрации!');
        }
        $id = $this->db->lastInsertId();
        return $id ? (int) $id : null;
    }

    public function exit(array $request, $userId)
    {
        return null;
    }
}