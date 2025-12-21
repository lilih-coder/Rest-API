<?php

namespace App\Core\Database;

use PDO;
use PDOException;

class DB
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host = 'localhost';
            $dbname = 'movie_db';
            $username = 'root';
            $password = '';
            $charset = 'utf8mb4';

            try {
                self::$instance = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$instance;
    }
}