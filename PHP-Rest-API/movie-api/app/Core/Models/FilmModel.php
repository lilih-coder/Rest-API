<?php
namespace App\Core\Models;

use App\Core\Database\PDOBase;

class FilmModel extends PDOBase
{
    protected string $tableName = 'movies';

    // Összes film részletes adatokkal (JOIN)
    public function getAllWithDetails(array $filters = []): array
    {
        $sql = "
            SELECT movies.*, studios.name AS studio_name, directors.name AS director_name,
                   categories.name AS category_name, languages.name AS language_name
            FROM movies
            LEFT JOIN studios ON movies.studio_id = studios.id
            LEFT JOIN directors ON movies.director_id = directors.id
            LEFT JOIN categories ON movies.category_id = categories.id
            LEFT JOIN languages ON movies.language_id = languages.id
            WHERE (:director_id IS NULL OR movies.director_id = :director_id)
              AND (:category_id IS NULL OR movies.category_id = :category_id)
              AND (:studio_id IS NULL OR movies.studio_id = :studio_id)
              AND (:language_id IS NULL OR movies.language_id = :language_id)
            ORDER BY movies.title
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'director_id' => $filters['director_id'] ?? null,
            'category_id' => $filters['category_id'] ?? null,
            'studio_id' => $filters['studio_id'] ?? null,
            'language_id' => $filters['language_id'] ?? null,
        ]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Egy film részletes adatokkal
    public function getByIdWithDetails(int $id): array
    {
        $sql = "
            SELECT movies.*, studios.name AS studio_name, directors.name AS director_name,
                   categories.name AS category_name, languages.name AS language_name
            FROM movies
            LEFT JOIN studios ON movies.studio_id = studios.id
            LEFT JOIN directors ON movies.director_id = directors.id
            LEFT JOIN categories ON movies.category_id = categories.id
            LEFT JOIN languages ON movies.language_id = languages.id
            WHERE movies.id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    // Base CRUD metódusok használata
    public function createFilm(array $data): int
    {
        return $this->create([
            'title' => $data['title'] ?? null,
            'studio_id' => $data['studio_id'] ?? null,
            'director_id' => $data['director_id'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'language_id' => $data['language_id'] ?? null,
            'description' => $data['description'] ?? null,
        ]);
    }

    public function updateFilm(int $id, array $data): bool
    {
        return $this->update($id, [
            'title' => $data['title'] ?? null,
            'studio_id' => $data['studio_id'] ?? null,
            'director_id' => $data['director_id'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'language_id' => $data['language_id'] ?? null,
            'description' => $data['description'] ?? null,
        ]);
    }

    public function deleteFilm(int $id): bool
    {
        return $this->delete($id);
    }
}
