<div class="task">
    <label class="task_text">
        <?php echo $task['title'] ?>
    </label>
    <div class="task_checkbox_wrapper">
        <input class="task_checkbox" type="checkbox" name="is_active" disabled
            <?php
            if ($task['isReady']) {
                echo 'checked';
            }
            ?>
        >
    </div>
    <div class="task_btn">
        <button type="submit" name="task_ready_toggle" class="btn btn-success" value="<?php echo $task['id'] ?>">
            <?php echo $task['isReady'] ? 'UNREADY' : 'READY' ?>
        </button>
        <button type="submit" name="task_delete" class="btn btn-danger" value="<?php echo $task['id'] ?>">DELETE</button>
    </div>
</div>