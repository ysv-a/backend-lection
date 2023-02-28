<?php

$db = new \PDO("sqlite:" . __DIR__ . '/database.sqlite');

class DatabaseSessionHandler implements \SessionHandlerInterface
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function read($id): string|false
    {
        $statement = $this->db->prepare("
            SELECT data FROM sessions
            WHERE id = :id
        ");

        $statement->execute(['id' => $id]);

        if ($row = $statement->fetch(PDO::FETCH_OBJ)) {
            return $row->data;
        }

        return '';
    }

    public function write($id, $data): bool
    {
        $statement = $this->db->prepare("
            REPLACE INTO sessions VALUES (:id, :timestamp, :data)
        ");

        $insert = $statement->execute([
            'id' => $id,
            'timestamp' => time(),
            'data' => $data,
        ]);

        if ($insert) {
            return true;
        }

        return false;
    }

    public function open($path, $name): bool
    {
        if ($this->db) {
            return true;
        }

        return false;
    }

    public function close(): bool
    {
        $this->db = null;

        if ($this->db === null) {
            return true;
        }

        return false;
    }

    public function destroy($id): bool
    {
        $statement = $this->db->prepare("
            DELETE FROM sessions WHERE id = :id
        ");

        $delete = $statement->execute(['id' => $id]);

        if ($delete) {
            return true;
        }

        return false;
    }

    public function gc($max): int|false
    {
        $limit = time() - $max;

        $statement = $this->db->prepare("
            DELETE FROM sessions WHERE access < :limit
        ");

        $delete = $statement->execute(['limit' => $limit]);

        if ($delete) {
            return true;
        }

        return false;
    }
}

session_set_save_handler(new DatabaseSessionHandler($db));
session_start();

if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
 } else {
    $_SESSION['count']++;
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session DB</title>
</head>
<body>
    <h1>Count: <?php echo $_SESSION['count']; ?></h1>
</body>
</html>
