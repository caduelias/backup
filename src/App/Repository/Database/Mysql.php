<?php

declare(strict_types=1);

namespace App\Repository\Database;

use App\Exception\DatabaseException;
use PDO;
use stdClass; 

class Mysql extends PDO
{
    public function __construct(stdClass $config)
    {
        try {
            $dsn = sprintf('mysql:host=%s;dbname=%s', $config->host, $config->database);
            $username = $config->user;
            $password = $config->pass;
            
            parent::__construct(
                $dsn, 
                $username, 
                $password);
            
            $this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (DatabaseException $e) {
            throw new DatabaseException("Erro ao conectar no BD");
        }
       
    }
}