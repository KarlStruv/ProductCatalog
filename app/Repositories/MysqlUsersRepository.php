<?php

namespace App\Repositories;

use App\Config\MysqlConnection;
use App\Models\Collections\UsersCollection;
use App\Models\User;
use App\Repositories\Interfaces\UsersRepository;
use PDO;
use PDOException;

class MysqlUsersRepository implements UsersRepository
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

    public function getAll(): UsersCollection
    {
        $sql = " SELECT * FROM users";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([]);

        $users = $stmt->fetch(PDO::FETCH_ASSOC);
        $collection = new UsersCollection();

        foreach ($users as $user)
        {
            $collection->add(new User(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['password']
            ));
        }

        return $collection;
    }

    public function getByEmail(string $email): ?User
    {

        $sql = "SELECT * FROM users WHERE email =?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$email]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if (empty($user)) return null;

        return new User(
            $user['id'],
            $user['email'],
            $user['name'],
            $user['password']
        );
    }

    public function save(User $user): void
    {
        $sql = "INSERT INTO users (id, email, name, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            $user->getId(),
            $user->getEmail(),
            $user->getName(),
            $user->getPassword()
        ]);
    }

    public function getOne(string $id): ?User
    {
        $sql ="SELECT * FROM users WHERE id =?";
        $stmt=$this->connection->prepare($sql);
        $stmt->execute([$id]);
        $user =$stmt->fetch();

        return new  User(
            $user['id'],
            $user['email'],
            $user['name'],
            $user['password'],
        );


    }
}
