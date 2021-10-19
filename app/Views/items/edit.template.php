<?php

require_once 'App/Views/partials/header.template.php'

?>


<form action="/items/edit/<?php echo $item->getId(); ?>" method="post">
    <label for="name"> Product:</label>
    <input type="text" name="name" id="name">
    <br>
    <label for="quantity"> Quantity:</label>
    <input type="text" name="quantity" id="quantity">
    <br>
    <label> Category:
        <select name="category" id="category">
            <?php foreach ($categories->getCategories() as $category) { ?>
                <option value="<?php echo $category->getName(); ?>"> <?php echo $category->getName(); ?> </option>
            <?php } ?>
        </select>
    </label>
    <br>
    <button type="submit">Edit</button>

</form>