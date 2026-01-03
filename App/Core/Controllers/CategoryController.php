<?php
namespace App\Core\Controllers;
use App\Core\Models\CategoryModel;

class CategoryController
{
    private CategoryModel $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    // GET /categories
    public function index(): void
    {
        $categories = $this->categoryModel->getAllCategories();
        $this->sendResponse($categories);
    }

    // GET /categories/{id}
    public function show(int $id): void
    {
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            $this->sendResponse(['error' => 'Category not found'], 404);
        } else {
            $this->sendResponse($category);
        }
    }

    // POST /categories
    public function store(array $data): void
    {
        $newId = $this->categoryModel->createCategory($data);
        $this->sendResponse(['id' => $newId], 201);
    }

    // PUT /categories/{id}
    public function update(int $id, array $data): void
    {
        $success = $this->categoryModel->updateCategory($id, $data);
        if ($success) {
            $this->sendResponse(['message' => 'Category updated']);
        } else {
            $this->sendResponse(['error' => 'Update failed'], 400);
        }
    }

    // DELETE /categories/{id}
    public function destroy(int $id): void
    {
        $success = $this->categoryModel->deleteCategory($id);
        if ($success) {
            $this->sendResponse(['message' => 'Category deleted']);
        } else {
            $this->sendResponse(['error' => 'Delete failed'], 400);
        }
    }
      private function sendResponse($data, int $statusCode = 200): void
      {
            http_response_code($statusCode);
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
      }
}