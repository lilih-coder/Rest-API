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
            $config = require __DIR__ . '/../Config/config.php';

            $host = $config['db']['host'];
            $dbname = $config['db']['name'];
            $username = $config['db']['user'];
            $password = $config['db']['pass'];
            $charset = $config['db']['charset'];

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