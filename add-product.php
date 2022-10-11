<?php
require_once "upload-file.php";
// Filtre pour sécuriser les input du formulaire
$_POST = filter_input_array(INPUT_POST, [
    'name' => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags' => FILTER_FLAG_NO_ENCODE_QUOTES | FILTER_FLAG_STRIP_BACKTICK
    ],

    'price' => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags' => FILTER_FLAG_NO_ENCODE_QUOTES | FILTER_FLAG_STRIP_BACKTICK
    ],

    'description' => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags' => FILTER_FLAG_NO_ENCODE_QUOTES | FILTER_FLAG_STRIP_BACKTICK
    ]
]);

$product_name = $_POST['name'] ?? '';
$product_price = $_POST['price'] ?? '';
$product_description = $_POST['description'] ?? '';

if (!$product_name) {
    $errors['name'] = ERROR_REQUIRED_NAME;
} elseif (mb_strlen($product_name) < 3) {
    $errors['name'] = ERROR_TOO_SHORT_NAME;
} elseif (mb_strlen($product_name) > 30) {
    $errors['name'] = ERROR_TOO_LONG_NAME;
}


if (!$product_description) {
    $errors['description'] = ERROR_REQUIRED_DESCRIPTION;
} elseif (mb_strlen($product_description) < 15) {
    $errors['description'] = ERROR_TOO_SHORT_DESCRIPTION;
} elseif (mb_strlen($product_description) > 200) {
    $errors['description'] = ERROR_TOO_LONG_DESCRIPTION;
}


if (empty(array_filter($errors, fn ($e) => $e !== ''))) {
    $products = [...$products, [
        'name' => $product_name,
        'price' => $product_price,
        'description' => $product_description,
        'imgPath' => $target_file,
        'onSale' => true,
        'id' => time(),
    ]];
    file_put_contents($filename, json_encode($products));
    $product_name = '';
    $product_price = '';
    $product_description = '';
    header('Location: /');
}
?>
