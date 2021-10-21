<?php

namespace App\Repositories;

use App\Config\MysqlConnection;
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
        $config = MysqlConnection::config();

        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=UTF8";
        try {
            $this->connection = new PDO($dsn, $config['user'], $config['password']);
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