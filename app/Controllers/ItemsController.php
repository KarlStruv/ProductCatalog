<?php

namespace App\Controllers;

use App\Models\Collections\ItemsCollection;
use App\Models\Item;
use App\Repositories\Interfaces\CategoriesRepository;
use App\Repositories\Interfaces\ItemsRepository;
use App\Repositories\MysqlCategoriesRepository;
use App\Repositories\MysqlItemsRepository;
use App\Validations\ItemsValidation;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class ItemsController
{

    private ItemsRepository $itemsRepository;
    private CategoriesRepository $categoriesRepository;
    private ItemsValidation $itemsValidation;

    public function __construct()
    {
        $this->itemsRepository = new MysqlItemsRepository();
        $this->categoriesRepository = new MysqlCategoriesRepository();
        $this->itemsValidation = new ItemsValidation($this->itemsRepository);
    }

    public function index()
    {
        $items = $this->itemsRepository->getAll();

        require_once 'App/Views/items/index.template.php';
    }

    public function showAddForm()
    {
        $categories = $this->categoriesRepository->getAll();
        require_once 'App/Views/items/add.template.php';
    }

    public function add()
    {
        try {
            $this->itemsValidation->validateProductDetail($_POST['name']);
            $this->itemsValidation->validateProductDetail($_POST['category']);
            $this->itemsValidation->validateProductDetail($_POST['quantity']);
            $this->itemsValidation->validateProductDetail($_POST['created_at']);
            $this->itemsRepository->save(new Item(
                Uuid::uuid4(),
                $_POST['name'],
                $_POST['category'],
                $_POST['quantity'],
                $_POST['created_at'],
            ));
            header("Location: /");
        } catch (\InvalidArgumentException $e) {
            header('Location: /items/add');
        }
    }

    public function delete(array $vars)
    {
        $id = $vars['id'] ?? null;

        if ($id == null) header('Location: /');

        $item = $this->itemsRepository->getOne($id);

        if ($item !== null) {
            $this->itemsRepository->delete($item);
        }

        header('Location: /');
    }

    public function showEditForm(array $vars)
    {

        $id = $vars['id'] ?? null;

        $item = $this->itemsRepository->getOne($id);

        $categories = $this->categoriesRepository->getAll();

        require_once 'App/Views/items/edit.template.php';
    }

    public function edit(array $vars)
    {
        $id = $vars['id'] ?? null;
        if ($id == null) header('Location: /');

        $item = $this->itemsRepository->getOne($id);

        if ($item !== null) {
            $this->itemsRepository->edit($item);
        }

        header('Location: /items');
    }

    public function search()
    {
        $items = $this->itemsRepository->getAllByCategory($_POST['search']);

        require_once 'App/Views/items/results.template.php';
    }

}