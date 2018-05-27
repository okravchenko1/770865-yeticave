<?php
require_once('functions.php');
$connect = mysqli_connect('localhost', 'root', '', 'yeticave');
mysqli_set_charset($connect, "utf8");

if (!$connect) {
    exit('Ошибка подключения к БД');
}

$products = getLotsSortedByDate($connect);
$categories = getCategoryList($connect);

/*Проверяем наличие параметра запроса с id лота и проверяем существует ли лот*/
if (isset($_GET['id']) && in_array(intval($_GET['id']), array_column($products, 'id'))) {
    $product = getLotById($connect, $_GET['id']);
    $pageContent = include_template('lot', ['categories' => $categories, 'product' => $product]);
    $layout_content = include_template('layout', [
        'pageContent' => $pageContent,
        'categories' => $categories,
        'title' => $product['name']]);
    echo $layout_content;
} else {
    http_response_code(404);
}
?>
