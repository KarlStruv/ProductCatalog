<?php

namespace App\Controllers;

use App\Models\Item;
use App\Repositories\ItemsRepository;
use App\Repositories\MysqlItemsRepository;
use Ramsey\Uuid\Uuid;

class ItemsController{

    private ItemsRepository $itemsRepository;

    public function __construct()
    {
        $this->itemsRepository = new MysqlItemsRepository();
    }

    public function index()
    {
        $items = $this->itemsRepository->getAll();

        require_once 'App/Views/items/index.template.php';
    }

    public function showAddForm()
    {
        require_once 'App/Views/items/add.template.php';
    }

    public function add()
    {
        $item = new Item(
            Uuid::uuid4(),
            $_POST['name'],
            $_POST['category'],
            $_POST['quantity'],
            $_POST['created_at'],
        );
        $this->itemsRepository->save($item);

        header("Location: /");
    }

    public function delete()
    {
        $id = $vars['id'] ?? null;

        if ($id == null) header('Location: /');

        $item = $this->itemsRepository->getOne($id);

        if ($item !== null) {
            $this->itemsRepository->delete($item);
        }

        header('Location: /');
    }

    public function showEditForm()
    {
        require_once 'App/Views/items/edit.template.php';
    }

    public function edit()
    {
        $id = $vars['id'] ?? null;
        if ($id == null) header('Location: /');

        $product = $this->itemsRepository->getOne($id);

        if ($product !== null) {
            $this->itemsRepository->edit($product);
        }
    }

    public function search(): Item
    {
    //

    }

}