<?php

include_once 'database/DB.php';

class Task
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
     * @param int $userId
     * @return array|false
     */
    public function getTasks(array $request, int $userId): array
    {
        $sql = "SELECT id, description as title, status as isReady FROM `tasks`.`tasks` WHERE `user_id` = ?";;

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $request
     * @param int $userId
     * @return array|false
     * @throws Exception
     */
    public function addTask(array $request, int $userId): array
    {
        if (!$request['task_text']) {
            throw new Exception('Введите описание задачи!');
        }

        $sql = "insert into `tasks`.`tasks` (`user_id`, `description`,`status`,`created_at`) values (?, ?, ?, NOW())";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$userId, $request['task_text'], 0]);
        if (!$result) {
            throw new Exception('Не удалось добавить запись!');
        }

        return $this->getTasks([], $userId);
    }

    /**
     * @param array $request
     * @param int $userId
     * @return array|false
     * @throws Exception
     */
    public function taskReadyToggle(array $request, int $userId): array
    {
        $sql = "SELECT status FROM `tasks`.`tasks` WHERE `id` = ? and `user_id` = ?";;
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$request['task_ready_toggle'], $userId]);
        $status = $stmt->fetch(PDO::FETCH_COLUMN);
        if (!$request) {
            throw new Exception('Запись не найдена....');
        }

        $sql = "update `tasks`.`tasks` set `status` = ? where `id` = ? and `user_id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([(int)!$status, $request['task_ready_toggle'], $userId]);
        if (!$request['task_ready_toggle']) {
            throw new Exception('Не удалось записать');
        }

        return $this->getTasks([], $userId);
    }

    /**
     * @param array $request
     * @param int $userId
     * @return array|false
     * @throws Exception
     */
    public function taskReadyAll(array $request, int $userId): array
    {
        $sql = "update `tasks`.`tasks` set `status` = ? where `user_id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([1, $userId]);
        if (!$request) {
            throw new Exception('Не удалось обновить...');
        }

        return $this->getTasks([], $userId);
    }

    /**
     * @param array $request
     * @param int $userId
     * @return array|false
     * @throws Exception
     */
    public function deleteTask(array $request, int $userId): array
    {
        $sql = "delete from `tasks`.`tasks` where `id` = ? and `user_id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$request['task_delete'], $userId]);
        if (!$request) {
            throw new Exception('Не удалось удалить');
        }

        return $this->getTasks([], $userId);
    }

    /**
     * @param array $request
     * @param int $userId
     * @return array|false
     * @throws Exception
     */
    public function removeAllTasks(array $request, int $userId): array
    {
        $sql = "delete from `tasks`.`tasks` where `user_id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        if (!$request) {
            throw new Exception('Не удалось удалить');
        }

        return $this->getTasks([], $userId);
    }




}