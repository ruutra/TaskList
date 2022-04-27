<?php
ob_start();
session_start();

include 'app/authorization.php';

$login = $_POST['login'];
$password = $_POST['password'];
if (isset($login, $password)) {
    authorization($login, $password);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskList</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
        </head>
        <body>
            <div>
                <h1>Authorization</h1>
                    <form action="auth.php" method="post">
                        <div class="mb-3">
                            <label for="exampleInputLogin" class="form-label">Login</label>
                            <input type="text" name="login" class="form-control" id="exampleInputLogin">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

            </div>
        </body>
</html>
