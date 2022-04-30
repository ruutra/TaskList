<?php

include_once 'models/User.php';
include_once 'models/Task.php';

class Controller
{
    const ROUTS = [
        'auth' => ['class' => 'User', 'method' => 'auth', 'redirect' => 'tasks.php', 'template' => 'auth.php', 'auth' => false],
        'exit' => ['class' => 'User', 'method' => 'exit', 'template' => 'auth.php'],

        'index' => ['class' => 'Task', 'method' => 'getTasks', 'template' => 'tasks.php', 'auth' => true],
        'add_task' => ['class' => 'Task', 'method' => 'addTask', 'template' => 'tasks.php', 'auth' => true],
        'ready_toggle' => ['class' => 'Task', 'method' => 'taskReadyToggle', 'template' => 'tasks.php', 'auth' => true],
        'ready_all' => ['class' => 'Task', 'method' => 'taskReadyAll', 'template' => 'tasks.php', 'auth' => true],
        'task_delete' => ['class' => 'Task', 'method' => 'deleteTask', 'template' => 'tasks.php', 'auth' => true],
        'remove_all' => ['class' => 'Task', 'method' => 'removeAllTasks', 'template' => 'tasks.php', 'auth' => true],
    ];

    /**
     * @return bool
     */
    public function handleRequest(): bool
    {
        $page = 'index';
        if (!empty($_REQUEST)) {
            $page = $_REQUEST['action'] ?? $page;
        }

        if (!isset(self::ROUTS[$page])) {
            header('HTTP/1.1 404 Not Found');
            return $this->render('views/404.html');
        }

        $route = self::ROUTS[$page];
        if ($route['auth'] && !isset($_SESSION['id'])) {
            return $this->render('views/auth.php');
        }

        $userId = $_SESSION['id'] ?: null;
        try {
            $class = new $route['class'];
            $data = $class->{$route['method']}($_POST, $userId);
        } catch (Exception $e) {
            echo sprintf("<script>alert('Ошибка: %s')</script>", $e->getMessage());
            $data = $route['class'] === `User` ? [] : (new Task())->getTasks($_POST, $userId);
        }

        if (isset($route['redirect']) && $data) {
            $_SESSION['id'] = $data;
            $data = (new Task())->getTasks($_POST, $userId);
            $template = 'views/' . $route['redirect'];
        } else {
            $template = 'views/' . $route['template'];
        }

        return $this->render($template, $data);
    }

    /**
     * @param string $template
     * @param mixed $data
     * @return bool
     */
    private function render(string $template, $data = null): bool
    {
        ob_start();
        if (is_array($data)) {
            extract($data);
        }
        include $template;
        echo ob_get_clean();
        return true;
    }

    private function redirect($path) {
        header('HTTP/1.1 301');
        header('Location: ' . $path, true, 301);
    }
}