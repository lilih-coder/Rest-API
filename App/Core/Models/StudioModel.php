<?php
namespace App\Core\Models;

use App\Core\Database\PDOBase;

class StudioModel extends PDOBase
{
      // Tábla neve
      protected string $tableName = 'studios';

      // Összes stúdió részletes adatokkal
      public function getAllWithDetails(array $filters = []): array
      {
          $sql = "SELECT * FROM studios ORDER BY name";

          $stmt = $this->pdo->prepare($sql);
          $stmt->execute();

          return $stmt->fetchAll(\PDO::FETCH_ASSOC);
      }

      // Egy stúdió részletes adatokkal (név + id)
      public function getByIdWithDetails(int $id): array
      {
          $sql = "SELECT * FROM studios WHERE id = :id";

          $stmt = $this->pdo->prepare($sql);
          $stmt->execute(['id' => $id]);
          return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
      }

      // stúdió hozzáadása, frissítése, törlése
      public function createStudio(array $data): int
      {
          $sql = "INSERT INTO studios (name) VALUES (:name)";

          $stmt = $this->pdo->prepare($sql);
          $stmt->execute([
              'name' => $data['name'],             
          ]);

          return (int)$this->pdo->lastInsertId();
      }

      public function updateStudio(int $id, array $data): bool
      {
          $sql = "UPDATE studios SET name = :name WHERE id = :id";

          $stmt = $this->pdo->prepare($sql);
          return $stmt->execute([
              'id' => $id,
              'name' => $data['name'],             
          ]);
      }

      public function deleteStudio(int $id): bool
      {
          $sql = "DELETE FROM studios WHERE id = :id";

          $stmt = $this->pdo->prepare($sql);
          return $stmt->execute(['id' => $id]);
      }
}