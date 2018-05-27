<?php
require_once('functions.php');
$connect = mysqli_connect('localhost', 'root', '', 'yeticave');
mysqli_set_charset($connect, "utf8");


if (!$connect) {
    print('Ошибка подключения: ' .mysqli_connect_error());
}
else {
    $products = getLotsSortedByDate($connect);
    $categories = getCategoryList($connect);
    $pageContent = include_template('index', ['categories' => $categories, 'products' => $products]);
    $layout_content = include_template('layout', [
        'pageContent' => $pageContent,
        'categories' => $categories,
        'is_auth' => $is_auth,
        'title' => 'YetiCave - Главная']);
    echo $layout_content;

}
?>