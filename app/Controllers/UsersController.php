<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\MysqlUsersRepository;
use App\Repositories\UsersRepository;
use Ramsey\Uuid\Uuid;

class UsersController
{
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new MysqlUsersRepository();
    }

    public function showRegisterForm()
    {
        require_once 'App/Views/users/register.template.php';
    }

    public function register()
    {
        $this->usersRepository->save(
            new User(
                Uuid::uuid4(),
                $_POST['name'],
                $_POST['email'],
                password_hash($_POST['password'], PASSWORD_DEFAULT)
            )
        );

        header('Location: /');
    }

    public function showLoginForm()
    {
        require_once 'App/Views/users/login.template.php';
    }

    public function login()
    {
        $user = $this->usersRepository->getByEmail($_POST['email']);

        if($user != null && password_verify($_POST['password'], $user->getPassword())){
            $_SESSION['authId'] = $user->getId();
            header('Location: /items');
        }else{
            header('Location: /login');
        }
    }
}