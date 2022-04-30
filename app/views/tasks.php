<?php

ob_start();
session_start();

if (isset($_POST['exit'])) {
    unset($_SESSION['userId']);
}

if (!$_SESSION['userId']) {
    header('HTTP/1.1 301');
    header('Location: http://localhost/auth.php', true, 301);
}

include 'app/app.php';
$tasks = getTasks($_SESSION['userId']);
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
        <div class="container">
            <h1>Task list</h1>
            <form action="index.php" method="post">
                <div class="add_task actions">
                    <input class="add_task_text" type="text" name="task_text" placeholder="Enter text...">
                    <button type="submit" name="add_task" class="btn btn-primary">ADD TASK</button>
                    <button name="exit" class="btn btn-danger">Exit</button>
                </div>
                <div class="tasks_edit actions">
                    <button type="submit" name="task_remove_all" class="btn btn-warning">REMOVE ALL</button>
                    <button type="submit" name="task_ready_all" class="btn btn-success">READY ALL</button>
                </div>
                <input type="text" name="tasks" value='<?php echo json_encode($tasks) ?>' hidden>
                <?php
                    if ($tasks) {
                        echo '<div class="task_list actions">';
                        foreach ($tasks as $key => $task) {
                            include 'task.php';
                        }
                        echo '</div>';
                    }
                ?>
            </form>
        </div>
    </body>
</html>