<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TaskList</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet"  href="../../styles/style.css">
    </head>
    <body>
        <div class="container">
            <h1>Task list</h1>
            <form method="post">
                <div class="add_task actions">
                    <input class="add_task_text" type="text" name="task_text" placeholder="Enter text...">
                    <button type="submit" formaction="/?action=add_task" class="btn btn-primary">ADD TASK</button>
                    <button formaction="/?action=exit" class="btn btn-danger">Exit</button>
                </div>
                <div class="tasks_edit actions">
                    <button type="submit" formaction="/?action=remove_all" class="btn btn-warning">REMOVE ALL</button>
                    <button type="submit" formaction="/?action=ready_all" class="btn btn-success">READY ALL</button>
                </div>
                <?php
                    if (is_array($data) && !empty($data)) {
                        echo '<div class="task_list actions">';
                        foreach ($data as $key => $task) {
                            include 'task.php';
                        }
                        echo '</div>';
                    }
                ?>
            </form>
        </div>
    </body>
</html>