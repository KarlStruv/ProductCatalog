<?php


namespace App\Repositories;

use App\Models\Category;
use App\Models\Collections\CategoriesCollection;
use App\Models\Relation;
use App\Repositories\Interfaces\CategoriesRepository;
use App\Repositories\Interfaces\RelationsRepository;
use PDO;
use PDOException;

class MysqlRelationRepository implements RelationsRepository
{
    private PDO $connection;

    public function __construct()
    {
        $host = '127.0.0.1';
        $db = 'productsapp';
        $user = 'karlis';
        $pass = '1234';

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
        try {
            $this->connection = new \PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function relate(string $relationId): ?Relation
    {
        $sql = "SELECT * FROM relations WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$relationId]);
        $item = $stmt->fetch();

        return new Relation(
            $item['relation_id'],
            $item['product_id'],
            $item['relation_id'],
        );
    }

    public function getOne(string $relationId): ?Relation
    {
        $sql = "SELECT * FROM relations WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$relationId]);
        $item = $stmt->fetch();

        return new Relation(
            $item['relation_id'],
            $item['product_id'],
            $item['relation_id'],
        );
    }
}