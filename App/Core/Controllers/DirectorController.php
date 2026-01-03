<?php
namespace App\Core\Controllers;
use App\Core\Models\DirectorModel;

class DirectorController
{
    private DirectorModel $directorModel;

    public function __construct()
    {
        $this->directorModel = new DirectorModel();
    }

    // GET /directors
    public function index(): void
    {
        $directors = $this->directorModel->getAllDirectors();
        $this->sendResponse($directors);
    }

    // GET /directors/{id}
    public function show(int $id): void
    {
        $director = $this->directorModel->getDirectorById($id);
        if (!$director) {
            $this->sendResponse(['error' => 'Director not found'], 404);
        } else {
            $this->sendResponse($director);
        }
    }

    // POST /directors
    public function store(array $data): void
    {
        $newId = $this->directorModel->createDirector($data);
        $this->sendResponse(['id' => $newId], 201);
    }

    // PUT /directors/{id}
    public function update(int $id, array $data): void
    {
        $success = $this->directorModel->updateDirector($id, $data);
        if ($success) {
            $this->sendResponse(['message' => 'Director updated']);
        } else {
            $this->sendResponse(['error' => 'Update failed'], 400);
        }
    }

    // DELETE /directors/{id}
    public function destroy(int $id): void
    {
        $success = $this->directorModel->deleteDirector($id);
        if ($success) {
            $this->sendResponse(['message' => 'Director deleted']);
        } else {
            $this->sendResponse(['error' => 'Delete failed'], 400);
        }
    }

      private function sendResponse($data, int $status = 200): void
      {
            http_response_code($status);
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
      }
}