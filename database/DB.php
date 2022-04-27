<?php

class DB  {
    /** @var string */
    private $user;
    /** @var string */
    private  $password;
    /** @var string */
    private  $host;
    /** @var int */
    private  $port;
    /** @var string */
    private  $name;

    public function __construct()
    {
        $conf = (include __DIR__ . '/../config.php')['db'];
        $this->user = $conf['user'];
        $this->password = $conf['pass'];
        $this->host = $conf['host'];
        $this->port = $conf['port'];
        $this->name = $conf['name'];
    }

    /**
     * @throws Exception
     */
    public function connectDB(): PDO
    {
        $dsn = "mysql:host=$this->host;port=$this->port;name=$this->name;charset=utf8";
        $conn = new PDO($dsn, $this->user, $this->password);
        if (!$conn)
            throw new Exception('Невозможно подключиться к серверу базы данных');
        else {
         //$query = $conn->query('set names utf8');
         //if (!$query)
         //    throw new Exception('Невозможно подключиться к серверу базы данных');
         //else
                return $conn;
        }
    }
    public function migrationFiles($conn) {
        $allFiles = glob( __DIR__ . '/migrations/*.sql');
        foreach ($allFiles as $file) {
            $this->migrate($conn, $file);
            echo basename($file) . '<br>';
        }
    }

    /**
     * @param PDO $conn
     * @param string $file
     * @return void
     */
    private function migrate(PDO $conn, string $file) {
        $query = include $file;
        $command = sprintf(
                'mysql -u%s -p%s -h %s -D %s < %s',
            $this->user,
            $this->password,
            $this->host,
            $this->name,
            $file
        );

        shell_exec($command);
        $conn->query($query);
    }
}
