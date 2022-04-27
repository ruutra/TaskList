<?php

include 'database/DB.php';

/**
 * @throws Exception
 */
function conn () {
    $bd = new DB();

    $conn = $bd->connectDB();
    $bd->migrationFiles($conn);
}
