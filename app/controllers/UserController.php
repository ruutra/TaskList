<?php

namespace App\Controllers;

use App\Models\Task;
use App\Models\User;
use Exception;

class UserController {

    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * @param array $request
     * @return array
     * @throws Exception
     */
    public function userAuth(array $request)
    {
        $login = filter_var(trim($request['login']),FILTER_SANITIZE_STRING);
        $password = filter_var(trim($request['password']),FILTER_SANITIZE_STRING);

        if(!$login){
            throw new Exception ('Некорректные данные для логина! ');
        }

        if(!$password){
            throw new Exception('Некорректные данные для пароля!');
        }

        $userId = $this->user->auth($login,$password);
        $_SESSION['id'] = $userId;
        $data = (new Task())->getTasks($userId);
        return ['tasks.php', $data];
    }

    /**
     * @param array $request
     * @param $userId
     * @return array
     */
    public function exit(array $request, $userId): array
    {
        $_SESSION['id'] = null;
        return ['auth.php', null];
    }
}
