<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\MysqlUsersRepository;
use App\Repositories\Interfaces\UsersRepository;
use App\Validations\UsersValidation;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class UsersController
{
    private UsersRepository $usersRepository;
    private UsersValidation $usersValidation;

    public function __construct()
    {
        $this->usersRepository = new MysqlUsersRepository();
        $this->usersValidation = new UsersValidation($this->usersRepository);
    }

    public function showRegisterForm()
    {
        require_once 'App/Views/users/register.template.php';
    }

    public function register()
    {
        try {
            $this->usersValidation->validateName($_POST['name']);
            $this->usersValidation->validateEmail($_POST['email']);
            $this->usersValidation->validatePassword($_POST['password']);
            $this->usersRepository->save(
                new User(
                    Uuid::uuid4(),
                    $_POST['name'],
                    $_POST['email'],
                    password_hash($_POST['password'], PASSWORD_DEFAULT)
                )
            );
        } catch (InvalidArgumentException $e)
        {
            header('Location: /register');
        }

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