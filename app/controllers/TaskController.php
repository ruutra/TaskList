<?php

namespace App\Controllers;

use App\Models\Task;
use Exception;

class TaskController
{
    /** @var Task */
    private $task;

    public function __construct()
    {
        $this->task = new Task();
    }

    public function getUserTask(array $request, int $userId): array
    {
        $data = $this->task->getTasks($userId);
        return ['tasks.php', $data];
    }

    /**
     * @param array $request
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function addUserTask(array $request, int $userId): array
    {
        $this->task->addTask($request['task_text'], $userId);
        $data = $this->task->getTasks($userId);
        return ['tasks.php', $data];
    }

    /**
     * @param array $request
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function toggleUserTask(array $request, int $userId): array
    {
        $this->task->taskReadyToggle((int) $request['task_ready_toggle'], $userId);
        $data = $this->task->getTasks($userId);
        return ['tasks.php',$data];
    }

    /**
     * @param array $request
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function userTaskReadyAll(array $request, int $userId): array
    {
        $this->task->taskReadyAll((int)$request['task_ready_toggle'], $userId);
        $data = $this->task->getTasks($userId);
        return ['tasks.php',$data] ;
    }

    /**
     * @param array $request
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function deleteUserTask(array $request, int $userId): array
    {
        $this->task->deleteTask($request['task_delete'],$userId);
        $data = $this->task->getTasks($userId);
        return ['tasks.php',$data];
    }

    /**
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function removeAllUserTasks(array $request,int $userId): array
    {
        $this->task->removeAllTasks($userId);
        $data = $this->task->getTasks($userId);
        return ['tasks.php',$data];
    }
}