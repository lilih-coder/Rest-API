<?php

namespace App\Core\Database;
use PDO;

$config = require __DIR__ . '/app/Core/Config/config.php';

$host = $config['db']['host'];
$dbname = $config['db']['name'];
$user = $config['db']['user'];
$pass = $config['db']['pass'];
$charset = $config['db']['charset'];

// Példa PDO kapcsolat létrehozására
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$pdo = new \PDO($dsn, $user, $pass, [
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
]);

class PDOBase
{
      protected string $tableName;

    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::getInstance();
    }

      public function create(array $data): ?int
      {
            $fields = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), '?'));
      
            $sql = "INSERT INTO {$this->tableName} ($fields) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array_values($data));
      
            return (int)$this->pdo->lastInsertId();
      }

      public function get(int $id): array
      {
            $sql = "SELECT * FROM {$this->tableName} WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
            return $result ? $result : [];
      }

      public function getAll (): array
      {
            $stmt = $this->pdo->query("SELECT * FROM {$this->tableName} ORDER BY name");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }

      public function update(int $id, array $data): bool
      {
            $set = implode(", ", array_map(fn($key) => "$key = ?", array_keys($data)));
            $stmt = $this->pdo->prepare("UPDATE {$this->tableName} SET $set WHERE id = ?");
            return $stmt->execute([...array_values($data), $id]);
      }

      public function delete(int $id): bool
      {
            $stmt = $this->pdo->prepare("DELETE FROM {$this->tableName} WHERE id = ?");
            return $stmt->execute([$id]);
      }
} 
