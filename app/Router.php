<?php

namespace App;

use Exception;

class Router
{
    const ROUTS = [
        'auth' => ['class' => 'UserController', 'method' => 'userAuth', 'auth' => false],
        'exit' => ['class' => 'UserController', 'method' => 'exit', 'auth' => true],

        'index' => ['class' => 'TaskController', 'method' => 'getUserTask', 'auth' => true],
        'add_task' => ['class' => 'TaskController', 'method' => 'addUserTask', 'auth' => true],
        'ready_toggle' => ['class' => 'TaskController', 'method' => 'toggleUserTask', 'auth' => true],
        'ready_all' => ['class' => 'TaskController', 'method' => 'userTaskReadyAll', 'auth' => true],
        'task_delete' => ['class' => 'TaskController', 'method' => 'deleteUserTask', 'auth' => true],
        'remove_all' => ['class' => 'TaskController', 'method' => 'removeAllUserTasks', 'auth' => true],
    ];

    public function handleRequest(): bool
    {
        $page = 'index';
        if (!empty($_REQUEST)) {
            $page = $_REQUEST['action'] ?? $page;
        }

        if (!isset(self::ROUTS[$page])) {
            header('HTTP/1.1 404 Not Found');
            return $this->render('404.html');
        }

        $route = self::ROUTS[$page];
        if ($route['auth'] && !isset($_SESSION['id'])) {
            return $this->render('auth.php');
        }

        $userId = $_SESSION['id'] ?: null;
        try {
            $className = 'App\\Controllers\\' . $route['class'];
            $class = new $className;
            $data = $class->{$route['method']}($_POST, $userId);
        } catch (Exception $e) {
            echo sprintf("<script>alert('Ошибка: %s')</script>", $e->getMessage());
            header('Refresh: 0; url=' . $_SERVER['PHP_SELF']);
            return false;
        }
        return $this->render($data[0], $data[1]);

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
        include __DIR__ . '\\views\\' . $template;
        echo ob_get_clean();
        return true;
    }

    private function redirect($path) {
        header('HTTP/1.1 301');
        header('Location: ' . $path, true, 301);
    }
}