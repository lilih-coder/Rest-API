<?php
namespace App\Core\Controllers;

use App\Core\Models\FilmModel;

class FilmController
{
    private FilmModel $filmModel;

    public function __construct()
    {
        $this->filmModel = new FilmModel();
    }
/*
    // GET /films
    public function index(array $filters = []): void
    {
        $films = $this->filmModel->getAllWithDetails($filters);
        $this->sendResponse($films);
    }
*/

    // GET /films
    public function index(): void
    {
        // 1️⃣ GET paraméterek lekérése
        $categoryId = isset($_GET['category_id']) && $_GET['category_id'] !== ''
                    ? (int)$_GET['category_id']
                    : null;

        $directorId = isset($_GET['director_id']) && $_GET['director_id'] !== ''
                    ? (int)$_GET['director_id']
                    : null;

        $studioId = isset($_GET['studio_id']) && $_GET['studio_id'] !== ''
                    ? (int)$_GET['studio_id']
                    : null;

        $languageId = isset($_GET['language_id']) && $_GET['language_id'] !== ''
                    ? (int)$_GET['language_id']
                    : null;

        // 2️⃣ Filter tömb összeállítása
        $filters = [
            'category_id' => $categoryId,
            'director_id' => $directorId,
            'studio_id'   => $studioId,
            'language_id' => $languageId,
        ];

        // 3️⃣ Lekérés a Modeltől
        $films = $this->filmModel->getAllWithDetails($filters);

        // 4️⃣ JSON válasz
        $this->sendResponse($films);
    }

    // GET /films/{id}
    public function show(int $id): void
    {
        $film = $this->filmModel->getByIdWithDetails($id);
        if (!$film) {
            $this->sendResponse(['error' => 'Film not found'], 404);
        } else {
            $this->sendResponse($film);
        }
    }

    // POST /films
    public function store(array $data): void
    {
        $newId = $this->filmModel->createFilm($data);
        $this->sendResponse(['id' => $newId], 201);
    }

    // PUT /films/{id}
    public function update(int $id, array $data): void
    {
        $success = $this->filmModel->updateFilm($id, $data);
        if ($success) {
            $this->sendResponse(['message' => 'Film updated']);
        } else {
            $this->sendResponse(['error' => 'Update failed'], 400);
        }
    }

    // DELETE /films/{id}
    public function destroy(int $id): void
    {
        $success = $this->filmModel->deleteFilm($id);
        if ($success) {
            $this->sendResponse(['message' => 'Film deleted']);
        } else {
            $this->sendResponse(['error' => 'Delete failed'], 400);
        }
    }

    // Segéd metódus JSON válaszhoz
    private function sendResponse(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function search(string $keyword): void
    {
        // A router param lehet URL-enkódött (pl. szóköz -> %20)
        $keyword = urldecode($keyword);
        $results = $this->filmModel->searchFilm($keyword);
        $this->sendResponse($results);
    }
}
