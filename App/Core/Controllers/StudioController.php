<?php

namespace App\Core\Controllers;

use App\Core\Models\StudioModel;

class StudioController
{
    private StudioModel $studioModel;

    public function __construct()
    {
        $this->studioModel = new StudioModel();
    }

      // GET /studios
      public function index(array $filters = []): void
      {
          $studios = $this->studioModel->getAllWithDetails();
          $this->sendResponse($studios);
      }

      // GET /studios/{id}
      public function show(int $id): void
      {
          $studio = $this->studioModel->getByIdWithDetails($id);
          if (!$studio) {
              $this->sendResponse(['error' => 'Studio not found'], 404);
          } else {
              $this->sendResponse($studio);
          }
      }

      // POST /studios
      public function store(array $data): void
      {
          $newId = $this->studioModel->createStudio($data);
          $this->sendResponse(['id' => $newId], 201);
      }

      // PUT /studios/{id}
      public function update(int $id, array $data): void
      {
          $success = $this->studioModel->updateStudio($id, $data);
          if ($success) {
              $this->sendResponse(['message' => 'Studio updated']);
          } else {
              $this->sendResponse(['error' => 'Update failed'], 400);
          }
      }

      // DELETE /studios/{id}
      public function destroy(int $id): void
      {
          $success = $this->studioModel->deleteStudio($id);
          if ($success) {
              $this->sendResponse(['message' => 'Studio deleted']);
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