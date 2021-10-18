<?php


namespace App\Repositories;

use App\Models\Collections\ItemsCollection;
use App\Models\Item;
use PDO;
use PDOException;

class MysqlItemsRepository implements ItemsRepository
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

    public function getAll(): ItemsCollection
    {
        $sql = "SELECT * FROM items";
        $sql .= " ORDER by created_at DESC";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $collection = new ItemsCollection($items);

        foreach ($items as $item) {
            $collection->add(new Item(
                $item['id'],
                $item['name'],
                $item['category'],
                $item['quantity'],
                $item['created_at'],
                $item['updated_at']
            ));
        }
        return $collection;
    }

    public function getOne(string $id): ?Item
    {
        $sql = "SELECT * FROM items WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        $item = $stmt->fetch();

        return new Item(
            $item['id'],
            $item['name'],
            $item['category'],
            $item['quantity'],
            $item['created_at'],
            $item['updated_at']
        );
    }

    public function save(Item $item): void
    {
        $sql = "INSERT INTO items (id, name, category, quantity, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            $item->getId(),
            $item->getName(),
            $item->getCategory(),
            $item->getQuantity(),
            $item->getCreatedAt(),
            $item->getUpdatedAt()
        ]);
    }

    public function delete(Item $item): void
    {
        $sql = "DELETE FROM items WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$item->getId()]);
    }

    public function edit(Item $item): void
    {
        $sql = "UPDATE items SET name=?, category=?,quantity=?,updated_at=? WHERE id=?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$item->getName(), $item->getCategory(), $item->getQuantity(), $item->getUpdatedAt(), $item->getId()]);
    }
}