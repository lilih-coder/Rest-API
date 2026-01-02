<?php 

namespace App\Core;

class Response
{
    private int $statusCode = 200;
    private array $headers = [];

    const STATUSES = [
        200 => "OK",
        201 => "Created",
        400 => "Bad Request",
        401 => "Unauthorized",
        403 => "Forbidden",
        404 => "Not Found",
        500 => "Internal Server Error",
    ];

    public function setStatusCode(int $code): self
    {
        $this->statusCode = $code;
        return $this;
    }

    public function setHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function json(array $data): void
    {
        $protocol = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0';
        $statusText = self::STATUSES[$this->statusCode] ?? '';
        header($protocol . ' ' . $this->statusCode . ' ' . $statusText);
        header('Content-Type: application/json');

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        echo json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
        exit;
    }
}