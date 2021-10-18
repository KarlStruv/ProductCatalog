<?php

require_once 'App/Views/partials/header.template.php'
?>



<form action="/items/add" method="post">
    <label for="name"> Product:</label>
    <input type="text" name="name" id="name">
    <br>
    <label for="category"> Category:</label>
    <input type="text" name="category" id="category">
    <br>
    <label for="quantity"> Quantity:</label>
    <input type="text" name="quantity" id="quantity">
    <br>
    <button type="submit">Create</button>

</form>