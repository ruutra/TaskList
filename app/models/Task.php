<?php

namespace App\Models;

use PDO;
use Exception;
use Database\DB;

class Task
{
    /** @var PDO */
    private $db;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $db = new DB();
        $this->db = $db->connectDB();
    }

    /**
     * @param int $userId
     * @return array|false
     */
    public function getTasks(int $userId): array
    {
        $sql = "SELECT id, description as title, status as isReady FROM `tasks`.`tasks` WHERE `user_id` = ?";;

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $text
     * @param int $userId
     * @return array|false
     * @throws Exception
     */
    public function addTask(string $text, int $userId): void
    {
        if (!$text) {
            throw new Exception('Введите описание задачи!');
        }

        $sql = "insert into `tasks`.`tasks` (`user_id`, `description`,`status`,`created_at`) values (?, ?, ?, NOW())";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$userId, $text, 0]);
        if (!$result) {
            throw new Exception('Не удалось добавить запись!');
        }
    }

    /**
     * @param array $id
     * @param int $userId
     * @return array|false
     * @throws Exception
     */
    public function taskReadyToggle($id, int $userId): void
    {
        $sql = "SELECT status FROM `tasks`.`tasks` WHERE `id` = ? and `user_id` = ?";;
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id, $userId]);
        $status = $stmt->fetch(PDO::FETCH_COLUMN);
        if ($status !== '1' && $status !== '0') {
            throw new Exception('Запись не найдена....');
        }

        $sql = "update `tasks`.`tasks` set `status` = ? where `id` = ? and `user_id` = ?";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([(int)!$status,$id, $userId]);
        if (!$result) {
            throw new Exception('Не удалось записать');
        }
    }

    /**
     * @param int $userId
     * @return array|false
     * @throws Exception
     */
    public function taskReadyAll( $id ,int $userId): void
    {
        $sql = "update `tasks`.`tasks` set `status` = ? where `user_id` = ?";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([1, $userId]);
        if (!$result) {
            throw new Exception('Не удалось обновить...');
        }
    }

    /**
     * @param $id
     * @param int $userId
     * @return array|false
     * @throws Exception
     */
    public function deleteTask($id, int $userId): void
    {
        $sql = "delete from `tasks`.`tasks` where `id` = ? and `user_id` = ?";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$id, $userId]);
        if (!$result) {
            throw new Exception('Не удалось удалить');
        }
    }

    /**
     * @param $delete
     * @param int $userId
     * @return array|false
     * @throws Exception
     */
    public function removeAllTasks(int $userId): void
    {
        $sql = "delete from `tasks`.`tasks` where `user_id` = ?";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$userId]);
        if(!$result){
            throw new Exception('Не удалось удалить');
        }
    }
}