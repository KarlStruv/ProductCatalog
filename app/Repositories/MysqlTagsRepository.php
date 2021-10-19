<?php

namespace App\Repositories;

use App\Models\Collections\TagsCollection;
use App\Models\Tag;
use App\Repositories\Interfaces\TagsRepository;
use PDO;
use PDOException;

class MysqlTagsRepository implements TagsRepository
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

    public function getAll(): TagsCollection
    {
        $sql = "SELECT * FROM tags";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $collection = new TagsCollection($tags);

        foreach ($tags as $tag) {
            $collection->add(new Tag(
                $tag['id'],
                $tag['name']
            ));
        }
        return $collection;
    }

    public function getOne(string $id): ?Tag
    {
        $sql = "SELECT * FROM tags WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        $item = $stmt->fetch();

        return new Tag(
            $item['id'],
            $item['name'],
        );
    }
}