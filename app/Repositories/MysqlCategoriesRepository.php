<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Collections\CategoriesCollection;
use App\Repositories\Interfaces\CategoriesRepository;
use PDO;
use PDOException;

class MysqlCategoriesRepository implements CategoriesRepository
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

    public function getAll(): CategoriesCollection
    {
        $sql = "SELECT * FROM categories";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $collection = new CategoriesCollection($categories);

        foreach ($categories as $category) {
            $collection->add(new Category(
                $category['id'],
                $category['name']
            ));
        }
        return $collection;
    }

    public function getOne(string $id): ?Category
    {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        $item = $stmt->fetch();

        return new Category(
            $item['id'],
            $item['name'],
        );
    }
}