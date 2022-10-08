<?php
$filename = './data/data.json';
$_POST = filter_input_array(INPUT_POST, [
    'id' => FILTER_VALIDATE_INT,
]);
$id = $_POST['id'] ?? '';
var_dump($id);

if ($id) {
    $products = json_decode(file_get_contents($filename), true) ?? [];
    if (count($products)) {
        $productIndex = array_search($id, array_column($products, 'id'));
        $products[$productIndex]['onSale'] = !$products[$productIndex]['onSale'];
        file_put_contents($filename, json_encode($products));
    }
}
header('Location: /');
?>