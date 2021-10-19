<?php

require_once 'App/Views/partials/header.template.php'
?>

<body>
<form action="/search" method="get">
    <input type="text" id="search" name="search"></form>
    <button type="submit">Search</button>
</form>

<br>
<br>

<form action="/items/add" method="get">
    <button type="submit">Add new product</button>
</form>


<h1>All Products</h1>

<table border=3 cellpadding=5>
    <tr>
        <th>Product</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Created</th>
        <th>Last Updated</th>
        <th>Delete</th>
        <th>Edit</th>
    </tr>

    <?php foreach ($items->getItems() as $item) { ?>
    <tr>
        <td> <?php echo $item->getName(); ?></td>
        <td> <?php echo $item->getCategory(); ?></td>
        <td> <?php echo $item->getQuantity(); ?></td>
        <td> <?php echo $item->getCreatedAt(); ?></td>
        <td> <?php echo $item->getUpdatedAt(); ?></td>
        <td>
            <form method="post" action="/items/delete/<?php echo $item->getId();?>">
                <button type="submit">X</button>
            </form>
        </td>

        <td>
            <form method="get" action="/items/edit/<?php echo $item->getId();?>">
                <button type="submit">O</button>
            </form>
        </td>


    </tr>
    <?php } ?>

</table>

</body>
