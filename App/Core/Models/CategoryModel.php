<?php
namespace App\Core\Models;
use App\Core\Database\PDOBase;

class CategoryModel extends PDOBase
{
    protected string $tableName = 'categories';

    public function getAllCategories(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM " . $this->tableName . " ORDER BY name");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

      public function getCategoryById(int $id): ?array
      {
            $stmt = $this->pdo->prepare("SELECT * FROM " . $this->tableName . " WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $category = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $category ?: null;
      }

      public function createCategory(array $data): int
      {
            $stmt = $this->pdo->prepare("INSERT INTO " . $this->tableName . " (name) VALUES (:name)");
            $stmt->execute(['name' => $data['name']]);
            return (int)$this->pdo->lastInsertId();
      }

      public function updateCategory(int $id, array $data): bool
      {
            $stmt = $this->pdo->prepare("UPDATE " . $this->tableName . " SET name = :name WHERE id = :id");
            return $stmt->execute(['name' => $data['name'], 'id' => $id]);
      }

      public function deleteCategory(int $id): bool
      {
            $stmt = $this->pdo->prepare("DELETE FROM " . $this->tableName . " WHERE id = :id");
            return $stmt->execute(['id' => $id]);
      }    

}