<?php
require_once 'errors.php';
$filename = "./data/data.json";

$errors = [
    'name' => '',
    'price' => '',
    'description' => '',
];

$products = [];

if (file_exists($filename)) {
    $data = file_get_contents($filename);
    $products = json_decode($data, true) ?? [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once './add-product.php';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Commerce</title>
</head>
<body>
    <div class="container">
        <div class="content">
            <form action="/" method="POST">
                <label for="name">Produit</label>
                <input type="text" name="name" id="name" >

                <label for="price">Prix</label>
                <input type="number" min="0.00" max="10000.00" step="0.01" name="price"/>

                <label for="description">Description</label>
                <input type="text" name="description" id="description">

                <button type="submit" class="btn">
                    Créer le produit
                </button>
            </form>

            <?php if ($errors['name']) : ?>
                <p class="text-danger"><?= $errors['name'] ?></p>
            <?php elseif ($errors['description']) : ?>
                <p class="text-danger"><?= $errors['description'] ?></p>
            <?php endif; ?>

            <table>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Description</th>
                    <th>En vente</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <th>
                            <?= $product['name'] ?>  
                        </th>
                        <th>
                            <?= $product['price'] . " €" ?>  
                        </th>
                        <th>
                            <?= $product['description'] ?>  
                        </th>
                        <th>
                            <?php if ($product['onSale'] === true) : ?>
                                Oui
                            <?php else : ?>
                                Non
                            <?php endif; ?>
                        </th>
                        <th>
                            <form action="/remove-product.php" method="POST">
                                <?php if ($product['onSale'] === true) : ?>
                                    <input type="hidden" name="onSale" value="<?= $product['onSale'] ?>">
                                <?php else : ?>
                                    <input type="hidden" name="onSale" value="<?= $product['onSale'] ?>">
                                <?php endif; ?>
                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                <button class="btn" type="submit"> Supprimer</button>
                                
                            </form>
                            <form action="/update-product.php" method="POST">

                                <button class="btn" type="submit"><?= $product['onSale'] ? 'Retirer' : 'Ajouter' ?></button>
                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                            </form>
                        </th>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>